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
    $sql_select = "SELECT * FROM dbo.Drinkbase" ;
    $stmt = $conn->query($sql_select);
    $drinks = $stmt->fetchAll(); 
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

        <title>View Drink base</title>

        <?php include "page_include/staffheader.inc.php"?>
      </head>

  
      <div class="container">
            <h2>View Drink base</h2>
            <table class="viewDrink table-bordered">
            <tr>
                <th>Drink ID</th>
                <th>Drink Category</th>
                <th>Drink Type</th>
                <th>Drink Name</th>
                <th>Drink Price</th>
                <th>Drink Image Location</th>
                <th colspan="2"></th>
            </tr>
            <?php
            foreach($drinks as $drink) {
                echo "<tr><td>".$drink['DrinkId']."</td>";
                echo "<td>".$drink['DrinkCategory']."</td>";
                echo "<td>".$drink['DrinkType']."</td>";
                echo "<td>".$drink['DrinkName']."</td>";
                echo "<td>".$drink['price']."</td>";
                echo "<td>".$drink['imageLocation']."</td>";
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