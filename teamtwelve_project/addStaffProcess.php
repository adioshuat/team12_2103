<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    $storeName= $_POST["inputStaffName"];
    //$storeLocation=$_POST["inputPassword"];
    $storeLocation="location";
    $storeContact="1234567";
    $storeID="38";
//    if (isset($_POST["username"]))
//    {
//        $username = trim($_POST["username"]);
//        if (!empty($username))    
//        {
//            if($username != "User Name is a required field." )
//                $usernameValid = true;
//        }
//    }
//    if (isset($_POST["name"]))
//    {
//        $name = trim($_POST["name"]);
//        if (!empty($name))    
//        {
//            if($name != "Name is a required field." )
//                $nameValid = true;
//        }
//    }
//        
//    if (isset($_POST["email"]))
//    {
//        $email = trim($_POST["email"]);
//        $emailPattern = "/^(.+)@([^\.].*)\.([a-z]{2,})$/";
//        $emailValid = preg_match($emailPattern, $email);
//    }
//        
//    if (isset($_POST["passwd"]))
//    {
//        $pwd1 = $_POST["passwd"];
//        $pwd1Valid = true;
//    }
//   
//    if (isset($_POST["cpasswd"]))
//    {
//        if($pwd1Valid)
//        {
//            $pwd2 = $_POST["cpasswd"];
//            $pwd2Valid = ($pwd1 == $pwd2);
//        }
//    }
//
//    
//    if ($usernameValid && $emailValid && $pwd1Valid && $pwd2Valid)
//    {
//        session_start();
        
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
//            $sql_insert = "INSERT INTO Store (storeName,storeLocation,storeContact)
//                                   VALUES (?,?,?)";
//
//            $stmt = $conn->prepare($sql_insert);
//           // $stmt->bindValue(1, $storeID);
//            $stmt->bindValue(1, $storeName);
//            $stmt->bindValue(2,  $storeLocation);
//            $stmt->bindValue(3, $storeContact);
//            $stmt->execute();
//            
//            $_SESSION['registered']=true;
            $sql_select = "SELECT * FROM dbo.Store";
$stmt = $conn->query($sql_select);
$registrants = $stmt->fetchAll(); 
    console.log($registrants);
    echo "<h2>People who are registered:</h2>";
    echo "<table>";
    echo "<tr><th>Name</th>";
    echo "<th>Email</th>";
    echo "<th>Date</th></tr>";
    foreach($registrants as $registrant) {
        echo "<tr><td>".$registrant['storeName']."</td>";
        echo "<td>".$registrant['storeLocation']."</td>";
        echo "<td>".$registrant['storeContact']."</td></tr>";
    }
    echo "</table>";
            //header("Location: login.php");
        }
        catch(Exception $e) {
            die(var_dump($e));
        }
//        }
}
?>