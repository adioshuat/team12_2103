<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST")
{   
    if (isset($_POST["inputStaffName"]))
    {
        $staffName= $_POST["inputStaffName"];
        $staffUsername=$_POST["inputUserName"];
        $staffPassword=$_POST["inputPassword"];
        $staffLocation=$_POST["inputLocation"];
        $mode="insert";
    }
    if (isset($_POST["updateStaffId"]))
    {
        $updateStaffId=$_POST["updateStaffId"];
        $updateStaffName=$_POST["updateStaffName"];
        $updateStaffUserName=$_POST["updateStaffUserName"];
        $updateStaffLocation=$_POST["updateLocation"];
        $mode="update";
    }
    if (isset($_POST["deleteStaff"]))
    {
        $deleteStaff=$_POST["deleteStaff"];
        $mode="delete";
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
            if($mode=='insert')
            {
            $sql_insert = "INSERT INTO Staff (staffName,username,passw,storeId)
                                   VALUES (?,?,?,?)";

            $stmt = $conn->prepare($sql_insert);
            $stmt->bindValue(1, $staffName);
            $stmt->bindValue(2, $staffUsername);
            $stmt->bindValue(3, $staffPassword);
            $stmt->bindValue(4, $staffLocation);
            $stmt->execute();
            header("Location: viewStaff.php");
            }
            if($mode=="update")
                {
                $sql_select = "SELECT * FROM dbo.Staff where staffId ='$updateStaffId'" ;
                $stmt = $conn->query($sql_select);
                $drinks = $stmt->fetchAll(); 
                $result=count($drinks);
                if($result==1)
                    {
                    $sql_update = "UPDATE dbo.Staff SET staffName='$updateStaffName',storeId='$updateStaffLocation',username='$updateStaffUserName' WHERE staffId ='$updateStaffId'" ;
                    $Query = $conn->query($sql_update);
                    header("Location: viewStaff.php");
                    }
                 }
            if($mode=="delete")
                {
                $sql_select = "SELECT * FROM dbo.Staff where staffId ='$deleteStaff'" ;
                $stmt = $conn->query($sql_select);
                 $drinks  = $stmt->fetchAll(); 
                $result=count($drinks);
                if($result==1)
                    {
                    try{
                    $sql_delete = "DELETE FROM dbo.Staff where staffId ='$deleteStaff' " ;
                    $Query = $conn->query($sql_delete);
                    header("Location: viewStaff.php");
                    }
                    catch(Exception $e){
                        $message = "Invalid delete!";
                        echo "<script type='text/javascript'>alert('$message');window.location.href='viewStaff.php';</script>";
                    }
                    }
                 }
        }
        catch(Exception $e) {
            die(var_dump($e));
        }
//        }
}
?>