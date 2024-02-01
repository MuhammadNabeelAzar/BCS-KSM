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
    Public function getroles(){
        $con = $GLOBALS["con"];
        $sql = " SELECT * FROM role";
        $result = $con->query($sql) or die($con->error);
        
        return $result;
    }
    public function addUser($firstname,$lastname,$dob,$email,$nic,$cno,$role){
        $con = $GLOBALS["con"];
        $sql = " INSERT INTO user(Fname,Lname,user_email,user_dob,user_nic,user_contactNo,role_id) values('$firstname','$lastname','$email','$dob','$nic','$cno','$role')";
        $result = $con->query($sql) or die($con->error);
        if ($result) {
            // Retrieve the last inserted ID
            $lastInsertId = $con->insert_id;
            return $lastInsertId;
        }
    } 
    public function addUserLogin($email,$nic,$user_id){
        $con = $GLOBALS["con"];
        $sql = " INSERT INTO login(login_email,login_password,user_id) values('$email','$nic','$user_id')";
        $result = $con->query($sql) or die($con->error);
        
        return $result;
    } 
    public function getaspecificuser($user_id){
        $con = $GLOBALS["con"];     
        $sql = "SELECT * FROM user WHERE user_id='$user_id'";
        $result = $con->query($sql) or die($con->error);
        
        return $result;
    }
    public function getPassword($user_id){
        $con = $GLOBALS["con"];     
        $sql = "SELECT login_password FROM login WHERE user_id='$user_id'";
        $result = $con->query($sql) or die($con->error);
        return $result ;
    }
    public function updateUser($firstname,$lastname,$email,$nic,$dob,$cno,$role,$user_id){
        $con = $GLOBALS["con"];
        $sql = " UPDATE user SET Fname = '$firstname',Lname = '$lastname' ,user_email = '$email' ,user_nic = '$nic',user_dob = '$dob' ,user_contactNo = '$cno' ,role_id = '$role' WHERE user_id = '$user_id'";
        $result = $con->query($sql) or die($con->error);
        
        return $result;
    } 
    public function removeUser($user_id){
        $con = $GLOBALS["con"];     
        $sql = "DELETE FROM user WHERE user_id='$user_id'";
        $result = $con->query($sql) or die($con->error);
        
        return $result;
    }
    public function resetPassword($user_id,$new_password){
        $newHashedPassword = password_hash($new_password,PASSWORD_DEFAULT);
        $con = $GLOBALS["con"];     
        $sql = "UPDATE login SET login_password = '$newHashedPassword'  WHERE user_id = '$user_id'";
        $result = $con->query($sql) or die($con->error);
        
        return $result;
    }

}
