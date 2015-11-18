<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    $mode;
    if (isset($_POST["inputSugarDelete"]))
    {
        $sugarDelete=$_POST["inputSugarDelete"];
        $mode="delete";
    }
    if (isset($_POST["inputSugarPercentage"]))
    {
        $sugarPercentage= $_POST["inputSugarPercentage"];
        $sugarDescription=$_POST["inputSugarDescription"];
        $mode="insert";
    }
    if (isset($_POST["updateSugarId"]))
    {
        $updateSugarId=$_POST["updateSugarId"];
        $updateSugarPercentage=$_POST["updateSugarPercentage"];
        $updateSugarDescription=$_POST["updateSugarDescription"];
        $mode="update";
    }
    
        
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
             if($mode=="insert")
                {
                $sql_insert = "INSERT INTO SugarLevel (percentage,levelDescription)VALUES (?,?)";
                $stmt = $conn->prepare($sql_insert);
                $stmt->bindValue(1, $sugarPercentage);
                $stmt->bindValue(2,  $sugarDescription);
                $stmt->execute();
                header("Location: staffmenu.php");
                 }
             if($mode=="delete")
                {
                $sql_select = "SELECT * FROM dbo.SugarLevel S where S.sugarLevelId =$sugarDelete" ;
                $stmt = $conn->query($sql_select);
                $sugarlevels = $stmt->fetchAll(); 
                $result=count($sugarlevels);
                if($result==1)
                    {
                    $sql_delete = "DELETE FROM dbo.SugarLevel where sugarLevelId =$sugarDelete" ;
                    $Query = $conn->query($sql_delete);
                    $deleteSugar = $Query->fetchAll(); 
                    header("Location: staffmenu.php");
                    }
                 }
             if($mode=="update")
                {
                $sql_select = "SELECT * FROM dbo.SugarLevel where sugarLevelId =$updateSugarId" ;
                $stmt = $conn->query($sql_select);
                $sugarlevels = $stmt->fetchAll(); 
                $result=count($sugarlevels);
                if($result==1)
                    {
                    $sql_update = "UPDATE dbo.SugarLevel SET percentage='$updateSugarPercentage',levelDescription='$updateSugarDescription' WHERE sugarLevelId =$updateSugarId" ;
                    $Query = $conn->query($sql_update);
                    header("Location: staffmenu.php");
                    }
                 }

        }


        
        catch(Exception $e) {
            die(var_dump($e));
        }
        
}

?>