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
    </head>
    <body>  
        <div class="container">
        <?php include "page_include/header.inc.php"?>
        <div class="container-fluid" class="col-md-12">
        <div id="myCarousel" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                <?php
                echo '<li data-target="#myCarousel" data-slide-to="0" class="active"></li>';
                echo '<li data-target="#myCarousel" data-slide-to="1"></li>';
                echo '<li data-target="#myCarousel" data-slide-to="2"></li>';?>
            </ol>
            <div class="carousel-inner" role="listbox">
                    <?php
                    $listofimg = glob("images/carousel/*.jpg");
                    $count=0;
                    if(count($listofimg)>0)
                    {
                         foreach($listofimg as $img)
                        {
                            if($count==0)
                            {
                                echo '<div class="active item">';    
                                echo '<img class="carouselimg" id="image" src="'.$img.'"/>';
                                $count+=1;
                            }
                            else{
                                echo '<div class="item">';    
                                echo '<img class="carouselimg" id="image" src="'.$img.'"/>';
                            }
                            echo '</div>';
                        }
                    }
                    ?>
            </div>
                <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
            <span class="glyphicon glyphicon-chevron-left"></span>
        </a>
            <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
                <span class="glyphicon glyphicon-chevron-right"></span></a>
        </div>
<!--        <br>
        <p>Hi all!</p>
        <p>Welcome to <b>Treble Milk Tea.</b></p>
        <p>Thank you! Cheers! </p> -->
        </div>   
        <?php include "page_include/footer.inc.php"?>
         
        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <script src="js/bootstrap.min.js" type="text/javascript"></script>
    </body>
</html>
