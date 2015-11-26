<!DOCTYPE html>
<?php
session_start();
$current_url =  $_SERVER["QUERY_STRING"]; 
$categorysel = explode("=",$current_url);   

if(isset($_SESSION['userid']))
{
    $userid= $_SESSION['userid'];
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
       
        
    $sql_selectbeverage = "select i.itemId,d.drinkType,d.drinkName,ing.ingredientName,c.cupName, sg.percentage,i.quantity, i.itemPrice from Items i, Drinkbase d, Ingredient ing, Cup c, SugarLevel sg, 
                        Transactions tt where i.drinkId=d.drinkId AND i.ingredientId=ing.ingredientId 
                        AND i.cupId=c.cupId AND i.sugarLevelId=sg.sugarLevelId AND 
                        tt.orderId=i.orderId and tt.orderStatus='True' and tt.customerId=?";
    $stmtbev = $connection->prepare($sql_selectbeverage);
    $stmtbev->bindValue(1, $userid);
    $stmtbev->execute();
    $transactions = $stmtbev->fetchAll();

    if(count($transactions) > 0) {
        echo '<div>';
        echo '<table width="100%" border="1">
        <h2>My Orders</h2>    
        <tr> 
          <td><strong><font color="#000000">Item</font></s></td>
          <td><strong><font color="#000000">Type</font></strong></td>
          <td><strong><font color="#000000">Drink</font></strong></td>
          <td><strong><font color="#000000">Ingredient</font></strong></td>
          <td><strong><font color="#000000">Cupsize</font></strong></td>
          <td><strong><font color="#000000">Sugar</font></strong></td>
          <td><strong><font color="#000000">Quantity</font></strong></td>
          <td><strong><font color="#000000">Price ($)</font></strong></td>
        </tr>';
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
    }    
        echo '</tr></table><p><br/></p>';
        echo '</div>';
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