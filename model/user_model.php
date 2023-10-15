<?php

include_once(__DIR__ . "/../commons/dbconnection.php");
$dbConnectionObj = new dbConnection();

class user{
    
    Public function getUserdetails(){
        $con = $GLOBALS["con"];
        $sql = " SELECT * FROM user u JOIN role r ON u.role_id = r.role_id ORDER BY u.user_id ASC";
        $result = $con->query($sql) or die($con->error);
        
        return $result;
    }
}