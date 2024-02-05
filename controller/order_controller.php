<?php
session_start();
include '../model/order_model.php';
$orderObj = new order();

if (isset($_GET['status']) && $_GET['status'] === 'update-stock') {
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //this automatically reduces the ingredient stock values  in the database when an item is ordered or sold depending on the recipe
    $fooditem_id = $_POST['fooditem_id'];
    $fooditem_qty = $_POST['fooditem_qty'];

    //the model handles the deduction
    $orderObj->updateStock($fooditem_id, $fooditem_qty);
    $response = "successfully updated the stock";
    // Send a JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
  }
}

if (isset($_GET['status']) && $_GET['status'] === 'update-other-items-stock') {
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // //this automatically reduces the other item stock values 
    $item_id = $_POST['item_id'];
    $qty = $_POST['qty'];

    $orderObj->updateItemStock($item_id, $qty);
    $response = "successfully updated the stock";
    header('Content-Type: application/json');
    echo json_encode($response);

  } else {
    $error = "Cannot update the stock";
    header('Content-Type: application/json');
    echo json_encode($error);
  }

}
if (isset($_GET['status']) && $_GET['status'] === 'add-order') {
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //this places an order
    $fooditems = $_POST['fooditems'] ?? null;
    $items = $_POST['items'] ?? null;
    $customer_id = $_POST['customer_id'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $discount = $_POST['discount'] ?? 0;
    $status_id = '1';
    //get the customer id 
    if ($customer_id === '') {

      $result = $orderObj->getlastcustomerId();
      $lastcustomerid = $result->fetch_assoc();
      $last_customer_id = $lastcustomerid['last_customer_id'];
      $customer_id = $last_customer_id;
      $orderObj->addorder($customer_id, $status_id, $date, $time);
      $order_id = $orderObj->getLastInsertedOrderId();

    } else { 
      //place the order with the customer id
      $orderObj->addorder($customer_id, $status_id, $date, $time);
      $order_id = $orderObj->getLastInsertedOrderId();
    }
    if (isset($fooditems) && is_array($fooditems)) {
      //add every food item 
      foreach ($fooditems as $item) {
        $food_itemId = $item[0];
        $qty = $item[1];
        $priceperitem = $item[2];
        $sum = $priceperitem * $qty;
        $discountamount = ($sum * $discount) / 100;
        $total = $sum - $discountamount;
        $orderObj->addorderitems($order_id, $food_itemId, $qty, $priceperitem, $discount, $total);
      }
    }
    if (isset($items) && is_array($items)) {
      //add every other item
      foreach ($items as $item) {
        $itemId = $item[0];
        $qty = $item[1];
        $priceperitem = $item[2];
        $sum = $priceperitem * $qty;
        $discountamount = ($sum * $discount) / 100;
        $total = $sum - $discountamount;
        $orderObj->addOtherOrderItems($order_id, $itemId, $qty, $priceperitem, $discount, $total);
      }
    }
    $response = "successfully added  the order";
    header('Content-Type: application/json');
    echo json_encode($response);

  }

}

if (isset($_GET['status']) && $_GET['status'] === 'quick-sell') {
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //this is the quick sales function 
    $fooditems = $_POST['fooditems'] ?? null;
    $items = $_POST['items'] ?? null;
    $customer_id = $_POST['customer_id'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $discount = $_POST['discount'] ?? 0;
    $status_id = '1';
     //get the customer id 
    if ($customer_id === '') {
      $result = $orderObj->getlastcustomerId();
      $lastcustomerid = $result->fetch_assoc();
      $last_customer_id = $lastcustomerid['last_customer_id'];
      $customer_id = $last_customer_id;
    }
    $orderObj->quickSell($customer_id, $date, $time);

    if (isset($fooditems) && is_array($fooditems)) {
      foreach ($fooditems as $item) {
         //add every food item
        $food_itemId = $item[0];
        $qty = $item[1];
        $priceperitem = $item[2];
        $sum = $priceperitem * $qty;
        $discountamount = ($sum * $discount) / 100;
        $total = $sum - $discountamount;
        $last_Id = $orderObj->getLastInsertedSaleId();
        $orderObj->insertFoodItemsDetailsQuickSales($last_Id, $food_itemId, $qty, $priceperitem, $discount, $total);
      }
    }
    if (isset($items) && is_array($items)) {
       //add every other item
      foreach ($items as $item) {
        $itemId = $item[0];
        $qty = $item[1];
        $priceperitem = $item[2];
        $sum = $priceperitem * $qty;
        $discountamount = ($sum * $discount) / 100;
        $total = $sum - $discountamount;
        $last_Id = $orderObj->getLastInsertedSaleId();
        $orderObj->insertOtherItemsDetailsQuickSales($last_Id, $itemId, $qty, $priceperitem, $discount, $total);
      }
    }
    $response = "successfully inserted sales details";

    header('Content-Type: application/json');
    echo json_encode($response);
  }
}

if (isset($_GET['status']) && $_GET['status'] === 'get-processing-orders') {
  //this gets all the processing orders
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
  //this gets all the placed orders
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
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //this gets all the order items details
    $order_id = $_POST['order_id'];
    $result = $orderObj->getOrderDetails($order_id);
    $response = array();

    while ($row = $result->fetch_assoc()) {
      $response[] = $row;
    }
  }
  header('Content-Type: application/json');
  echo json_encode($response);
}

