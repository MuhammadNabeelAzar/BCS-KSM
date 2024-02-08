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

    <div class="row items-container">
        <div class="col-md-3 items-column">
            <div class="row items-list-row justify-content-center">
                <div class="row justify-content-center">
                    <div class="row justify-content-center align-items-center searchBarRow">
                        <div class="col-auto">
                            <input class="form-control " type="search" id="seachBar" placeholder="Search"
                                onkeyup="search()" aria-label="Search">
                        </div>
                    </div>

                        <ul class="list-group items-list list-row">
                            <?php
                            while ($foodrow = $fooditemResult->fetch_assoc()) {
                                $foodid = $foodrow['food_itemId'];
                                $foodid = base64_encode($foodid);
                                ?>
                                <a type="button" class="list-group-item"
                                    href="add-recipe.php?foodId=<?php echo $foodid ?>">
                                    <h5><?php echo $foodrow['item_name']; ?></h5>
                            </a>
                            <?php } ?>
                        </ul>
                    </div>
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