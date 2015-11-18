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
    <title>Add Staff</title>
    

  </head>

  <body>



    <div class="container" id="addStaff">
        <form class="form-horizontal" action="addStaffProcess.php" method="post" role="form">
              <div class="form-group">
                <label for="inputStaffName" class="col-sm-2 control-label">Staff Name</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="inputStaffName" name="inputStaffName" placeholder="Staff Name">
                </div>
              </div>
              <div class="form-group">
                <label for="inputPassword" class="col-sm-2 control-label">Password</label>
                <div class="col-sm-10">
                  <input type="password" class="form-control" id="inputPassword" name="inputPassowrd" placeholder="Password">
                </div>
              </div>
              <div class="form-group">
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
