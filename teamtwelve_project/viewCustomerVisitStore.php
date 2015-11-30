<?php
session_start();

if(isset($_SESSION['staffId'])&&$_SESSION['adminStatus']=='YES')
{
    $_SESSION['adminStatus'];
    $_SESSION['staffId'];
    $_SESSION['storeId'];
    $_SESSION['staffName'];
    echo '<div class="alert alert-success" role="alert">Welcome '.$_SESSION["staffName"].' <a href="logout.php">Click here to logout</a></div>';
}
else if(isset($_SESSION['staffId']))
{
    $message = "You would need admin rights to proceed!";
    echo "<script type='text/javascript'>alert('$message');window.location.href='staffmenu.php';</script>";
}
else{
    header("Location: stafflogin.php");
}
?>
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
            <div class="form-group">
            <h2>View Customer Visits</h2>
            </div>
            <div class="form-group">
                    <?php
                    echo 'Filter by: ';
                    echo '<select id="mySelect" onchange="searchCustomer()">';
                    echo '<option id="option" value="ALL">ALL';
                    echo '</option>';

                    foreach($catname as $name)
                    {
                        echo '<option id="option" value="'.$name['storeName'].'">'.$name['storeName'];
                        echo '</option>';
                    }
                    echo '</select>';
                    echo '<p></p>';
                    echo 'Display in Pie-Chart view <input type="checkbox" onClick="searchCustomer()" id="myCheck">';
                    ?>
                <p id="tablesearch"></p>
            </div>
            <div id="chart_div"></div>
        </div>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript">
      google.load('visualization', '1.0', {'packages':['corechart']});
      google.setOnLoadCallback(searchCustomer);
      
      function searchCustomer() {
        var filter = document.getElementById("mySelect").value;
        
        var xmlhttp = new XMLHttpRequest();
        var url = 'viewCustomerVisitStore_process.php?storelocation=' + filter;
        var myArr = [];
        var html = "";
        var count=1;
        
        var data = new google.visualization.DataTable();
                   
        data.addColumn('string', 'Customer Name');
        data.addColumn('number', 'Total Sales');
    
        var chartData = [];
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
                myArr = JSON.parse(xmlhttp.responseText);
                html += '<br><table width="50%" border="1">';
                html += "<tr><td><strong><font color='#000000'>No.</font></strong></td><td><strong><font color='#000000'>Customer Name</font></strong></td><td><strong><font color='#000000'>Email</font></strong></td><td><strong><font color='#000000'>Total Spending ($)</font></strong></td></tr>";
                for (var i = 0; i < myArr.length; i++) {
                  chartData.push([myArr[i].customer, myArr[i].spent]);
                  html += "<tr><td>"+count+"</td><td>" + myArr[i].customer + "</td><td>" + myArr[i].email + "</td><td>" + myArr[i].spent + "</td></tr>";
                  count++;
                }
                html += '</table>';
                
                data.addRows(chartData); 
        
                var options = {
                  title: 'Customer Spending',
                  'width':800,
                  'height':450,
                  bar: {groupWidth: "10%"},
                  legend: {position: "bottom"}
                };

                if(document.getElementById('myCheck').checked === true)
                {
                     var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
                     document.getElementById("chart_div").style.visibility = "visible";
                     document.getElementById("tablesearch").innerHTML = "";
                     document.getElementById("tablesearch").style.visibility = "hidden";
                     chart.draw(data, options);
                }
                else{
                    document.getElementById("chart_div").style.visibility = "hidden";
                    document.getElementById("tablesearch").style.visibility = "visible";
                    document.getElementById("tablesearch").innerHTML =  html;
                }
            }
            else{
                document.getElementById("chart_div").style.visibility = "hidden";
                document.getElementById("tablesearch").style.visibility = "visible";
                document.getElementById("tablesearch").innerHTML =  "<br><b>No results found...</b>";
            }
        };
        xmlhttp.open("GET", url, true);
        xmlhttp.send();
      }
  </script>
</body>
</html>