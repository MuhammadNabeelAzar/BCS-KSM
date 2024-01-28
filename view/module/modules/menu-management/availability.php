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
        <div class="col"><input class="form-control "  id="seachBar" type="search" placeholder="Search" aria-label="Search" onkeyup="search()">
                            <button class="btn btn-outline-success " type="submit">Search</button></div>
        <div class="row">
            <div class="row">
                <?php
                while ($fooditems = $fooditemResult->fetch_assoc()) {
                    $foodid = $fooditems['food_itemId'];
                    $foodid = base64_encode($foodid);
                    ?>
                    <div class="card" style="width: 18rem;margin:2px;">
                        <img class="card-img-top" src="../../../<?php echo $fooditems["img_path"] ?>" alt="Card image cap">
                        <div class="card-body">
                            <input type="hidden" class="food_id" value="<?php echo $fooditems["food_itemId"] ?>">
                            <div class="row">
                                <p class="card-title">
                                    <?php echo $fooditems["item_name"] ?>
                                </p>
                                <?php
                                $availability = $fooditems['availability'];
                                $tmp_availability = $fooditems['tmp_deactivate_availability'];

                                if ($availability === '1' && $tmp_availability==='0') {
                                    echo "<h5>Available</h5>";
                                } else {
                                    echo "<h5>Unavailable</h5>";
                                }
                                ?>

                            </div>

                            <div class="row">
                                <p class="card-title"></p>
                                <button type="button" class="btn btn-danger" onclick="deactivatefoodItem(this)" data-foodid="<?php echo $fooditems["food_itemId"]; ?>" >
                                    <i class="bi bi-file-minus"></i>
                                </button>
                                <button type="button" class="btn btn-primary" onclick="activatefoodItem(this)" data-foodid="<?php echo $fooditems["food_itemId"]; ?>" >
                                    <i class="bi bi-file-plus"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                <?php }
                ?>
            </div>
        </div>
    </div>
    <div class="modal " tabindex="-1" role="dialog" id="confirmdeactivateModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Deactivate Food Item</h5>
        <button type="button" class="close" id="closemodalbtn1" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Confirming this will deactivate the food item!</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="deactivatebtn">Save changes</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="closemodalbtn2">Close</button>
      </div>
    </div>
  </div>
</div>
    <div class="modal " tabindex="-1" role="dialog" id="confirmactivateModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Activate Food Item</h5>
        <button type="button" class="close" id="closeActivatemodalbtn1" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Confirming this will activate the food item!</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="activatebtn">Save changes</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="closeActivatemodalbtn2">Close</button>
      </div>
    </div>
  </div>
</div>
    <script type="text/javascript" src="../../../../commons/clock.js"></script>
    <script type="text/javascript" src="availability.js"></script>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
    crossorigin="anonymous"></script>

</html>