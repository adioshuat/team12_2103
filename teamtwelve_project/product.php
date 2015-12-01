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
	<link rel="shortcut icon" href="/images/favicon.ico">
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
            
            $sql_select="SELECT DISTINCT drinkCategory from dbo.Drinkbase";
            
            $stmt = $connection->query($sql_select);
            $categories = $stmt->fetchAll(); 
            $count=0;
            if(count($categories) > 0) {   
                echo '<div class="col-xs-6 col-sm-3 col-md-3">';
                echo '<div class="panel-heading">';
                echo '<h1 class="panel-header">Product</h1>';
                echo '</div>';  
                echo '<div class="panel-body">';
                foreach($categories as $cat) {
                    if($categorysel[1]==$cat[drinkCategory])
                    {
                        echo '<ul class="nav nav-pills nav-stacked">';
                        echo '<li class="active"><a href="product.php?id='.$cat[drinkCategory].'"">'.$cat[drinkCategory].'</a></li>';
                        echo '</ul>'; 
                        $_SESSION['category']=$cat[drinkCategory];
                    }
                    else if($count==0 && $categorysel[1]=='')
                    {
                        echo '<ul class="nav nav-pills nav-stacked">';
                        echo '<li class="active"><a href="product.php?id='.$cat[drinkCategory].'"">'.$cat[drinkCategory].'</a></li>';
                        echo '</ul>'; 
                        $_SESSION['category']=$cat[drinkCategory];
                    }
                    else{
                        echo '<ul class="nav nav-pills nav-stacked">';
                        echo '<li><a href="product.php?id='.$cat[drinkCategory].'"">'.$cat[drinkCategory].'</a></li>';
                        echo '</ul>';
                    }
                    $count=$count+1;
                }
                echo '</div>';
                echo '</div>';
            }
            echo '<div class="col-xs-10 col-sm-9 col-md-9">';
            echo '<p><br></p>';
            $drinkCategory=$_SESSION['category'];
            if(isset($_SESSION['category']))
            {
                $myurl= 'images/beverage/'.$drinkCategory;    
            }
            
            $sql_select= "SELECT drinkId,drinkType,drinkCategory,drinkName,imageLocation from dbo.Drinkbase where drinkCategory='".$drinkCategory."'";
          
            $stmt = $connection->query($sql_select);
            $beverages = $stmt->fetchAll(); 
            if(count($beverages) > 0) {   
                foreach($beverages as $bev) {
                    echo '<div class="col-xs-6 col-sm-4 col-md-3">';
                    $photo= (basename($bev['imageLocation'],'.jpg'));
                    echo '<a href="product_select.php?id='.$bev['drinkId'].'" class="thumbnail">';
                    echo '<img src="'.$myurl.'/'.$bev['imageLocation'].'"/>';
                    echo '<caption>'.$bev['drinkType'].' '.$bev['drinkName'];
                    echo '</caption>';
                    echo '</a>';
                    echo '</div>';
                }
            }
            else{
                echo "<h3>No image found.</h3>";
            }            
            echo '</div>';

        ?>
        </div>
        <?php include "page_include/footer.inc.php"?>
        </div>    
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <script src="js/bootstrap.min.js" type="text/javascript"></script>
    </body>
</html>
