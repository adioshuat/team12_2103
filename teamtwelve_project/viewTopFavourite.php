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
        
        $sql= "SELECT name FROM filtercategory order by name";
        $stmtcat = $conn->prepare($sql);
        $stmtcat->execute();
        $catname = $stmtcat->fetchAll();?>
            
        <div class="container">
              <div class="form-group">
                  <h2>View Top 5 Favorite</h2></div>
              <div class="form-group">
                    <?php
                    echo 'Filter by: ';
                    echo '<select id="mySelect" onchange="drawChart()">';
                    echo '</option>';
                
                    foreach($catname as $name)
                    {
                        echo '<option id="option" value="'.$name['name'].'">'.$name['name'];
                        echo '</option>';
                    }
                    echo '</select>';
                    ?>
              </div>  
              <p id="filter"></p>
            <div id="chart_div"></div>
        </div>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript">
      google.load('visualization', '1.0', {'packages':['corechart']});
      google.setOnLoadCallback(drawChart);
      
      function drawChart() {
        var filter = document.getElementById("mySelect").value;
       
        var data = new google.visualization.DataTable();
                   
        data.addColumn('string', filter);
        data.addColumn('number', 'Quantity');
        
        if(filter==='Drink')
        {
        <?php
            $sql_select= "select top 5 i.drinkId, d.DrinkType, d.DrinkName, sum(i.quantity) as total from items i, Transactions t, Drinkbase d
                        where t.orderId=i.orderId
                        and d.DrinkId=i.drinkId
                        and t.orderStatus='True' 
                        group by i.drinkId,d.DrinkType,d.DrinkName
                        order by total desc";
            $stmt = $conn->prepare($sql_select);
            $stmt->execute();
            $drinklist = $stmt->fetchAll();
            
            if(count($drinklist)>0)
            {
                foreach($drinklist as $drink)
                {
                       $drinkconcat=$drink['DrinkType'].'-'.$drink['DrinkName']; 
                       echo "data.addRow(['{$drinkconcat}', {$drink['total']}]);";
                }
            }
        ?>}          
        else if(filter==='Ingredient')
        {
        <?php
            $sql_ing= "select top 5 i.ingredientId, ing.ingredientName, sum(i.quantity) as total from items i, Transactions t, Ingredient ing
                        where t.orderId=i.orderId
                        and ing.ingredientId=i.ingredientId
                        and t.orderStatus='True' 
                        group by i.ingredientId, ing.ingredientName
                        order by total desc";
            $stmt2 = $conn->prepare($sql_ing);
            $stmt2->execute();
            $inglist = $stmt2->fetchAll();
            
            if(count($inglist)>0)
            {
                foreach($inglist as $ingredient)
                {
                       echo "data.addRow(['{$ingredient['ingredientName']}', {$ingredient['total']}]);";
                }
            }
        ?>}
        else if(filter==='Store')
        {
        <?php
            $sql_store= "select top 5 st.staffId, sto.storeName, sum(i.quantity) as total from items i, Transactions t, Staff st, Store sto
                        where t.orderId=i.orderId
			and st.staffId=t.staffId
			and st.storeId=sto.storeId
                        and t.orderStatus='True' 
                        group by st.staffId, sto.storeName
                        order by total desc";
            $stmt3 = $conn->prepare($sql_store);
            $stmt3->execute();
            $storelist = $stmt3->fetchAll();
            
            if(count($storelist)>0)
            {
                foreach($storelist as $store)
                {
                       echo "data.addRow(['{$store['storeName']}', {$store['total']}]);";
                }
            }
        ?>}
        else if(filter==='Sugar Preference')
        {
        <?php
            $sql_sugar= "select top 5 i.sugarLevelId, sg.percentage, sum(i.quantity) as total from items i, Transactions t, SugarLevel sg
                        where t.orderId=i.orderId
                        and sg.sugarLevelId=i.sugarLevelId
                        and t.orderStatus='True' 
                        group by i.sugarLevelId,sg.percentage
                        order by total desc";
            $stmt4 = $conn->prepare($sql_sugar);
            $stmt4->execute();
            $sugarlist = $stmt4->fetchAll();
            
            if(count($sugarlist)>0)
            {
                foreach($sugarlist as $sugar)
                { 
                       echo "data.addRow(['{$sugar['percentage']}', {$sugar['total']}]);";
                }
            }
        ?>}   
        else if(filter==='Customer')
        {
        <?php
            $sql_customer= "select top 5 t.customerId, c.customerName, sum(i.quantity) as total from items i, Transactions t, Customer c
                        where t.orderId=i.orderId
			and c.customerId=t.customerId
                        and t.orderStatus='True' 
                        group by t.customerId, c.customerName
                        order by total desc";
            $stmt5 = $conn->prepare($sql_customer);
            $stmt5->execute();
            $customerlist = $stmt5->fetchAll();
            
            if(count($customerlist)>0)
            {
                foreach($customerlist as $cust)
                {
                       echo "data.addRow(['{$cust['customerName']}', {$cust['total']}]);";
                }
            }
        ?>} 
        else if(filter==='Staff')
        {
        <?php
            $sql_stf= "select top 5 t.staffId, st.staffName, sum(i.quantity) as total from items i, Transactions t, Staff st
                        where t.orderId=i.orderId
			and st.staffId=t.staffId
                        and t.orderStatus='True' 
                        group by t.staffId, st.staffName
                        order by total desc";
            $stmt6 = $conn->prepare($sql_stf);
            $stmt6->execute();
            $stafflist = $stmt6->fetchAll();
            
            if(count($stafflist)>0)
            {
                foreach($stafflist as $staff)
                {
                       echo "data.addRow(['{$staff['staffName']}', {$staff['total']}]);";
                }
            }
        ?>
        } 
                   
        var options = {
          title: 'Sales Result',
          'width':800,
          'height':500,
          displayAnnotations: true,
          bar: {groupWidth: "10%"},
          legend: {position: "bottom"}
        };
         
        var chart = new google.visualization.BarChart(document.getElementById('chart_div'));
       
        chart.draw(data, options);
      }
  </script>
</body>
</html>