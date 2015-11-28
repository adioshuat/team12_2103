
<html lang="en">
        <head>
          <meta charset="utf-8">
          <meta http-equiv="X-UA-Compatible" content="IE=edge">
          <meta name="viewport" content="width=device-width, initial-scale=1">
          <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
          <meta name="description" content="">
          <meta name="author" content="">
          <link rel="icon" href="../../favicon.ico">

        <title>Staff menu</title>

        <?php include "page_include/staffheader.inc.php"?>
      </head>
      <body>
      <div class="container">
          <p id="fitler"></p>
            <h2>View Sales</h2>
        <?php
        session_start();
        
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
        
        $sql= "SELECT DISTINCT(storeName) FROM store order by storeName";
        $stmtcat = $conn->prepare($sql);
        $stmtcat->execute();
        $catname = $stmtcat->fetchAll();
        
        echo 'Filter: ';
        echo '<select id="mySelect" onchange="drawChart()">';
        echo '<option id="option" value="ALL">ALL';
        echo '</option>';
        
        foreach($catname as $name)
        {
            echo '<option id="option" value="'.$name['storeName'].'">'.$name['storeName'];
            echo '</option>';
        }
        echo '</select>';
        echo '<p></p>';
        ?>
            
  <p id="filter"></p>
  <div align="center" id="chart_div"></div>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript">
      google.load('visualization', '1.0', {'packages':['corechart']});
      google.setOnLoadCallback(drawChart);
      
      function drawChart() {
        var filter = document.getElementById("mySelect").value;
        document.getElementById("filter").innerHTML = "You selected to filter: " + filter;
        
        document.cookie="profile_viewer_uid="+ filter;
        
        var data = new google.visualization.DataTable();
 
        data.addColumn('string', 'Month');
        data.addColumn('number', 'Total Sales'); 
        document.getElementById("filter").innerhtml=filter;
        if(filter==='ALL')
        {
        <?php
            $sql_select= "SELECT DATENAME(MONTH,timeofpurchase) as 'Month', YEAR(timeofpurchase) as 'Year', COUNT(*) transactions, SUM(totalprice) as 'Total Sales'
FROM transactions GROUP BY DATENAME(MONTH,timeofpurchase),YEAR(timeofpurchase)";
            $stmt = $conn->prepare($sql_select);
            $stmt->execute();
            $totalsalesList = $stmt->fetchAll();
            
            if(count($totalsalesList)>0)
            {
                foreach($totalsalesList as $sales)
                {
                       $datesales=$sales['Month'].'/'.$sales['Year'];
                       echo "data.addRow(['{$datesales}', {$sales['Total Sales']}]);";
                }
            }
        ?>
        }
        else{
        <?php
            $dom = new DOMDocument();
            $belement = $dom->getElementById("filter");
            echo $belement->nodeValue;
            $profile_viewer_uid = $_COOKIE['profile_viewer_uid'];
            $sql_selectstore= "SELECT DATENAME(MONTH,timeofpurchase) as 'Month', YEAR(timeofpurchase) as 'Year', COUNT(*) transactions, SUM(totalprice) as 'Total Sales'
                        FROM transactions t, store st, staff stf
                        WHERE t.staffId=stf.staffId
                        AND stf.storeId=st.storeId
                        AND st.storeName LIKE '".$belement."%'
                        GROUP BY DATENAME(MONTH,timeofpurchase),YEAR(timeofpurchase)";
            $stmt2 = $conn->prepare($sql_selectstore);
            $stmt2->execute();
            $storesalesList = $stmt2->fetchAll();
            
            if(count($storesalesList)>0)
            {
                foreach($storesalesList as $storesales)
                {
                       $datesalesstore=$storesales['Month'].'/'.$storesales['Year'];
                       echo "data.addRow(['{$datesalesstore}', {$storesales['Total Sales']}]);";
                }
            }
        ?>
        }      
        var options = {
                title : 'Monthly Sales',
                vAxis: {title: 'Sales($)'},
                hAxis: {title: 'Month'},
                seriesType: 'bars',
                series: {5: {type: 'line'}}
            };
            
        var chart = new google.visualization.ComboChart(document.getElementById('chart_div'));
        
        chart.draw(data, options);
        
      }
  </script>
</body>
</html>