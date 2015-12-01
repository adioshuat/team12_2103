<?php 
session_start();
if(isset($_SESSION['staffId']))
{
    $_SESSION['adminStatus'];
    $_SESSION['staffId'];
    $_SESSION['storeId'];
    $_SESSION['staffName'];
    echo '<div class="alert alert-success" role="alert">Welcome '.$_SESSION["staffName"].' <a href="logout.php">Click here to logout</a></div></div>';
}
else{
    header("Location: stafflogin.php");
}
?>

<?php
session_start();
   
//    if ($usernameValid && $emailValid && $pwd1Valid && $pwd2Valid)
//    {
//        session_start();
if($_SERVER["REQUEST_METHOD"] == "GET")
    {
        $customerId=$_GET["searchCustomerId"];
        $customerName=$_GET["searchCustomerName"];
        $orderId=$_GET["searchOrderId"];        
        if(isset($_GET["searchCustomerId"]) && $customerId!="")
        {            
            $message="Searching by customer ID: $customerId";
            $sql_select = "SELECT * FROM orderStatus_False WHERE customerId='$customerId'" ;
        }
        else if(isset($_GET["searchCustomerName"])&& $customerName!="")
        {   
             $message="Searching by customer Name: $customerName";
            //looking if a customer contain that name
            $sql_select = "SELECT * FROM orderStatus_False WHERE customerName like '%$customerName%'" ;
        }
        else if(isset($_GET["searchOrderId"])&& $orderId!="")
        {
            $message="Searching by order ID: $orderId";
            $sql_select = "SELECT * FROM orderStatus_False WHERE orderId='$orderId'" ;
        }
        else{
            $message="";
            $sql_select = "SELECT * FROM orderStatus_False" ;
        }
    }
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
        
        try{
    $stmt = $conn->query($sql_select);
    $transactions = $stmt->fetchAll(); 
    ?>
    <html lang="en">
        <head>
          <meta charset="utf-8">
          <meta http-equiv="X-UA-Compatible" content="IE=edge">
          <meta name="viewport" content="width=device-width, initial-scale=1">
          <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
          <meta name="description" content="">
          <meta name="author" content="">
          <link rel="shortcut icon" href="/images/favicon.ico">

        <title>Billing</title>

        <?php include "page_include/staffheader.inc.php"?>
      </head>

  
      <div class="container">
            <h2>View Transaction <?php echo $message; ?></h2>
            <form class="form-horizontal" action="billing.php" method="get" role="form">
              <div class="form-group" >
                <label for="searchCustomerId" class="col-sm-2 control-label">Search Customer ID</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="searchCustomerId" name="searchCustomerId" placeholder="">
                </div>
              </div>
              <div class="form-group">
                <label for="searchCustomerName" class="col-sm-2 control-label">Search Customer Name</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="searchCustomerName" name="searchCustomerName" placeholder="">
                </div>
              </div>
              <div class="form-group">
                <label for="searchOrderId" class="col-sm-2 control-label">Search Order ID</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="searchOrderId" name="searchOrderId" placeholder="">
                </div>
              </div>
              <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                  <button type="submit" class="btn btn-success">Search</button>
                </div>
              </div>
            </form>
            <form class="form-horizontal">
              <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                  <button class="btn btn-default">Clear</button>
                </div>
              </div>
             </form>
            <table class="viewIngredient table-bordered">
            <tr>
                <th>Transaction ID</th>
                <th>Order ID</th>
                <th>Total Price</th>
                <th>Order Status</th>
                <th>Customer ID</th>
                <th>Customer Name</th>
                <th></th>
            </tr>
            <?php
            foreach($transactions as $transaction) {
                echo "<tr>";
                echo "<td>".$transaction['ID']."</td>";
                echo "<td>".$transaction['orderId']."</td>";
                echo "<td>".round($transaction['totalPrice'],2)."</td>";
                echo "<td>".$transaction['orderStatus']."</td>";
                echo "<td>".$transaction['customerId']."</td>";
                echo "<td>".$transaction['customerName']."</td>";
                echo "<td><form action='viewBilling.php' form method='get'><button class='btn btn-success' id='selectOrder' name='selectOrder' value=".$transaction['orderId'].">Order</button></form></td>";
                echo "</tr>";
            }
            ?>
          </table>
      </div>
    <?php
    }
        catch(Exception $e) {
            die(var_dump($e));
        }
//        }

?>