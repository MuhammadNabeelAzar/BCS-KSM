<?php

include_once '../commons/dbconnection.php';
$dbConnectionObj = new dbConnection();

class Login{

    public function validateLogin($loginusername,$loginpassword)
    {
        $con = $GLOBALS["con"];
        $loginpassword = sha1($loginpassword);
        
        $sql = "SELECT u.user_fname,u.user_lname,u.user_email, u.user_id, u.user_role FROM user u,"
                ." login l WHERE u.user_id = l.user_id AND l.login_username='$loginusername'"
                    . " AND l.login_password='$loginpassword'";
        
        $result = $con->query($sql) or die($con->error);
        
        return $result;
    }
    public function addLogin($email,$nic,$user_id)
    {
        $nic= sha1($nic);
        $con = $GLOBALS["con"];
        
        $sql = "INSERT INTO login(login_username,login_password,user_id)VALUES('$email','$nic','$user_id')";
        
        $result = $con->query($sql) or die($con->error);
        
        return $result;
    }

}
