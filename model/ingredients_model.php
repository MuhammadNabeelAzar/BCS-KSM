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
    Public function addstock_G($ing_id,$updateqty){
        $con = $GLOBALS["con"];
        $sql = "UPDATE ingredients SET `remaining_qty(g)` = `remaining_qty(g)` + $updateqty WHERE ing_id  = $ing_id  ";
        $result = $con->query($sql) or die($con->error);
        
        return $result;
    }
    Public function addstock_Kg($ing_id,$updateqty){
        $con = $GLOBALS["con"];
        $sql = "UPDATE ingredients SET `remaining_qty(kg)` = `remaining_qty(kg)` + $updateqty WHERE ing_id  = $ing_id  ";
        $result = $con->query($sql) or die($con->error);
        
        return $result;
    }
    Public function addstock_L($ing_id,$updateqty){
        $con = $GLOBALS["con"];
        $sql = "UPDATE ingredients SET `remaining_qty(l)` = `remaining_qty(l)` + $updateqty WHERE ing_id  = $ing_id  ";
        $result = $con->query($sql) or die($con->error);
        
        return $result;
    }
    Public function addstock_Ml($ing_id,$updateqty){
        $con = $GLOBALS["con"];
        $sql = "UPDATE ingredients SET `remaining_qty(ml)` = `remaining_qty(ml)` + $updateqty WHERE ing_id  = $ing_id  ";
        $result = $con->query($sql) or die($con->error);
        
        return $result;
    }
    Public function addstock_oz($ing_id,$updateqty){
        $con = $GLOBALS["con"];
        $sql = "UPDATE ingredients SET `remaining_qty(oz)` = `remaining_qty(oz)` + $updateqty WHERE ing_id  = $ing_id  ";
        $result = $con->query($sql) or die($con->error);
        
        return $result;
    }
    Public function addstock_lb($ing_id,$updateqty){
        $con = $GLOBALS["con"];
        $sql = "UPDATE ingredients SET `remaining_qty(lb)` = `remaining_qty(lb)` + $updateqty WHERE ing_id  = $ing_id  ";
        $result = $con->query($sql) or die($con->error);
        
        return $result;
    }
    Public function addstock_nos($ing_id,$updateqty){
        $con = $GLOBALS["con"];
        $sql = "UPDATE ingredients SET `remaining_qty(nos)` = `remaining_qty(nos)` + $updateqty WHERE ing_id  = $ing_id  ";
        $result = $con->query($sql) or die($con->error);
        
        return $result;
    }
    Public function subtractstock_G($ing_id,$updateqty){
        $con = $GLOBALS["con"];
        $sql = "UPDATE ingredients SET `remaining_qty(g)`= GREATEST(`remaining_qty(g)` - $updateqty,0) WHERE ing_id  = $ing_id ";
        $result = $con->query($sql) or die($con->error);
        
        return $result;
    }
    Public function subtractstock_Kg($ing_id,$updateqty){
        $con = $GLOBALS["con"];
        $sql = "UPDATE ingredients SET `remaining_qty(kg)`= GREATEST(`remaining_qty(kg)` - $updateqty,0) WHERE ing_id  = $ing_id ";
        $result = $con->query($sql) or die($con->error);
        
        return $result;
    }
    Public function subtractstock_L($ing_id,$updateqty){
        $con = $GLOBALS["con"];
        $sql = "UPDATE ingredients SET `remaining_qty(l)`= GREATEST(`remaining_qty(l)` - $updateqty,0) WHERE ing_id  = $ing_id ";
        $result = $con->query($sql) or die($con->error);
        
        return $result;
    }
    Public function subtractstock_Ml($ing_id,$updateqty){
        $con = $GLOBALS["con"];
        $sql = "UPDATE ingredients SET `remaining_qty(ml)`= GREATEST(`remaining_qty(ml)` - $updateqty,0) WHERE ing_id  = $ing_id ";
        $result = $con->query($sql) or die($con->error);
        
        return $result;
    }
    Public function subtractstock_oz($ing_id,$updateqty){
        $con = $GLOBALS["con"];
        $sql = "UPDATE ingredients SET `remaining_qty(oz)`= GREATEST(`remaining_qty(oz)` - $updateqty,0) WHERE ing_id  = $ing_id ";
        $result = $con->query($sql) or die($con->error);
        
        return $result;
    }
    Public function subtractstock_lb($ing_id,$updateqty){
        $con = $GLOBALS["con"];
        $sql = "UPDATE ingredients SET `remaining_qty(lb)`= GREATEST(`remaining_qty(lb)` - $updateqty,0) WHERE ing_id  = $ing_id ";
        $result = $con->query($sql) or die($con->error);
        
        return $result;
    }
    Public function subtractstock_nos($ing_id,$updateqty){
        $con = $GLOBALS["con"];
        $sql = "UPDATE ingredients SET `remaining_qty(nos)`= GREATEST(`remaining_qty(nos)` - $updateqty,0) WHERE ing_id  = $ing_id ";
        $result = $con->query($sql) or die($con->error);
        
        return $result;
    }
    Public function resetingredientstock($ing_id){
        $con = $GLOBALS["con"];
        $sql = "UPDATE ingredients SET `remaining_qty(g)`= '0', `remaining_qty(ml)`='0' WHERE ing_id  = $ing_id ";
        $result = $con->query($sql) or die($con->error);
        
        return $result;
    }
    Public function sendIngredientRefillRequest($ing_id,$quantity,$reason,$factor_id){
        $con = $GLOBALS["con"];
        $sql = "INSERT INTO stock_refill_requests (ing_id,quantity,factor_id,reason,request_status,req_date,req_time) 
        VALUES ('$ing_id', '$quantity', '$factor_id', '$reason', 'pending', CURRENT_DATE, CURRENT_TIME)";
        $result = $con->query($sql) or die($con->error);
        
        return $result;
    }
    Public function getAllStockRefillRequests(){
        $con = $GLOBALS["con"];
        $sql = "SELECT stock_refill_requests.* ,factors.factor ,factors.factorsf,ingredients.ing_name FROM stock_refill_requests 
        JOIN factors ON stock_refill_requests.factor_id = factors.factor_id 
        JOIN ingredients ON stock_refill_requests.ing_id = ingredients.ing_id
        WHERE request_status NOT IN ('finished', 'cancelled') ORDER BY req_date DESC";
        $result = $con->query($sql) or die($con->error);
        
        return $result;
    }
    Public function getPendingStockRefillRequests(){
        $con = $GLOBALS["con"];
        $sql = "SELECT stock_refill_requests.* ,factors.factor ,factors.factorsf,ingredients.ing_name FROM stock_refill_requests 
        JOIN factors ON stock_refill_requests.factor_id = factors.factor_id 
        JOIN ingredients ON stock_refill_requests.ing_id = ingredients.ing_id
        WHERE request_status IN ('pending','accepted','completed') ORDER BY req_date DESC";
        $result = $con->query($sql) or die($con->error);
        
        return $result;
    }
    Public function acceptRefillRequest($req_id){
        $con = $GLOBALS["con"];
        $sql = "UPDATE stock_refill_requests SET request_status = 'accepted' WHERE req_id = $req_id";
        $result = $con->query($sql) or die($con->error);
        
        return $result;
    }
    Public function closeRefillRequest($req_id){
        $con = $GLOBALS["con"];
        $sql = "UPDATE stock_refill_requests SET request_status = 'finished' WHERE req_id = $req_id";
        $result = $con->query($sql) or die($con->error);
        
        return $result;
    }
    Public function cancelRefillRequest($req_id){
        $con = $GLOBALS["con"];
        $sql = "UPDATE stock_refill_requests SET request_status = 'cancelled' WHERE req_id = $req_id";
        $result = $con->query($sql) or die($con->error);
        
        return $result;
    }
    Public function completeRefillRequest($req_id){
        $con = $GLOBALS["con"];
        $sql = "UPDATE stock_refill_requests SET request_status = 'completed' WHERE req_id = $req_id";
        $result = $con->query($sql) or die($con->error);
        
        return $result;
    }

}
?>