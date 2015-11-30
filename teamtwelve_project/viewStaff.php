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
    $message = "You would need admin rights to proceed!";
    echo "<script type='text/javascript'>alert('$message');window.location.href='staffmenu.php';</script>";
}
else{
    header("Location: stafflogin.php");
}

        
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
    $sql_select1 = "SELECT * FROM dbo.Store " ;
    $stmt1 = $conn->query($sql_select1);
    $locations = $stmt1->fetchAll(); 
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
                <th>User Name</th>
                <th>Location</th>
                <th></th>
                <th></th>
            </tr>
            <?php
            foreach($staffs as $staff) {
                echo "<tr>";
                echo "<td><form action='addStaffProcess.php' method='post'>".$staff['staffId']."</td>";
                echo "<td><input type='text' name='updateStaffName' value=".$staff['staffName']."></td>";
                echo "<td><input type='text' name='updateStaffUserName' value=".$staff['username']."></td>";
                echo "<td>";
                echo '<select name="updateLocation">';
                    foreach($locations as $location)
                    { 
                        if($staff['storeId']==$location['storeId']){
                        echo '<option id="optionlocaiton" value='.$location['storeId'].' selected>'.$location['storeLocation'];
                        echo '</option>';
                        }
                        else{
                        echo '<option id="optionlocaiton" value='.$location['storeId'].'>'.$location['storeLocation'];
                        echo '</option>';
                        }
                    }
                echo '</select>';
                echo "</td>";
                echo "<td><button class='btn btn-success' id='updateStaffId' name='updateStaffId' value=".$staff['staffId'].">Edit</button></form></td>";
                echo '<td><form action="addStaffProcess.php" method="post"><button class="btn btn-danger" id="deleteStaff" name="deleteStaff" value='.$staff["staffId"].'>delete</button></form></td>';
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
//        }

?>