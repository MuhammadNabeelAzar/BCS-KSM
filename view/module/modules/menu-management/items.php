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
    <div class="row items-container common-container m-0">
        <div class="col-md-3 items-column">
            <div class="row items-list-row justify-content-center">
                <div class="row justify-content-center">
                    <div class="row justify-content-center searchBarRow">
                        <input class="form-control " type="search" id="seachBar" placeholder="Search" onkeyup="search()"
                            aria-label="Search">
                    </div>

                    <div class="row">
                        <ul class="list-group list-row">
                            <?php
                            while ($foodrow = $fooditemResult->fetch_assoc()) {
                                $foodid = $foodrow['food_itemId'];
                                $foodid = base64_encode($foodid);
                                ?>
                                <a type="button" class="list-group-item"
                                    href="edit-foodItems.php?status=edit-foodItem&foodId=<?php echo $foodid ?>">
                                    <h5>
                                        <?php echo $foodrow['item_name']; ?>
                                    </h5>
                                </a>
                            <?php } ?>
                            <?php
                            while ($otherItemRow = $otherItemResult->fetch_assoc()) {
                                $otherItemId = $otherItemRow['item_id'];
                                $otherItemId = base64_encode($otherItemId);
                                ?>
                                <a type="button" class="list-group-item"
                                    href="edit-otherItems.php?status=edit-Item&itemId=<?php echo $otherItemId ?>">
                                    <h5>
                                        <?php echo $otherItemRow['item_name']; ?>
                                    </h5>
                                </a>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="col add-items-column d-flex align-items-center justify-content-center">
                <div class="card add-items-card">
                    <div class="card-header addItem-card-header text-center">
                        <H3>Add Food Item</H3>
                    </div>
                    <form id="add-item-form" action="../../../../controller/menu_controller.php?status=add-fooditem"
                        enctype="multipart/form-data" method="post">

                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text placeholdername" id="inputGroup-sizing-default">Food
                                    Item</span>
                            </div>
                            <input type="text" class="form-control" aria-label="Default" aria-describedby="inputGroup"
                                id="food_Name" name="food_Name" required>
                        </div>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text placeholderdescription"
                                    id="inputGroup-sizing-default">Description</span>
                            </div>
                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="1" id="food_descript"
                                name="food_descript"> </textarea>
                        </div>

                        <div class="row align-items-center ">
                            <div class="col">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend input-group-prepend-img ">
                                        <input type="file" class="form-control" aria-label="Default"
                                            aria-describedby="inputGroup" name="food_image" id="food_image">
                                    </div>
                                </div>
                            </div>
                            <div class="col-auto">
                                <img id="imgprev" src="" alt="Image Preview">
                            </div>
                            <div class="row m-0">
                                <select class="forms-select mb-3 mt-3 " id="categories" aria-label="categories"
                                    name="categories" required>
                                    <option disabled selected value="0">Category</option>
                                    <?php
                                    while ($category = $categoryResult->fetch_assoc()) {
                                        echo '<option value=' . $category['category_id'] . '>' . $category['category_name'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="row   justify-content-center align-items-center mt-5">

                                <div class="col-auto">
                                    <button type="button" class="btn btn-outline-secondary"
                                        onclick="switchToAddOtherItemBtn()">Other
                                        Item</button>
                                </div>
                                <div class="col-auto">
                                    <button type="button" class="btn btn-outline-secondary"
                                        onclick="switchToFoodItemBtn()">Food
                                        Item</button>
                                </div>
                                <div class="col-auto buttonDiv">
                                    <button type="submit" class="btn btn-outline-primary additembtn ">
                                        Add Food Item
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
    crossorigin="anonymous"></script>

</html>