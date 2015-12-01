<?php session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST")
{    
    $mode;
    if (isset($_POST["inputDrinkCategory"]))
    {
        $drinkCategory= $_POST["inputDrinkCategory"];
        $drinkType=$_POST["inputDrinkType"];
        $drinkName=$_POST["inputDrinkName"];
        $drinkPrice=$_POST["inputDrinkPrice"];
        $mode="insert";
        echo $mode;
    }
    if (isset($_POST["updateDrinkCategory"]))
    {
        $updateDrinkCategory=$_POST["updateDrinkCategory"];
        $updateDrinkType=$_POST["updateDrinkType"];
        $updateDrinkName=$_POST["updateDrinkName"];
        $updateDrinkPrice=$_POST["updateDrinkPrice"];
        $updateImageLocation=$_POST["updateImageLocation"];
        $updateDrinkId=$_POST["updateDrinkId"];
        $mode="update";
        echo $mode;
    }
    if (isset($_POST["deleteDrink"]))
    {
        $deleteDrink=$_POST["deleteDrink"];
        echo $deleteDrink;
        $mode="delete";
        echo $mode;
    }
//    if ($usernameValid && $emailValid && $pwd1Valid && $pwd2Valid)
//    {
//        session_start();
        
        require_once("../../protected/team12/config.php");
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
            if($mode=="insert")
                {
                $sql_insert = "INSERT INTO Drinkbase (DrinkCategory,DrinkType,DrinkName,price)
                                       VALUES (?,?,?,?)";

                $stmt = $conn->prepare($sql_insert);
                $stmt->bindValue(1, $drinkCategory);
                $stmt->bindValue(2,  $drinkType);
                $stmt->bindValue(3,  $drinkName);
                $stmt->bindValue(4, $drinkPrice);
                $stmt->execute();
                header("Location: viewDrink.php");
                }
            if($mode=="update")
                {
                $sql_select = "SELECT * FROM dbo.Drinkbase where DrinkId ='$updateDrinkId'" ;
                $stmt = $conn->query($sql_select);
                $drinks = $stmt->fetchAll(); 
                $result=count($drinks);
                if($result==1)
                    {
                    $sql_update = "UPDATE dbo.Drinkbase SET DrinkCategory='$updateDrinkCategory',DrinkType='$updateDrinkType',DrinkName='$updateDrinkName',price='$updateDrinkPrice' WHERE DrinkId ='$updateDrinkId'" ;
                    $Query = $conn->query($sql_update);
                    header("Location: viewDrink.php");
                    }
                 }
            if($mode=="delete")
                {
                $sql_select = "SELECT * FROM dbo.Drinkbase where DrinkId ='$deleteDrink'" ;
                $stmt = $conn->query($sql_select);
                 $drinks  = $stmt->fetchAll(); 
                $result=count($drinks);
                if($result==1)
                    {
                    try{
                    $sql_delete = "DELETE FROM dbo.Drinkbase where DrinkId ='$deleteDrink'" ;
                    $Query = $conn->query($sql_delete);
                    header("Location: viewDrink.php");
                    }
                    catch(Exception $e){
                        $message = "Invalid delete!";
                        echo "<script type='text/javascript'>alert('$message');window.location.href='viewDrink.php';</script>";
                    }
                    }
                 }
        }


        
        catch(Exception $e) {
            die(var_dump($e));
        }
        
}

?>
