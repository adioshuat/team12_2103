<?php
session_start();
if(isset($_SESSION['staffId'])&&$_SESSION['adminStatus']=='YES')
{
    $_SESSION['adminStatus'];
    $_SESSION['staffId'];
    $_SESSION['storeId'];
    $_SESSION['staffName'];
    echo '<div class="alert alert-success" role="alert">Welcome '.$_SESSION["staffName"].' <a href="logout.php">Click here to logout</a></div>';
}
else if(isset($_SESSION['staffId']))
    {
     header("Location: staffmenu.php");
}
else{
    header("Location: stafflogin.php");
}

//    if ($usernameValid && $emailValid && $pwd1Valid && $pwd2Valid)
//    {
//        session_start();
        //dd
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
        echo "<tr>";
        echo "<td><form method='post' action='addLocationProcess.php'>".$store['storeId']."</td>";
        echo "<td><input type='text' name='updateStoreName' value=".$store['storeName']."></td>";
        echo "<td><input type='text' name='updateStoreLocation' value=".$store['storeLocation']."></td>";
        echo "<td><input type='text' name='updateStoreContact' value=".$store['storeContact']."></td>";
        echo "<td>";
        echo "<button class='btn btn-default' id='updateStoreId' name='updateStoreId' value=".$store['storeId'].">Edit</button></form>";
        echo "</td>";
        echo "<td>";
        echo "<form action='addLocationProcess.php' method='post'>";
        echo "<button class='btn btn-danger' id='deleteStore' name='deleteStore' value=".$store['storeId'].">Delete</button>";
        echo "</form>";
        echo "</td>"; 
        echo "</tr>";
    }
    ?>
        </table>
    </div>
    <?php
    }
        catch(Exception $e) {
            die(var_dump($e));
        }
//        }asda

?>