
<html>
  <head>
  <div>
      <?php
        require_once "../../protected/team12/config.php";
        $host = DBHOST;
        $user = DBUSER;
        $pwd = DBPASS;
        $db =  DBNAME;

        // Connecting to database
        try {
            $conn = new PDO( "sqlsrv:Server= $host ; Database = $db ", $user, $pwd);
            $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
        }
        catch(Exception $e){
            die(var_dump($e));
        }
        
        $sql_select= "select drinkid, count(drinkid) as total from items i, Transactions t where t.orderId=i.orderId
and t.orderStatus='True' group by drinkId order by drinkId asc";
        $stmt = $conn->prepare($sql_select);
        $stmt->execute();
        $drinklist = $stmt->fetchAll();
        
        if(count($drinklist)>0)
        {
            echo '<table>';
            echo '<tr><td><strong><font color="#000000">Drink Id</td></font><td><strong><font color="#000000">Quantity</font></td></font></strong></tr>';
            foreach($drinklist as $drink)
            {
            $drinkid=$drink['drinkid'];
            $quantity=$drink['total'];
            
            echo '<tr><td>'.$drinkid.'</td><td>'.$quantity.'</td></tr>';
            }
            echo '</table>';
        }
?>
  </div>
  </head>
    <!--Div that will hold the pie chart-->
    <div id="chart_div"></div>
  </body>
</html>