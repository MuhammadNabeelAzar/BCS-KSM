<?php
session_start();
include_once '../../../../model/role_model.php';
if (!isset($_SESSION['user']) || !isset($_SESSION['user']['role_id'])) {
    // Redirect to the login page
    header("Location: http://localhost/BcsKSM/view/login/login.php");
    exit(); // Make sure to exit after a header redirect
}

$userRoleID = $_SESSION['user']['role_id'];
    // Redirect to the home page
    switch ($userRoleID) {
        case 2:
            header("Location: http://localhost/BcsKSM/view/users/chef/chef.php");
            break;
        case 3:
            header("Location: http://localhost/BcsKSM/view/users/stock-manager/stockmanager.php");
            break;
        case 4:
            header("Location: http://localhost/BcsKSM/view/users/cashier/cashier.php");
            break;
        }
include_once '../../../../model/sales_model.php';
$salesObj = new sales();
$orderSalesResult = $salesObj->getOrderSalesDetails();
$quickSalesResult = $salesObj->getQuickSalesDetails();

?>
<html>

<head>
    <title>Restaurant Management System</title>
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
    <div class="container-fluid ">
        <div class="row justify-content-center">
            <div class="col-md-9 justify-content-center">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="col-md-3 mb-2 mt-2">
                        <input type="text" id="seachBar" class="form-control" placeholder="Search"
                            aria-label="searchbar" aria-describedby="search" onkeyup="search()">
                    </div>
                    <div class="row">
                        <input type="hidden" id="salesItemsSearchType">
                        <div class="col-auto  text-center">
                            <button class=" btn btn-outline-secondary " type="button"
                                onclick="filtersalesdetails('sales')">Quick Sales</button>

                        </div>
                        <div class="col-auto text-center">
                            <button class=" btn btn-outline-secondary" type="button"
                                onclick="filtersalesdetails('order')">Order Sales</button>

                        </div>
                    </div>
                </div>

                <div class="table-responsive tableRowLg">
                    <table class="table table-hover   table-striped  ">
                        <thead class="table-header table-header-lg  text-center">
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Customer ID</th>
                                <th scope="col">Date</th>
                                <th scope="col">Time</th>
                                <th scope="col">Info</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while ($row = $orderSalesResult->fetch_assoc()) {
                                $Id = $row['order_id'];
                                ?>
                                <tr class=" ordersalesRow table-light text-center">
                                    <td>
                                        <?php echo 'O' . $row['order_id'] ?>
                                    </td>
                                    <td>
                                        <?php echo $row['customer_id'] ?>
                                    </td>
                                    <td>
                                        <?php echo $row['order_date'] ?>
                                    </td>
                                    <td>
                                        <?php echo $row['order_time'] ?>
                                    </td>

                                    <td><a class="btn btn-outline-primary"
                                            onclick="getSalesInfo(<?php echo $Id ?>,'order')"><i
                                                class="bi bi-info-circle"></i></a></td>
                                </tr>
                            <?php } ?>
                            <?php
                            while ($row = $quickSalesResult->fetch_assoc()) {
                                $Id = $row['sales_id'];
                                ?>
                                <tr class="quicksalesRow table-light text-center">
                                    <td>
                                        <?php echo 'S' . $row['sales_id'] ?>
                                    </td>
                                    <td>
                                        <?php echo $row['customer_id'] ?>
                                    </td>
                                    <td>
                                        <?php echo $row['date'] ?>
                                    </td>
                                    <td>
                                        <?php echo $row['time'] ?>
                                    </td>

                                    <td><a class="btn btn-outline-primary"
                                            onclick="getSalesInfo(<?php echo $Id ?>,'quicksale')"><i
                                                class="bi bi-info-circle"></i></a></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
        <div class="modal" id="orderDetailsModal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"></h5>
                        <button type="button" class="btn-close modalclosetbtn" data-bs-dismiss="modal" aria-label="Close">
                        </button>
                    </div>
                    <div class="modal-body m-0" id="order-details-modal-body">
                        <div class="row salesDetailsRow m-0">

                        </div>
                    <div class="row justify-content-end ">
                <div class="col-auto">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                   
                </div>        
                </div>
                    </div>
                   
                </div>
            </div>
        </div>

        <script type="text/javascript" src="../../../../commons/clock.js"></script>
        <script type="text/javascript" src="sales.js"></script>

</body>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
    crossorigin="anonymous"></script>

</html>