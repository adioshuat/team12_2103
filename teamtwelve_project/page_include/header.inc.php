<?php
    if(isset($_SESSION['userid']))
    {
        $userid= $_SESSION['userid'];  
        $username=$_SESSION['username'];
    }
    
?>
<link href="../css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
<link href="../css/milktea_style.css" rel="stylesheet" ztype="text/css"/>
<header>
    <nav class="navbar navbar-default" >
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" 
                        data-target="#bs-example-navbar-collapse-1">
                    <span class="icon-bar"></span>       
                    <span class="icon-bar"></span>  
                    <span class="icon-bar"></span> 
                </button>
            </div>

            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <?php if($username){echo '<span style="float:right;" id="username">You are logged in as, ';echo $username; echo'</span><br>';} else{echo '<br>';} ?>
                <?php $currentPage = basename($_SERVER['SCRIPT_FILENAME']); ?>
                <ul class="nav navbar-nav">
                   <li <?php if($currentPage == "index.php") {echo ' class = "active"';} ?> ><a href="index.php"><span class="glyphicon glyphicon-home"></span> Home</a></li>
                   <li <?php if ($currentPage == "product.php") {echo 'class = "active"'; } ?>><a href="product.php"><span class="glyphicon glyphicon-cutlery"></span> Product</a></li>
                   <li <?php if ($currentPage == "register.php" || $currentPage == "viewtransaction.php") {echo 'class = "active"'; } ?>>
                    <?php if($userid!=''){
                        echo '<a href="viewtransaction.php"><span class="glyphicon glyphicon-check"></span> My Orders</a>';
                    }
                    else{ 
                    echo '<a href="register.php"><span class="glyphicon glyphicon-user"></span> Register/Login</a>';
                    }
                    ?></li>
                  <?php if($userid!=''){
                        echo ' <li><a href="ordershistory.php"><span class="glyphicon glyphicon-book"></span> View History</a></li>';
                    }?>
                </ul>
         
                <form class="navbar-form navbar-right" role="form" action="product_search.php" method="post">
                <div class="form-group">
                    <input type="text" name='searchText' id='searchText' class="form-control" size="30" placeholder="Looking for something?"/>         
                    <button type="submit" id="buttonSearch" class="glyphicon glyphicon-search btn-sm"></button>
                </div>
                </form>
            </div>
            </nav>
</header> 
