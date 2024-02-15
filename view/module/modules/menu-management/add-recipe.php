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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>

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
    <div class="d-flex items-container">
        <div class="col-md-3 items-column">
        <div class="row m-0  items-list-row justify-content-center">
                <div class="row m-0 justify-content-center ">
                    <div class="row m-0 justify-content-center align-items-center searchBarRow">

                        <div class="col-auto">
                            <input class="form-control " type="search" id="seachBar" placeholder="Search"
                                onkeyup="search()" aria-label="Search">
                        </div>
                        <div class="col-auto ">
                            <a class="btn  back-btn btn-md" href="recipe.php"><i
                                    class="bi bi-arrow-return-left"></i></a>
                        </div>
                    </div>

                    <div class="row justify-content-center m-0">

                        <div class="col">
                        <ul class="list-group  list-row">
                            <?php
                            while ($foodrow = $fooditemResult->fetch_assoc()) {
                                $foodid = $foodrow['food_itemId'];
                                $foodid = base64_encode($foodid);
                                ?>
                                <a type="button" class="list-group-item" href="add-recipe.php?foodId=<?php echo $foodid ?>">
                                    <h5>
                                        <?php echo $foodrow['item_name']; ?>
                                    </h5>
                                </a>
                            <?php } ?>
                        </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-9  recipecolumn ">
           <div class="col recipeRow ">
           <input type="hidden" class="form-control" aria-label="Default" aria-describedby="inputGroup" id="food_id" name="food_id" value="<?php echo $fooditemrow['food_itemId'] ?>">

<div class="row m-0 ItemNameRow  ">
    <div class="col text-center ItemNameCol">
        <h1><?php echo $fooditemrow['item_name'] ?></h1>
    </div>
    
</div>

<div class="row  selectedIngredientsRow m-0" >
    <?php
    if (isset($_GET['foodId'])) {
        $food_id = $_GET['foodId'];
        ?>
        <div class="col">
            <form id="addrecipe"
                action="../../../../controller/menu_controller.php?status=add-recipie&foodId=<?php echo $food_id ?>"
                enctype="multipart/form-data" method="post" onsubmit="return submitValidation()">
          <div class="col m-0" id="selected-ingredients">
           </div>
                
        </div>
        <div class="col-auto  m-0 img-col ">
            <img id="imgprev" class="FoodImageRecipe" src="<?php echo "../../../" . $fooditemrow["img_path"] ?>" alt="Image Preview">
        </div>
    <?php } ?>
    <div class="row justify-content-center mt-3 mb-2">
                    <button id="addrecipiebtn" type="" class="btn btn-outline-primary col-auto" >
                        Update
                    </button>
                </div>
            </form>
</div>

