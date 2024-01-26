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