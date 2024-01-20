<?php

include_once(__DIR__ . "/../commons/dbconnection.php");
$dbConnectionObj = new dbConnection();

class sales
{
    public function getOrderSalesDetails()
    {
      $con = $GLOBALS["con"];
      $sql = "SELECT * FROM  `order` WHERE status_id = '4'";
      $result = $con->query($sql) or die($con->error);
  
      return $result;
    }
    public function getQuickSalesDetails()
    {
      $con = $GLOBALS["con"];
      $sql = "SELECT * FROM  quick_sales";
      $result = $con->query($sql) or die($con->error);
  
      return $result;
    }
 
    public function getSalesOtherItemsInfo($ID,$item_id)
  {
    $con = $GLOBALS["con"];
    $sql = "SELECT  quick_sales.*, 
        sales_items.*, 
        other_items.item_name AS item_name FROM quick_sales
        JOIN sales_items ON quick_sales.sales_id = sales_items.sales_id
        LEFT JOIN other_items ON sales_items.item_id = other_items.item_id
          WHERE quick_sales.sales_id = $ID AND sales_items.item_id = $item_id";
    $result = $con->query($sql) or die($con->error);

    return $result;
  }
    public function getSalesFoodItemsInfo($ID,$item_id)
  {
    $con = $GLOBALS["con"];
    $sql = "SELECT  quick_sales.*, 
 
        sales_items.*, 
        food_items.item_name AS item_name FROM quick_sales
        JOIN sales_items ON quick_sales.sales_id = sales_items.sales_id
        LEFT JOIN food_items ON sales_items.food_itemId = food_items.food_itemId
          WHERE quick_sales.sales_id = $ID AND food_items.food_ItemId = $item_id";
    $result = $con->query($sql) or die($con->error);

    return $result;
  }
  public function getOrderSalesOtherItemsInfo($ID,$item_id)
  {
      $con = $GLOBALS["con"];
      $sql = "SELECT  
                  `order`.*, 
                  `order_items`.*, 
                  other_items.item_name AS item_name 
              FROM 
                  `order`
              JOIN 
                  `order_items` ON `order`.order_id = `order_items`.order_id
              LEFT JOIN 
                  other_items ON order_items.item_id = other_items.item_id
              WHERE 
                  `order`.order_id = $ID AND order_items.item_id = $item_id ";
  
      $result = $con->query($sql) or die($con->error);
  
      return $result;
  }
  
    public function getOrderSalesFoodItemsInfo($ID,$item_id)
  {
    $con = $GLOBALS["con"];
    $sql = "SELECT  `order`.*,
         order_items.*,  
        food_items.item_name AS item_name FROM `order`
        JOIN order_items ON `order`.order_id = order_items.order_id
        LEFT JOIN food_items ON order_items.food_itemId = food_items.food_itemId
          WHERE `order`.order_id = $ID  AND order_items.food_itemId = $item_id ";
    $result = $con->query($sql) or die($con->error);

    return $result;
  }
    public function getOrderItems($ID)
  {
    $con = $GLOBALS["con"];
    $sql = "SELECT food_itemId, item_id FROM order_items WHERE order_items.order_id = $ID";

    $result = $con->query($sql) or die($con->error);

    return $result;
  }
    public function getQuickSaleItems($ID)
  {
    $con = $GLOBALS["con"];
    $sql = "SELECT food_ItemId, item_id FROM sales_items WHERE sales_items.sales_id = $ID";

    $result = $con->query($sql) or die($con->error);

    return $result;
  }
  
  
}

