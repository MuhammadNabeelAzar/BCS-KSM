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
    Public function getfoodItems(){
        $con = $GLOBALS["con"];
        $sql = " SELECT * FROM food_items";
        $result = $con->query($sql) or die($con->error);
        
        return $result;
    }
    public function getaspecificfoodItem($foodItem_id){
        $con = $GLOBALS["con"];     
        $sql = "SELECT * FROM food_items WHERE food_itemId='$foodItem_id'";
        $result = $con->query($sql) or die($con->error);
        
        return $result;
    }
    public function editfoodItem($foodId,$itemName, $itemDescription,$path,$categoryId){
        $con = $GLOBALS["con"];     
        $sql = "UPDATE food_items SET item_name = '$itemName',food_description = '$itemDescription' , category_id = '$categoryId', img_path ='$path' WHERE food_itemId = '$foodId'";
        $result = $con->query($sql) or die($con->error);
        
        return $result;
    }
    public function removefooditem($item_id){
        $con = $GLOBALS["con"];     
        $sql = "DELETE FROM food_items WHERE food_itemId='$item_id'";
        $result = $con->query($sql) or die($con->error);
        
        return $result;
    }
    Public function addcategory($categoryName){
        $con = $GLOBALS["con"];
        $sql = " INSERT INTO categories(category_name) values('$categoryName')";
        $result = $con->query($sql) or die($con->error);
        
        return $result;
    }
    Public function addfoodItem($itemName, $itemDescription,$path,$categoryId){
        $con = $GLOBALS["con"];
        $sql = " INSERT INTO food_items(item_name,food_description,category_id,img_path) values('$itemName','$itemDescription','$categoryId','$path')";
        $result = $con->query($sql) or die($con->error);
        
        return $result;
    }
    public function deletecategory($categoryid){
        $con = $GLOBALS["con"];     
        $sql = "DELETE FROM categories WHERE category_id='$categoryid'";
        $result = $con->query($sql) or die($con->error);
        
        return $result;
    }
    public function deletefooditem($foodid){
        $con = $GLOBALS["con"];     
        $sql = "DELETE FROM food_items WHERE food_itemId='$foodid'";
        $result = $con->query($sql) or die($con->error);
        
        return $result;
    }
}
?>