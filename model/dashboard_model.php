<?php

include_once(__DIR__ . "/../commons/dbconnection.php");
$dbConnectionObj = new dbConnection();

class dashboard{
    public function getAllOrderSalesItems()
    {
        $con = $GLOBALS["con"];
        $sql = "SELECT order_items.food_itemId,order_items.item_id,order_items.final_price AS price, order.status_id,
        COALESCE(food_items.item_name, other_items.item_name) AS item_name 
        FROM order_items
        JOIN `order` ON order_items.order_id = order.order_id
        LEFT JOIN food_items ON order_items.food_itemId = food_items.food_itemId
        LEFT JOIN other_items ON order_items.item_id = other_items.item_id 
        WHERE order.status_id NOT IN (1,2,3,5)";

        $result = $con->query($sql) or die($con->error);
        
        return $result;
    }
    public function getAllOrderSalesCustomerDetails()
    {
        $con = $GLOBALS["con"];
        $sql = "SELECT `order`.customer_id,`order`.order_time AS time FROM `order`";

        $result = $con->query($sql) or die($con->error);
        
        return $result;
    }
    public function getAllOrderSalesCategories()
    {
        $con = $GLOBALS["con"];
        $sql = "SELECT order_items.food_itemId,order_items.item_id, 
        COALESCE(food_items.category_id, other_items.category_id) AS category_id ,categories.category_name
        FROM order_items
        LEFT JOIN food_items ON order_items.food_itemId = food_items.food_itemId
        LEFT JOIN other_items ON order_items.item_id = other_items.item_id
        JOIN categories ON COALESCE(food_items.category_id, other_items.category_id) = categories.category_id";

        $result = $con->query($sql) or die($con->error);
        
        return $result;
    }
    public function getAllQuickSalesCategories()
    {
        $con = $GLOBALS["con"];
        $sql = "SELECT sales_items.food_itemId, 
        COALESCE(food_items.category_id, other_items.category_id) AS category_id,categories.category_name
        FROM sales_items
        LEFT JOIN food_items ON sales_items.food_itemId = food_items.food_itemId
        LEFT JOIN other_items ON sales_items.item_id = other_items.item_id
        JOIN categories ON COALESCE(food_items.category_id, other_items.category_id) = categories.category_id";

        $result = $con->query($sql) or die($con->error);
        
        return $result;
    }
    public function getAllQuickSalesCustomerDetails()
    {
        $con = $GLOBALS["con"];
        $sql = "SELECT quick_sales.customer_id,quick_sales.time AS time FROM quick_sales";

        $result = $con->query($sql) or die($con->error);
        
        return $result;
    }
    public function getIngredientStockLevels()
    {
        $con = $GLOBALS["con"];
        $sql1 = "SELECT ingredients.ing_name,ingredients.`remaining_qty(kg)`  FROM ingredients WHERE factor_id IN (1,2,3,6,7,8,9)";
        $sql2 = "SELECT ingredients.ing_name,ingredients.`remaining_qty(l)` FROM ingredients WHERE factor_id IN (4,5)";

        $result1 = $con->query($sql1) or die($con->error);
        $result2 = $con->query($sql2) or die($con->error);
        
        $data = array(
        'solidItems' => $result1->fetch_all(MYSQLI_ASSOC),
        'liquidItems' => $result2->fetch_all(MYSQLI_ASSOC)
        );

        return $data;
    }
    public function getAllQuickSalesItems()
    {
        $con = $GLOBALS["con"];
        $sql = "SELECT sales_items.food_itemId,sales_items.item_id,sales_items.total AS price, 
        COALESCE(food_items.item_name, other_items.item_name) AS item_name
        FROM sales_items
        LEFT JOIN food_items ON sales_items.food_itemId = food_items.food_itemId
        LEFT JOIN other_items ON sales_items.item_id = other_items.item_id";

        $result = $con->query($sql) or die($con->error);
        
        return $result;
    }
    
    
}