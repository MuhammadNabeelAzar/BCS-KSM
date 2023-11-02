<?php 

include_once(__DIR__ . "/../commons/dbconnection.php");
$dbConnectionObj = new dbConnection();

class menu{
    Public function getcategories(){
        $con = $GLOBALS["con"];
        $sql = " SELECT * FROM categories";
        $result = $con->query($sql) or die($con->error);
        
        return $result;
    }
    Public function addcategory($categoryName){
        $con = $GLOBALS["con"];
        $sql = " INSERT INTO categories(category_name) values('$categoryName')";
        $result = $con->query($sql) or die($con->error);
        
        return $result;
    }
    public function deletecategory($categoryid){
        $con = $GLOBALS["con"];     
        $sql = "DELETE FROM categories WHERE category_id='$categoryid'";
        $result = $con->query($sql) or die($con->error);
        
        return $result;
    }
}
?>