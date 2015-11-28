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
                    ?>
              <p id="filter"></p>
              </div>
              <div class="form-group">
              <p id="tablesearch"></p>
              </div>  
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
    
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
                myArr = JSON.parse(xmlhttp.responseText);
                html += '<br/><table width="50%" border="1">';
                html += "<tr><td><strong><font color='#000000'>No.</font></strong></td><td><strong><font color='#000000'>Customer Name</font></strong></td><td><strong><font color='#000000'>Email</font></strong></td><td><strong><font color='#000000'>Total Spending ($)</font></strong></td></tr>";
                for (var i = 0; i < myArr.length; i++) {
                  html += "<tr><td>"+count+"</td><td>" + myArr[i].customer + "</td><td>" + myArr[i].email + "</td><td>" + myArr[i].spent + "</td></tr>";
                  count++;
                }
                html += '</table>';
                
                document.getElementById("tablesearch").innerHTML =  html;
            }
            else{
                document.getElementById("tablesearch").innerHTML =  "<b>No results found...</b>";
            }
        };
        xmlhttp.open("GET", url, true);
        xmlhttp.send();
      }
  </script>
</body>
</html>