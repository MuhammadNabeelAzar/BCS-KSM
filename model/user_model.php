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
        
        return $result;
    } 
    public function getaspecificuser($user_id){
        $con = $GLOBALS["con"];     
        $sql = "SELECT * FROM user WHERE user_id='$user_id'";
        $result = $con->query($sql) or die($con->error);
        
        return $result;
    }
    public function updateUser($firstname,$lastname,$email,$nic,$cno,$role,$user_id){
        $con = $GLOBALS["con"];
        $sql = " UPDATE user SET Fname = '$firstname',Lname = '$lastname' ,user_email = '$email' ,user_nic = '$nic',user_contactNo = '$cno' ,role_id = '$role' WHERE user_id = '$user_id'";
        $result = $con->query($sql) or die($con->error);
        
        return $result;
    } 
    public function removeUser($user_id){
        $con = $GLOBALS["con"];     
        $sql = "DELETE FROM user WHERE user_id='$user_id'";
        $result = $con->query($sql) or die($con->error);
        
        return $result;
    }

}
