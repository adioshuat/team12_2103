   <html lang="en">
        <head>
          <meta charset="utf-8">
          <meta http-equiv="X-UA-Compatible" content="IE=edge">
          <meta name="viewport" content="width=device-width, initial-scale=1">
          <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these 
tags -->
          <meta name="description" content="">
          <meta name="author" content="">
          <link rel="icon" href="../../favicon.ico">

        <title>Staff menu</title>

        <?php include "page_include/staffheader.inc.php"?>
      </head>
      <body>

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
        $catname = $stmtcat->fetchAll();?>
        <div class="container">
            <h2>View Store Sales</h2>
              <div class="form-group">
                    <?php
                    echo '<select id="mySelect" onchange="drawChart()">';
                    echo '<option id="option" value="ALL">ALL';
                    echo '</option>';

                    foreach($catname as $name)
                    {
                        echo '<option id="option" value="'.$name['storeName'].'">'.$name['storeName'];
                        echo '</option>';
                    }
                    echo '</select>';
                    ?>
              </div>  
              <p id="filter"></p>
             <div class="form-group" id="chart_div"></div>
        </div>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript">
      google.load('visualization', '1.0', {'packages':['corechart']});
      google.setOnLoadCallback(drawChart);
      
      function drawChart() {
        var filter = document.getElementById("mySelect").value;
        console.log(filter);
        document.getElementById("filter").innerHTML = "You selected to filter: " + filter;
        
        var data = new google.visualization.DataTable();
 
        data.addColumn('string', 'Month');
        data.addColumn('number', 'Revenue');
        
        var xmlhttp = new XMLHttpRequest();
        var url = 'viewStoreSales_process.php?location=' + filter;
        var myArr = [];
        var chartData = [];
        
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
                myArr = JSON.parse(xmlhttp.responseText);
                for (var i=0; i<myArr.length; i++) {
                    chartData.push([myArr[i].month, myArr[i].total_sales]);
                }
                console.log(chartData);
                data.addRows(chartData); 
                var options = {
                    title : 'Monthly Sales',
                    vAxis: {title: 'Sales'},
                    hAxis: {title: 'Month'},
                    seriesType: 'bars',
                    'width':800,
                    'height':500,
                    displayAnnotations: true,
                    series: {5: {type: 'line'}},
                    bar: {groupWidth: "10%"},
                    legend: {position: "bottom"}
                };

                var chart = new google.visualization.ComboChart(document.getElementById('chart_div'));

                chart.draw(data, options);
            }
        };
        xmlhttp.open("GET", url, true);
        xmlhttp.send();
      }
  </script>
</body>
</html>