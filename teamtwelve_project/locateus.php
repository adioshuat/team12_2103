<!DOCTYPE html>
<?php
session_start();

?>

<html>
    <head>
        <title>Milk Tea Treble</title>
        <link href="css/milktea_style.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>  
        <div class="container">
        <?php include "page_include/header.inc.php"?>
        <div class="container-fluid" class="col-md-12">
                <div style="border: solid; width: 100%;" id="googleMap"></div>
        </div>   
        <?php include "page_include/footer.inc.php"?>
         
        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <script src="js/bootstrap.min.js" type="text/javascript"></script>
    </body>
</html>
