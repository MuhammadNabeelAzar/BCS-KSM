<?php
session_start();
include_once '../../../../model/menu_model.php';
include_once '../../../../model/role_model.php';
if (!isset($_SESSION['user']) || !isset($_SESSION['user']['role_id'])) {
    // Redirect to the login page
    header("Location: http://localhost/BcsKSM/view/login/login.php");
    exit(); // Make sure to exit after a header redirect
}

$userRoleID = $_SESSION['user']['role_id'];
$menuObj = new menu();
$categoryResult = $menuObj->getcategories();

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
    <?php
    if (isset($_GET["msg"])) {
        $msg = base64_decode($_GET["msg"]);
        ?>
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <div class="d-flex justify-content-between align-items-center">
                <p class="mb-0">
                    <?php echo $msg; ?>
                </p>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                </button>
            </div>
        </div>

        <?php
    }
    ?>
    <div class="container-fluid categorycontainer">
        <div class="row">
            <div class="row categoryRow justify-content-center">
                <div class="row justify-content-end">
                    <a type="button" class="btn btn-outline-primary addCategoryBtn" data-bs-toggle="modal"
                        data-bs-target="#addCategoryModal"><span><i class="bi bi-plus-circle"></i></span> Add Category
                    </a>
                </div>
                <?php
                while ($categoryrow = $categoryResult->fetch_assoc()) {
                    $categoryid = $categoryrow["category_id"];
                    $fooditemResult = $menuObj->getfoodItems();
                    $otherItemResult = $menuObj->getOtherItems(); //get all the foodItems
                    ?>
                    <div class="col-md-3  categorycard">
                        <div class="card">
                            <div class="card-header ">
                                <input type="hidden" id="hiddenField" name="HiddenFoodID"
                                    value="<?php echo $categoryrow['category_id']; ?>">
                                <div class="row">
                                    <h4 class="col">
                                        <?php echo $categoryrow['category_name']; ?>
                                    </h4>
                                    <button type="button" class="btn btn-outline-danger delete-category-btn col"
                                        onclick="deletecategory(<?php echo $categoryid ?>)"><i
                                            class="bi bi-trash"></i></button>

                                </div>
                            </div>
                            <div class="card-body">
                                <ul class="list-group">
                                    <div class="row">
                                        <?php
                                        while ($foodrow = $fooditemResult->fetch_assoc()) {
                                            if ($foodrow['category_id'] == $categoryid) { //display the food items if the categoryid matches the food item category id
                                                ?>
                                                <li class="list-group-item">
                                                    <p>
                                                        <?php echo $foodrow['item_name'] . "   " . "Rs." . $foodrow['price'] . " " ?>
                                                    </p>

                                                </li>
                                            <?php }
                                        } ?>
                                        <?php
                                        while ($itemsrow = $otherItemResult->fetch_assoc()) {
                                            if ($itemsrow['category_id'] == $categoryid) { //display the food items if the categoryid matches the food item category id
                                                ?>
                                                <li class="list-group-item">

                                                    <input type="hidden" id="itemName" name="itemName"
                                                        value="<?php echo $itemsrow['item_name']; ?>">
                                                    <p>
                                                        <?php echo $itemsrow['item_name'] . " " . $itemsrow['price'] . " " ?>
                                                    </p>

                                                </li>
                                            <?php }
                                        } ?>
                                    </div>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>


    </div>
    <div class="modal fade" id="addCategoryModal" tabindex="-1" role="dialog" aria-labelledby="addCategoryModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Category</h5>
                    <button type="button" class="btn-close modalclosetbtn" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <form action="../../../../controller/menu_controller.php?status=add-category"
                        enctype="multipart/form-data" method="post">
                        <div class="form-group">
                            <input type="text" class="form-control" id="Category" name="Category"
                                aria-describedby="newCategory" placeholder="Category Name" required>
                        </div>
                        <div class="row  justify-content-end mt-3">
                            <div class="col-auto">
                                <button type="button" class="btn btn-outline-secondary"
                                    data-bs-dismiss="modal">Close</button>
                            </div>
                            <div class="col-auto">
                                <button type="submit" class="btn btn-outline-primary">Save changes</button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <div class="modal fade" id="deleteCategoryModal" tabindex="-1" role="dialog"
        aria-labelledby="deleteCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteCategoryModalLabel">Modal title</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="../../../../controller/menu_controller.php?status=delete-category"
                        enctype="multipart/form-data" method="post">
                        <input type="hidden" id="CategoryId" name="categoryId">
                        <p>Are you sure you want to delete this category ?</p>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Delete</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <script type="text/javascript" src="../../../../commons/clock.js"></script>
    <script type="text/javascript" src="category.js"></script>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
    crossorigin="anonymous"></script>

</html>