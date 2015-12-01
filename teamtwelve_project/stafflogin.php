<?php 
session_start();
    if ($_SERVER["REQUEST_METHOD"] == "POST"){

    $username = trim($_POST["inputName"]);
    $password = trim($_POST["inputPassword"]);
 
    require_once "../../protected/team12/config.php";
    $host = DBHOST;
    $user = DBUSER;
    $pwd = DBPASS;
    $db =  DBNAME;

    // Connecting to database
    try {
        $connection = new PDO( "sqlsrv:Server= $host ; Database = $db ", $user, $pwd);
        $connection->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
    }
    catch(Exception $e){
        die(var_dump($e));
    }
    try{

    $sql_login= "SELECT * FROM dbo.Staff where username=? and passw=?";
    $stmt = $connection->prepare($sql_login);
    $stmt->bindValue(1, $username);
    $stmt->bindValue(2, $password);
    $stmt->execute();
    $userfind = $stmt->fetchAll();

    if(count($userfind)>0)
    {
        foreach($userfind as $user)
        {
            $_SESSION['adminStatus']=$user['adminStatus'];
            $_SESSION['staffId']=$user['staffId'];
            $_SESSION['storeId']=$user['storeId'];
            $_SESSION['staffName']=$user['staffName'];
        }
        header("Location: staffmenu.php");
    }
    else{
         header("Location: stafflogin.php");
    }
    }
    catch(Exception $e){
        die(var_dump($e));
    }
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
    <link rel="shortcut icon" href="/images/favicon.ico">    <?php include "page_include/staffheader.inc.php"?>
    <title>Sign in for admin</title>

  </head>

  <body>

    <div class="container">

        <h1>Staff Login</h1>
          <div class="container" id="loginStaff">
            <form class="form-horizontal" action="stafflogin.php" method="post" role="form">
              <div class="form-group" >
                <label for="inputLocation" class="col-sm-2 control-label">User name</label>
                <div class="col-sm-10">
                  <input type="text" id="inputName" name="inputName" class="form-control" placeholder="name" required autofocus>
                </div>
              </div>
              <div class="form-group">
                <label for="inputPassword" class="col-sm-2 control-label">Password</label>
                <div class="col-sm-10">
                  <input  type="password" id="inputPassword" name="inputPassword" class="form-control" placeholder="Password" required>
                </div>
              </div>
              <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                  <button type="submit" class="btn btn-default">Submit</button>
                </div>
              </div>
            </form>
    </div>  
      

    </div> <!-- /container -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>
  </body>
</html>
