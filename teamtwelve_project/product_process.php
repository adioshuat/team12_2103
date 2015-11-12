<?php
session_start();
if(isset($_SESSION['userid']))
{
    $userid= $_SESSION['userid'];
}

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    //check userid true first
    if (isset($_POST["drinkid"]))
    {
        $drinkid = trim($_POST["drinkid"]);
    }
    if (isset($_POST["ingredientoption"]))
    {
        $ingredient = trim($_POST["ingredientoption"]);
    }
        
    if (isset($_POST["sugaroption"]))
    {
        $sugarlevel = trim($_POST["sugaroption"]);
    }
        
    if (isset($_POST["cupoption"]))
    {
        $cupsize = trim($_POST["cupoption"]);
    }
   
    if (isset($_POST["numOfDrink"]))
    {
        $quantity = trim($_POST["numOfDrink"]);
    }
    
        require_once "../../protected/team12/config.php";
        $host = DBHOST;
        $user = DBUSER;
        $pwd = DBPASS;
        $db =  DBNAME;

        // Connecting to database
        try {
            $connection = new PDO( "sqlsrv:Server= $host ; Database = $db ", $user, $pwd);
            $connection->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
            
            $sql_checktrans= "SELECT COUNT(*) as checktrans FROM dbo.Transactions where orderStatus='False' AND customerId=?";
            $stmtcheck = $connection->prepare($sql_checktrans);
            $stmtcheck->bindValue(1, $userid);
            $stmtcheck->execute();
            $countcheck = $stmtcheck->fetchAll();

            foreach($countcheck as $count)
            {
                $falsevalue= $count['checktrans'];
            }
            if($falsevalue<1)
            {
                $sql_insert_transaction = "INSERT INTO dbo.Transactions (totalPrice,orderStatus,timeOfPurchase,customerId)
                               VALUES (?,?,?,?)";

                $stmttrans = $connection->prepare($sql_insert_transaction);
                $stmttrans->bindValue(1, 0);
                $stmttrans->bindValue(2, 'False');
                $stmttrans->bindValue(3, '1900-01-01');
                $stmttrans->bindValue(4, $userid);
                $stmttrans->execute();
            }
            else{
                //do nothing & wait for approval to pending transactions
            }
        }
        catch(Exception $error){
            die(var_dump($error));
        }
        if($error!=null)
        {
            $output= "<p>Unable to connect to database<p>". $error;
            exit($output);
        }
        try{
        $sql_orderstat= "SELECT orderId FROM dbo.Transactions where orderStatus='False' and customerId=?";
        $stmtorder = $connection->prepare($sql_orderstat);
        $stmtorder->bindValue(1, $userid);
        $stmtorder->execute();
        $orderid = $stmtorder->fetchAll();
        
        foreach($orderid as $order)
        {
        
        $orderNum = $order['orderId'];   
        
        
        $sql_pricesum= "SELECT (SELECT SUM(price) FROM Drinkbase where drinkId=?) + (SELECT SUM(price) FROM Ingredient where ingredientId=?) + (SELECT SUM(price) FROM Cup where cupId=?) AS 'Total'";
        $stmtprice = $connection->prepare($sql_pricesum);
        $stmtprice->bindValue(1, $drinkid);
        $stmtprice->bindValue(2, $ingredient);
        $stmtprice->bindValue(3, $cupsize);
        $stmtprice->execute();
        $sumtotal = $stmtprice->fetchAll();
        foreach($sumtotal as $sum)
        {
         $sumprice= $sum['Total'];   
        }

        $sql_insert_item = "INSERT INTO dbo.Items (drinkId, ingredientId, cupId, sugarLevelId, itemPrice, quantity, orderId)
                            VALUES (?,?,?,?,?,?,?)";

        $stmtitem = $connection->prepare($sql_insert_item);
        $stmtitem->bindValue(1, $drinkid);
        $stmtitem->bindValue(2, $ingredient);
        $stmtitem->bindValue(3, $cupsize);
        $stmtitem->bindValue(4, $sugarlevel);
        $stmtitem->bindValue(5, $sumprice*$quantity);
        $stmtitem->bindValue(6, $quantity);
        $stmtitem->bindValue(7, $orderNum);
        $stmtitem->execute();
        }
        }
        catch(Exception $e) {
            die(var_dump($e));
        }
        
        header("Location: viewtransaction.php");   
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
        </div>
        <?php include "page_include/footer.inc.php"?>
        </div>    
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <script src="js/bootstrap.min.js" type="text/javascript"></script>
    </body>
</html>


