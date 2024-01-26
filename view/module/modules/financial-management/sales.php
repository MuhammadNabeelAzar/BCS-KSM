<?php
  session_start();
  include_once '../../../../model/role_model.php';
  if (!isset($_SESSION['user']) || !isset($_SESSION['user']['role_id'])) {
    // Redirect to the login page
    header("Location: http://localhost/BcsKSM/view/login/login.php");
    exit(); // Make sure to exit after a header redirect
}

$userRoleID = $_SESSION['user']['role_id'];
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
</head>

<body>
    <!--      navbar-->
    <nav class="navbar navbar-expand-sm navbar-light bg-light" style="height:70px">
        <div class="container-fluid">
            <div class="d-flex flex-column datetime m-2">
                <div class="date">
                    <span id="dayname">Day</span>
                    <span id="month">Month</span>:
                    <span id="daynum">00</span>
                    <span id="year">Year</span>
                </div>
                <div class="time">
                    <span id="hour">00</span>:
                    <span id="minutes">00</span>:
                    <span id="seconds">00</span>:
                    <span id="period">AM</span>
                </div>

            </div>

            <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto"> <!-- Use "ml-auto" to push items to the right -->
                    <button type="button" class="btn btn-light" id="bell"><i class="bi  bi-bell"></i></button>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Account
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="#"><Span><i class="bi bi-lock"></i></Span>Settings</a>
                            </li>
                            <li><a class="dropdown-item" href="#"><span><i
                                            class="bi bi-box-arrow-right"></i></span>Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <a class="btn btn-primary" data-bs-toggle="offcanvas" href="#offcanvasExample" role="button"
        aria-controls="offcanvasExample">
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
    <div class="container-fluid">
        <div class="row">
            <div class="row">
                <div class="col">
                    <input type="text" id="seachBar" class=" form-control" placeholder="Search" aria-label="searchbar"
                        aria-describedby="search" onkeyup="search()">

                </div>
                <div class="col">
                    <div class=" input-group-append">
                        <button class=" btn btn-outline-secondary" type="button"><i class="bi bi-search"></i></button>
                    </div>
                </div>
                <div class="col">
                <input type="hidden" id="salesItemsSearchType">
                <button class=" btn btn-secondary col" type="button" onclick="filtersalesdetails('sales')"><p>Quick Sales</p></button><button class=" btn btn-secondary col" type="button"  onclick="filtersalesdetails('order')"><p>Order Sales</p></button>
                </div>
            </div>
            <div class="row">
                <div class="table-responsive " style="height:400px">
                    <table class="table">
                        <thead>
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
                                <tr class=" ordersalesRow">
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

                                    <td><a class="btn btn-primary" onclick="getSalesInfo(<?php echo $Id ?>,'order')"></a></td>
                                </tr>
                            <?php } ?>
                            <?php
                            while ($row = $quickSalesResult->fetch_assoc()) {
                                $Id = $row['sales_id'];
                                ?>
                                <tr class="quicksalesRow">
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

                                    <td><a class="btn btn-primary" onclick="getSalesInfo(<?php echo $Id ?>,'quicksale')"></a></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
    </div>
    <div class="modal" id="orderDetailsModal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"></h5>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="order-details-modal-body">
      </div>
      <div class="modal-footer ">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> 
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