<!DOCTYPE html>
<?php
session_start();

$current_url =  $_SERVER["QUERY_STRING"]; 
$categorysel = explode("=",$current_url);   
?>
<html>
    <head>
        <title>Milk Tea Treble</title>
        <link href="css/milktea_style.css" rel="stylesheet" type="text/css"/>
        <script src="http://maps.googleapis.com/maps/api/js"></script>
        <script type="text/javascript">

        </script>
    </head>
    <body>  
        <div class="container">
        <?php include "page_include/header.inc.php"?>
        <div class="container-fluid" class="col-md-12">
        <?php 
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
        catch(Exception $error){
            die(var_dump($error));
        }
        if($error!=null)
        {
            $output= "<p>Unable to connect to database<p>". $error;
            exit($output);
        }
            
            $sql_select="SELECT * from store";
            
            $stmt = $connection->query($sql_select);
            $storeList = $stmt->fetchAll();
            echo '<div class="col-xs-8 col-sm-8 col-md-6">';
            echo '<div class="panel-heading">';
            echo '<h1 class="panel-header">Store Information</h1>';
            echo '</div>';
            echo '<div class="panel-body">';
            foreach($storeList as $storename)
            {
                echo '<a href="http://maps.google.com/?q='.$storename[storeLocation].'" target="_blank" style ="color:#000000" class="thumbnail">';
                echo '<label>'.$storename['storeName'].'</label><p></p>';
                echo $storename['storeContact'].'<p></p>';
                echo $storename['storeLocation'].'<p></p>';
                echo '</a>';
            }
            echo '</div>';
            echo '</div>';
        ?>
        </div>
        <?php include "page_include/footer.inc.php"?>
        </div>    
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <script src="js/bootstrap.min.js" type="text/javascript"></script>
    </body>
</html>
>
