<?php
session_start();
include '../model/order_model.php';
$orderObj = new order();

if (isset($_GET['status']) && $_GET['status'] === 'update-stock') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        //
       $fooditem_id = $_POST['fooditem_id'];
       $fooditem_qty =  $_POST['fooditem_qty'];

       //
       $orderObj->updateStock($fooditem_id,$fooditem_qty);

       
           // Fetch all rows and encode as JSON
           $response = "successfully updated the stock";

           // Send a JSON response
           header('Content-Type: application/json');
           echo json_encode($response);
       
        
    
    } else {

    }

}
if (isset($_GET['status']) && $_GET['status'] === 'add-order') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        //
        $fooditems = $_POST['fooditems'];
        $customer_id = $_POST['customer_id'];
      $date = $_POST['date'];
    $time = $_POST['time'];
    $discount = $_POST['discount'] ?? 0;
    $status_id = '1';
    if($customer_id === ''){
        
            $result = $orderObj->getlastcustomerId();
            $lastcustomerid = $result->fetch_assoc();
            $last_customer_id = $lastcustomerid['last_customer_id'];
            $customer_id = $last_customer_id ;
            $orderObj->addorder($customer_id,$status_id,$date,$time);
            $order_id = $orderObj->getLastInsertedOrderId();
        
    } else  {
        $orderObj->addorder($customer_id,$status_id,$date,$time);
        $order_id = $orderObj->getLastInsertedOrderId();
    }
  foreach($fooditems as $item){
    $food_itemId = $item[0];
    $qty = $item[1];
    $priceperitem =  $item[2];
    $sum = $priceperitem * $qty;
    $discountamount =  ($sum * $discount ) / 100;
    $total = $sum - $discountamount;
    $orderObj->addorderitems($order_id,$food_itemId,$qty,$priceperitem,$discount,$total);
  }
    $response = "successfully added  the order";

           // Send a JSON response
           header('Content-Type: application/json');
           echo json_encode($response);
    
    }

}
if (isset($_GET['status']) && $_GET['status'] === 'get-processing-orders') {
  $result = $orderObj->getprocessingOrders();
  $rows = [];
while ($row = $result->fetch_assoc()) {
    $orderID = $row['order_id'];

    // Check if there is already an array for this order ID
    if (!isset($rows[$orderID])) {
        // If not, create a new array for this order ID
        $rows[$orderID] = [];
    }

    // Push the current row into the array for this order ID
    $rows[$orderID][] = $row;
}
  header('Content-Type: application/json');
           echo json_encode($rows);
  
}
if (isset($_GET['status']) && $_GET['status'] === 'get-placed-orders') {
  $result = $orderObj->getPlacedOrders();
  $rows = [];
while ($row = $result->fetch_assoc()) {
    $orderID = $row['order_id'];

    // Check if there is already an array for this order ID
    if (!isset($rows[$orderID])) {
        // If not, create a new array for this order ID
        $rows[$orderID] = [];
    }

    // Push the current row into the array for this order ID
    $rows[$orderID][] = $row;
}
  header('Content-Type: application/json');
           echo json_encode($rows);
  
}
if (isset($_GET['status']) && $_GET['status'] === 'get-order-details') {
  if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $order_id = $_POST['order_id'];
    $result = $orderObj->getOrderDetails($order_id);
    $response = array();
    
    while($row = $result->fetch_assoc()){
      $response[] = $row;
    }
  }
  header('Content-Type: application/json');
           echo json_encode($response);
  
}
if (isset($_GET['status']) && $_GET['status'] === 'cancel-order') {
  if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $order_id = $_POST['order_id'];
    $orderObj->cancelOrder($order_id);
    $response = "cancelled";
  }
  header('Content-Type: application/json');
           echo json_encode($response);
  
}
if (isset($_GET['status']) && $_GET['status'] === 'finish-order') {
  if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $order_id = $_POST['order_id'];
    $orderObj->finishOrder($order_id);
    $response = "finished";
  }
  header('Content-Type: application/json');
           echo json_encode($response);
  
}

?>