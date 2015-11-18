<?php
session_start();
//    if (isset($_POST["username"]))
//    {
//        $username = trim($_POST["username"]);
//        if (!empty($username))    
//        {
//            if($username != "User Name is a required field." )
//                $usernameValid = true;
//        }
//    }
//    if (isset($_POST["name"]))
//    {
//        $name = trim($_POST["name"]);
//        if (!empty($name))    
//        {
//            if($name != "Name is a required field." )
//                $nameValid = true;
//        }
//    }
//        
//    if (isset($_POST["email"]))
//    {
//        $email = trim($_POST["email"]);
//        $emailPattern = "/^(.+)@([^\.].*)\.([a-z]{2,})$/";
//        $emailValid = preg_match($emailPattern, $email);
//    }
//        
//    if (isset($_POST["passwd"]))
//    {
//        $pwd1 = $_POST["passwd"];
//        $pwd1Valid = true;
//    }
//   
//    if (isset($_POST["cpasswd"]))
//    {
//        if($pwd1Valid)
//        {
//            $pwd2 = $_POST["cpasswd"];
//            $pwd2Valid = ($pwd1 == $pwd2);
//        }
//    }
//
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
    $sql_select = "SELECT * FROM dbo.Staff S, dbo.Store D WHERE S.storeId=D.storeId" ;
    $stmt = $conn->query($sql_select);
    $staffs = $stmt->fetchAll(); 
    ?>
    <html lang="en">
        <head>
          <meta charset="utf-8">
          <meta http-equiv="X-UA-Compatible" content="IE=edge">
          <meta name="viewport" content="width=device-width, initial-scale=1">
          <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
          <meta name="description" content="">
          <meta name="author" content="">
          <link rel="icon" href="../../favicon.ico">

        <title>Staff menu</title>

        <?php include "page_include/staffheader.inc.php"?>
      </head>

  
      <div class="container">
            <h2>View Staff</h2>
            <table class="viewStaff table-bordered">
            <tr>
                <th>Staff ID</th>
                <th>Staff Name</th>
                <th>Location</th>
                <th></th>
                <th></th>
            </tr>
            <?php
            foreach($staffs as $staff) {
                echo "<tr><td>".$staff['staffId']."</td>";
                echo "<td>".$staff['staffName']."</td>";
                echo "<td>".$staff['storeLocation']."</td>";
                echo "<td>Edit</td>";
                echo "<td>Delete</td></tr>";
            }
            ?>
          </table>
      </div>
    <?php
    }
        catch(Exception $e) {
            die(var_dump($e));
        }
//        }

?>