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
?>

<?php
if($_SERVER["REQUEST_METHOD"] == "POST"){
            if(isset($_POST["addOrderId"]))
            {
            $insertDrink=$_POST["drinkOption"];
            $insertIngredient=$_POST["ingredientOption"];
            $insertCup=$_POST["cupOption"];
            $insertSugar=$_POST["sugarOption"];
            $insertOrderId=$_POST["addOrderId"];
            $insertNumOfDrink=trim($_POST["numOfDrink"]);
            //insert sql statment
            $mode="add";
            
            }
            if(isset($_POST["approveOrder"])){
            $approveOrder=$_POST["approveOrder"];
            $approvePrice=$_POST["totalPrice"];
            $approveStaffId=$_SESSION['staffId'];
            //update sql statement 
            $approveOrder;
            $todayDate=date("Y-m-d",strtotime('+1 day'));
            $mode="approve";
            }
            if(isset($_POST["deleteItem"])){
            $deleteItem=$_POST["deleteItem"];
            $insertOrderId=$_POST["deleteOrderId"];
            $deleteItem;
            $mode="delete";
            }
        require_once "../../protected/team12/config.php";
        $host = DBHOST;
        $user = DBUSER;
        $pwd = DBPASS;
        $db =  DBNAME;

        // Connecting to database
        try {
            $conn = new PDO( "sqlsrv:Server= $host ; Database = $db ", $user, $pwd);
            $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
        }
        catch(Exception $e){
            die(var_dump($e));
        }
        
        try{
            if($mode=="approve")
            {
            $sql_select = "SELECT * FROM dbo.Transactions WHERE orderStatus='False' AND orderId='$approveOrder'" ;    
            $stmt = $conn->query($sql_select);
            $transactions = $stmt->fetchAll();
            $result=count($transactions);
            if($result==1)
               {
                $sql_update = "UPDATE dbo.Transactions SET orderStatus='True',totalPrice='$approvePrice' , timeOfPurchase='$todayDate' , staffId='$approveStaffId' WHERE orderId='$approveOrder'" ;
                $Query = $conn->query($sql_update);
                $message="Recipet<br> Total price: $approvePrice <br> Date of purchase: $todayDate";
                $sql_selectbeverage = "select i.itemId,d.drinkName,d.drinkType,ing.ingredientName,c.cupName, sg.percentage,i.quantity,i.itemPrice from Items i, Drinkbase d, Ingredient ing, Cup c, SugarLevel sg, 
                        Transactions tt where i.drinkId=d.drinkId AND i.ingredientId=ing.ingredientId 
                        AND i.cupId=c.cupId AND i.sugarLevelId=sg.sugarLevelId AND 
                        tt.orderId=i.orderId and tt.orderId=?";
                $stmtbev = $conn->prepare($sql_selectbeverage);
                $stmtbev->bindValue(1, $approveOrder);
                $stmtbev->execute();
                $displayOrders = $stmtbev->fetchAll();
                }
            }
            if($mode=="add")
            {
            $sql_search="SELECT SUM(C.price+I.price+D.price)AS 'totalPrice' FROM dbo.Cup C,dbo.Ingredient I,dbo.Drinkbase D where cupid='$insertCup' and ingredientId='$insertIngredient' and DrinkId='$insertDrink'";
            $sum = $conn->query($sql_search);
            $totalPrices = $sum->fetchAll();
             foreach($totalPrices as $totalPrice)
                 {
                 $insertPrice=$totalPrice['totalPrice'];
                 }
            $sql_insert_item = "INSERT INTO dbo.Items (drinkId, ingredientId, cupId, sugarLevelId, itemPrice, quantity, orderId)
                                VALUES (?,?,?,?,?,?,?)";
            $stmtitem = $conn->prepare($sql_insert_item);
            $stmtitem->bindValue(1, $insertDrink);
            $stmtitem->bindValue(2, $insertIngredient);
            $stmtitem->bindValue(3, $insertCup);
            $stmtitem->bindValue(4, $insertSugar);
            $stmtitem->bindValue(5, $insertPrice*$insertNumOfDrink);
            $stmtitem->bindValue(6, $insertNumOfDrink);
            $stmtitem->bindValue(7, $insertOrderId);
            $stmtitem->execute();
            header("Location:viewBilling.php?selectOrder=$insertOrderId");
            }
            if($mode=="delete")
                {
                $sql_select = "SELECT * FROM dbo.Items where itemId =$deleteItem" ;
                $deleteQuery = $conn->query($sql_select);
                $deleteResult = $deleteQuery->fetchAll(); 
                $result=count($deleteResult);
                if($result==1)
                    {
                    $sql_delete = "DELETE FROM dbo.Items where itemId =$deleteItem" ;
                    $Query = $conn->query($sql_delete);
                     header("Location:viewBilling.php?selectOrder=$insertOrderId");
                    }
                }
            ?>
    <html>
        <head>
            <title>View Order</title>
            <link href="css/milktea_style.css" rel="stylesheet" type="text/css"/>
        </head>
        <body>  
            <div class="container">
            <?php include "page_include/staffheader.inc.php"?>
                <div class="container-fluid" class="col-md-12">
                    <h1><?php echo $message; ?></h1>
           <?php if(count($displayOrders) > 0) 
               {
               ?>
                    <table width="100%" border="1">
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
                    </tr>
                    <?php
                foreach($displayOrders as $displayOrder)
                { 
                      echo '<tr><td>'.$displayOrder['itemId'].'</td>';
                      echo '<td>'.$displayOrder['drinkType'].'</td>';
                      echo '<td>'.$displayOrder['drinkName'].'</td>';
                      echo '<td>'.$displayOrder['ingredientName'].'</td>';
                      echo '<td>'.$displayOrder['cupName'].'</td>';
                      echo '<td>'.$displayOrder['percentage'].'</td>';
                      echo '<td>'.$displayOrder['quantity'].'</td>';
                      echo '<td>'.round($displayOrder['itemPrice'],2).'</td>';
                      echo '</tr>';
                }
                echo '<a href="staffmenu.php">Click to return to staff menu</a>';
               }
                ?>
            </div>
            </div>    
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
            <script src="js/bootstrap.min.js" type="text/javascript"></script>
        </body>
</html>
<?php
        }
        catch(Exception $e) {
            die(var_dump($e));
        }
            
            
}            
?>