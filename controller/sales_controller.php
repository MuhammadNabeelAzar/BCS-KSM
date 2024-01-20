<?php
session_start();
include '../model/sales_model.php';
$salesObj = new sales();

if (isset($_GET['status']) && $_GET['status'] === 'get-orderSales-details') {
  if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $ID = $_POST['id'];
    $item_id;
    
    


 $salesResult = $salesObj->getOrderItems($ID);
 $salesDetails = $salesResult->fetch_all(MYSQLI_ASSOC);
  

$otherItemsarray = [];
$foodItemsarray = [];

foreach($salesDetails as $row){
    $fooditemId = $row["food_itemId"];
    
    if ($fooditemId !== NULL) {
        $item_id = $fooditemId;
        $FoodItemsresult = $salesObj->getOrderSalesFoodItemsInfo($ID,$item_id);
        $foodItemsarray[] = $FoodItemsresult->fetch_assoc();
    } else if ($fooditemId === NULL) {
        $item_id = $row['item_id'];
        $OtherItemsresult = $salesObj->getOrderSalesOtherItemsInfo($ID,$item_id);
        $otherItemsarray[] = $OtherItemsresult->fetch_assoc();
}

    $response = array(
        "otherItems" => $otherItemsarray,
        "foodItems" => $foodItemsarray
    );
  }
}
  header('Content-Type: application/json');
           echo json_encode($response);
  
}
if (isset($_GET['status']) && $_GET['status'] === 'get-quickSales-details') {
  if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $ID = $_POST['id'];
    $item_id;

    $salesResult = $salesObj->getQuickSaleItems($ID);
    $salesDetails = $salesResult->fetch_all(MYSQLI_ASSOC);

$otherItemsarray = [];
$foodItemsarray = [];
foreach($salesDetails as $row){
    $fooditemId = $row["food_ItemId"];
    
    if ($fooditemId !== NULL) {
        $item_id = $fooditemId;
        $FoodItemsresult = $salesObj->getSalesFoodItemsInfo($ID,$item_id);
        $foodItemsarray[] = $FoodItemsresult->fetch_assoc();
    } else if ($fooditemId === NULL) {
        $item_id = $row['item_id'];
        $OtherItemsresult = $salesObj->getSalesOtherItemsInfo($ID,$item_id);
        $otherItemsarray[] = $OtherItemsresult->fetch_assoc();
}


    $response = array(
        "otherItems" => $otherItemsarray,
        "foodItems" => $foodItemsarray
    );
}
  }
  header('Content-Type: application/json');
           echo json_encode($response);
  
}


?>