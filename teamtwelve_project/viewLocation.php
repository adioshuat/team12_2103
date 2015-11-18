<?php
session_start();
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
    $sql_select = "SELECT * FROM dbo.Store " ;
    $stmt = $conn->query($sql_select);
    $stores = $stmt->fetchAll(); 
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
    <h2>View Location</h2>
    <table class="viewLocation table-bordered">
        <tr>
            <th>Store ID</th>
            <th>Store Name</th>
            <th>Store Location</th>
            <th>Store Contact</th>
            <th colspan="2"></th>
        </tr>
    <?php
    foreach($stores as $store) {
        echo "<tr><td>".$store['storeId']."</td>";
        echo "<td>".$store['storeName']."</td>";
        echo "<td>".$store['storeLocation']."</td>";
        echo "<td>".$store['storeContact']."</td>";
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