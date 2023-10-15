<?php

include_once(__DIR__ . "/../commons/dbconnection.php");
$dbConnectionObj = new dbConnection();

class customer{
    
    Public function getcustomerdetails(){
        $con = $GLOBALS["con"];
        $sql = " SELECT * FROM customer";
        $result = $con->query($sql) or die($con->error);
        
        return $result;
    }
}