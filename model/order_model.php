<?php

include_once(__DIR__ . "/../commons/dbconnection.php");
$dbConnectionObj = new dbConnection();

class order
{
    public function updateStock($fooditem_id, $fooditem_qty)
{
    $con = $GLOBALS["con"];

    // Query to retrieve information from ingredients_food_items
    $sql_select = "SELECT ing_id, `qty_required(g)`, `qty_required(ml)`, factor FROM ingredients_food_items WHERE food_itemId = $fooditem_id";
    
    // Execute the select query
    $result_select = $con->query($sql_select) or die($con->error);

    // Check if the select query was successful
    if ($result_select) {
        while ($row = $result_select->fetch_assoc()) {
            $ing_id = $row['ing_id'];
            $required_qty_g = $row['qty_required(g)'];
            $required_qty_ml = $row['qty_required(ml)'];
            $factor = $row['factor'];

            // Update remaining_qty(g)
            $sql_update_g = "UPDATE ingredients
                             SET `remaining_qty(g)` = `remaining_qty(g)` - ($required_qty_g * $fooditem_qty)
                             WHERE ing_id = $ing_id
                             AND $factor < 8";

            // Execute the update query for remaining_qty(g)
            $result_update_g = $con->query($sql_update_g) or die($con->error);

            // Check if the update query for remaining_qty(g) was successful
            if (!$result_update_g) {
                die("Error updating `remaining_qty(g)`: " . $con->error);
            }

            // Update remaining_qty(ml)
            $sql_update_ml = "UPDATE ingredients
                              SET `remaining_qty(ml)` = `remaining_qty(ml)` - ($required_qty_ml * $fooditem_qty)
                              WHERE ing_id = $ing_id
                              AND $factor >= 8";

            // Execute the update query for remaining_qty(ml)
            $result_update_ml = $con->query($sql_update_ml) or die($con->error);

            // Check if the update query for remaining_qty(ml) was successful
            if (!$result_update_ml) {
                die("Error updating `remaining_qty(ml)`: " . $con->error);
            }
        }
    } else {
        // Handle error in executing the select query
        die("Error retrieving data from ingredients_food_items: " . $con->error);
    }

    return true;
}

  public function getlastcustomerId()
    {
        $con = $GLOBALS["con"];
        $sql = "SELECT MAX(customer_id) AS last_customer_id FROM customer;";
        $result = $con->query($sql) or die($con->error);

        return $result;
    }

    
    

  public function addorder($customer_id,$status_id,$date,$time)
    {
        $con = $GLOBALS["con"];
        $sql = "INSERT INTO `order` (customer_id, status_id, order_date, order_time) VALUES ('$customer_id', '$status_id', '$date', '$time')";

        $result = $con->query($sql) or die($con->error);

        return $result;
        
    }
  public function getLastInsertedOrderId()
    {
        $con = $GLOBALS["con"];
        $sql = "SELECT LAST_INSERT_ID() as order_id";
        $result = $con->query($sql) or die($con->error);
        $row = $result->fetch_assoc();
        $order_id = $row['order_id'];


        return $order_id;
    }
  public function addorderitems($order_id,$food_itemId,$qty,$priceperitem,$discount,$total)
    {
        $con = $GLOBALS["con"];
        $sql = "INSERT INTO order_items (order_id,quantity,food_itemId,unit_price,discount,final_price) VALUES('$order_id','$qty','$food_itemId','$priceperitem','$discount','$total')";
        $result = $con->query($sql) or die($con->error);
        
        return $result;
    }
  public function getprocessingOrders()
    {
        $con = $GLOBALS["con"];
        $sql = "SELECT  `order`.*, 
        customer.*, 
        order_items.*, 
        order_status.*,
        food_items.item_name AS item_name FROM `order`
        JOIN customer ON `order`.customer_id = customer.customer_id
        JOIN order_items ON `order`.order_id = order_items.order_id
        JOIN food_items ON `order_items`.food_itemId = food_items.food_itemId
        JOIN order_status ON `order`.status_id = order_status.status_id
          WHERE `order`.status_id IN (1,2,3) ";
        $result = $con->query($sql) or die($con->error);
        
        return $result;
    }
  public function getPlacedOrders()
    {
        $con = $GLOBALS["con"];
        $sql = "SELECT  `order`.*, 
        order_items.*, 
        order_status.*,
        food_items.item_name AS item_name FROM `order`
        JOIN order_items ON `order`.order_id = order_items.order_id
        JOIN food_items ON `order_items`.food_itemId = food_items.food_itemId
        JOIN order_status ON `order`.status_id = order_status.status_id
          WHERE `order`.status_id IN (1,2) ";
        $result = $con->query($sql) or die($con->error);
        
        return $result;
    }
  public function getOrderDetails($order_id)
    {
        $con = $GLOBALS["con"];
        $sql = "SELECT  `order`.*, 
        customer.*, 
        order_items.*, 
        order_status.*,
        food_items.item_name AS item_name FROM `order`
        JOIN customer ON `order`.customer_id = customer.customer_id
        JOIN order_items ON `order`.order_id = order_items.order_id
        JOIN food_items ON `order_items`.food_itemId = food_items.food_itemId
        JOIN order_status ON `order`.status_id = order_status.status_id
          WHERE `order`.order_id = $order_id ";
        $result = $con->query($sql) or die($con->error);
        
        return $result;
    }
  public function cancelOrder($order_id)
    {
        $con = $GLOBALS["con"];
        $sql = "UPDATE `order` SET status_id = 5 WHERE `order_id` = $order_id ";
        $result = $con->query($sql) or die($con->error);
        
        return $result;
    }
  public function finishOrder($order_id)
    {
        $con = $GLOBALS["con"];
        $sql = "UPDATE `order` SET status_id = 4 WHERE `order_id` = $order_id ";
        $result = $con->query($sql) or die($con->error);
        
        return $result;
    }

    
    
}
?>