<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    if (isset($_POST["inputLocation"]))
    {
        $storeName= $_POST["inputLocation"];
        //$storeLocation=$_POST["inputPassword"];
        $storeLocation=$_POST["inputAddress"];
        $storeContact=$_POST["inputContact"];
        $mode="insert";
    }
    if (isset($_POST["updateStoreId"]))
    {
        $updateStoreId=$_POST["updateStoreId"];
        $updateStoreName=$_POST["updateStoreName"];
        $updateStoreLocation=$_POST["updateStoreLocation"];
        $updateStoreContact=$_POST["updateStoreContact"];
        $mode="update";

    }
    if (isset($_POST["deleteStore"]))
    {
        $deleteStore=$_POST["deleteStore"];
        $mode="delete";
    }

//    
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
            if(mode=="insert"){
            $sql_insert = "INSERT INTO Store (storeName,storeLocation,storeContact)
                                   VALUES (?,?,?)";

            $stmt = $conn->prepare($sql_insert);
            $stmt->bindValue(1, $storeName);
            $stmt->bindValue(2,  $storeLocation);
            $stmt->bindValue(3, $storeContact);
            $stmt->execute();
            header("Location: viewLocation.php");
                  }
            if($mode=="update")
                {
                $sql_select = "SELECT * FROM dbo.Store where storeId ='$updateStoreId'" ;
                $stmt = $conn->query($sql_select);
                $stalls = $stmt->fetchAll(); 
                $result=count($stalls);
                if($result==1)
                    {
                    $sql_update = "UPDATE dbo.Store SET storeName='$updateStoreName',storeLocation='$updateStoreLocation',storeContact='$updateStoreContact' WHERE storeId ='$updateStoreId'" ;
                    $Query = $conn->query($sql_update);
                    header("Location: viewLocation.php");
                    }
                 }
            if($mode=="delete")
                {
                $sql_select = "SELECT * FROM dbo.Store where storetId =$deleteStore" ;
                $stmt = $conn->query($sql_select);
                 $stalls = $stmt->fetchAll(); 
                $result=count($stall);
                if($result==1)
                    {
                    try{
                    $sql_delete = "DELETE FROM dbo.store where storeId =$deleteStore" ;
                    $Query = $conn->query($sql_delete);
                    header("Location: viewLocation.php");
                    }
                    catch(Exception $e){
                        $message = "Invalid delete!";
                        echo "<script type='text/javascript'>alert('$message');window.location.href='viewLocation.php';</script>";
                    }
                    }
                 }
        }


        
        catch(Exception $e) {
            die(var_dump($e));
        }
        
}
//asdas
?>