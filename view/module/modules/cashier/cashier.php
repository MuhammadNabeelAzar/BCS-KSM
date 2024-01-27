<?php
  session_start();
  include_once '../../../../model/role_model.php';
  $userRoleID = isset($_SESSION['user']['role_id']) ? $_SESSION['user']['role_id'] : null;
include_once '../../../../model/menu_model.php';
$menuObj = new menu();
$categoryResult = $menuObj->getcategories();
?>
<html>

<head>
    <title>Restaurant Management System</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
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
    <!--user navigation-->
    <div class="container-fluid">
        <div class="row" style="background-color:;">
            <div class="col">
                <div class="row justify-content-center" id="categories">
                    <div class="card col" style="margin:2px;">
                        <a class="card-link" onclick="showallItems()">
                            <div class="card-body">
                                <div class="row">
                                    <h3 class="card-title text-center">
                                        All
                                    </h3>
                                </div>

                            </div>
                        </a>
                    </div>
                    <?php
                    while ($categories = $categoryResult->fetch_assoc()) {
                        $categoryId = $categories['category_id'];
                        ?>

                        <div class="card col" style="margin:2px;">
                            <a class="card-link" onclick="filteritems(<?php echo $categoryId; ?>)">
                                <div class="card-body">
                                    <input type="hidden" id="category-id" value="<?php echo $categories['category_id']; ?>">
                                    <div class="row">
                                        <h3 class="card-title text-center">
                                            <?php echo $categories["category_name"] ?>
                                        </h3>
                                    </div>

                                </div>
                            </a>
                        </div>

                    <?php } ?>
                </div>
                <div class="row justify-content-center" id="fooditems-container" style="height:;"> </div>
                <div class="row customerPendingorderList bg-dark overflow-auto" style="width:100%;height:200px"></div>
            </div>
            <div class="col-md-2 bg-light" style="background-color:;">
                <div class="row" style="background-color:;">
                    <h4 class="col">Order Details</h4><button type="button" id="switchToQuickSellBtn" class="col" onclick="switchToQuickSell()">Quick Sell</button>
                    <button type="button" class="col"  id="switchToPlaceOrderBtn" onclick="switchToOrder()">Orders</button>
                    <div class="row">
                    <input class="col" type="hidden" id="customer_id" >
                        <div class="col">First Name</div>
                        <input class="col" type="text" id="customerFName" required>
                    </div>
                    <div class="row">
                        <div class="col">Last Name</div>
                        <input class="col" type="text" id="customerLName">
                    </div>
                    <div class="row">
                        <div class="col">Email</div>
                        <input class="col" type="text" id="customerEmail">
                    </div>
                    <div class="row">
                        <div class="col">Contact No </div>
                        <input class="col" type="text" id="customerCno"  onchange="getcustomerdetails()">
                    </div>
                </div>
                <div class="row " id="fooditemslistcontainer" style="background-color:white;"></div>
                <div class="row justify-content-center" style="background-color:">
                    <div class="row">
                        <div class="row">
                        <div class="col checkitem">
                        <label for="discountCheckbox">Discount</label>
                            <input type="checkbox" id="discountCheckbox" onclick="showDiscountInput()" >                          
                        </div>
                        <div class="col" id="discountinput"></div> 
                        </div>
                        <div class="row">
                        <div class="col">
                            <h5>Total :</h5>
                        </div>
                        <div class="col" id="totalDiv">
                            <h5 id="totalAmount"></h5>
                        </div>
                        </div>
                    </div>
                    <button class="btn btn-primary col-md-8" id="placeOrderBtn" onclick="placeOrder()">
                        <h7>Place Order</h7>
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    <div class="modal finishOrderconfirmationmodal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="confirmation-modal-title">Finish Order</h5>
        <button type="button" class="close finishOrderconfirmationmodal-close-button"  aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="">
        <p>Are you sure you want to complete and close the order?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary finishOrderconfirmationmodal-close-button" >Close</button>
        <button type="button" class="btn btn-success finishOrderconfirmation-button">Confirm</button>
      </div>
    </div>
  </div>
</div>
    <div class="modal confirmationmodal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="confirmation-modal-title">Cancel Order</h5>
        <button type="button" class="close close-confirmation-modal-button"  aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="">
        <p>Are you sure you want to cancel this order?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary close-confirmation-modal-button" >Close</button>
        <button type="button" class="btn btn-danger cancel-order-button">Confirm</button>
      </div>
    </div>
  </div>
</div>

    <div class="Modal" id="orderDetailsModal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"></h5>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="order-details-modal-body">
        <p id="fooditems"></p>
      </div>
      <div class="modal-footer ">
      <button type="button" class="btn btn-danger" id="cancelOrderButton" onclick="cancelorder()">Cancel Order</button>
      <button type="button" class="btn btn-success" id="finishOrderButton" onclick="finishorder()">Finish Order</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> 
      </div>
    </div>
  </div>
</div>
    <div class="Modal" id="quickSellmodal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="quick-sell-modal-title"></h5>
        <button type="button closebtn" class="close" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="quick-sell-modal-body" id="sales-details-modal-body">
        <p id="quick-sale-items"></p>
      </div>
      <div class="modal-footer ">
      <button type="button" class="btn btn-success" id="sellButton" >Confirm</button>
        <button type="button closebtn" class="btn btn-secondary" >Close</button> 
      </div>
    </div>
  </div>
</div>




    <script type="text/javascript" src="cashier.js"></script>
    <script type="text/javascript" src="../../../../commons/clock.js"></script>
    
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
    crossorigin="anonymous"></script>

</html>