<?php 

include_once(__DIR__ . "/../commons/dbconnection.php");
$dbConnectionObj = new dbConnection();

class ingredient{
    public function addIngredient($ingName,$ingDescription,$path,$factorId){
        $con = $GLOBALS["con"];
        
        $sql = "INSERT INTO ingredients(ing_name,ing_description,img_path,factor_id) values('$ingName','$ingDescription','$path','$factorId')";
        
        $result = $con->query($sql) or die($con->error);
        
        return $result;
    }
    public function getAllingredients()
    {
        $con = $GLOBALS["con"];
        
        $sql = "SELECT * FROM ingredients i JOIN factors f ON i.factor_id = f.factor_id ORDER BY i.ing_id";
        
        $result = $con->query($sql) or die($con->error);
        
        return $result;
    }
    public function updateingredients($ingName,$ingDescription,$ing_id,$factor_id){
        $con = $GLOBALS["con"];
        $sql = " UPDATE ingredients SET ing_name = '$ingName',ing_description = '$ingDescription' , factor_id = '$factor_id' WHERE ing_id = '$ing_id'";
        $result = $con->query($sql) or die($con->error);
        
        return $result;
    } 
    public function updateingredientImage($path,$ingg_id){
        $con = $GLOBALS["con"];
        $sql = " UPDATE ingredients SET img_path = '$path' WHERE ing_id = '$ingg_id'";
        $result = $con->query($sql) or die($con->error);
        
        return $result;
    } 
    public function getaspecificIngredient($ingg_id){
        $con = $GLOBALS["con"];     
        $sql = "SELECT * FROM ingredients WHERE ing_id='$ingg_id'";
        $result = $con->query($sql) or die($con->error);
        
        return $result;
    }
    public function getIngredienttoUpdate($ingg_id){
        $con = $GLOBALS["con"];     
        $sql = "SELECT * FROM ingredients WHERE ing_id='$ingg_id'";
        $result = $con->query($sql) or die($con->error);
        
        return $result;
    }
    public function removeIngredient($ing_id){
        $con = $GLOBALS["con"];     
        $sql = "DELETE FROM ingredients WHERE ing_id='$ing_id'";
        $result = $con->query($sql) or die($con->error);
        
        return $result;
    }
    Public function getfactors(){
        $con = $GLOBALS["con"];
        $sql = " SELECT * FROM factors";
        $result = $con->query($sql) or die($con->error);
        
        return $result;
    }
}
?>