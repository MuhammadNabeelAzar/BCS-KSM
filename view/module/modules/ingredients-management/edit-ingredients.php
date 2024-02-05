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
    <a class="btn btn-primary" data-bs-toggle="offcanvas" href="#offcanvasExample" role="button"
        aria-controls="offcanvasExample">
        <i class="bi bi-list"></i>
    </a>
    <a class="btn btn-primary" href="ingredients.php">Back</a>
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
    <div class="row">
        <div class="col-md-3" style="background-color:black">
            <div class="accordion">
                <div class="row">
                    <input class="form-control " id="seachBar" type="search" placeholder="Search" aria-label="Search"
                        onkeyup="search()">
                    <button class="btn btn-outline-success " type="submit">Search</button>
                    <ul class="list-group">
                        <?php
                        while ($ingrow = $ingResult->fetch_assoc()) {
                            $ing_id = $ingrow["ing_id"];
                            $ing_id = base64_encode($ing_id);
                            ?>
                            <a type="button" class="list-group-item"
                                href="edit-ingredients.php?ingid=<?php echo $ing_id ?>">
                                <p>
                                    <?php echo $ingrow["ing_name"] ?>
                                </p>
                            </a>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col" style="background-color:blue">
            <div class="row">
                <form action="../../../../controller/ingredients_controller.php?status=edit-ingredient"
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
                        <label for="exampleFormControlTextarea1">Description</label>
                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"
                            name="ing_descript"><?php echo isset($ingredientrow["ing_description"]) ? $ingredientrow["ing_description"] : ''; ?></textarea>
                    </div>

                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <input type="file" class="form-control" aria-label="Default" aria-describedby="inputGroup"
                                name="ing_image" onchange="readUrl(this);" value="">
                        </div>

                        <select class="forms-select mb-3" id="factors" aria-label="factors" name="factors" required>
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

                        <div class="col-md-3">
                            <img id="imgprev"
                                src="<?php echo isset($ingredientrow["img_path"]) ? "../../../" . $ingredientrow["img_path"] : ''; ?>"
                                alt="Uploaded Image" width="60px" height="60px">
                        </div>
                    </div>

                    <button id="updateIng" type="submit" class="btn btn-primary">
                        Add
                    </button>

                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#removeIngredientModal">
                        Remove Ingredient
                    </button>
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
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure you want to remove this ingredient ?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <a type="button" class="btn btn-primary"
                        href="../../../../controller/ingredients_controller.php?status=remove-ingredient&ingid=<?php echo $ing_id ?>">Remove
                        ingredient</a>
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