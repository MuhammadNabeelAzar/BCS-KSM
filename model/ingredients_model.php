<?php 

include_once(__DIR__ . "/../commons/dbconnection.php");
$dbConnectionObj = new dbConnection();

class ingredient{
    public function addIngredient($ingName,$ingDescription,$path){
        $con = $GLOBALS["con"];
        
        $sql = "INSERT INTO ingredients(ing_name,ing_description,img_path) values('$ingName','$ingDescription','$path')";
        
        $result = $con->query($sql) or die($con->error);
        
        return $result;
    }
    public function getAllingredients()
    {
        $con = $GLOBALS["con"];
        
        $sql = "SELECT * FROM ingredients";
        
        $result = $con->query($sql) or die($con->error);
        
        return $result;
    }
    public function updateingredients($ingName,$ingDescription,$path,$ing_id){
        $con = $GLOBALS["con"];
        $sql = " UPDATE ingredients SET ing_name = '$ingName',ing_description = '$ingDescription' ,img_path = '$path' WHERE ing_id = '$ing_id'";
        $result = $con->query($sql) or die($con->error);
        
        return $result;
    } 
    public function getaspecificIngredient($ingg_id){
        $con = $GLOBALS["con"];     
        $sql = "SELECT * FROM ingredients WHERE ing_id='$ingg_id'";
        $result = $con->query($sql) or die($con->error);
        
        return $result;
    }
}
?>