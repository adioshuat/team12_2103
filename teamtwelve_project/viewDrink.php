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
                echo "<tr>";
                echo "<td><form method='post' action='addDrinkProcess.php'>".$drink['DrinkId']."</td>";
                echo "<td><input type='text' name='updateDrinkCategory' value=".$drink['DrinkCategory']."></td>";
                echo "<td><input type='text' name='updateDrinkType' value=".$drink['DrinkType']."></td>";
                echo "<td><input type='text' name='updateDrinkName' value=".$drink['DrinkName']."></td>";
                echo "<td><input type='text' name='updateDrinkPrice' value=".$drink['price']."></td>";
                echo "<td><input type='text' name='updateImageLocation' value=".$drink['imageLocation']."></td>";
                echo "<td><button class='btn btn-default' id='updateDrinkId' name='updateDrinkId' value=".$drink['DrinkId'].">Edit</button></form></td>";
                echo "<td>";
                echo "<form action='addDrinkProcess.php' method='post'>";
                echo "<button class='btn btn-danger'  id='deleteDrink' name='deleteDrink' value=".$drink['DrinkId'].">Delete</button>";
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
//        }

?>