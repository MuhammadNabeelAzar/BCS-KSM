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
$otherItemResult = $menuObj->getOtherItems();
$categoryResult = $menuObj->getcategories();
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
                        <input class="form-control " type="search" id="seachBar" placeholder="Search" onkeyup="search()" aria-label="Search">
                        <button class="btn btn-outline-success " type="submit" >Search</button>

                    <ul class="list-group">
                        <?php
                        while($foodrow = $fooditemResult->fetch_assoc())
                        {
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
        <div class="col" style="background-color:yellow">
            <div class="row">
                <button type="button" class="col btn btn-primary" onclick="switchToAddOtherItemBtn()">Other Item</button>
                <button type="button" class="col btn btn-primary" onclick="switchToFoodItemBtn()">Food Item</button>
                <form id="add-item-form" action="../../../../controller/menu_controller.php?status=add-fooditem"
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
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text placeholdername" id="inputGroup-sizing-default">Food Item</span>
                        </div>
                        <input type="text" class="form-control" aria-label="Default" aria-describedby="inputGroup"
                        id="food_Name"  name="food_Name" required>
                    </div>
                    <div class="input-group">
                        <label for="exampleFormControlTextarea1">Description</label>
                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"
                        id="food_descript"  name="food_descript"> </textarea>
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <input type="file" class="form-control" aria-label="Default" aria-describedby="inputGroup"
                                name="food_image" id="food_image" >
                        </div>   
                        <select class="forms-select mb-3" id="categories" aria-label="categories" name="categories" >
                        <option disabled selected value="0">Select</option>
                                        <?php
                                        while ($category = $categoryResult->fetch_assoc()) {
                                            echo '<option value=' . $category['category_id'] . '>' . $category['category_name'] . '</option>';
                                        }
                                        ?>
                    </select>
      
                        <div class="col-md-3">
                        <img id="imgprev" src="" alt="Image Preview" style="height: 100px; width: 100px;">
                                </div>

                    </div>
                    <div class="row buttonDiv">
                    <button type="submit" class="btn btn-primary" >
   Add Food Item
</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
  </div>
  <script>
            $(document).ready(() => {
                $("#food_image").change(function () {
                    const file = this.files[0];
                    if (file) {
                        let reader = new FileReader();
                        reader.onload = function (event) {
                            $("#imgprev")
                              .attr("src", event.target.result);
                        };
                        reader.readAsDataURL(file);
                    }
                });
            });
        </script>

        <script type="text/javascript" src="items.js"></script>
        <script type="text/javascript" src="../../../../commons/clock.js"></script>
    </body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</html>