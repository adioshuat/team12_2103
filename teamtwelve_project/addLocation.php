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
    <title>Add Location</title>
    

  </head>

  <body>



    <div class="container" id="addLocation">
            <form class="form-horizontal" action="addLocationProcess.php" method="post" role="form">
              <div class="form-group" >
                <label for="inputLocation" class="col-sm-2 control-label">Name of Location</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="inputLocation" name="inputLocation" placeholder="Name of location">
                </div>
              </div>
              <div class="form-group">
                <label for="inputAddress" class="col-sm-2 control-label">Address</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="inputAddress" name="inputAddress" placeholder="Address">
                </div>
              </div>
               <div class="form-group">
                <label for="inputContact" class="col-sm-2 control-label">Contact</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="inputContact" name="inputContact" placeholder="Contact">
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
