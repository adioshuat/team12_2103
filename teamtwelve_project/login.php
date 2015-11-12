<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST"){

    $username = trim($_POST["username"]);
    $password = trim($_POST["passwd"]);
 
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

    $sql_login= "SELECT * FROM dbo.Customer where username=? and passw=?";
    $stmt = $connection->prepare($sql_login);
    $stmt->bindValue(1, $username);
    $stmt->bindValue(2, $password);
    $stmt->execute();
    $userfind = $stmt->fetchAll();

    if(count($userfind)>0)
    {
        foreach($userfind as $cus)
        {
            $_SESSION['userid']=$cus['customerId'];
            $_SESSION['username']=$cus['username'];
        }
        header("Location: index.php");
    }
    else{
         header("Location: register.php");
    }
    }
    catch(Exception $e){
        die(var_dump($e));
    }
}
?>
<html>
<head>
<Title>Milk Tea Treble</Title>
<link href="css/milktea_style.css" rel="stylesheet" type="text/css"/>
</head>
    <body>  
    <div class="container">
    <?php include "page_include/header.inc.php"?>
    <div class="container-fluid" class="col-md-12">  
    <?php echo $username, $password?>    
    <div class="col-md-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Account</h3>
                </div>  

                <div class="panel-body">
                    <ul class="nav nav-pills nav-stacked">
                        <li class="active"><a href="login.php" >Login</a></li>
                        <li><a href="register.php" >Register</a></li>
                    </ul>   
                </div>
            </div>
    </div>
    <div class="col-sm-8">
        <form class="form-horizontal" role="form" action="login.php" method="POST" >
        <h2>Login Account</h2>
              <div class="form-group">
                <label for="username" class="col-sm-3 control-label">User Name</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="username" name="username">
                </div>
              </div>

              <div class="form-group">
                <label for="passwd" class="col-sm-3 control-label">Password</label>
                <div class="col-sm-9">
                    <input type="password" class="form-control" id="passwd" name="passwd">
                </div>
              </div>       

            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-9">
                  <button type="submit" class="btn btn-primary">Login</button>
                </div>
              </div>
        </form>
    </div>
    </div>
    <?php include "page_include/footer.inc.php"?>
    </div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="js/bootstrap.min.js" type="text/javascript"></script>
</body>
</html>



