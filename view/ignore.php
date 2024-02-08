var requiredqty = document.createElement('input');
requiredqty.setAttribute('type', 'number');
requiredqty.setAttribute('placeholder', 'required quantity');
requiredqty.setAttribute('name', 'required_quantity[]');
requiredqty.setAttribute('id', 'required_quantity');
requiredqty.required = true;


var factor = document.createElement('select');
factor.setAttribute('name', 'factor[]');

var g = document.createElement('option');
g.value = '1';
g.text = 'g';
factor.appendChild(g);
var kg = document.createElement('option');
kg.value = '2';
kg.text = 'kg';
factor.appendChild(kg);
var c = document.createElement('option');
c.value = '3';
c.text = 'c';
factor.appendChild(c);
var tbsp = document.createElement('option');
tbsp.value = '4';
tbsp.text = 'tbsp';
factor.appendChild(tbsp);
var tsp = document.createElement('option');
tsp.value = '5';
tsp.text = 'tsp';
factor.appendChild(tsp);
var oz = document.createElement('option');
oz.value = '6';
oz.text = 'oz';
factor.appendChild(oz);
var lb = document.createElement('option');
lb.value = '7';
lb.text = 'lb';
factor.appendChild(lb);
var ml = document.createElement('option');
ml.value = '8';
ml.text = 'ml';
factor.appendChild(ml);
var l = document.createElement('option');
l.value = '9';
l.text = 'l';
factor.appendChild(l);




BEGIN

IF NEW.factor = '8' THEN
SET NEW.`qty_required(ml)` = NEW.`qty_required(g)`;
END IF;
IF NEW.factor = '9' THEN
SET NEW.`qty_required(ml)` = NEW.`qty_required(g)` / 1000;
END IF;
END

BEGIN
IF NEW.factor = '1' THEN
SET NEW.`qty_required(g)` = NEW.`qty_required(g)`;
END IF;

IF NEW.factor = '2' THEN
SET NEW.`qty_required(g)` = NEW.`qty_required(g)` * 1000;
END IF;
IF NEW.factor = '3' THEN
SET NEW.`qty_required(g)` = NEW.`qty_required(g)` * 250;
END IF;
IF NEW.factor = '4' THEN
SET NEW.`qty_required(g)` = NEW.`qty_required(g)` * 14.175;
END IF;
IF NEW.factor = '5' THEN
SET NEW.`qty_required(g)` = NEW.`qty_required(g)` * 5.69;
END IF;
IF NEW.factor = '6' THEN
SET NEW.`qty_required(g)` = NEW.`qty_required(g)` * 28.3495;
END IF;
IF NEW.factor = '7' THEN
SET NEW.`qty_required(g)` = NEW.`qty_required(g)` * 453.592;
END IF;
IF NEW.factor = '8' THEN
SET NEW.`qty_required(ml)` = NEW.`qty_required(g)`;
END IF;
IF NEW.factor = '9' THEN
SET NEW.`qty_required(ml)` = NEW.`qty_required(g)` * 1000 ;
END IF;

END


function increaseDecreasefooditemqty(button) {
var card = button.parentElement.parentElement.parentElement; // Go up three levels to the main container
var qtyInput = card.querySelector('.qty-box');
var qty = parseInt(qtyInput.value) || 0;

if (button.classList.contains('add-btn')) {
qty += 1;
} else if (button.classList.contains('subtract-btn')) {
qty = Math.max(0, qty - 1);
}

qtyInput.value = qty;
}
function increaseDecreasefooditemqtymanually(value) {
var inputvalue = value;
console.log(inputvalue);
var card = document.activeElement.closest('.card'); // Go up three levels to the main container
console.log(card);
var clonedcard = card.cloneNode(true);
var itemsContainer = document.getElementById('fooditems');


}

function addFooditemtoCart(){

}


var Ordercard = $(
' <div class="card col-md-2">'+
    '<input type="hidden" id="order-id" value="' + orderId + '">'+
    '<div class="row">
        <h5>'+'Order Id :'+orderId+'</h5>
    </div>'+
    ' <div class="row fooditemDetails">'+
        '</div>
</div>'
);
var fooditemsDetailsRow = $('.fooditemDetails');
ordersRow.append(Ordercard);

