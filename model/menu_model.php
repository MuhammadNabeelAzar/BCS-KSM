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
    public function getOtherItems()
    {
        $con = $GLOBALS["con"];
        $sql = " SELECT * FROM other_items";
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
    public function getAnItemDetails($Item_id)
    {
        $con = $GLOBALS["con"];
        $sql = "SELECT * FROM other_items WHERE item_id='$Item_id'";
        $result = $con->query($sql) or die($con->error);

        return $result;
    }
    public function getanItem($Item_id)
    {
        $con = $GLOBALS["con"];
        $sql = "SELECT * FROM other_items WHERE item_id='$Item_id'";
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
    public function editItem($itemId, $itemName, $itemDescription, $path, $categoryId)
    {
        $con = $GLOBALS["con"];
        $sql = "UPDATE other_items SET item_name = '$itemName',`description` = '$itemDescription' , category_id = '$categoryId', img_path ='$path' WHERE item_id = '$itemId'";
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
    public function addItem($itemName, $itemDescription, $path, $categoryId)
    {
        $con = $GLOBALS["con"];
        $sql = " INSERT INTO other_items(item_name,`description`,category_id,img_path) values('$itemName','$itemDescription','$categoryId','$path')";
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
        
        // Step 1: Update other_items
        $sql1 = "UPDATE other_items 
                 SET category_id = null
                 WHERE category_id = '$categoryid'";
    
        // Step 2: Update food_items
        $sql2 = "UPDATE food_items 
                 SET category_id = null
                 WHERE category_id = '$categoryid'";
    
        // Step 3: Delete the category
        $sql3 = "DELETE FROM categories WHERE category_id='$categoryid'";
    
        // Perform the queries within a transaction for atomicity
        try {
            $con->begin_transaction();
    
            $con->query($sql1) or die($con->error);
            $con->query($sql2) or die($con->error);
            $con->query($sql3) or die($con->error);
    
            $con->commit();
            return true;
        } catch (Exception $e) {
            $con->rollback();
            return false;
        }
    }
    
    public function deletefooditem($foodid)
    {
        $con = $GLOBALS["con"];
        $sql = "DELETE FROM food_items WHERE food_itemId='$foodid'";
        $result = $con->query($sql) or die($con->error);

        return $result;
    }
    public function deleteitem($itemId)
    {
        $con = $GLOBALS["con"];
        $sql = "DELETE FROM other_items WHERE item_id='$itemId'";
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
    public function setItemprice($itemId, $price)
    {
        $con = $GLOBALS["con"];
        $sql = "UPDATE other_items SET `price` = $price  WHERE item_id  = $itemId  ";
        $result = $con->query($sql) or die($con->error);

        return $result;
    }

    public function getrecipe($food_id)
    {
        $con = $GLOBALS["con"];
        $sql = "SELECT ingredients_food_items.*, ingredients.ing_name
        FROM ingredients_food_items
        JOIN ingredients ON ingredients_food_items.ing_id = ingredients.ing_id
        WHERE ingredients_food_items.food_itemId = '$food_id';
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
    public function getItemswithcategory($category_id)
    {
        $con = $GLOBALS["con"];
        $sql = "SELECT * FROM other_items WHERE  category_id = $category_id";

        $result = $con->query($sql) or die($con->error);
        return $result;

    }
    public function getRecipeToCalculateAvailableQty($food_id)
    {
        $con = $GLOBALS["con"];
        $sql = "SELECT * FROM ingredients_food_items
        JOIN ingredients ON ingredients_food_items.ing_id = ingredients.ing_id
        WHERE ingredients_food_items.food_itemId = $food_id;
        ";
        $result = $con->query($sql) or die($con->error);
        return $result;

    }
    public function addstock($item_Id, $quantity)
    {
        $con = $GLOBALS["con"];
        $sql = "UPDATE other_items SET available_quantity = available_quantity + $quantity  WHERE item_id  = $item_Id  ";
        $result = $con->query($sql) or die($con->error);

        return $result;
    }
    public function reduceStock($item_Id, $quantity)
    {
        $con = $GLOBALS["con"];
        $sql = "UPDATE other_items 
        SET available_quantity = GREATEST(available_quantity - $quantity, 0) 
        WHERE item_id = $item_Id";
        $result = $con->query($sql) or die($con->error);

        return $result;
    }
    public function resetStock($item_Id)
    {
        $con = $GLOBALS["con"];
        $sql = "UPDATE other_items SET available_quantity = 0  WHERE item_id  = $item_Id  ";
        $result = $con->query($sql) or die($con->error);

        return $result;
    }
}
?>