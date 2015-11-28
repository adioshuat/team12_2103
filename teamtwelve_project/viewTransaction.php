<!DOCTYPE html>
<?php

session_start();
$current_url =  $_SERVER["QUERY_STRING"]; 
$categorysel = explode("=",$current_url);   

if(isset($_SESSION['userid']))
{
    $userd= $_SESSION['userid'];
}
else{
    header("Location: login.php");
}
?>

<html>
    <head>
        <title>Milk Tea Treble</title>
        <link href="css/milktea_style.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>  
        <div class="container">
        <?php include "page_include/header.inc.php"?>
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
       
        
    $sql_selectbeverage = "select CONVERT(VARCHAR(11),tt.timeOfPurchase,106) as 'dateOfPurchase',i.itemId,d.drinkName,d.drinkType,ing.ingredientName,c.cupName, sg.percentage,i.quantity,i.itemPrice from Items i, Drinkbase d, Ingredient ing, Cup c, SugarLevel sg, 
                        Transactions tt where i.drinkId=d.drinkId AND i.ingredientId=ing.ingredientId 
                        AND i.cupId=c.cupId AND i.sugarLevelId=sg.sugarLevelId AND 
                        tt.orderId=i.orderId and tt.orderStatus='False' and tt.customerId=? order by dateOfPurchase desc";
    $stmtbev = $connection->prepare($sql_selectbeverage);
    $stmtbev->bindValue(1, $userid);
    $stmtbev->execute();
    $transactions = $stmtbev->fetchAll();

    if(count($transactions) > 0) {
        echo '<table>
        <h2>My Orders</h2>    
        <tr class="row">
          <td><strong><font color="#000000">No.</font></strong></td>
          <td><strong><font color="#000000">Date Of Purchase</font></strong></td>
          <td><strong><font color="#000000">Item</font></strong></td>
          <td><strong><font color="#000000">Type</font></strong></td>
          <td><strong><font color="#000000">Drink</font></strong></td>
          <td><strong><font color="#000000">Ingredient</font></strong></td>
          <td><strong><font color="#000000">Cupsize</font></strong></td>
          <td><strong><font color="#000000">Sugar</font></strong></td>
          <td><strong><font color="#000000">Quantity</font></strong></td>
          <td><strong><font color="#000000">Price ($)</font></strong></td>
        </tr>';
    $count=1;
    foreach($transactions as $trans)
    { 
          echo '<tr class="row">';
          echo '<td>'.$count.'</td>';
          echo '<td>'.$trans['dateOfPurchase'].'</td>';
          echo '<td>'.$trans['itemId'].'</td>';
          echo '<td>'.$trans['drinkType'].'</td>';
          echo '<td>'.$trans['drinkName'].'</td>';
          echo '<td>'.$trans['ingredientName'].'</td>';
          echo '<td>'.$trans['cupName'].'</td>';
          echo '<td>'.$trans['percentage'].'</td>';
          echo '<td>'.$trans['quantity'].'</td>';
          echo '<td>'.round($trans['itemPrice'],2).'</td>';
          echo '</tr>';
          $count+=1;
    }    
        echo '</table><p><br/></p>';
    }
    else{
        echo "<h3>No orders found.</h3>";
        echo '<p></p>';
    }

    ?>
    </div>
    <?php include "page_include/footer.inc.php"?>
    </div>    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="js/bootstrap.min.js" type="text/javascript"></script>
    
    </body>
</html>