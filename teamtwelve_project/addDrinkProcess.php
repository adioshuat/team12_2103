<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    $drinkCategory= $_POST["inputDrinkCategory"];
    $drinkType=$_POST["inputDrinkType"];
    $drinkName=$_POST["inputDrinkName"];
    $drinkPrice=$_POST["inputDrinkPrice"];

//    if ($usernameValid && $emailValid && $pwd1Valid && $pwd2Valid)
//    {
//        session_start();
        
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
            $sql_insert = "INSERT INTO Drinkbase (DrinkCategory,DrinkType,DrinkName,price)
                                   VALUES (?,?,?,?)";

            $stmt = $conn->prepare($sql_insert);
            $stmt->bindValue(1, $drinkCategory);
            $stmt->bindValue(2,  $drinkType);
            $stmt->bindValue(3,  $drinkName);
            $stmt->bindValue(4, $drinkPrice);
            $stmt->execute();
            header("Location: staffmenu.php");
        }


        
        catch(Exception $e) {
            die(var_dump($e));
        }
        
}

?>