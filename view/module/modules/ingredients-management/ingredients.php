<?php
session_start();
include_once '../../../../model/role_model.php';
if (!isset($_SESSION['user']) || !isset($_SESSION['user']['role_id'])) {
    // Redirect to the login page
    header("Location: http://localhost/BcsKSM/view/login/login.php");
    exit(); // Make sure to exit after a header redirect
}

$userRoleID = $_SESSION['user']['role_id'];
    // Redirect to the home page
    switch ($userRoleID) {
        case 4:
            header("Location: http://localhost/BcsKSM/view/users/cashier/cashier.php");
            break;
        }
include_once '../../../../model/ingredients_model.php';
$ingredientObj = new ingredient();
$ingResult = $ingredientObj->getAllingredients();
$ingfactorResult = $ingredientObj->getfactors();

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

<?php
    if (isset($_GET["addmsg"])) {
        $msg = base64_decode($_GET["addmsg"]);
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
    <!--user navigation-->
    <div class="row items-container   common-container m-0">
        <div class="col-md-3 items-column">
            <div class="row items-list-row justify-content-center">
                <div class="row justify-content-center">
                    <div class="row justify-content-center align-items-center searchBarRow">

                        <div class="col-auto">
                            <input class="form-control " type="search" id="seachBar" placeholder="Search"
                                onkeyup="search()" aria-label="Search">
                        </div>
                    </div>
                    <div class="row">
                    <ul class="list-group list-row">
                        <?php
                        while ($ingrow = $ingResult->fetch_assoc()) {
                            $ing_id = $ingrow["ing_id"];
                            $ing_id = base64_encode($ing_id);
                            ?>
                            <a type="button" class="list-group-item"
                                href="edit-ingredients.php?status=edit-ingredient&ingid=<?php echo $ing_id ?>">
                                <h5>
                                    <?php echo $ingrow["ing_name"] ?>
                                </h5>
                            </a>
                        <?php } ?>
                    </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="col edit-items-column d-flex align-items-center justify-content-center ">
            <div class="card edit-items-card">
                <div class="card-header edit-Item-card-header text-center">
                    <H3>Add Ingredient</H3>
                </div>
                <form id="add-ingredients-form"
                    action="../../../../controller/ingredients_controller.php?status=add-ingredient"
                    enctype="multipart/form-data" method="post">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Ingredient Name</span>
                        </div>
                        <input type="text" class="form-control" aria-label="Default" aria-describedby="inputGroup"
                            name="ing_Name">
                    </div>
                    <div class="input-group ">
                        <div class="input-group-prepend">
                            <span class="input-group-text placeholderdescription"
                                id="inputGroup-sizing-default">Description</span>
                        </div>
                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="1"
                            name="ing_descript"></textarea>
                    </div>
                    <div class="row align-items-center justify-content-between ">
                        <div class="col-auto">
                            <div class="input-group-prepend  input-group-prepend-img">
                                <input type="file" class="form-control" aria-label="Default"
                                    aria-describedby="inputGroup" name="ing_image" id="ing_image">
                            </div>
                        </div>
                        <div class="col-auto">
                            <img id="imgprev" src="" alt="Image Preview" >
                        </div>
                        <div class="row m-0">
                            <select class="forms-select mb-3 mt-3" name="factors" id="factors" aria-label="factors" required>
                                <option disabled selected value="">Select</option>
                                <?php
                                while ($factor = $ingfactorResult->fetch_assoc()) {
                                    echo '<option value="' . $factor['factor_id'] . '">' . $factor['factorsf'] . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="row mt-5 justify-content-center ">
                            <div class="col-auto">
                            <button type="submit" class="btn btn-outline-primary">
                        Add
                    </button>
                            </div>
                        </div>
                    
                </form>
            </div>
        </div>
    </div>
    </div>
    </div>

    <script type="text/javascript" src="../../../../commons/clock.js"></script>

    </script>
    <script>
        $(document).ready(() => {
            $("#ing_image").change(function () {
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
</body>
<script type="text/javascript" src="ingredients.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
    crossorigin="anonymous"></script>

</html>