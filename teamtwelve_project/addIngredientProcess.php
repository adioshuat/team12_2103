<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    $mode;
    if (isset($_POST["deleteIngredient"]))
    {
        $deleteIngredient=$_POST["deleteIngredient"];
        $mode="delete";
    }
    if (isset($_POST["inputIngredientName"]))
    {
        //INSERT
        $ingredientName= $_POST["inputIngredientName"];
        $ingredientPrice=$_POST["inputIngredientPrice"];
        echo $ingredientName;
        echo $ingredientPrice;
        $mode="insert";
    }
    if (isset($_POST["updateIngredientId"]))
    {
        $updateIngredientId=$_POST["updateIngredientId"];
        $updateIngredientName=$_POST["updateIngredientName"];
        $updateIngredientPrice=$_POST["updateIngredientPrice"];
        $mode="update";
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
            if($mode=="insert")
            {
                $sql_insert = "INSERT INTO Ingredient (ingredientName,price)VALUES (?,?)";
                $stmt = $conn->prepare($sql_insert);
                $stmt->bindValue(1, $ingredientName);
                $stmt->bindValue(2,  $ingredientPrice);
                $stmt->execute();
                header("Location: viewIngredient.php");
            }
            if($mode=="update")
                {
                $sql_select = "SELECT * FROM dbo.Ingredient where ingredientId =$updateIngredientId" ;
                $stmt = $conn->query($sql_select);
                $ingredients = $stmt->fetchAll(); 
                $result=count($ingredients);
                if($result==1)
                    {
                    $sql_update = "UPDATE dbo.Ingredient SET ingredientName='$updateIngredientName',price='$updateIngredientPrice' WHERE ingredientId =$updateIngredientId" ;
                    $Query = $conn->query($sql_update);
                    header("Location: viewIngredient.php");
                    }
                 }
            if($mode=="delete")
                {
                $sql_select = "SELECT * FROM dbo.Ingredient  where ingredientId =$deleteIngredient" ;
                $stmt = $conn->query($sql_select);
                 $ingredients = $stmt->fetchAll(); 
                $result=count($ingredients);
                if($result==1)
                    {
                    $sql_delete = "DELETE FROM dbo.Ingredient where ingredientId =$deleteIngredient" ;
                    $Query = $conn->query($sql_delete);
                    header("Location: viewIngredient.php");
                    }
                 }
        }


        
        catch(Exception $e) {
            die(var_dump($e));
        }
        
}

?>