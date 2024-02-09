<?php
session_start();
include_once '../../../../model/role_model.php';
if (!isset($_SESSION['user']) || !isset($_SESSION['user']['role_id'])) {
  // Redirect to the login page
  header("Location: http://localhost/BcsKSM/view/login/login.php");
  exit(); // Make sure to exit after a header redirect
}

$userRoleID = $_SESSION['user']['role_id'];
include_once '../../../../model/menu_model.php';
$menuObj = new menu();
$fooditemResult = $menuObj->getfoodItems();
?>
<html>

<head>
  <title>Restaurant Management System</title>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
  <div class="row Allitems-container justify-content-center">
    <div class="row searchBarRow">
      <div class="col">
        <input class="form-control" id="seachBar" type="search" placeholder="Search" aria-label="Search"
          onkeyup="search()">

      </div>
    </div>

    <div class="row itemcards justify-content-center">
      <?php
      $fooditemResult->data_seek(0); // Resetting the result set pointer
      while ($fooditems = $fooditemResult->fetch_assoc()) {
        $foodid = $fooditems['food_itemId'];
        $foodid = base64_encode($foodid);
        ?>
        <div class="card Allitemscard">
          <div class="row card-header allItem-card-header text-center">
            <h5>
              <?php echo $fooditems["item_name"] ?>
            </h5>
          </div>
          <div class="card-body m-0">
            <div class="row">
              <img class="card-img-top m-0" src="../../../<?php echo $fooditems["img_path"] ?>" alt="Card image cap">
            </div>
            <input type="hidden" class="food_id" value="<?php echo $fooditems["food_itemId"] ?>">
            <div class="row  text-center mt-3 availabilityRow">

              <?php
              $availability = $fooditems['availability'];
              $tmp_availability = $fooditems['tmp_deactivate_availability'];

              switch (true) {
                case($availability === '1' && $tmp_availability === '0'):
                  echo "<h5 class='availabilityText '>Active</h5>";
                  break;
                case($availability === '1' && $tmp_availability === '1'):
                  echo "<h5 class='availabilityText'>Deactivated</h5>";
                  break;
                case($availability === '0'):
                  echo "<h5 class='availabilityText'>Unavailable</h5><p>(Insufficient stock)</p>";
                  break;
              }
              ?>

            </div>
            <div class="row mt-4 activityActionBtnRow">
              <div class="col">
                <button type="button" class="btn btn-outline-danger  text-center"
                  onclick="deactivatefoodItem(this,this.closest('.availabilityText'))"
                  data-foodid="<?php echo $fooditems["food_itemId"]; ?>">
                  Deactivate
                </button>
              </div>
              <div class="col">
                <button type="button" class="btn btn-outline-primary  text-center"
                  onclick="activatefoodItem(this,this.closest('.availabilityText'))"
                  data-foodid="<?php echo $fooditems["food_itemId"]; ?>">
                  Activate
                </button>
              </div>
            </div>

          </div>
        </div>
        <?php
      }
      ?>
    </div>
  </div>

  <div class="modal " tabindex="-1" role="dialog" id="confirmdeactivateModal">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Deactivate Food Item</h5>
          <button type="button" class="btn-close modalclosetbtn" id="closemodalbtn1" data-bs-dismiss="modal"
            aria-label="Close">
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
            <p>Confirming this will deactivate the food item!</p>
          </div>
          <div class="row justify-content-end">
            <div class="col-auto">
              <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"
                id="closemodalbtn2">Close</button>

            </div>
            <div class="col-auto">
              <button type="button" class="btn btn-outline-primary" id="deactivatebtn">Save changes</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="modal " tabindex="-1" role="dialog" id="confirmactivateModal">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Activate Food Item</h5>
          <button type="button" class="btn-close modalclosetbtn" id="closeActivatemodalbtn1" data-bs-dismiss="modal"
            aria-label="Close">
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
            <p>Confirming this will activate the food item!</p>
          </div>
          <div class="row justify-content-end">
            <div class="col-auto">
              <button type="button" class="btn btn-outline-primary" id="activatebtn">Save changes</button>
            </div>
            <div class="col-auto">
              <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"
                id="closeActivatemodalbtn2">Close</button>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
  <script type="text/javascript" src="../../../../commons/clock.js"></script>
  <script type="text/javascript" src="availability.js"></script>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
  integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</html>