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
$locationFilterGet = $_GET['storelocation'];
$locationFilter = str_replace("%"," ",$locationFilterGet);

    if($locationFilter=='ALL')
    {
        $sql_selectstore = "SELECT distinct c.customerId, c.customerName, c.email, SUM(t.totalPrice) as 'spent' FROM Customer c, Transactions t 
                            where c.customerId=t.customerId group by c.customerId, c.customerName, c.email having c.customerId in 
                            (SELECT customerId FROM dbo.Transactions t WHERE staffId in
                            (SELECT staffId FROM dbo.staff st where st.storeId in
                            (SELECT storeID FROM dbo.Store))) order by spent desc
                            ";
    }
    else{
        $sql_selectstore = "SELECT distinct c.customerId, c.customerName, c.email, SUM(t.totalPrice) as 'spent' FROM Customer c, Transactions t 
                            where c.customerId=t.customerId group by c.customerId, c.customerName, c.email having c.customerId in 
                            (SELECT customerId FROM dbo.Transactions t WHERE staffId=
                            (SELECT staffId FROM dbo.staff st where st.storeId=
                            (SELECT storeID FROM dbo.Store s where storeName='".$locationFilter."'))) order by spent desc";
    }
    $stmt2 = $conn->prepare($sql_selectstore);
    $stmt2->execute();
    $storesalesList = $stmt2->fetchAll();
    $data =  array();
    if (count($storesalesList) > 0) {
        foreach ($storesalesList as $key => $result) {

            $data[$key] = array(
                    'customer' => $result['customerName'],
                    'email' => $result['email'],
                    'spent' => round($result['spent'],2));
        }
        header('Content-type: application/json');
        echo json_encode($data);
    }
            