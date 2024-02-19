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
$otheritemResult = $menuObj->getOtherItems();
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
    
    <div class="row Allitems-container justify-content-start m-0">
        <div class="row d-flex searchBarRow justify-content-start p-0">
                    <?php
    if (isset($_GET["msg"])) {
        $msg = base64_decode($_GET["msg"]);
        ?>
        <div class="alert alert-success alert-dismissible fade show " role="alert">
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
    <div class="col-auto">
    <input class="form-control m-2 " type="search" id="seachBar" placeholder="Search" onkeyup="search()"
                    aria-label="Search">
    </div>
        </div>
        <div class="row itemcards justify-content-center">
            <?php
            while ($fooditems = $fooditemResult->fetch_assoc()) {
                $foodid = $fooditems['food_itemId'];
                $foodid = base64_encode($foodid);
                ?>
                <div class="card Allitemscard ">
                    <div class="row card-header allItem-card-header text-center">
                        <h5>
                            <?php echo $fooditems["item_name"] ?>
                        </h5>
                    </div>
                    <div class="card-body m-0">
                        <div class="row">
                            <img class="card-img-top m-0" src="../../../<?php echo $fooditems["img_path"] ?>"
                                alt="Card image cap">
                        </div>
                        <input type="hidden" value="<?php echo $fooditems["food_itemId"] ?>">

                        <div class="row mt-2">
                            <p class="card-title">
                                <?php echo " Price:" . " " . $fooditems["price"] ?>
                            </p>
                            <div class="col-auto">
                                <button type="button" class="btn btn-outline-secondary" data-bs-toggle="popover"
                                    data-bs-placement="bottom" title="Food Description"
                                    data-bs-content="<?php echo isset($fooditems["food_description"]) ? $fooditems["food_description"] : 'No description'; ?>">
                                    Description
                                </button>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="row m-0 mt-4">
                                <button type="button" class="btn btn-outline-primary" id="editremQtybtn"
                                    onclick="setprice('<?php echo $foodid ?>')">
                                    Change price
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            <?php }
            ?>
            <?php
            while ($otheritemsrow = $otheritemResult->fetch_assoc()) {
                $item_id = $otheritemsrow['item_id'];
                $item_id = base64_encode($item_id);
                ?>
                <div class="card Allitemscard ">
                    <div class="row card-header allItem-card-header text-center">
                        <h5>
                            <?php echo $otheritemsrow["item_name"] ?>
                        </h5>
                    </div>
                    <div class="card-body m-0">
                        <div class="row">
                            <img class="card-img-top m-0" src="../../../<?php echo $otheritemsrow["img_path"] ?>"
                                alt="Card image cap">
                        </div>
                        <input type="hidden" value="<?php echo $otheritemsrow["item_id"] ?>">
                        <div class="row mt-2">
                            <p class="card-title">
                                <?php echo " Price:" . " " . $otheritemsrow["price"] ?>
                            </p>
                            <div class="col-auto">
                                <button type="button" class="btn btn-outline-secondary" data-bs-toggle="popover"
                                    data-bs-placement="bottom" title="Item Description" data-bs-trigger="focus"
                                    data-bs-content="<?php echo isset($otheritemsrow["description"]) ? $otheritemsrow["description"] : 'No description'; ?>">
                                    Description
                                </button>
                            </div>
                        </div>
                        <div class="row  mt-2">
                            <div class="row m-0 mt-4">
                                <button type="button" class="btn btn-outline-danger" id="editremQtybtn"
                                    onclick="setItemprice('<?php echo base64_decode($item_id) ?>')">
                                    Change price
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

            <?php }
            ?>
        </div>
    </div>


    <div class="modal fade" id="setpriceModal" tabindex="-1" role="dialog" aria-labelledby="setpriceModal"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"></h5>
                    <button type="button" class="btn-close modalclosetbtn" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <form id="set-price-form" action="../../../../controller/menu_controller.php?status=set-price"
                        enctype="multipart/form-data" method="post">
                        <div class="input-group">
                            <input type="hidden" class="form-control" aria-label="Text input with dropdown button"
                                name="food_id" id="food_id">
                            <input type="number" class="form-control" aria-label="Text input with dropdown button"
                                name="price" id="price" required>

                        </div>
                        <div class="row justify-content-end  m-2">
                    <button type="button" class="btn btn-outline-secondary col-auto m-2" data-bs-dismiss="modal">Close</button>
                    <button type="submit " class="btn btn-outline-primary col-auto m-2">Save changes</button>
                </div>
                        
                    </form>
                    
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="../../../../commons/clock.js"></script>
    <script type="text/javascript" src="pricing.js"></script>
</body>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
    crossorigin="anonymous"></script>


</html>