if (isset($_GET['status']) && $_GET['status'] === 'get-quick-sale-details') {
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
     //this gets all the quick sales details to generate an invoice
    $sale_id = $_POST['sale_id'];
    $itemArray = array();
    $fooditemArray = array();
    $response = array();

    $result = $orderObj->getSalesDetails($sale_id);
    $salesDetails = $result->fetch_assoc();

    $salesItemsDetails = $orderObj->getSalesItemsDetails($sale_id);
    $salesItemsDetailsResult = $salesItemsDetails->fetch_all(MYSQLI_ASSOC);

    $foodItemFound = false; //set this as false as default
    $otherItemFound = false;//set this as false as default
    foreach ($salesItemsDetailsResult as $foodrow) {
      if ($foodrow['food_itemId'] !== null) {
        $foodItemFound = true; //returns true if an item has been found to get the details
        break; 
      }
    }
    foreach ($salesItemsDetailsResult as $otherItemrow) {
      if ($otherItemrow['item_id'] !== null) {
        $otherItemFound = true;//returns true if an item has been found to get the details
        break;
      }
    }
//get the details if items are found
    if ($foodItemFound) {
      $fooditemResult = $orderObj->getSalesFoodItemsDetails($sale_id);
      $foodresult = $fooditemResult->fetch_all(MYSQLI_ASSOC);
    }

    if ($otherItemFound) {
      $otheritemResult = $orderObj->getSalesOtherItemsDetails($sale_id);
      $itemResult = $otheritemResult->fetch_all(MYSQLI_ASSOC);
    }
    //push fooditems and other items into their respective arrays and customer details. Then send  them back with the response.
    $response['customerAndSalesDetails'] = $salesDetails;
    $response['fooditemArray'] = isset($foodresult) ? $foodresult : [];
    $response['otheritemArray'] = isset($itemResult) ? $itemResult : [];

  }
  header('Content-Type: application/json');
  echo json_encode($response);
}

if (isset($_GET['status']) && $_GET['status'] === 'get-order-customer-details') {
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //this gets thhe order details and customer details similar to the function above
    $order_id = $_POST['order_id'];
    $itemArray = array();
    $fooditemArray = array();
    $response = array();

    $result = $orderObj->getOrderDetailsForInvoice($order_id);
    $orderDetails = $result->fetch_assoc();

    $orderItemsDetails = $orderObj->getOrderItemsDetails($order_id);
    $orderItemsDetailsResult = $orderItemsDetails->fetch_all(MYSQLI_ASSOC);

    $foodItemFound = false;
    $otherItemFound = false;
    foreach ($orderItemsDetailsResult as $foodrow) {
      if ($foodrow['food_itemId'] !== null) {
        $foodItemFound = true;
        break;
      }
    }
    foreach ($orderItemsDetailsResult as $otherItemrow) {
      if ($otherItemrow['item_id'] !== null) {
        $otherItemFound = true;
        break;
      }
    }

    if ($foodItemFound) {
      $fooditemResult = $orderObj->getFoodItemsOrderDetails($order_id);
      $foodresult = $fooditemResult->fetch_all(MYSQLI_ASSOC);
    }

    if ($otherItemFound) {
      $otheritemResult = $orderObj->getOtherItemsOrderDetails($order_id);
      $itemResult = $otheritemResult->fetch_all(MYSQLI_ASSOC);
    }

    $response['customerAndOrderDetails'] = $orderDetails;
    $response['fooditemArray'] = isset($foodresult) ? $foodresult : [];
    $response['otheritemArray'] = isset($itemResult) ? $itemResult : [];

  }
  header('Content-Type: application/json');
  echo json_encode($response);

}

if (isset($_GET['status']) && $_GET['status'] === 'get-last-inserted-saleId') {
  if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    $response = $orderObj->getLastSaleId();
    header('Content-Type: application/json');
    echo json_encode($response);

  }
}

if (isset($_GET['status']) && $_GET['status'] === 'cancel-order') {
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //this cancels a placed order
    $order_id = $_POST['order_id'];
    $orderObj->cancelOrder($order_id);
    $response = "Order cancelled successfully";
  }
  header('Content-Type: application/json');
  echo json_encode($response);
}

if (isset($_GET['status']) && $_GET['status'] === 'finish-order') {
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //this closes and marks the order as completed 
    $order_id = $_POST['order_id'];
    $orderObj->finishOrder($order_id);
    $response = "order completed and closed successfully";
  }
  header('Content-Type: application/json');
  echo json_encode($response);
}

if (isset($_GET['status']) && $_GET['status'] === 'accept-order') {
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //this marks the order as accepted
    $order_id = $_POST['order_id'];
    $orderObj->acceptOrder($order_id);
    $response = "Order Accepted";
  }
  header('Content-Type: application/json');
  echo json_encode($response);
}

if (isset($_GET['status']) && $_GET['status'] === 'mark-order-as-ready') {
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //this marks the order as ready to collect
    $order_id = $_POST['order_id'];
    $orderObj->markOrderAsReady($order_id);
    $response = "Order completed";
  }
  header('Content-Type: application/json');
  echo json_encode($response);
}

?>