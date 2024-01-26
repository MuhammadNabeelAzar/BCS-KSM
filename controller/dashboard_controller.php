<?php
session_start();
include '../model/dashboard_model.php';
$dashboardObj = new dashboard();

if (isset($_GET['status']) && $_GET['status'] === 'get-all-sold-items') {
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        //

        $data = $dashboardObj->getAllOrderSalesItems();
        $data2 = $dashboardObj->getAllQuickSalesItems();
        $orderSales = $data->fetch_all(MYSQLI_ASSOC);
        $quickSales = $data2->fetch_all(MYSQLI_ASSOC);
      
        

        $response = $orderSales +  $quickSales;
    
        header('Content-Type: application/json');
        echo json_encode($response);
        }
    }
if (isset($_GET['status']) && $_GET['status'] === 'get-all-sold-categories') {
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        //

        $data = $dashboardObj->getAllOrderSalesCategories();
        $data2 = $dashboardObj->getAllQuickSalesCategories();
        $orderSalesCategories = $data->fetch_all(MYSQLI_ASSOC);
        $quickSalesCategories = $data2->fetch_all(MYSQLI_ASSOC);
      
        

        $response =  $orderSalesCategories +  $quickSalesCategories;
    
        header('Content-Type: application/json');
        echo json_encode($response);
        }
    }
if (isset($_GET['status']) && $_GET['status'] === 'get-sales-customer-details') {
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        //

        $data = $dashboardObj->getAllOrderSalesCustomerDetails();
        $data2 = $dashboardObj->getAllQuickSalesCustomerDetails();
        $orderCustomerAndSalesTimeDetails = $data->fetch_all(MYSQLI_ASSOC);
        $quickCustomerAndSalesTimeDetails = $data2->fetch_all(MYSQLI_ASSOC);
      
        

        $response =  $orderCustomerAndSalesTimeDetails +  $quickCustomerAndSalesTimeDetails;
    
        header('Content-Type: application/json');
        echo json_encode($response);
        }
    }
if (isset($_GET['status']) && $_GET['status'] === 'get-ingredients-stock-levels') {
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        //

        $response = $dashboardObj->getIngredientStockLevels();
    
        header('Content-Type: application/json');
        echo json_encode($response);
        }
    }





?>