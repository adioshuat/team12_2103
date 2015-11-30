<!DOCTYPE html>
<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST")
{
     if (isset($_POST["searchText"]))
    {
         $searchvalue=$_POST["searchText"];
    }
}
?>

<html>
    <head>
        <title>Milk Tea Treble</title>
        <link href="css/milktea_style.css" rel="stylesheet" type="text/css"/>
        <script src="milktea_script.js" type="text/javascript"></script>
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
        
            $searchFilter = str_replace(" ","%",$searchvalue);
            $sql_select= "SELECT CONCAT(DrinkType, ' ', DrinkName) as 'drinkFullName' 
                            FROM Drinkbase where CONCAT(DrinkType, ' ', DrinkName) LIKE '%".$searchFilter."%'";
            $stmt = $connection->prepare($sql_select);
            $stmt->bindValue(1, $searchvalue);
            $stmt->execute();
            $searchlist = $stmt->fetchAll();
            echo '<div>';
            $countsearch= count($searchlist);
            if(count($searchlist) > 0) {  
                echo '<h3>'.$countsearch.' results found..</h3><p></p>';  
                foreach($searchlist as $search)
                {   
                    echo '<div class="col-xs-8 col-sm-4 col-md-3">';
                    echo '<a href="product_select.php?id='.$search['DrinkId'].'" class="thumbnail">';
                    echo '<img src="images/beverage/'.$search['DrinkCategory'].'/'.$search['imageLocation'].'"/>';
                    echo '<caption>'.$search['DrinkType'].' '.$search['DrinkName'];
                    echo '</caption>';
                    echo '</a>';
                    echo '</div>';
                }
            }
            else{
                echo "<h3>No results found.</h3>";
                echo '<p></p>';
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
