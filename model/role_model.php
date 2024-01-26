<?php 

include_once(__DIR__ . "/../commons/dbconnection.php");
$dbConnectionObj = new dbConnection();

class role{
    public function getUserRole($userid){
        $con = $GLOBALS["con"];
        
        $sql = "SELECT role_id FROM user WHERE user_id = $userid";
        
        $result = $con->query($sql) or die($con->error);
        
        return $result;
    }

}
?>