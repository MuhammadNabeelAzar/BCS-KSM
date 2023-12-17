<?php
session_start();
include '../model/order_model.php';
$orderObj = new order();

if (isset($_GET['status']) && $_GET['status'] === '') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        //
        

        $result = $orderObj->g();
        $result = $result->fetch_assoc();
        $response = $orderIDresult;
    
        
        header('Content-Type: application/json');
        echo json_encode($response);
    } 

}

?>