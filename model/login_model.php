<?php 

include_once '../commons/dbconnection.php';
$dbConnectionObj = new dbConnection();

class Login{

    public function validateLogin($loginusername,$loginpassword)
    {
        $con = $GLOBALS["con"];
        $loginpassword = sha1($loginpassword);
        
        $sql = "SELECT u.Fname,u.Lname,u.user_email, u.user_id, u.role_id FROM user u,"
                . "login l WHERE u.user_id = l.user_id AND l.login_username='$loginusername'"
                . "AND l.login_password='$loginpassword'";
        
        $result = $con->query($sql) or die($con->error);
        
        return $result;
    }  
}
