<?php

//get store data
require_once "../../protected/team12/config.php";
$host = DBHOST;
$user = DBUSER;
$pwd = DBPASS;
$db = DBNAME;

// Connecting to database
try {
    $conn = new PDO("sqlsrv:Server= $host ; Database = $db ", $user, $pwd);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    die(var_dump($e));
}

//get location filter
$locationFilterGet = $_GET['location'];
$locationFilter = str_replace("%"," ",$locationFilterGet);

//if all location
if ($locationFilter == 'ALL') {
    $query = "SELECT DATENAME(MONTH,timeofpurchase) as 'Month', COUNT(*), SUM(totalprice) as 'Total Sales'
    FROM transactions GROUP BY DATENAME(MONTH,timeofpurchase)";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $totalsalesList = $stmt->fetchAll();
    $data = array();
    if (count($totalsalesList) > 0) {
        foreach ($totalsalesList as $key => $sales) {

            $data[$key] = array(
                    'month' => $sales['Month'],
                    'total_sales' => round($sales['Total Sales'],2));
        }
        
        header('Content-type: application/json');
        echo json_encode($data);
    }
} else {
    $sql_selectstore = "SELECT DATENAME(MONTH,timeofpurchase) as 'Month', COUNT(*), SUM(totalprice) as 'Total Sales'
                        FROM transactions t, store st, staff stf
                        WHERE t.staffId=stf.staffId
                        AND stf.storeId=st.storeId
                        AND st.storeName = '" . $locationFilter . "'
                        GROUP BY DATENAME(MONTH,timeofpurchase),YEAR(timeofpurchase)";
    $stmt2 = $conn->prepare($sql_selectstore);
    $stmt2->execute();
    $storesalesList = $stmt2->fetchAll();
    $data =  array();
    if (count($storesalesList) > 0) {
        foreach ($storesalesList as $key => $storesales) {

            $data[$key] = array(
                    'month' => $storesales['Month'],
                    'total_sales' => round($storesales['Total Sales'],2));
        }
        header('Content-type: application/json');
        echo json_encode($data);
    }
}
            
            