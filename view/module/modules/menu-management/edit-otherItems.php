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
$Item_id = base64_decode($_GET['itemId']);
$fooditemResult = $menuObj->getfoodItems();
$categoryResult = $menuObj->getcategories();
$otherItemResult = $menuObj->getOtherItems();
$otherItem = $menuObj->getanItem($Item_id);
$otherItem = $otherItem->fetch_assoc();
?>
<html>
    <head>
        <title>Restaurant Management System</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">    
    </head>
    <body>
        <!--      navbar-->
        <nav class="navbar navbar-expand-sm navbar-light bg-light"style="height:70px">
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
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Account
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="#"><Span><i class="bi bi-lock"></i></Span>Settings</a></li>
                                <li><a class="dropdown-item" href="#"><span><i class="bi bi-box-arrow-right"></i></span>Logout</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <a class="btn btn-primary" data-bs-toggle="offcanvas" href="#offcanvasExample" role="button" aria-controls="offcanvasExample">
            <i class="bi bi-list"></i>
        </a>
        <a class="btn btn-primary" href="items.php">Back</a>
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

        <div class="row">
        <div class="col-md-3" style="background-color:black">
            <div class="accordion">
                <div class="row">
                    <form class="form-inline">
                        <input class="form-control " type="search" id="seachBar" placeholder="Search" aria-label="Search" onkeyup="search()">
                        <button class="btn btn-outline-success " type="submit">Search</button>

                    </form>
                    <ul class="list-group">
                        <?php
                        while($foodrow = $fooditemResult->fetch_assoc()){
                            $foodid = $foodrow['food_itemId'];
                            $foodid = base64_encode($foodid);
                            ?>
                            <a type="button" class="list-group-item" href="edit-foodItems.php?status=edit-foodItem&foodId=<?php echo $foodid ?>">
                            <p><?php echo $foodrow['item_name'] ;?></p>
                        </a> 
                        <?php } ?>
                        <?php
                        while($otherItemRow = $otherItemResult->fetch_assoc())
                        {
                            $otherItemId = $otherItemRow['item_id'];
                            $otherItemId = base64_encode($otherItemId);
                            ?>
                            <a type="button" class="list-group-item" href="edit-otherItems.php?status=edit-Item&itemId=<?php echo $otherItemId ?>">
                            <p> <?php echo $otherItemRow['item_name'] ;?></p>
                        </a> 
                        <?php } ?>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col" style="background-color:blue">
            <div class="row">
                <form action="../../../../controller/menu_controller.php?status=edit-otherItem"
                    enctype="multipart/form-data" method="post">
                    <div class="row" id="errormsg">
                        <?php
                        if (isset($_GET["msg"])) {
                            $msg = base64_decode($_GET["msg"]);
                            ?>
                            <div class="row">
                                <p>
                                    <?php echo $msg; ?>
                                </p>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                    <input type="hidden" class="form-control" aria-label="Default" aria-describedby="inputGroup"
                            name="itemId" value="<?php echo $otherItem['item_id'] ?>">
                    <input type="hidden" class="form-control" aria-label="Default" aria-describedby="inputGroup"
                            name="img_path_name" value="<?php echo $otherItem['img_path'] ?>">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Item</span>
                        </div>
                        <input type="text" class="form-control" aria-label="Default" aria-describedby="inputGroup"
                            name="item_Name" value="<?php echo $otherItem['item_name'] ?>">
                    </div>
                    <div class="input-group">
                        <label for="exampleFormControlTextarea1">Description</label>
                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"
                            name="item_descript" > <?php echo $otherItem['description'] ?></textarea>
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <input type="file" class="form-control" aria-label="Default" aria-describedby="inputGroup"
                                name="item_image" id="item_image" onchange="readUrl(this);" >
                        </div>   
                        <select class="forms-select mb-3" id="category" aria-label="category" name="category" required>
                        <option value="">----</option>
                        <?php
                        while ($categoryrow = $categoryResult->fetch_assoc()) {
                            ?>
                            <option name="category_selected" value="<?php echo $categoryrow["category_id"]; ?>" <?php
                               if ($otherItem["category_id"] == $categoryrow["category_id"]) {
                                   ?> selected="selected" <?php
                               }
                               ?>>
                                <?php echo $categoryrow["category_name"]; ?>
                            </option>
                            <?php
                        }
                        ?>
                    </select>
      
                        <div class="col-md-3">
                        <img id="imgprev" src="<?php echo "../../../" . $otherItem["img_path"] ?>" alt="Image Preview" style="height: 100px; width: 100px;">
                                </div>

                    </div>
                    <button type="submit" class="btn btn-primary">
                        update
                    </button>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#removeItemModal">Remove Item
                    </button>
                </form>
            </div>
        </div>
    </div>
  </div>

  <div class="modal fade" id="removeItemModal" tabindex="-1" role="dialog"
        aria-labelledby="removeitemModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="removeitemtitle">Remove item</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure you want to remove this this item ?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <a type="button" class="btn btn-primary"
                        href="../../../../controller/menu_controller.php?status=delete-item&itemId=<?php echo $Item_id ?>">Remove
                         item</a>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        function readUrl(input) {
            if (input.files && input.files[0]) {
                console.log(input.files[0]);
                var reader = new FileReader();
                reader.onload = function (e) {
                    $("#imgprev")
                        .attr('src', e.target.result)
                        .height(70)
                        .width(80);
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>

        <script type="text/javascript" src="../../../../commons/clock.js"></script>
        <script type="text/javascript" src="items.js"></script>
    </body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</html>