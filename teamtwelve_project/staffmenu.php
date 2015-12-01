<?php 
session_start();
if(isset($_SESSION['staffId']))
{
    $_SESSION['adminStatus'];
    $_SESSION['staffId'];
    $_SESSION['storeId'];
    $_SESSION['staffName'];
    echo '<div class="alert alert-success" role="alert">Welcome '.$_SESSION["staffName"].' Staff ID: '.$_SESSION['staffId'].'  <a href="logout.php">Click here to logout</a></div>';
}
else{
    header("Location: stafflogin.php");
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="/images/favicon.ico">

    <title>Staff menu</title>

    <?php include "page_include/staffheader.inc.php"?>
    
  </head>

  <body>



      <div class="container">
        <h1>Staff Menu</h1>
        
            <table class="menu">
            <thead>
                <tr>
                    <th>Billing</th>
                    <th>View</th>
                    <th>Item Management</th>
                </tr>
            </thead>
                <tbody>
                <tr>
                    <td><a href="billing.php" class="btn btn-success customwidth customwidth" role="button">Billing</a></td>
                    <td> <a href="viewcustomervisitstore.php" class="btn btn-success customwidth" role="button">View Customer Visits</a>
                        <a href="viewTopFavourite.php" class="btn btn-success customwidth" role="button">View Top Favourite</a>
                    </td>
                    <td>
                        <a href="addStaff.php" class="btn btn-success customwidth customwidth" role="button">Add Staff</a>
                        <a href="viewStaff.php" class="btn btn-success customwidth" role="button">View Staff</a>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td><a href="viewStoreSales.php" class="btn btn-success customwidth" role="button">View Store Sales</a></td>
                    <td>
                        <a href="addLocation.php" class="btn btn-success customwidth" role="button">Add Location</a>
                        <a href="viewLocation.php" class="btn btn-success customwidth" role="button">View Location</a>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td>
                        <a href="addDrink.php" class="btn btn-success customwidth" role="button">Add Drink</a>
                        <a href="viewDrink.php" class="btn btn-success customwidth" role="button">View Drink</a>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td>
                        <a href="addIngredient.php" class="btn btn-success customwidth" role="button">Add Ingredient</a>
                        <a href="viewIngredient.php" class="btn btn-success customwidth" role="button">View Ingredient</a>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td>
                        <a href="addSugarLevel.php" class="btn btn-success customwidth" role="button">Add Sugar level</a>
                        <a href="viewSugarLevel.php" class="btn btn-success customwidth" role="button">view Sugar level</a>
                    </td>
                </tr>
                </tbody>
            </table>

      
      </div>


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>
