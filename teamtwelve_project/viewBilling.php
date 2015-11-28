<?php 
session_start();
if(isset($_SESSION['staffId']))
{
    $_SESSION['adminStatus'];
    $_SESSION['staffId'];
    $_SESSION['storeId'];
    $_SESSION['staffName'];
    echo '<div class="alert alert-success" role="alert">Welcome '.$_SESSION["staffName"].' <a href="logout.php">Click here to logout</a></div></div>';
}
else{
    header("Location: stafflogin.php");
}
$orderId=$_GET["selectOrder"];
?>

<!DOCTYPE html>
<html>
    <head>
        <title>View Order</title>
        <link href="css/staff-menu.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>  
        <div class="container">
        <?php include "page_include/staffheader.inc.php"?>
        <div class="container-fluid" class="col-md-12">
        <?php 
        require_once "../../protected/team12/config.php";
        $host = DBHOST;
        $user = DBUSER;
        $pwd = DBPASS;
        $db =  DBNAME;

        // Connecting to database
        try {
            $connection = new PDO( "sqlsrv:Server= $host ; Database = $db ", $user, $pwd);
            $connection->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
        }
        catch(Exception $error){
            die(var_dump($error));
        }
        if($error!=null)
        {
            $output= "<p>Unable to connect to database<p>". $error;
            exit($output);
        }
       

    $sql_selectbeverage = "select i.itemId,d.drinkName,d.drinkType,ing.ingredientName,c.cupName, sg.percentage,i.quantity,i.itemPrice from Items i, Drinkbase d, Ingredient ing, Cup c, SugarLevel sg, 
                        Transactions tt where i.drinkId=d.drinkId AND i.ingredientId=ing.ingredientId 
                        AND i.cupId=c.cupId AND i.sugarLevelId=sg.sugarLevelId AND 
                        tt.orderId=i.orderId and tt.orderStatus='False' and tt.orderId=?";
    $stmtbev = $connection->prepare($sql_selectbeverage);
    $stmtbev->bindValue(1, $orderId);
    $stmtbev->execute();
    $transactions = $stmtbev->fetchAll();
    
    //get total price
    $totalPrice=0;
    if(count($transactions) > 0) {
        ?>
        <div>
        <table class="viewBilling table-bordered" width="100%" border="1">
        <h2>Approve Order</h2>    
        <tr> 
          <td><strong><font color="#000000">Item</font></strong></td>
          <td><strong><font color="#000000">Type</font></strong></td>
          <td><strong><font color="#000000">Drink</font></strong></td>
          <td><strong><font color="#000000">Ingredient</font></strong></td>
          <td><strong><font color="#000000">Cup size</font></strong></td>
          <td><strong><font color="#000000">Sugar</font></strong></td>
          <td><strong><font color="#000000">Quantity</font></strong></td>
          <td><strong><font color="#000000">Price ($)</font></strong></td>
          <td><strong><font color="#000000">Delete</strong></td>
        </tr>
        <?php
    foreach($transactions as $trans)
    { 
          echo '<tr><td>'.$trans['itemId'].'</td>';
          echo '<td>'.$trans['drinkType'].'</td>';
          echo '<td>'.$trans['drinkName'].'</td>';
          echo '<td>'.$trans['ingredientName'].'</td>';
          echo '<td>'.$trans['cupName'].'</td>';
          echo '<td>'.$trans['percentage'].'</td>';
          echo '<td>'.$trans['quantity'].'</td>';
          echo '<td>'.round($trans['itemPrice'],2).'</td>';
          $totalPrice=$totalPrice+$trans['itemPrice'];
          echo "<td><form action='billingProcess.php' method='post'>";
          echo "<button class='btn btn-danger' id='deleteItem' name='deleteItem' value=".$trans['itemId'].">Delete</button>";
          echo "<input type='hidden' name='deleteOrderId' value='$orderId'>";
          echo "</form>";
          echo '</td>';
          echo '</tr>';
    }
            //find all drink
            $sql_selectDrink= "SELECT * FROM dbo.Drinkbase ORDER BY DrinkId";
            $stmdri = $connection->query($sql_selectDrink);
            $drink = $stmdri->fetchAll();
            //find all ingredient
            $sql_selectingredient= "SELECT * FROM dbo.Ingredient ORDER BY ingredientId";
            $stmting = $connection->query($sql_selectingredient);
            $ingredient = $stmting->fetchAll();
           //find all sugar
            $sql_selectsugar= "SELECT * FROM dbo.SugarLevel";
            $stmtsug = $connection->query($sql_selectsugar);
            $sugarlevel = $stmtsug->fetchAll();
            //find all cup size
            $sql_selectcup= "SELECT * FROM dbo.Cup";
            $stmtcup = $connection->query($sql_selectcup);
            $cupsize = $stmtcup->fetchAll();
            
           
    ?>  
        <tr> 
        <?php   
            echo '<td><form action="billingProcess.php" method="post"></td>';
            echo '<td></td>';
            echo '<td>';
            echo '<select name="drinkOption" id="drinkOption">';
                    foreach($drink as $dri)
                    { 
                        echo '<option id="optionint" value='.$dri['DrinkId'].'>'.$dri['DrinkType'].":".$dri['DrinkName'];
                        echo '</option>';
                    }
            echo '</select>';
            echo '</td>';
            echo '<td>';
            echo '<select name="ingredientOption">';
                    foreach($ingredient as $int)
                    { 
                        echo '<option id="optionint" value='.$int['ingredientId'].'>'.$int['ingredientName'];
                        echo '</option>';
                    }
            echo '</select>';   
            echo '</td>';
            echo '<td>';
            echo '<select name="cupOption">';
                    foreach($cupsize as $cup)
                    { 
                        echo '<option id="optioncup" value='.$cup['cupId'].'>'.$cup['cupName'];
                        echo '</option>';
                    }
            echo '</select>';
            echo '</td>';
            echo '<td>';
            echo '<select name="sugarOption" id="sugarOption">';
                    foreach($sugarlevel as $sur)
                    { 
                        echo '<option id="optionsur" value='.$sur['sugarLevelId'].'>'.$sur['levelDescription'].'--'.$sur['percentage'];
                        echo '</option>';
                    }
                    echo '</select>';
            echo '</td>';
            echo '<td><input onchange="myFunction()" type="number" pattern="^[0-50]" min="1" value="1" placeholder="Pick a number" name="numOfDrink" id="numOfDrink" /></td>';
            echo '<td id="price"></td>';
            echo '<td><button class="btn btn-success" id="addOrderId" name="addOrderId" value='.$orderId.'>Add</button></form></td>';
        ?>
            </tr>
            </table>
            <p><br/></p>
            <h2>Total Price= <?php echo  $totalPrice; ?></h2>
            <form action='billingProcess.php' method='post'>
            <button class="btn btn-success" id='approveOrder' name='approveOrder' value='<?php echo $orderId; ?>'>Approve</button>
            <input type='hidden' name='totalPrice' value='<?php echo $totalPrice;?>'>
            </form>
        </div>
    <?php
    }
    else{
        echo "<h3>No orders found.</h3>";
        echo '<p></p>';
        ?>
        <table class="viewBilling table-bordered" width="100%" border="1">
        <h2>Add Order</h2>    
        <tr> 
          <td><strong><font color="#000000">Item</font></strong></td>
          <td><strong><font color="#000000">Type</font></strong></td>
          <td><strong><font color="#000000">Drink</font></strong></td>
          <td><strong><font color="#000000">Ingredient</font></strong></td>
          <td><strong><font color="#000000">Cup size</font></strong></td>
          <td><strong><font color="#000000">Sugar</font></strong></td>
          <td><strong><font color="#000000">Quantity</font></strong></td>
          <td><strong><font color="#000000">Price ($)</font></strong></td>
          <td><strong><font color="#000000">Delete</strong></td>
        </tr> 
        <tr> 
        <?php
                    //find all drink
            $sql_selectDrink= "SELECT * FROM dbo.Drinkbase ORDER BY DrinkId";
            $stmdri = $connection->query($sql_selectDrink);
            $drink = $stmdri->fetchAll();
            //find all ingredient
            $sql_selectingredient= "SELECT * FROM dbo.Ingredient ORDER BY ingredientId";
            $stmting = $connection->query($sql_selectingredient);
            $ingredient = $stmting->fetchAll();
           //find all sugar
            $sql_selectsugar= "SELECT * FROM dbo.SugarLevel";
            $stmtsug = $connection->query($sql_selectsugar);
            $sugarlevel = $stmtsug->fetchAll();
            //find all cup size
            $sql_selectcup= "SELECT * FROM dbo.Cup";
            $stmtcup = $connection->query($sql_selectcup);
            $cupsize = $stmtcup->fetchAll();
            
            echo '<td><form action="billingProcess.php" method="post"></td>';
            echo '<td></td>';
            echo '<td>';
            echo '<select name="drinkOption" id="drinkOption">';
                    foreach($drink as $dri)
                    { 
                        echo '<option id="optionint" value='.$dri['DrinkId'].'>'.$dri['DrinkType'].":".$dri['DrinkName'];
                        echo '</option>';
                    }
            echo '</select>';
            echo '</td>';
            echo '<td>';
            echo '<select name="ingredientOption">';
                    foreach($ingredient as $int)
                    { 
                        echo '<option id="optionint" value='.$int['ingredientId'].'>'.$int['ingredientName'];
                        echo '</option>';
                    }
            echo '</select>';   
            echo '</td>';
            echo '<td>';
            echo '<select name="cupOption">';
                    foreach($cupsize as $cup)
                    { 
                        echo '<option id="optioncup" value='.$cup['cupId'].'>'.$cup['cupName'];
                        echo '</option>';
                    }
            echo '</select>';
            echo '</td>';
            echo '<td>';
            echo '<select name="sugarOption" id="sugarOption">';
                    foreach($sugarlevel as $sur)
                    { 
                        echo '<option id="optionsur" value='.$sur['sugarLevelId'].'>'.$sur['levelDescription'].'--'.$sur['percentage'];
                        echo '</option>';
                    }
                    echo '</select>';
            echo '</td>';
            echo '<td><input onchange="myFunction()" type="number" pattern="^[0-50]" min="1" value="1" placeholder="Pick a number" name="numOfDrink" id="numOfDrink" /></td>';
            echo '<td id="price"></td>';
            echo '<td><button class="btn-success" id="addOrderId" name="addOrderId" value='.$orderId.'>Add</button></form></td>';
        ?>
            </tr>
            </table>        
    <?php    
        }
    ?>    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="js/bootstrap.min.js" type="text/javascript"></script>
    
    </body>
</html>