// for (var i = 0 ; i < fooditemRowArray.length; i++){ // fooditemRow=fooditemRowArray[i];
    fooditemsDetailsRow.append(fooditemRowArray); // } console.log(); console.log("orders",order); <div class="row">
    function increaseCounter(button,available_quantity) {
  var inputElement = button.parentNode.previousElementSibling;

  var food_id_inCart = $(button)
    .closest(".fooditemRow")
    .find(".food_ids")
    .val();
  var foodcard = $('.card:has(.food_ids[value="' + food_id_inCart + '"])');
  var maxItemQty = $(foodcard).find(".availableQty").text();
  maxItemQty = parseInt(maxItemQty.replace(/\D/g, ""));
  console.log(maxItemQty)
  // Check if the item is not in the food category
  if (!foodcard.length) {
    var maxItemQty = available_quantity;
  }

  maxItemQty = parseInt(maxItemQty);
  console.log(maxItemQty);

  x = parseInt($(inputElement).val());
  if (x < maxItemQty) {
    x++;
    $(inputElement).val(x);
    console.log(x);
    AddTotal(button);
  }
  calculateDiscountOnquantityChange();
}




public function getSalesDetails($sale_id)
  {
    $con = $GLOBALS["con"];
    $result = array();
    $customerDetailsQuery = "SELECT * FROM customer WHERE customer_id = (
      SELECT customer_id
      FROM quick_sales
      WHERE sales_id = $sale_id
  )";

      $customerResult = $con->query($customerDetailsQuery) or die($con->error);
      $result['customerDetails'] = $customerResult->fetch_assoc();

    $foodItemsQuery = "SELECT  quick_sales.*, sales_items.*,food_items.item_name
        FROM quick_sales
        JOIN sales_items ON quick_sales.sales_id = sales_items.sales_id
         JOIN food_items ON sales_items.food_itemId = food_items.food_itemId
         WHERE quick_sales.sales_id = '$sale_id'AND sales_items.food_itemId IS NOT NULL ";
$foodItemsResult = $con->query($foodItemsQuery) or die($con->error);
$result['foodItems'] = $foodItemsResult->fetch_all(MYSQLI_ASSOC);

    $OtherItemsQuery = "SELECT  quick_sales.*, sales_items.*,other_items.item_name
        FROM quick_sales
        JOIN sales_items ON quick_sales.sales_id = sales_items.sales_id
         JOIN other_items ON sales_items.item_id = other_items.item_id
         WHERE quick_sales.sales_id = '$sale_id' AND sales_items.item_id IS NOT NULL";
    $otherItemsResult = $con->query($OtherItemsQuery) or die($con->error);
    $result['otherItems'] = $otherItemsResult->fetch_all(MYSQLI_ASSOC);

    
    return $result;
  }

  function displayReceiptDetails(response) {

var sum = 0;
var itemArray = [];
  for (var i = 0; i < response.length; i++) {
    var innerArray = response[i];
    var customerId = innerArray.customer_id;
    var customerEmail = innerArray.customer_email;
    var customerNo = innerArray.contact_number;
    var customerName = innerArray.customer_fname + " " + innerArray.customer_lname;
    var date = innerArray.date;
    var time = innerArray.time;
    var discount = innerArray.discount;
    var quantity = innerArray.qty;
    var unitPrice = innerArray.unit_price;
    var itemName = innerArray.item_name;
    var totalperitem = parseInt(innerArray.total);
    sum += totalperitem;
    // Append other details as needed
    var itemRow = '<div class="row itemRow"><h6 class="col items">'+itemName+'</h6>'+
    '<h6 class="col qty">'+quantity+'</h6>'+
    '<h6 class="col unitprice">'+unitPrice+'</h6></div>';
    itemArray.push(itemRow);
  }
  console.log("itemarray",itemArray);
}


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
    session_start();
include_once '../../../../model/role_model.php';
$userRoleID = isset($_SESSION['user']['role_id']) ? $_SESSION['user']['role_id'] : null;




<div class="row  items-container m-0">
        <div class="col-md-3 items-column">
            
        </div>
        <div class="col m-0 recipecolumn">
            <input type="hidden" class="form-control" aria-label="Default" aria-describedby="inputGroup" id="food_id"
                name="food_id" value="<?php echo $fooditemrow['food_itemId'] ?>">
            <div class="row  ItemNameRow justify-content-center">
                <div class="col text-center ItemNameCol">
                    <h1>
                        <?php echo $fooditemrow['item_name'] ?>
                    </h1>
                </div>
            </div>

            <div class="row selectedIngredientsRow">
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
                            <div class="row SubmitRecipebtnRow justify-content-center">
                                <button id="addrecipiebtn" type="" class="btn btn-outline-primary col-auto" >
                                    update
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="col-auto m-0 img-col">
                        <img id="imgprev" src="<?php echo "../../../" . $fooditemrow["img_path"] ?>" alt="Image Preview">
                    </div>
                <?php } ?>
            </div>

            <div class="row bg-light ing-list">
                <div class="row">
                    <h3>Ingredients</h3>
                </div>
                <!--List of all available ingredients-->

                <div class="row">
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
                                    <input class="form-control qtyrequired" type="text" value="<?php
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

                                    <select class="form-select col-auto" id="factorSelect" name="factor[]">
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