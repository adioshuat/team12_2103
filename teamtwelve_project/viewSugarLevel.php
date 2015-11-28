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
    $sql_select = "SELECT * FROM dbo.SugarLevel" ;
    $stmt = $conn->query($sql_select);
    $sugarlevels = $stmt->fetchAll(); 
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

        <title>View Sugar Level</title>

        <?php include "page_include/staffheader.inc.php"?>
      </head>

  
      <div class="container">
            <h2>View Sugar Level</h2>
            
                <table class="viewStaff table-bordered">
            <tr>
                <th>Sugar level ID</th>
                <th>Percentage</th>
                <th>Level Description</th>
                <th colspan="2"></th>
            </tr>
            <?php
            foreach($sugarlevels as $sugarlevel) 
            {
                echo "<tr>";
                echo "<td><form method='post' action='addSugarProcess.php'>".$sugarlevel['sugarLevelId']."</td>"; 
                echo "<td><input type='text' name='updateSugarPercentage' value=".$sugarlevel['percentage']."></td>";
                echo "<td><input type='text' name='updateSugarDescription' value=".$sugarlevel['levelDescription']."></td>";
                echo "<td><button class='btn btn-default' id='updateSugarId' name='updateSugarId' value=".$sugarlevel['sugarLevelId'].">Edit</button></form></td>";
                echo "<td><form action='addSugarProcess.php' method='post'><button class='btn btn-danger' id='deleteSugar' name='deleteSugar' value=".$sugarlevel['sugarLevelId'].">Delete</button></form></td>";                
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