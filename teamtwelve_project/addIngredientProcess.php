<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    $mode;
    if (isset($_POST["deleteIngredient"]))
    {
        $deleteIngredient=$_POST["deleteIngredient"];
        $mode="delete";
        echo $deleteIngredient;
        echo $mode;
    }
    if (isset($_POST["inputIngredientName"]))
    {
        //INSERT
        $ingredientName= $_POST["inputIngredientName"];
        $ingredientPrice=$_POST["inputIngredientPrice"];
        echo $ingredientName;
        echo $ingredientPrice;
        $mode="insert";
        echo $mode;
    }
    if (isset($_POST["updateIngredientId"]))
    {
        $updateIngredientId=$_POST["updateIngredientId"];
        $updateIngredientName=$_POST["updateIngredientName"];
        $updateIngredientPrice=$_POST["updateIngredientPrice"];
        echo $updateIngredientId;
        echo $updateIngredientName;
        echo $ingredientPrice;
        $mode="update";
        echo $mode;
    }
    
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
            $sql_insert = "INSERT INTO Ingredient (ingredientName,price)
                                   VALUES (?,?)";
            $stmt = $conn->prepare($sql_insert);
            $stmt->bindValue(1, $ingredientName);
            $stmt->bindValue(2,  $ingredientPrice);
            $stmt->execute();
            header("Location: staffmenu.php");
        }


        
        catch(Exception $e) {
            die(var_dump($e));
        }
        
}

?>