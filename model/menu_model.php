<?php

include_once(__DIR__ . "/../commons/dbconnection.php");
$dbConnectionObj = new dbConnection();

class menu
{
    public function getcategories()
    {
        $con = $GLOBALS["con"];
        $sql = " SELECT * FROM categories";
        $result = $con->query($sql) or die($con->error);

        return $result;
    }
    public function getfoodItems()
    {
        $con = $GLOBALS["con"];
        $sql = " SELECT * FROM food_items";
        $result = $con->query($sql) or die($con->error);

        return $result;
    }
    public function getaspecificfoodItem($foodItem_id)
    {
        $con = $GLOBALS["con"];
        $sql = "SELECT * FROM food_items WHERE food_itemId='$foodItem_id'";
        $result = $con->query($sql) or die($con->error);

        return $result;
    }
    public function editfoodItem($foodId, $itemName, $itemDescription, $path, $categoryId)
    {
        $con = $GLOBALS["con"];
        $sql = "UPDATE food_items SET item_name = '$itemName',food_description = '$itemDescription' , category_id = '$categoryId', img_path ='$path' WHERE food_itemId = '$foodId'";
        $result = $con->query($sql) or die($con->error);

        return $result;
    }
    public function removefooditem($item_id)
    {
        $con = $GLOBALS["con"];
        $sql = "DELETE FROM food_items WHERE food_itemId='$item_id'";
        $result = $con->query($sql) or die($con->error);

        return $result;
    }
    public function addcategory($categoryName)
    {
        $con = $GLOBALS["con"];
        $sql = " INSERT INTO categories(category_name) values('$categoryName')";
        $result = $con->query($sql) or die($con->error);

        return $result;
    }
    public function addfoodItem($itemName, $itemDescription, $path, $categoryId)
    {
        $con = $GLOBALS["con"];
        $sql = " INSERT INTO food_items(item_name,food_description,category_id,img_path) values('$itemName','$itemDescription','$categoryId','$path')";
        $result = $con->query($sql) or die($con->error);

        return $result;
    }
    public function setrecipe($food_id, $ing_id, $quantity, $factors)
    {
        $con = $GLOBALS["con"];

        $values = array();
        for ($i = 0; $i < count($ing_id); $i++) {
            $values[] = "('" . $ing_id[$i] . "', '$food_id', '" . $quantity[$i] . "', '" . $factors[$i] . "')";
        }
        $sql = "
        INSERT INTO ingredients_food_items (ing_id, food_itemId, `qty_required(g)`, factor) 
        VALUES " . implode(', ', $values) . "
        ON DUPLICATE KEY UPDATE 
        `qty_required(g)` = VALUES(`qty_required(g)`),
        factor = VALUES(factor)
    ";

        $result = $con->query($sql) or die($con->error);

        return $result;
    }

    public function deletecategory($categoryid)
    {
        $con = $GLOBALS["con"];
        $sql = "DELETE FROM categories WHERE category_id='$categoryid'";
        $result = $con->query($sql) or die($con->error);

        return $result;
    }
    public function deletefooditem($foodid)
    {
        $con = $GLOBALS["con"];
        $sql = "DELETE FROM food_items WHERE food_itemId='$foodid'";
        $result = $con->query($sql) or die($con->error);

        return $result;
    }
    public function getfooditemtosetprice($food_id)
    {
        $con = $GLOBALS["con"];
        $sql = "SELECT * FROM food_items WHERE food_itemId='$food_id'";
        $result = $con->query($sql) or die($con->error);

        return $result;
    }
    public function setprice($food_id, $price)
    {
        $con = $GLOBALS["con"];
        $sql = "UPDATE food_items SET `price` = $price  WHERE food_itemId  = $food_id  ";
        $result = $con->query($sql) or die($con->error);

        return $result;
    }

    public function getrecipe($food_id)
    {
        $con = $GLOBALS["con"];
        $sql = "SELECT ingredients_food_items.*, ingredients.ing_name
        FROM ingredients_food_items
        JOIN ingredients ON ingredients_food_items.ing_id = ingredients.ing_id
        WHERE ingredients_food_items.food_itemId = $food_id;
        ";
        $result = $con->query($sql) or die($con->error);
        return $result;

    }
    public function deleterecipeIng($ing_id)
    {
        $con = $GLOBALS["con"];
        $sql = "DELETE FROM ingredients_food_items WHERE ing_id = $ing_id ";
        $result = $con->query($sql) or die($con->error);
        return $result;

    }
    public function deactivatefoodAvailability($food_id)
    {
        $con = $GLOBALS["con"];
        $sql = "UPDATE food_items SET tmp_deactivate_availability = 1 WHERE food_itemID = $food_id";
        $result = $con->query($sql) or die($con->error);
        return $result;

    }
    public function activatefoodAvailability($food_id)
    {
        $con = $GLOBALS["con"];
        $sql = "UPDATE food_items SET tmp_deactivate_availability = 0 WHERE food_itemID = $food_id";
        $result = $con->query($sql) or die($con->error);
        return $result;

    }
    public function getfoodItemswithcategory($category_id)
    {
        $con = $GLOBALS["con"];
        $sql = "SELECT * FROM food_items WHERE  category_id = $category_id";
        
        $result = $con->query($sql) or die($con->error);
        return $result;

    }
    
}
?>