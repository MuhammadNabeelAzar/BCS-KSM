<?php

include_once(__DIR__ . "/../commons/dbconnection.php");
$dbConnectionObj = new dbConnection();

class order
{
    public function d()
    {
        $con = $GLOBALS["con"];
        $sql = " ";
        $result = $con->query($sql) or die($con->error);

        return $result;
    }
    
    
}
?>