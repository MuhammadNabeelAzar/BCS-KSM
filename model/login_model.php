<?php 

include_once '../commons/dbconnection.php';
$dbConnectionObj = new dbConnection();

class Login{

    public function validateLogin($username,$password)
    {
        $con = $GLOBALS["con"];
        
        $sql = "SELECT login.*, user.user_email, user.user_id, user.role_id  FROM login
        JOIN user ON login.user_id = user.user_id
         WHERE login.login_email='$username'";
        
        $result = $con->query($sql) or die($con->error);
        if($result->num_rows >0){
            $row = $result->fetch_assoc();

            if (password_verify($password,$row['login_password'])){
                return $row;
            }
        }
        return null;
    }     
}
