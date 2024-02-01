<?php 
session_start();
include_once '../../../../model/role_model.php';
if (!isset($_SESSION['user']) || !isset($_SESSION['user']['role_id'])) {
    // Redirect to the login page
    header("Location: http://localhost/BcsKSM/view/login/login.php");
    exit(); // Make sure to exit after a header redirect
}

$userRoleID = $_SESSION['user']['role_id'];
include_once '../../../../model/dashboard_model.php';
$dashboardrObj = new dashboard();

?>
<html>
    <head>
        <title>Restaurant Management System</title>
        <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">   
        <link rel="stylesheet" type="text/css" href="../../../../style/style.css">
        
    </head>
    <body>
    <?php 
    include '../../../commons/header.php';
    ?>
        <a class="btn btn-primary" data-bs-toggle="offcanvas" href="#offcanvasExample" role="button" aria-controls="offcanvasExample">
            <i class="bi bi-list"></i>
        </a>
        <hr>
        <!--user navigation-->
        <?php
    // Include the sidebar file
    if ($userRoleID == 1) {
        include '../../../commons/admin-navigation.php';
    } elseif ($userRoleID == 2) {
        include '../../../commons/chef-navigation.php';
    } elseif ($userRoleID == 3) {
        include '../../../commons/stock-manager-navigation.php';
    } elseif ($userRoleID == 4) {
        include '../../../commons/cashier-navigation.php';
    }
    ?>

        </div>
        <!--user navigation-->
        <div class="container-fluid" style="background-color:#fff9db">
<div class="row">
    <div class="col-md-5 salesItemsChart" ></div>
    <div class="col-md-5">
       
        <div class="row topcategoriesChart"></div>
        <div class="row totalDiv"></div>
    </div>
</div>
<div class="row">
    <div class="col-md-5 AvgPurchaseTime"></div>
    <div class="col-md-5 ingStockLevels"></div>
</div>
        </div>
         
        <script type="text/javascript" src="../../../../commons/clock.js"></script>
        <script type="text/javascript" src="dashboard.js"></script>
    </body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</html>