<div class="row m-0 ing-list">
    <div class="row ">
        <div class="row">
            <h3>Ingredients</h3>
        </div>
        <!-- List of all available ingredients -->
        <div class="row ingListRow ">
        <?php
        $selected_ingredients = array();
        $selected_quantities = array();
        $selected_factor = array();

        // Loop through the selected ingredients to store them in an array
        while ($reciperow = $recipeResult->fetch_assoc()) {
            $selected_ingredients[] = $reciperow['ing_id'];
            $selected_quantitiesg[$reciperow['ing_id']] = $reciperow['qty_required(g)']; // Store quantity by ingredient ID
            $selected_quantitiesml[$reciperow['ing_id']] = $reciperow['qty_required(ml)'];
            $selected_factor[$reciperow['ing_id']] = $reciperow['factor'];
        }

        // Reset the result set pointer for the ingredient loop
        $ingResult->data_seek(0);

        while ($ingrow = $ingResult->fetch_assoc()) {
            $ing_id = $ingrow['ing_id'];
            ?>

            <div class="col-auto form-check form-switch form-check-inline ml-1" id="checkitem">
                <input type="hidden" value="<?php echo $ing_id; ?>" id="ing_id" name="ing_id[]">
                <div class="row">
                    <div class="col-auto">
                    <input class="form-check-input specific-checkbox " type="checkbox" value="<?php echo $ing_id; ?> "
                               onclick="addIngredientsToRecipe(this)" name="ingidcheck" id="selectedIngs" <?php echo in_array($ing_id, $selected_ingredients) ? 'checked' : ''; ?>>

                    </div>
                    <div class="col-auto">
                        <h5>
                            <?php echo $ingrow['ing_name']; ?>
                        </h5>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <input class="form-control qtyrequired" type="hidden" value="<?php
                        $quantity = '';
                        if (isset($selected_factor[$ing_id]) && ($selected_factor[$ing_id] == '8' || $selected_factor[$ing_id] == '9')) {
                            $quantity = $selected_quantitiesml[$ing_id] ?? '';
                            if ($selected_factor[$ing_id] == '9') {
                                $quantity = $quantity / 1000;
                            }
                        } elseif (isset($selected_factor[$ing_id]) && $selected_factor[$ing_id] == '1') {
                            $quantity = $selected_quantitiesg[$ing_id] ?? '';
                            //display grams
                        } elseif (isset($selected_factor[$ing_id]) && $selected_factor[$ing_id] == '2') {
                            $quantity = $selected_quantitiesg[$ing_id] ?? '';
                            $quantity = number_format($quantity / 1000, 3); // Convert grams to kilograms
                        } elseif (isset($selected_factor[$ing_id]) && $selected_factor[$ing_id] == '3') {
                            $quantity = $selected_quantitiesg[$ing_id] ?? '';
                            $quantity = $quantity / 250; // Convert g to c
                        } elseif (isset($selected_factor[$ing_id]) && $selected_factor[$ing_id] == '4') {
                            $quantity = $selected_quantitiesg[$ing_id] ?? '';
                            $quantity = number_format($quantity / 14.175, 2); // Convert g to tbsp
                        } elseif (isset($selected_factor[$ing_id]) && $selected_factor[$ing_id] == '5') {
                            $quantity = $selected_quantitiesg[$ing_id] ?? '';
                            $quantity = number_format($quantity / 5.69, 2); // Convert g to tsp
                        } elseif (isset($selected_factor[$ing_id]) && $selected_factor[$ing_id] == '6') {
                            $quantity = $selected_quantitiesg[$ing_id] ?? '';
                            $quantity = number_format($quantity / 28.3495, 2); // Convert g to oz
                        } elseif (isset($selected_factor[$ing_id]) && $selected_factor[$ing_id] == '7') {
                            $quantity = $selected_quantitiesg[$ing_id] ?? '';
                            $quantity = number_format($quantity / 453.592, 2); // Convert g to lb
                        } elseif (isset($selected_factor[$ing_id]) && $selected_factor[$ing_id] == '8') {
                            $quantity = $selected_quantitiesml[$ing_id] ?? '';
                            // display ml
                        } elseif (isset($selected_factor[$ing_id]) && $selected_factor[$ing_id] == '9') {
                            $quantity = $selected_quantitiesml[$ing_id] ?? '';
                            $quantity = number_format($quantity / 1000, 2); // Convert ml to l
                        }

                        echo $quantity;
                        ?>" id="qtyrequired_<?php echo $ing_id; ?>" name="qtyrequired[]" class="qtyrequired" required>
                    </div>

                    <div class="col-auto">

                        <select class="form-select col-auto text-center" style="display: none;" id="factorSelect" name="factor[]">
                            <?php
                            $options = array(
                                '1' => 'g',
                                '2' => 'kg',
                                '3' => 'c',
                                '4' => 'tbsp',
                                '5' => 'tsp',
                                '6' => 'oz',
                                '7' => 'lb',
                                '8' => 'ml',
                                '9' => 'l'
                            );

                            foreach ($options as $value => $text) {
                                $selected = ($selected_factor[$ing_id] == $value) ? 'selected' : '';
                                echo "<option value='{$value}' {$selected}>{$text}</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>

            </div>

            <?php
        }
        ?>

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
                    <button type="button" class="btn-close modalclosetbtn" data-bs-dismiss="modal" aria-label="Close">
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

    <div class="modal" id="removeIngredientModal" tabindex="-1" role="dialog" data-bs-keyboard="false"
        data-bs-backdrop="static">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Modal title</h5>
                    <button type="button" class="btn-close modalclosetbtn" data-dismiss="modal" aria-label="Close"
                        onclick=" closeRemoveIngmodal(this)">
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="ingId">
                    <p>Confirming this will remove the ingredient</p>
                </div>
                <div class="modal-footer">
                    <button id="removeIngBtn" onclick=" removeingHandler()" type="button"
                        class="btn btn-danger">Remove</button>
                    <button type="button" onclick=" closeRemoveIngmodal()" class="btn btn-secondary"
                        data-dismiss="modal">Close</button>
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