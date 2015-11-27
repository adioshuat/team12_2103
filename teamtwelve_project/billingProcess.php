<?php
if($_SERVER["REQUEST_METHOD"] == "POST"){
            if(isset($_POST["addOrderId"]))
            {
            $insertDrink=$_POST["drinkOption"];
            $insertIngredient=$_POST["ingredientOption"];
            $insertCup=$_POST["cupOption"];
            $insertSugar=$_POST["sugarOption"];
            $insertOrderId=$_POST["addOrderId"];
            $insertNumOfDrink=$_POST["numOfDrink"];
            //insert sql statment
            $mode="add";
            
            }
            if(isset($_POST["approveOrder"])){
            $approveOrder=$_POST["approveOrder"];
            $approvePrice=$_POST["totalPrice"];
            //update sql statement 
            $approveOrder;
            $todayDate=date("Y-m-d",strtotime('+1 day'));
            $mode="approve";
            }
            if(isset($_POST["deleteItem"])){
            $deleteItem=$_POST["deleteItem"];
            $deleteItem;
            $mode="delete";
            }
            echo $mode;
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
            echo $result;
            if($result==1)
               {
                $sql_update = "UPDATE dbo.Transactions SET orderStatus='True',totalPrice='$approvePrice' , timeOfPurchase='$todayDate' WHERE orderId='$approveOrder'" ;
                $Query = $conn->query($sql_update);
                $message="Recipet" + "Total price" +$approvePrice+" Datae of purchase" +$todayDate;
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
//            $sql_insert_item = "INSERT INTO dbo.Items (drinkId, ingredientId, cupId, sugarLevelId, itemPrice, quantity, orderId)
//                                VALUES (?,?,?,?,?,?,?)";
//            $stmtitem = $connection->prepare($sql_insert_item);
//            $stmtitem->bindValue(1, $insertDrink);
//            $stmtitem->bindValue(2, $insertIngredient);
//            $stmtitem->bindValue(3, $insertCup);
//            $stmtitem->bindValue(4, $insertSugar);
//            $stmtitem->bindValue(5, $insertPrice*$insertNumOfDrink);
//            $stmtitem->bindValue(6, $insertNumOfDrink);
//            $stmtitem->bindValue(7, $insertOrderId);
//            $stmtitem->execute();
            echo '<form name="return" method="get" action="'.$_SERVER['PHP_SELF'].'?>" >';
            echo '<input type="text" name="selectOrder" value='.$insertOrderId.'>';
            echo '<form>';
            }
            ?>
            <h2><?php echo $message; ?></h2>
            
<?php
        }
        catch(Exception $e) {
            die(var_dump($e));
        }
            
            
}            
?>