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
    <link rel="icon" href="../../favicon.ico">
    <?php include "page_include/staffheader.inc.php"?>
    <title>Add Drink</title>
    

  </head>

  <body>
    <div class="container" id="addDrink">
                      <h1>Add Drink</h1>
        <form class="form-horizontal" action="addDrinkProcess.php" method="post" role="form">
              <div class="form-group" >
                <label for="inputDrinkCategory" class="col-sm-2 control-label">Category of Drink</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="inputDrinkCategory" name="inputDrinkCategory" placeholder="">
                </div>
              </div>
              <div class="form-group">
                <label for="inputDrinkType" class="col-sm-2 control-label">Type of Drink</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="inputDrinkType" name="inputDrinkType" placeholder="">
                </div>
              </div>
               <div class="form-group">
                <label for="inputDrinkName" class="col-sm-2 control-label">Name of Drink</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="inputDrinkName" name="inputDrinkName" placeholder="">
                </div>
              </div>
                <div class="form-group">
                <label for="inputDrinkPrice" class="col-sm-2 control-label">Price of Drink</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="inputDrinkPrice" name="inputDrinkPrice" placeholder="">
                </div>
              </div>
              <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                  <button type="submit" class="btn btn-default">Add</button>
                </div>
              </div>
            </form>
    </div><!-- /.container -->

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>
  </body>
</html>
