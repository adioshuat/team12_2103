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
        <form class="form-horizontal" role="form" action="register_process.php" method="POST" >
        <h2>Register Account</h2>
        
              <div class="form-group">
                <label for="username" class="col-sm-3 control-label">User Name</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="username" name="username">
                </div>
              </div>
        
            <div class="form-group">
                <label for="name" class="col-sm-3 control-label">Name</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="username" name="name">
                </div>
              </div>

              <div class="form-group">
                <label for="email" class="col-sm-3 control-label">Email</label>
                <div class="col-sm-9">
                    <input type="email" class="form-control" id="email" name="email">
                </div>
              </div>

              <div class="form-group">
                <label for="passwd" class="col-sm-3 control-label">Password</label>
                <div class="col-sm-9">
                    <input type="password" class="form-control" id="passwd" name="passwd">
                </div>
              </div>

              <div class="form-group">
                <label for="cpasswd" class="col-sm-3 control-label">Confirm Password</label>
                <div class="col-sm-9">
                    <input type="password" class="form-control" id="cpasswd" name="cpasswd">
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



