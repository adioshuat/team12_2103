<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>Staff menu 2</title>

    <?php include "page_include/staffheader.inc.php"?>
  </head>

  <body>



      <div class="container">
        <h1>Staff Menu</h1>
            <table class="menu">
            <thead>
                <tr>
                    <th>Billing</th>
                    <th>Add</th>
                    <th>Edit</th>
                    <th>View</th>
                </tr>
            </thead>
                <tbody>
                <tr>
                    <td><a href="billing.php" class="btn btn-success customwidth customwidth" role="button">Billing</a></td>
                    <td><a href="addStaff.php" class="btn btn-success customwidth customwidth" role="button">Add Staff</a></td>
                    <td><a href="#" class="btn btn-success customwidth" role="button">Edit Staff</a></td>
                    <td><a href="viewStaff.php" class="btn btn-success customwidth" role="button">View Sales</a></td>
                </tr>
                <tr>
                    <td></td>
                    <td><a href="addLocation.php" class="btn btn-success customwidth" role="button">Add Location</a></td>
                    <td><a href="viewLocation.php" class="btn btn-success customwidth" role="button">Edit Location</a></td>
                    <td><a href="#" class="btn btn-success customwidth" role="button">View Customer</a></td>
                </tr>
                <tr>
                    <td><a href="viewDrink.php" class="btn btn-success customwidth" role="button">View drink</a></td>
                    <td><a href="addDrink.php" class="btn btn-success customwidth" role="button">Add Drink</a></td>
                    <td><a href="#" class="btn btn-success customwidth" role="button">Edit drink</a></td>
                    <td><a href="viewStaff.php" class="btn btn-success customwidth" role="button">View Staff</a></td>
                </tr>
                <tr>
                     <td><a href="viewIngredient.php" class="btn btn-success customwidth" role="button">View ingredient</a></td>
                    <td><a href="addIngredient.php" class="btn btn-success customwidth" role="button">Add ingredient</a></td>
                    <td><a href="#" class="btn btn-success customwidth" role="button">Edit ingredient</a></td>
                    <td><a href="viewLocation.php" class="btn btn-success customwidth" role="button">View Location</a></td>
                </tr>
                <tr>
                    <td></td>
                    <td><a href="addSugarLevel.php" class="btn btn-success customwidth" role="button">Add Sugar level</a></td>
                    <td><a href="#" class="btn btn-success customwidth" role="button">Edit Sugar level</a></td>
                    <td><a href="viewSugarLevel.php" class="btn btn-success customwidth" role="button">view Sugar level</a></td>
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
