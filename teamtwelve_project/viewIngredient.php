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
    $sql_select = "SELECT * FROM dbo.Ingredient" ;
    $stmt = $conn->query($sql_select);
    $ingredients = $stmt->fetchAll(); 
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

        <title>View Ingredient</title>

        <?php include "page_include/staffheader.inc.php"?>
      </head>

  
      <div class="container">
            <h2>View Ingredient</h2>
            <table class="viewIngredient table-bordered">
            <tr>
                <th>Ingredient ID</th>
                <th>Ingredient Name</th>
                <th>Price</th>
                <th colspan="2"></th>
            </tr>
            <?php
            foreach($ingredients as $ingredient) {
                echo "<tr>";
                echo "<td><form method='post' action='addIngredientProcess.php'>".$ingredient['ingredientId']."</td>";
                echo "<td><input type='text' name='updateIngredientName' value=".$ingredient['ingredientName']."></td>";
                echo "<td><input type='text' name='updateIngredientPrice' value=".$ingredient['price']."></td>";
                echo "<td><button id='updateIngredientId' name='updateIngredientId' value=".$ingredient['ingredientId'].">Edit</button></form></td>";
                echo "<td>";
                echo "<form action='addIngredientProcess.php' method='post'>";
                echo "<button id='deleteIngredient' name='deleteIngredient' value=".$ingredient['ingredientId'].">Delete</button>";
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