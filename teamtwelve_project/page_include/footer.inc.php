<?php 
if(isset($_SESSION['userid']))
{
    $userid=$_SESSION['userid'];
}
?>
    <footer class="footer">
    <div class="alert alert-success col-lg-12">
        <p>Copyright 2015 Milk Tea Treble Team</p>
        <p><a href="locateus.php">Contact Us</a> <?php if($userid){echo '| <a href="logout.php">Log out</a>';} else{echo '| <a href="login.php">Log in</a>';} ?>    |     <a href="viewtransaction.php">My Orders</a></p>
    </div>
    </footer>        