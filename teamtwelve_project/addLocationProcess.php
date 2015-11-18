<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    $storeName= $_POST["inputLocation"];
    $storeLocation=$_POST["inputAddress"];
    $storeContact=$_POST["inputContact"];

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
            $sql_insert = "INSERT INTO Store (storeName,storeLocation,storeContact)
                                   VALUES (?,?,?)";

            $stmt = $conn->prepare($sql_insert);
            $stmt->bindValue(1, $storeName);
            $stmt->bindValue(2,  $storeLocation);
            $stmt->bindValue(3, $storeContact);
            $stmt->execute();
            header("Location: staffmenu.php");
        }


        
        catch(Exception $e) {
            die(var_dump($e));
        }
        
}

?>