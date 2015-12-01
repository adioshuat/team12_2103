<?php
?>
    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="../images/favicon.ico">
    <!-- Custom styles for this template -->
    <link href="css/staff-menu.css" rel="stylesheet">
    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
<?php $currentPage = basename($_SERVER['SCRIPT_FILENAME']); ?>
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="staffmenu.php">Treble</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
	<li <?php if($currentPage == "staffmenu.php") {echo ' class = "active"';} ?> ><a 	href="staffmenu.php"><span class="glyphicon glyphicon-home"></span> Home</a></li>
	<li <?php if ($currentPage == "billing.php") {echo 'class = "active"'; } ?>><a href="billing.php"><span 	class="glyphicon glyphicon-check"></span> Billing</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>
