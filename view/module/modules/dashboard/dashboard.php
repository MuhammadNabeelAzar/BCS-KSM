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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <link rel="stylesheet" type="text/css" href="../../../style/style.css">
    <link rel="stylesheet" type="text/css" href="../../../style/colors.css">


</head>

<body>
    <?php
    include '../../../commons/header.php';
    ?>

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

    <!--user navigation-->
    <div class=" container-fluid dashboard-container m-0  justify-content-center ">

        <div class="row justify-content-center salesChartRow">
            <div class="col-md-5  salesChartcol ">
                <div class="row  dashboardChartRow">
                    <div class="card dashboardCard">
                        <div class="card-body">
                            <div class="row dashboardTitle">
                                <h4 class="dashboardTitle">
                                    Sales
                                </h4>
                            </div>
                            <div class="row totalDiv text-start"></div>
                        </div>

                    </div>
                </div>
                <div class="row dashboardChartRow">

                    <div class="card dashboardCard ">
                        <div class="row card-title-row ">
                            <h5 class="card-title  dashboardTitle">Top Sales Items</h5>
                        </div>
                        <div class="card-body">
                            <div class="row salesItemsChart "></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-7 dashboardcol dashboardChartRow">
                <div class="card  dashboardCard">
                    <div class="row card-title-row ">
                        <h5 class="card-title  dashboardTitle">Top Categories</h5>
                    </div>
                    <div class="card-body ">
                        <div class="row topcategoriesChart "></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center dashboardChartRow">
            <div class="col-md-6 dashboardcol">
                <div class="card dashboardCard">
                    <div class="row card-title-row">
                        <h5 class="card-title  dashboardTitle">Day-Night Total Visitors</h5>
                    </div>
                    <div class="card-body AvgPurchaseTime"></div>
                </div>
            </div>

            <div class="col-md-6 dashboardcol ">
                <div class="card dashboardCard">
                    <div class="row card-title-row">
                        <h5 class="card-title  dashboardTitle">Ingredient Stock Levels</h5>
                    </div>
                    <div class="card-body ingStockLevels"></div>
                </div>
            </div>
        </div>

    </div>




    <script type="text/javascript" src="../../../../commons/clock.js"></script>
    <script type="text/javascript" src="dashboard.js"></script>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
    crossorigin="anonymous"></script>

</html>