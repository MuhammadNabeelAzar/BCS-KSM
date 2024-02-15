<?php
session_start();
include_once '../../../../model/role_model.php';
if (!isset($_SESSION['user']) || !isset($_SESSION['user']['role_id'])) {
    // Redirect to the login page
    header("Location: http://localhost/BcsKSM/view/login/login.php");
    exit(); // Make sure to exit after a header redirect
}

$userRoleID = $_SESSION['user']['role_id'];
include_once '../../../../model/ingredients_model.php';
$ingredientObj = new ingredient();
$ingResult = $ingredientObj->getAllingredients();

$ingg_id = base64_decode($_GET['ingid']);
$ingredientResult = $ingredientObj->getaspecificIngredient($ingg_id);
$ingredientrow = $ingredientResult->fetch_assoc();
$ingfactorResult = $ingredientObj->getfactors();
?>
<html>

<head>
    <title>Restaurant Management System</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
    if (isset($_GET["msg"])) {
        $msg = base64_decode($_GET["msg"]);
        ?>
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <p>
            <div class="row">
                <p>
                    <?php echo $msg; ?>
                </p>
            </div>

            </p>
            <button type="button" class="close" data-bs-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <?php
    }
    ?>
    <!--user navigation-->
    <div class="row items-container  common-container m-0">
        <div class="col-md-3 items-column">
            <div class="row items-list-row justify-content-center">
                <div class="row justify-content-center">
                    <div class="row justify-content-center align-items-center searchBarRow">

                        <div class="col-auto">
                            <input class="form-control " type="search" id="seachBar" placeholder="Search"
                                onkeyup="search()" aria-label="Search">
                        </div>
                        <div class="col-auto ">
                            <a class="btn  back-btn btn-md" href="ingredients.php"><i
                                    class="bi bi-arrow-return-left"></i></a>
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
            <div class="card edit-items-card ">
                <div class="card-header edit-Item-card-header text-center">
                    <H3>Edit Ingredient</H3>
                </div>
                <form id="edit-ingredients-form"
                    action="../../../../controller/ingredients_controller.php?status=edit-ingredient"
                    enctype="multipart/form-data" method="post">
                    <input type="hidden" name="ing_id" value="<?php echo isset($ingg_id) ? $ingg_id : ''; ?>" />

                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Ingredient Name</span>
                        </div>
                        <input type="text" class="form-control" aria-label="Default" aria-describedby="inputGroup"
                            name="ing_Name"
                            value="<?php echo isset($ingredientrow["ing_name"]) ? $ingredientrow["ing_name"] : ''; ?>">
                    </div>

                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text placeholderdescription"
                                id="inputGroup-sizing-default">Description</span>
                        </div>
                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="1"
                            name="ing_descript"><?php echo isset($ingredientrow["ing_description"]) ? $ingredientrow["ing_description"] : ''; ?></textarea>
                    </div>

                    <div class="row align-items-center justify-content-between">
                        <div class="col-auto">
                            <div class="input-group-prepend input-group-prepend-img">
                                <input type="file" class="form-control" aria-label="Default"
                                    aria-describedby="inputGroup" name="ing_image" onchange="readUrl(this);" value="">
                            </div>
                        </div>
                        <div class="col-auto">
                            <img id="imgprev"
                                src="<?php echo isset($ingredientrow["img_path"]) ? "../../../" . $ingredientrow["img_path"] : ''; ?>"
                                alt="Uploaded Image">
                        </div>
                        <div class="row m-0">
                            <select class="forms-select mb-3 mt-3" id="factors" aria-label="factors" name="factors"
                                required>
                                <option value="">----</option>
                                <?php
                                while ($factorrow = $ingfactorResult->fetch_assoc()) {
                                    ?>
                                    <option name="factor_selected" value="<?php echo $factorrow["factor_id"]; ?>" <?php echo (isset($ingredientrow["factor_id"]) && $ingredientrow["factor_id"] == $factorrow["factor_id"]) ? 'selected="selected"' : ''; ?>>
                                        <?php echo isset($factorrow["factorsf"]) ? $factorrow["factorsf"] : ''; ?>
                                    </option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                    <div class="col-auto ">
                            <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal"
                                data-bs-target="#removeIngredientModal">
                                Remove Ingredient
                            </button>
                        </div>
                        <div class="col-auto">
                            <button id="updateIng" type="submit" class="btn btn-outline-primary">
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
    <div class="modal fade" id="removeIngredientModal" tabindex="-1" role="dialog"
        aria-labelledby="RemoveingredientmodalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="removeingtitle">Remove Ingredient</h5>
                    <button type="button" class="btn-close modalclosetbtn" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure you want to remove this ingredient ?
                </div>
                <div class="row mt-3 justify-content-end">
                   <div class="col-auto">
                   <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                   </div>
                    <div class="col-auto">
                    <a type="button" class="btn btn-outline-primary"
                        href="../../../../controller/ingredients_controller.php?status=remove-ingredient&ingid=<?php echo $ing_id ?>">Remove
                        ingredient</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="../../../../commons/clock.js">
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

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
    <script type="text/javascript" src="edit-ingredient.js"></script>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
    crossorigin="anonymous"></script>

</html>