<?php
session_start();
include '../model/customer_model.php';
$customerObj = new customer();

if (isset($_GET['status']) && $_GET['status'] === 'add-customer') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        //
        $cus_id = $_POST['customer_id'];
        $cusFname = $_POST['customerFname'];
        $cusLname = $_POST['customerLname'];
        $cusEmail = $_POST['customerEmail'];
        $cusContactNo = $_POST['customercontactNo'];

        $customerObj->insertorUpdatecustomerdetails($cus_id,$cusFname,$cusLname,$cusEmail,$cusContactNo);

        $response = "sucessfully inserted";
    
        
        header('Content-Type: application/json');
        echo json_encode($response);
    } 

}
if (isset($_GET['status']) && $_GET['status'] === 'get-customer-details') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        //
        
        $cusContactNo = $_POST['customerNo'];

        $result = $customerObj->getAcustomersdetails($cusContactNo);
        
        $response = $result->fetch_assoc();
    
        
        header('Content-Type: application/json');
        echo json_encode($response);
    } 

}

?>