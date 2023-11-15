<?php
include_once '../../../../model/menu_model.php';
include_once '../../../../model/ingredients_model.php';
$menuObj = new menu();
$foodItem_id = base64_decode($_GET['foodId']);
$fooditemResult = $menuObj->getfoodItems();
$categoryResult = $menuObj->getcategories();
$fooditem = $menuObj->getaspecificfoodItem($foodItem_id);
$fooditemrow = $fooditem->fetch_assoc();

$ingredientObj = new ingredient();
$ingResult = $ingredientObj->getAllingredients();

if (isset($_GET['foodId'])) {
    $food_id = base64_decode($_GET['foodId']);
    $recipeResult = $menuObj->getrecipe($food_id);

}
?>

<html>

<head>
    <title>Restaurant Management System</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
</head>

<body>
    <!--      navbar-->
    <nav class="navbar navbar-expand-sm navbar-light bg-light">
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
    <a class="btn btn-primary" href="recipie.php">Back</a>
    <hr>
    <!--user navigation-->
    <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel"
        style="width:fit-content">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasExampleLabel"></h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <ul class="list-group">
                <li class="list-group-item">
                    <a href="#" data-bs-toggle="collapse" data-bs-target="#userManagementSubMenu">User Management</a>
                    <!-- Sublist -->
                    <div id="userManagementSubMenu" class="collapse">
                        <ul class="list-group">
                            <li class="list-group-item"><a href="../../admin/user-management/user.php">Users</a></li>
                        </ul>
                    </div>
                </li>
                <li class="list-group-item">
                    <a href="#" data-bs-toggle="collapse" data-bs-target="#menuManagementSubMenu">Menu Management</a>
                    <!-- Sublist -->
                    <div id="menuManagementSubMenu" class="collapse">
                        <ul class="list-group">
                            <li class="list-group-item"><a
                                    href="../../admin/menu-management/categories.php">Categories</a></li>
                            <li class="list-group-item"><a href="../../admin/menu-management/items.php">Items</a></li>
                            <li class="list-group-item"><a href="../../admin/menu-management/pricing.php">Pricing</a>
                            </li>
                            <li class="list-group-item"><a
                                    href="../../admin/menu-management/availability.php">Availability</a></li>
                        </ul>
                    </div>
                </li>
                <li class="list-group-item">
                    <a href="#" data-bs-toggle="collapse" data-bs-target="#ingredientsManagementSubMenu">Ingredients
                        Management</a>
                    <!-- Sublist -->
                    <div id="ingredientsManagementSubMenu" class="collapse">
                        <ul class="list-group">
                            <li class="list-group-item"><a
                                    href="../../admin/ingredients-management/ingredients.php">Ingredients</a></li>
                            <li class="list-group-item"><a href="../../admin/ingredients-management/stock.php">Stock</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="list-group-item">
                    <a href="#" data-bs-toggle="collapse" data-bs-target="#financialManagementSubMenu">Financial
                        Management</a>
                    <!-- Sublist -->
                    <div id="financialManagementSubMenu" class="collapse">
                        <ul class="list-group">
                            <li class="list-group-item"><a href="../../admin/financial-management/sales.php">Sales</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="list-group-item">
                    <a href="#" data-bs-toggle="collapse" data-bs-target="#customerSubMenu">Customer Management</a>
                    <!-- Sublist -->
                    <div id="customerSubMenu" class="collapse">
                        <ul class="list-group">
                            <li class="list-group-item"><a href="../../admin/customer-management/customer.php">Customers
                                    Details</a></li>
                        </ul>
                    </div>
                </li>
                <li class="list-group-item">
                    <a href="../../dashboards/dashboard.php">Dashboard</a>
                </li>

            </ul>
        </div>

    </div>
    <!--user navigation-->

    <div class="container-fluid" style="background-color:">
        <div class="row">
            <div class="col-md-3" style="background-color:">
                <div class="accordion">
                    <div class="row">
                        <form class="form-inline">
                            <input class="form-control " type="search" placeholder="Search" aria-label="Search">
                            <button class="btn btn-outline-success " type="submit">Search</button>

                        </form>
                        <ul class="list-group">
                            <?php
                            while ($foodrow = $fooditemResult->fetch_assoc()) {
                                $foodid = $foodrow['food_itemId'];
                                $foodid = base64_encode($foodid);
                                ?>
                                <a type="button" class="list-group-item"
                                    href="add-recipie.php?foodId=<?php echo $foodid ?>">
                                    <?php echo $foodrow['item_name']; ?>
                                </a>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col" style="background-color:">
                <div class="row">
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
                    id="food_id" name="food_id" value="<?php echo $fooditemrow['food_itemId'] ?>">
                    <div class="input-group mb-3">
                        <div class="row">
                            <h1>
                                <?php echo $fooditemrow['item_name'] ?>
                                <h1>
                        </div>
                    </div>
                    <div class="row" style="background-color:;">
                        <?php
                        if (isset($_GET['foodId'])) {
                            $food_id = $_GET['foodId'];

                            ?>
                            <form id="addrecipe"
                                action="../../../../controller/menu_controller.php?status=add-recipie&foodId=<?php echo $food_id ?>"
                                enctype="multipart/form-data" method="post" onsubmit="return submitValidation()">
                                <div class="col" id="selected-ingredients">
                                </div>
                                <button id="addrecipiebtn" type="" class="btn btn-primary ">
                                    update
                                </button>

                            </form>
                            <div class="row bg-light" style="background-color:">
                                <div class="col" id="list" style="background-color:">
                                    <h3>Ingredients</h3>
                                    <?php
                                    $selected_ingredients = array();

                                    // Loop through the selected ingredients to store them in an array
                                    while ($reciperow = $recipeResult->fetch_assoc()) {
                                        $selected_ingredients[] = $reciperow['ing_id'];
                                    }

                                    // Reset the result set pointer for the ingredient loop
                                    $ingResult->data_seek(0);

                                    while ($ingrow = $ingResult->fetch_assoc()) {
                                        $ing_id = $ingrow['ing_id'];
                                        ?>

                                        <div class="form-check form-check-inline ml-1" id="checkitem">
                                            <input type="hidden" value="<?php echo $ing_id; ?>" id="ing_id" name="ing_id[]">
                                            <input class="form-check-input" type="checkbox" value="<?php echo $ing_id; ?>"
                                                id="flexCheckDefault" <?php echo in_array($ing_id, $selected_ingredients) ? 'checked' : ''; ?>>
                                            <p>
                                                <?php echo $ingrow['ing_name']; ?>
                                            </p>
                                        </div>

                                        <?php
                                    }
                                    ?>

                                </div>
                            <?php } ?>
                            <div class="input-group mb-3">

                                <div class="col-md-3">
                                    <img id="imgprev" src="<?php echo "../../../" . $fooditemrow["img_path"] ?>"
                                        alt="Image Preview" style="height: 100px; width: 100px;">
                                </div>
                            </div>

                        </div>
                    </div>


                </div>
            </div>


        </div>

        <div class="modal fade" id="removeFooditemModal" tabindex="-1" role="dialog"
            aria-labelledby="removeFooditemModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="removeingtitle">Remove Food item</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to remove this this food item ?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <a type="button" class="btn btn-primary"
                            href="../../../../controller/menu_controller.php?status=delete-fooditem&foodId=<?php echo $foodid ?>">Remove
                            food item</a>
                    </div>
                </div>
            </div>
        </div>

        <script type="text/javascript">
            function readUrl(input) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $("#imgprev")
                        .attr('src', e.target.result)
                        .height(70)
                        .width(80);
                };
            }
        </script>

        <script type="text/javascript" src="../../../../commons/clock.js"></script>
        <script type="text/javascript" src="recipie.js"></script>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
    crossorigin="anonymous"></script>

</html>