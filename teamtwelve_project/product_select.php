<!DOCTYPE html>
<?php
session_start();

$current_url =  $_SERVER["QUERY_STRING"]; 
$drinksel = explode("=",$current_url);   
if(empty($drinksel[1]))
{
    header("Location: login.php");
}

if(isset($_SESSION['userid']))
{
    $userId= $_SESSION['userid'];
}
else{
    header("Location: login.php");
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
            $_SESSION['drinkid']=$drinksel[1];
            $drinkId= $drinksel[1];
            
            $sql_select= "SELECT DISTINCT drinkCategory, drinkType, drinkName, imageLocation from dbo.Drinkbase where drinkId= ?";
            $stmt = $connection->prepare($sql_select);
            $stmt->bindValue(1, $drinkId);
            $stmt->execute();
            $beverage = $stmt->fetchAll();
            echo '<div>';
            if(count($beverage) > 0) {  
                foreach($beverage as $bev)
                {
                    $myurl= 'images/beverage/'.$bev['drinkCategory'].'/'.$bev['imageLocation'];  
                    echo '<div class="col-xs-6 col-sm-4 col-md-3">';
                    echo '<h2>'.$bev['drinkType']." ".$bev['drinkName'];
                    echo '</h2>';
                    echo '<img src="'.$myurl.'" class="thumbnail">';
                    echo '</div>';
                    
                    //ingredient
                    echo '<div class="col-xs-6 col-sm-4 col-md-9">';
                    echo '<form class="form-horizontal" role="form" action="product_process.php" method="POST"';
                    $sql_selectingredient= "SELECT * FROM dbo.Ingredient ORDER BY ingredientId";
                    $stmting = $connection->query($sql_selectingredient);
                    $ingredient = $stmting->fetchAll();
                    echo '<div><table>';
                    echo '<tr>';
                    echo '<td><h3>Additional Ingredient: </h3>';
                    echo '<select name="ingredientoption">';
                    foreach($ingredient as $int)
                    { 
                        echo '<option id="optionint" value='.$int['ingredientId'].'>'.$int['ingredientName'];
                        echo '</option>';
                    }
                    echo '</select></td></tr>';
                    
                    $sql_selectsugar= "SELECT * FROM dbo.SugarLevel";
                    $stmtsug = $connection->query($sql_selectsugar);
                    $sugarlevel = $stmtsug->fetchAll();
                    echo '<tr>';
                    echo '<td><h3>Sugar Level: </h3>';
                    echo '<select name="sugaroption">';
                    foreach($sugarlevel as $sur)
                    { 
                        echo '<option id="optionsur" value='.$sur['sugarLevelId'].'>'.$sur['levelDescription'].'--'.$sur['percentage'];
                        echo '</option>';
                    }
                    echo '</select></td></tr>';
                    
                    $sql_selectcup= "SELECT * FROM dbo.Cup";
                    $stmtcup = $connection->query($sql_selectcup);
                    $cupsize = $stmtcup->fetchAll();
                    echo '<tr>';
                    echo '<td><h3>Cupsize: </h3>';
                    echo '<select name="cupoption">';
                    foreach($cupsize as $cup)
                    { 
                        echo '<option id="optioncup" value='.$cup['cupId'].'>'.$cup['cupName'];
                        echo '</option>';
                    }
                    echo '</select></td></tr>';
                    
                    echo '<tr>';
                    echo '<td><h3>Quantity: </h3>';
                    echo '<input type="number" pattern="^[0-50]" min="1" value="1" placeholder="Pick a number" name="numOfDrink" id="numOfDrink" />';
                    echo '</td></tr>';
                    
                    echo '<tr><td><input type="text" id="drinkid" name="drinkid" style="display:none;" value='.$drinksel[1].'></td></tr>';
                    echo '<tr><td><br/></td></tr>';
                    echo '<tr>';
                    
                    echo '<td><button type="submit" class="btn btn-success">Submit</button></td></tr>';
                    echo '</table>';
                    echo '<p></p>';
                    echo '</form>';
                    echo '</div>';
                }
            }
            else{
                echo "<h3>No image found.</h3>";
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
