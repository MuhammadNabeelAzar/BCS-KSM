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
  <div class="row container-fluid cashier-container m-0 p-0">
  <div class="row m-0">
      <div class="col itemsAndCategoryCol  m-0 p-0">
        <div class="row justify-content-center cashierCategoryRow " id="categories">
          <div class="card col-auto cashierCatCard">
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

            <div class="card col-auto cashierCatCard">
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

        <div class="row ordersAndItemsRow" >
          <div class="customerPendingorderList d-flex flex-column align-items-center"></div>
          <div class="col itemcards   justify-content-center">
            <div class="row justify-content-center" id="fooditems-container"> </div>
          </div>
        </div>
      </div>
      <div class=" col-md-2 cart">
        <div class="row justify-content-center mb-3 cart-title">
          <h3 class="col-auto"><i class="bi bi-cart"></i> Cart</h3>
        </div>
        <div class="row justify-content-center ">
          <button type="button" id="switchToQuickSellBtn" class="btn btn-outline-secondary m-2 col-auto"
            onclick="switchToQuickSell()">Quick Sell</button>
          <button type="button" class="btn btn-outline-secondary m-2 col-auto" id="switchToPlaceOrderBtn"
            onclick="switchToOrder()">Orders</button>

          <div class="cartcustomerDetailscard">
            <div class="input-group form-input mb-2">
              <input type="hidden" id="customer_id">
              <div class="input-group-prepend">
                <span class="input-group-text" id="F-name">First Name</span>
              </div>
              <input type="text" class="form-control" id="customerFName" required>
            </div>
            <div class="input-group form-input mb-2">
              <div class="input-group-prepend">
                <span class="input-group-text" id="L-name">Last Name</span>
              </div>
              <input type="text" class="form-control" id="customerLName">
            </div>
            <div class="input-group form-input mb-2">
              <div class="input-group-prepend">
                <span class="input-group-text" id="email">Email</span>
              </div>
              <input type="text" class="form-control" id="customerEmail">
            </div>
            <div class="input-group form-input mb-2">
              <div class="input-group-prepend">
                <span class="input-group-text" id="contact-no">Contact No</span>
              </div>
              <input type="text" class="form-control" id="customerCno" onchange="getcustomerdetails()">
            </div>
          </div>


        </div>
        <div class="row m-0 mt-2 justify-content-center">
        <div class="row cartItemsCard " id="fooditemslistcontainer"></div>
        </div>
        <div class="row justify-content-center">
          <div class="row mt-2 justify-content-center">
            <div class="Discountcard ">
              <div class="row justify-content-center checkitem">
                <div class="row justify-content-start mb-1">
                  <div class="form-check col-auto form-switch">
                    <input type="checkbox" class="form-check-input" id="discountCheckbox"
                      onchange="showDiscountInput()">
                  </div>
                </div>

                <div class="row m-0 " id="discountinput">
                  <span class="input-group-text " id="discountName">Discount</span>
                </div>

              </div>


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
          <button type="button" class="close finishOrderconfirmationmodal-close-button" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body" id="">
          <p>Are you sure you want to complete and close the order?</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary finishOrderconfirmationmodal-close-button">Close</button>
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
          <button type="button" class="close close-confirmation-modal-button" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body" id="">
          <p>Are you sure you want to cancel this order?</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary close-confirmation-modal-button">Close</button>
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
          <button type="button" class="btn btn-danger" id="cancelOrderButton" onclick="cancelorder()">Cancel
            Order</button>
          <button type="button" class="btn btn-success" id="finishOrderButton" onclick="finishorder()">Finish
            Order</button>
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
          <button type="button" class="btn btn-success" id="sellButton">Confirm</button>
          <button type="button closebtn" class="btn btn-secondary">Close</button>
        </div>
      </div>
    </div>
  </div>







  <script type="text/javascript" src="cashier.js"></script>
  <script type="text/javascript" src="../../../../commons/clock.js"></script>

</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
  integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</html>