<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    $staffName= $_POST["inputStaffName"];
    $staffUsername=$_POST["inputStaffName"];
    $staffPassword=$_POST["inputPassword"];

        
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
            $sql_insert = "INSERT INTO Staff (staffName,username,passw)
                                   VALUES (?,?,?)";

            $stmt = $conn->prepare($sql_insert);
            $stmt->bindValue(1, $staffName);
            $stmt->bindValue(2,  $staffUsername);
            $stmt->bindValue(3, $staffPassword);
            $stmt->execute();
            header("Location: staffmenu.php");
        }
        catch(Exception $e) {
            die(var_dump($e));
        }
//        }
}
?>