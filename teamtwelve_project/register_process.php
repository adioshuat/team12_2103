<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    $usernameValid = false;
    $nameValid= false;
    $emailValid = false;
    $pwd1Valid = false;
    $pwd2Valid = false;  
    
    if (isset($_POST["username"]))
    {
        $username = trim($_POST["username"]);
        if (!empty($username))    
        {
            if($username != "User Name is a required field." )
                $usernameValid = true;
        }
    }
    if (isset($_POST["name"]))
    {
        $name = trim($_POST["name"]);
        if (!empty($name))    
        {
            if($name != "Name is a required field." )
                $nameValid = true;
        }
    }
        
    if (isset($_POST["email"]))
    {
        $email = trim($_POST["email"]);
        $emailPattern = "/^(.+)@([^\.].*)\.([a-z]{2,})$/";
        $emailValid = preg_match($emailPattern, $email);
    }
        
    if (isset($_POST["passwd"]))
    {
        $pwd1 = $_POST["passwd"];
        $pwd1Valid = true;
    }
   
    if (isset($_POST["cpasswd"]))
    {
        if($pwd1Valid)
        {
            $pwd2 = $_POST["cpasswd"];
            $pwd2Valid = ($pwd1 == $pwd2);
        }
    }
    if ($usernameValid && $emailValid && $pwd1Valid && $pwd2Valid)
    {
        session_start();
        
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
                $sql_insert = "INSERT INTO dbo.Customer (username,customerName,email,passw)
                                       VALUES (?,?,?,?)";

                $stmt = $conn->prepare($sql_insert);
                $stmt->bindValue(1, $username);
                $stmt->bindValue(2, $name);
                $stmt->bindValue(3, $email);
                $stmt->bindValue(4, $pwd2);
                $stmt->execute();

                $_SESSION['registered']=true;
                header("Location: login.php");
        }
        catch(Exception $e) {
            die(var_dump($e));
        }
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
    <div class="col-md-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Account</h3>
                </div>  

                <div class="panel-body">
                    <ul class="nav nav-pills nav-stacked">
                        <li><a href="login.php" >Login</a></li>
                        <li class="active"><a href="register.php" >Register</a></li>
                    </ul>   
                </div>
            </div>
    </div>
    <div class="col-sm-8">  
       <form class="form-horizontal" role="form" action="register.php" method="POST" >
        <h2>Register Account</h2>
        
              <div class="form-group <?php if($usernameValid){echo 'has-success';} else {echo 'has-error';} ?> has-feedback">
                <label for="username" class="col-sm-3 control-label">User Name</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="username" name="username"
                           value="<?php if ($usernameValid){echo $username;} else {echo "User Name is a required field.";} ?>">
                    <span class="glyphicon <?php if ($usernameValid){ echo  "glyphicon-ok" ;} else {echo "glyphicon-remove";}?> form-control-feedback"></span>
                </div>
              </div>
        
            <div class="form-group <?php if($nameValid){echo 'has-success';} else {echo 'has-error';} ?> has-feedback">
                <label for="name" class="col-sm-3 control-label">User Name</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="name" name="name"
                           value="<?php if ($nameValid){echo $name;} else {echo "Name is a required field.";} ?>">
                    <span class="glyphicon <?php if ($nameValid){ echo  "glyphicon-ok" ;} else {echo "glyphicon-remove";}?> form-control-feedback"></span>
                </div>
              </div>

              <div class="form-group <?php if($emailValid){echo 'has-success';} else {echo 'has-error';} ?> has-feedback">
                <label for="email" class="col-sm-3 control-label">Email</label>
                <div class="col-sm-9">
                  <input type="email" class="form-control" id="email" name="email"
                           <?php if ($emailValid){echo 'value="$email';} else {echo 'placeholder="Email is a required field."';} ?>">
                     <span class="glyphicon <?php if ($emailValid){ echo  "glyphicon-ok" ;} else {echo "glyphicon-remove";}?> form-control-feedback"></span>
                </div>
              </div>

              <div class="form-group <?php if($pwd1Valid){echo 'has-success';} else {echo 'has-error';} ?> has-feedback">
                <label for="passwd" class="col-sm-3 control-label">Password</label>
                <div class="col-sm-9">
                    <input type="password" class="form-control" id="passwd" name="passwd"
                           <?php 
                           if ($pwd1Valid){echo "value='$pwd1'";} else {echo "placeholder='Password is a required field.'";} ?>>
                     <span class="glyphicon <?php if ($pwd1Valid){ echo  "glyphicon-ok" ;} else {echo "glyphicon-remove";}?> form-control-feedback"></span>
                </div>
              </div>

              <div class="form-group <?php if($pwd2Valid){echo 'has-success';} else {echo 'has-error';} ?> has-feedback">
                <label for="cpasswd" class="col-sm-3 control-label">Confirm Password</label>
                <div class="col-sm-9">
                    <input type="password" class="form-control" id="cpasswd" name="cpasswd"
                           <?php if ($pwd2Valid){echo "value='$pwd2'";} else {echo "placeholder='Password is a required field.'";}?>>
                     <span class="glyphicon <?php if ($pwd2Valid){ echo  "glyphicon-ok" ;} else {echo "glyphicon-remove";}?> form-control-feedback"></span>
                </div>
              </div>        

            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-9">
                  <button type="submit" class="btn btn-primary">Register</button>
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



