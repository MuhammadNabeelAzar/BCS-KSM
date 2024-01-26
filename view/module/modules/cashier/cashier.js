function filteritems(category_id) {
  //get the category ID
  const category_Id = category_id;

  //empty the container
  $("#fooditems-container").empty();

  //get category other items
  $.ajax({
    type: "POST",
    url: "../../../../controller/menu_controller.php?status=get-Items",
    data: { category: category_Id },
    dataType: "JSON",
    success: function (response) {
      // get the container for the cards
      var container = $("#fooditems-container");

      //loop thorugh the items and create cards

      for (var i = 0; i < response.length; i++) {
        var item = response[i];

        // Create a card element
        var card = $(
          '<div class="card " style="width: 15rem; margin: 2px;"></div>'
        );

        // Append card content while creating the content
        card.append(
          '<div class="card row">' +
            '<img  src="' +
            "../../../" +
            item.img_path +
            '" alt="Item Image" style="height:100px;>' +
            "</div>" +
            '<div class="card-body">' +
            '<input class="item_ids" type="hidden" id="itemId" value="' +
            item.item_id +
            '">' +
            '<h6 class="card-title">' +
            item.item_name +
            "</h6>" +
            "<p>" +
            item.description +
            "</p>" +
            "<div class='row'>" +
            "<div class='col'>" +
            "<p>Rs." +
            item.price +
            "</p>" +
            "</div>" +
            "<div class='col availableQty'>Available:" +
            item.available_quantity +
            "</div>" +
            "</div>" +
            (item.available_quantity >= "1"
              ? '<button class="btn btn-primary" onclick="additemtoCart(' +
                item.item_id +
                ')" >Add to Cart</button>'
              : '<button class="btn btn-danger">Unavailable</button>') +
            "</div>"
        );

        // Append the card to the container
        container.append(card);
      }
    },
  });

  //get category food items
  $.ajax({
    type: "POST",
    url: "../../../../controller/menu_controller.php?status=get-fooditems",
    data: { category: category_Id },
    dataType: "json",
    success: function (response) {
      //get the container ID
      var container = $("#fooditems-container");

      //loop through the response and create fooditem cards
      for (var i = 0; i < response.length; i++) {
        var item = response[i];

        // Create a card element
        var card = $(
          '<div class="card " style="width: 15rem; margin: 2px;"></div>'
        );

        // Append card content while creating the content
        card.append(
          '<div class="card row">' +
            '<img  src="' +
            "../../../" +
            item.img_path +
            '" alt="Item Image" style="height:100px;>' +
            "</div>" +
            '<div class="card-body">' +
            '<input class="food_ids" type="hidden" id="fooditemId" value="' +
            item.food_itemId +
            '">' +
            '<h6 class="card-title">' +
            item.item_name +
            "</h6>" +
            "<p>" +
            item.food_description +
            "</p>" +
            "<div class='row'>" +
            "<div class='col'>" +
            "<p>Rs." +
            item.price +
            "</p>" +
            "</div>" +
            "<div class='col availableQty'></div>" +
            "</div>" +
            (item.availability === "1"
              ? '<button class="btn btn-primary" onclick="addfooditemtoCart(' +
                item.food_itemId +
                ')" >Add to Cart</button>'
              : '<button class="btn btn-danger">Unavailable</button>') +
            "</div>"
        );

        var fooditem_id = item.food_itemId;

        //send the fooditem ID and the card element to get the available item quantity based on the remaining ingredients
        getavailableitemqty(fooditem_id, card);

        // Append the card to the container
        container.append(card);
      }
    },
  });
}

function showallItems() {
  //empty the container
  $("#fooditems-container").empty();
  //get all fooditems
  $.ajax({
    type: "POST",
    url: "../../../../controller/menu_controller.php?status=get-all-fooditems",
    dataType: "json",
    success: function (response) {
      // Get the container
      const container = $("#fooditems-container");

      for (var i = 0; i < response.length; i++) {
        var item = response[i];

        // Create a card element
        var card = $(
          '<div class="card " style="width: 15rem; margin: 2px;"></div>'
        );
        // Append card content while creating the content
        card.append(
          '<div class="card row">' +
            '<img  src="' +
            "../../../" +
            item.img_path +
            '" alt="Item Image" style="height:100px;>' +
            "</div>" +
            '<div class="card-body">' +
            '<input class="food_ids" type="hidden" id="fooditemId" value="' +
            item.food_itemId +
            '">' +
            '<h6 class="card-title">' +
            item.item_name +
            "</h6>" +
            "<p>" +
            item.food_description +
            "</p>" +
            "<div class='row'>" +
            "<div class='col'>" +
            "<p>Rs." +
            item.price +
            "</p>" +
            "</div>" +
            "<div class='col availableQty'></div>" +
            "</div>" +
            (item.availability === "1" &&
            item.tmp_deactivate_availability === "0"
              ? '<button class="btn btn-primary" onclick="addfooditemtoCart(' +
                item.food_itemId +
                ');" >Add to Cart</button>'
              : '<button class="btn btn-danger">Unavailable</button>') +
            "</div>"
        );
        var fooditem_id = item.food_itemId;
        //send the fooditem ID and the card element to get the available item quantity based on the remaining ingredients
        getavailableitemqty(fooditem_id, card);

        // Append the card to the container
        container.append(card);
      }
    },
  });
  $.ajax({
    type: "POST",
    url: "../../../../controller/menu_controller.php?status=get-all-items",
    dataType: "text",
    success: function (response) {
      // Get the container
      const container = $("#fooditems-container");

      for (var i = 0; i < response.length; i++) {
        var item = response[i];

        // Create a card element
        var card = $(
          '<div class="card " style="width: 15rem; margin: 2px;"></div>'
        );

        // Append card content while creating the content
        card.append(
          '<div class="card row">' +
            '<img  src="' +
            "../../../" +
            item.img_path +
            '" alt="Item Image" style="height:100px;>' +
            "</div>" +
            '<div class="card-body">' +
            '<input class="food_ids" type="hidden" id="fooditemId" value="' +
            item.item_id +
            '">' +
            '<h6 class="card-title">' +
            item.item_name +
            "</h6>" +
            "<p>" +
            item.description +
            "</p>" +
            "<div class='row'>" +
            "<div class='col'>" +
            "<p>Rs." +
            item.price +
            "</p>" +
            "</div>" +
            "<div class='col availableQty'>Available:" +
            item.available_quantity +
            "</div>" +
            "<div class='col availableQty'></div>" +
            "</div>" +
            (item.available_quantity > "0" &&
            item.tmp_deactivate_availability === "0"
              ? '<button class="btn btn-primary" onclick="additemtoCart(' +
                item.item_id +
                ');" >Add to Cart</button>'
              : '<button class="btn btn-danger">Unavailable</button>') +
            "</div>"
        );
        // Append the card to the container
        container.append(card);
      }
    },
  });
}

function additemtoCart(itemId) {
  //send an ajax request to get item details to add the item to the cart
  $.ajax({
    type: "POST",
    url: "../../../../controller/menu_controller.php?status=get-Item-details",
    data: { itemId: itemId },
    dataType: "JSON",
    success: function (response) {
      //get the container
      const fooditemContainer = $("#fooditemslistcontainer");

      //check if the same item exists in the cart with the name
      const existingfoodItemsinCart = checkItemsExistence(response.item_name);

      // if the same item is present then disable add and if its not present then add to cart
      if (!existingfoodItemsinCart) {
        fooditemContainer.append(
          ' <div class="row fooditemRow commonrow itemRow" > ' +
            ' <div class="col ml-auto"> ' +
            '<button type="button" class="bi bi-trash  btn-sm" onclick="removeItem(this)"></button>' +
            " </div> " +
            '<input class="food_ids" type="hidden" id="itemId" value="' +
            response.item_id +
            '">' +
            '<h6 class="food_item_name">' +
            response.item_name +
            "</h6>" +
            ' <div class="row"> ' +
            ' <div class="col"> ' +
            '<p class="pricePeritem">' +
            "Rs." +
            response.price +
            "</p>" +
            " </div> " +
            ' <div class="col"> ' +
            '<div class="input-group"> ' +
            ' <div class="col"> ' +
            '<button type="button" class="btn bi-file-minus btn-secondary btn-sm" onclick="decreaseCounter(this)" ></button>' +
            " </div> " +
            '<input style="width:10px;" class="col foodItemqty" type="number"  id="inputQuantitySelectorSm"  value="0" min="0" readonly>' +
            ' <div class="col"> ' +
            '<button type="button" class="btn bi-plus btn-secondary btn-sm" onclick="increaseitemCounter(this,' +
            response.available_quantity +
            ')"></button>' +
            " </div> " +
            "</div>" +
            " </div> " +
            "</div>" +
            "</div>"
        );
      }
    },
  });
}
function addfooditemtoCart(foodId) {

// add the fooditem to the cart
  $.ajax({
    type: "POST",
    url: "../../../../controller/menu_controller.php?status=get-fooditem-details",
    data: { food_id: foodId },
    dataType: "JSON",
    success: function (response) {
    
      const fooditemContainer = $("#fooditemslistcontainer");
        //check if the same item exists in the cart with the name
      const existingfoodItemsinCart = checkItemsExistence(response.item_name);

       // if the same fooditem is present then disable add and if its not present then add to cart
      if (!existingfoodItemsinCart) {
        fooditemContainer.append(
          ' <div class="row fooditemRow commonrow foodRow" > ' +
            ' <div class="col ml-auto"> ' +
            '<button type="button" class="bi bi-trash  btn-sm" onclick="removeItem(this)"></button>' +
            " </div> " +
            '<input class="food_ids" type="hidden" id="fooditemId" value="' +
            response.food_itemId +
            '">' +
            '<h6 class="food_item_name">' +
            response.item_name +
            "</h6>" +
            ' <div class="row"> ' +
            ' <div class="col"> ' +
            '<p class="pricePeritem">' +
            "Rs." +
            response.price +
            "</p>" +
            " </div> " +
            ' <div class="col"> ' +
            '<div class="input-group"> ' +
            ' <div class="col"> ' +
            '<button type="button" class="btn bi-file-minus btn-secondary btn-sm" onclick="decreaseCounter(this)" ></button>' +
            " </div> " +
            '<input style="width:10px;" class="col foodItemqty" type="number"  id="inputQuantitySelectorSm"  value="0" min="0" readonly>' +
            ' <div class="col"> ' +
            '<button type="button" class="btn bi-plus btn-secondary btn-sm" onclick="increasefooditemCounter(this,' +
            response.food_itemId +
            ')"></button>' +
            " </div> " +
            "</div>" +
            " </div> " +
            "</div>" +
            "</div>"
        );
      }
    },
  });
}

function checkItemsExistence(itemName) {

  //the function to check if the items exist in the cart
  var fooditemNamesinCart = $(".food_item_name");

//loop through the items in the cart and check if the item is available 
  for (var i = 0; i < fooditemNamesinCart.length; i++) {
    var currentName = $(fooditemNamesinCart[i]).text();

    if (currentName === itemName) {
      return true; //return true if its available else return false
    }
  }
  return false;
}

function increaseitemCounter(button, available_quantity) {
  // this function will be called when we click on the plus button of an item
  //get the  existing value of the quantity in the counter
  const inputElement = button.parentNode.previousElementSibling;


  // initialize the maximum qty that can be sold depending on the available quantity
  var maxItemQty = available_quantity;
  maxItemQty = parseInt(maxItemQty);

//limit the quantity counter to the available
  x = parseInt($(inputElement).val());
  if (x < maxItemQty) {
    x++;
    $(inputElement).val(x);

    AddTotal(button);
  }
  calculateDiscountOnquantityChange();
}
function increasefooditemCounter(button, fooditem_id) {
  var inputElement = button.parentNode.previousElementSibling;

  //get the recipe to calculate maximum no of fooditems that could be prepared 
  $.ajax({
    type: "POST",
    url: "../../../../controller/menu_controller.php?status=get-Recipe-To-Calculate-Available-Qty",
    data: { food_id: fooditem_id },
    dataType: "JSON",
    success: function (response) {
      // create an array to store all the maximum divisions of the required ingredients quantities and remianing ingredients quantites
      var itemavailableqty = [];

      for (var i = 0; i < response.length; i++) {
     
        const requiredqtyfactor = response[i].factor;
        const requiredqtyG = response[i]["qty_required(g)"];
        const requiredqtyML = response[i]["qty_required(ml)"];
        const remainingqtyG = response[i]["remaining_qty(g)"];
        const remainingqtyML = response[i]["remaining_qty(ml)"];

        //check if the ingredient is solid or liquid and calulate with grams or ml  
        if (requiredqtyfactor <= 7) {
          itemavailableqty.push(Math.floor(remainingqtyG / requiredqtyG));
        } else {
          itemavailableqty.push(Math.floor(remainingqtyML / requiredqtyML));
        }
      }
//get the maximum no of food items that could be prepared by getting the lowest no in the array to decided the maximum no of items that could be prepared
      var maxItemQty = Math.min.apply(Math, itemavailableqty);
      maxItemQty = parseInt(maxItemQty);
      x = parseInt($(inputElement).val());
      if (x < maxItemQty) {
        x++;
        $(inputElement).val(x);
        AddTotal(button);
      }
    },
  });
  calculateDiscountOnquantityChange();
}

function decreaseCounter(button) {
  // this function reduces the quantity value 
  var inputElement = button.parentNode.nextElementSibling;
  x = parseInt($(inputElement).val());
  if (x > 0) {
    x--;
    SubtractTotal(button);
  }
  $(inputElement).val(x);
  calculateDiscountOnquantityChange();
}


function removeItem(deletebtn) {
  // remove item from the cart
  const fooditemRowtodelete = $(deletebtn).closest(".fooditemRow");
  if (fooditemRowtodelete.length === 0) {
    fooditemRowtodelete = $(deletebtn).closest(".itemRow");
  }
  fooditemRowtodelete.remove();

  //calculate total when an item is reduced
  removepricefromtotal(fooditemRowtodelete);
}

function showDiscountInput() {
  //if the discount checkbox is checked then display the input box to enter a discount value else remove it if its not checked
  if (document.getElementById("discountCheckbox").checked) {
    var inputDiv = document.getElementById("discountinput");

    var discountInput = document.createElement("input");
    discountInput.classList.add("discountinput");
    discountInput.id = "discountpercentageinput";
    discountInput.type = "number";
    discountInput.min = "0";
    discountInput.max = "100";
    discountInput.placeholder = "%";

    inputDiv.appendChild(discountInput);
    calculatediscount(discountInput);
  } else {
    $("#discountpercentageinput").remove();
    RemoveDiscount();
  }
}
//initialize sum as a global value to store the value and display it 
var sum = 0;

function updateTotal(btn, operation) {
  //get price per item from the btn element 
  var priceperitem = $(btn)
    .closest(".fooditemRow")
    .find(".pricePeritem")
    .text();
  priceperitem = parseFloat(priceperitem.replace("Rs.", "").trim());

  if (operation === "add") {
    sum += priceperitem;
    displayTotal(sum);
  } else if (operation === "subtract") {
    sum -= priceperitem;
    displayTotal(sum);
  }
}

function AddTotal(btn) {
  var btn = btn;
  updateTotal(btn, "add");
}

function SubtractTotal(btn) {
  var btn = btn;
  updateTotal(btn, "subtract");
}
function displayTotal(sum) {
  var TotalDiv = $("#totalAmount");
  TotalDiv.html("Rs." + sum);
}

function removepricefromtotal(fooditemrow) {
  //this subtracts the price of the item from the total when the item is removed from the cart
  var priceperitem = $(fooditemrow).find(".pricePeritem").text();
  priceperitem = parseFloat(priceperitem.replace("Rs.", "").trim());
  var quantityInput = $(fooditemrow).find(".foodItemqty").val();
  quantityInput = parseInt(quantityInput);
  sum -= priceperitem * quantityInput;
  displayTotal(sum);
}

function calculatediscount(input) {
  //calulate the discount from the total and display the total on keyup 
  $(input).on("keyup", function () {
    discount = $(this).val();
    if (discount > 100) {
      $(this).val(""); // Set the value to the maximum allowed
      Swal.fire("Discount cannot be more than 100%");
    } else if (isNaN(discount)) {
      $(this).val(""); // Clear the input if the entered value is not a number
    }

    discountamount = (sum * discount) / 100;
    const latestSum = sum - discountamount;
    displayTotal(latestSum);
  });
}

function calculateDiscountOnquantityChange() {
  if ($("#discountCheckbox").prop("checked")) {
    discount = $("#discountpercentageinput").val();
    if (discount > 100) {
      $(this).val(""); // empty the value
      alert("Discount cannot be more than 100%");
    } else if (isNaN(discount)) {
      $(this).val(""); // Clear the input if the entered value is not a number
    }
    console.log(discount);
    discountamount = (sum * discount) / 100;
    console.log("discount is :" + discountamount);
    var sum2 = sum - discountamount;
    displayTotal(sum2);
  }
}
///start from here
function RemoveDiscount() {
  discount = 0;
  console.log(discount);
  discountamount = (sum * discount) / 100;
  console.log("discount is :" + discountamount);
  var sum2 = sum - discountamount;
  displayTotal(sum2);
}

function getcustomerdetails() {
  console.log("fetching");
  var customerNo = $("#customerCno").val();

  console.log(customerNo);
  $.ajax({
    type: "POST",
    url: "../../../../controller/customer_controller.php?status=get-customer-details",
    data: { customerNo: customerNo },
    dataType: "JSON",
    success: function (response) {
      console.log(response);

      var customer_number = response.contact_number;
      var customer_id = response.customer_id;
      var customerFName = response.customer_fname;
      var customerLName = response.customer_lname;
      var customerEmail = response.customer_email;

      if (customer_number === "") {
        $("#customer_id").val("");
        $("#customerFName").val("");
        $("#customerLName").val("");
        $("#customerEmail").val("");
      }

      $("#customer_id").val(customer_id);
      $("#customerFName").val(customerFName);
      $("#customerLName").val(customerLName);
      $("#customerEmail").val(customerEmail);
    },
  });
}
function getavailableitemqty(fooditem_id, card) {
  $.ajax({
    type: "POST",
    url: "../../../../controller/menu_controller.php?status=get-Recipe-To-Calculate-Available-Qty",
    data: { food_id: fooditem_id },
    dataType: "JSON",
    success: function (response) {
      console.log(response);
      calculatefooditemavailabilqty(response, card);
    },
  });
}
function calculatefooditemavailabilqty(response, card) {
  var itemavailableqty = [];
  for (var i = 0; i < response.length; i++) {
    var fooditem_id = response[i].food_itemId;
    var ing_id = response[i].ing_id;
    var requiredqtyfactor = response[i].factor;
    var requiredqtyG = response[i]["qty_required(g)"];
    var requiredqtyML = response[i]["qty_required(ml)"];
    var remainingqtyG = response[i]["remaining_qty(g)"];
    var remainingqtyML = response[i]["remaining_qty(ml)"];

    if (requiredqtyfactor <= 7) {
      itemavailableqty.push(Math.floor(remainingqtyG / requiredqtyG));
    } else {
      itemavailableqty.push(Math.floor(remainingqtyML / requiredqtyML));
    }
    // console.log("ing_id[" + i + "]: " + ing_id + "food Id = " + fooditem_id +  "required quantity factor ="+ requiredqtyfactor
    // + "required qty g ="+requiredqtyG + "required qty ml ="+requiredqtyML +"remaining g="+remainingqtyG +"remianing ml"+remainingqtyML);
  }
  var minitemavailableqty = Math.min.apply(Math, itemavailableqty);
  displayfooditemavailableQty(fooditem_id, minitemavailableqty, card);
}
function displayfooditemavailableQty(fooditem_id, minitemavailableqty, card) {
  console.log(card);
  card.each(function () {
    var foodcard_id = card.find(".food_ids").val();
    if (foodcard_id == fooditem_id) {
      $(this)
        .find(".availableQty")
        .html("Available :" + minitemavailableqty);
    }
  });
}
function placeOrder() {
  var fooditemqtyselected = $(".foodItemqty").val();
  var fooditemsinCart = $(".food_item_name");
  var customerFName = $("#customerFName").val();

  if (fooditemsinCart.length === 0) {
    alert("Please add a food item!");
  } else if (customerFName === "") {
    alert("Please enter the customer's first name!");
  } else {
    var hasZeroQuantity = false;

    $(".foodItemqty").each(function () {
      var quantity = $(this).val();

      // Check if the quantity is 0
      if (parseInt(quantity) === 0) {
        hasZeroQuantity = true;
        return false; // Break out of the loop early since we already found one with 0 quantity
      }
    });

    if (hasZeroQuantity) {
      alert("Add quantities to all items in the cart");
    } else {
      var customer_id = $("#customer_id").val();
      var customerLname = $("#customerLName").val();
      var customerEmail = $("#customerEmail").val();
      var customercontactNo = $("#customerCno").val();
      var foodItemsList = $(".foodRow").toArray();
      var itemList = $(".itemRow").toArray();
      var total = $("#totalAmount").text();
      var customerdetails = [
        $("#customer_id").val(),
        $("#customerFName").val(),
        $("#customerLName").val(),
        $("#customerEmail").val(),
        $("#customerCno").val(),
      ];
      var items = [];
      var discount = $(".discountinput").val();
      for (var i = 0; i < itemList.length; i++) {
        var item = [];
        var itemId = $(itemList[i]).find(".food_ids").val();
        var qty = Number($(itemList[i]).find(".foodItemqty").val());
        var priceperitem = $(itemList[i]).find(".pricePeritem").text();
        priceperitem = parseFloat(priceperitem.replace("Rs.", "").trim());
        item.push(itemId, qty, priceperitem);
        items.push(item);
      }
      var fooditems = [];
      for (var i = 0; i < foodItemsList.length; i++) {
        var item = [];
        var food_itemId = $(foodItemsList[i]).find(".food_ids").val();
        var qty = Number($(foodItemsList[i]).find(".foodItemqty").val());
        var priceperitem = $(foodItemsList[i]).find(".pricePeritem").text();
        priceperitem = parseFloat(priceperitem.replace("Rs.", "").trim());
        item.push(food_itemId, qty, priceperitem);
        fooditems.push(item);
      }
      $.ajax({
        type: "POST",
        url: "../../../../controller/customer_controller.php?status=add-customer",
        data: {
          customer_id: customer_id,
          customerFname: customerFName,
          customerLname: customerLname,
          customerEmail: customerEmail,
          customercontactNo: customercontactNo,
        },
        dataType: "text",
        success: function (response) {
          console.log(response);

          // Check if there are no problems before calling reduceStock
          if (response.trim() !== "") {
            reduceStock(foodItemsList, items);
          }

          // Reset form and display
        },
      });
      var currentDate = new Date();
      var formattedDate = currentDate.toISOString().slice(0, 10); // Format as YYYY-MM-DD
      var currentTime = currentDate.toTimeString().slice(0, 8);
      $.ajax({
        type: "POST",
        url: "../../../../controller/order_controller.php?status=add-order",
        data: {
          customer_id: customer_id,
          discount: discount,
          fooditems: fooditems,
          items: items,
          date: formattedDate,
          time: currentTime,
        },
        dataType: "text",
        success: function (response) {
          $(
            "#customer_id, #customerFName, #customerLName, #customerEmail, #customerCno"
          ).val("");
          $("#fooditemslistcontainer").empty();
          $("#discountCheckbox").prop("checked", false);
          $("#discountpercentageinput").remove();
          RemoveDiscount();

          sum = 0;
          displayTotal(sum);
          showAllOrders();
        },
      });
    }
  }
}

function reduceStock(foodItems, items) {
  for (var i = 0; i < foodItems.length; i++) {
    var foodItem = $(foodItems[i]);

    var fooditem_id = foodItem.find(".food_ids").val();
    var fooditemqty = foodItem.find(".foodItemqty").val();

    $.ajax({
      type: "POST",
      url: "../../../../controller/order_controller.php?status=update-stock",
      data: { fooditem_id: fooditem_id, fooditem_qty: fooditemqty },
      dataType: "text",
      success: function (response) {},
    });
  }
  for (var i = 0; i < items.length; i++) {
    var Item = $(items[i]);

    var item_id = Item[0];
    var qty = Item[1];

    $.ajax({
      type: "POST",
      url: "../../../../controller/order_controller.php?status=update-other-items-stock",
      data: { item_id: item_id, qty: qty },
      dataType: "text",
      success: function (response) {
        console.log(response);
      },
    });
    console.log(item + "qty:" + qty);
  }
}

function showAllOrders() {
  $(".customerPendingorderList").empty();
  var orderListDiv = $(".customerPendingorderList");
  $.ajax({
    type: "GET",
    url: "../../../../controller/order_controller.php?status=get-processing-orders",
    dataType: "JSON",
    success: function (response) {
      for (var order_id in response) {
        if (response.hasOwnProperty(order_id)) {
          var orderItems = response[order_id];
          var itemCount = orderItems.length;
          if (itemCount === 1) {
            var itemOrItem = "item";
          } else {
            var itemOrItem = "items";
          }

          for (var i = 0; i < orderItems.length; i++) {
            var order_id = orderItems[i].order_id;
            var customerFName = orderItems[i].customer_fname;
            var customerLName = orderItems[i].customer_lname;
            var orderStatus = orderItems[i].status_name;
            var orderStatusId = orderItems[i].status_id;
            var orderCard = $(
              '<div class="col-md-2 ">' +
                '<button type="button" class="btn btn-outline-primary" onclick="getorderDetails(' +
                order_id +
                "," +
                orderStatusId +
                ')">' +
                '<h5 style="text-align: left;">' +
                order_id +
                "</h5>" +
                "<p>" +
                customerFName +
                " " +
                customerLName +
                "</p>" +
                "<p>" +
                itemCount +
                " " +
                itemOrItem +
                "</p>" +
                "<p>" +
                orderStatus +
                "</p>" +
                "</button>" +
                "</div>"
            );
          }

          orderListDiv.append(orderCard);
        }
      }
    },
    // console.log(response);
    ///goot the processing order data
  });
}

function getorderDetails(order_id, orderStatusId) {
  var orderStatusId = orderStatusId;
  console.log("getting  id ---->", orderStatusId);
  $.ajax({
    type: "POST",
    url: "../../../../controller/order_controller.php?status=get-order-details",
    data: { order_id: order_id },
    dataType: "JSON",
    success: function (response) {
      console.log("succccc", response);
      displayOrderDetails(response, order_id, orderStatusId);
    },
  });

  console.log(order_id);
}
function displayOrderDetails(orderDetails, order_id, orderStatusId) {
  var statusId = orderStatusId;
  console.log("details adas", statusId);
  if (statusId !== 1) {
    console.log("cccccccccc", orderDetails);
    var modalBody = $("#order-details-modal-body");
    modalBody.empty();
    sum = 0;
    var orderIdInput = $(
      '<input type="hidden" id="order-id" value="' + order_id + '">'
    );
    var table =
      '<table class="table table-bordered"><thead><tr><th>#</th><th>Food Name</th><th>Price (Rs)</th><th>Quantity</th><th>Discount</th><th>Total</th></tr></thead><tbody>';
    for (var i = 0; i < orderDetails.length; i++) {
      var foodname = orderDetails[i].item_name;
      var pricePeritem = orderDetails[i].unit_price;
      var priceAfterDiscount = parseInt(orderDetails[i].final_price);
      var quantity = orderDetails[i].quantity;
      var discount = orderDetails[i].discount;
      sum += priceAfterDiscount;
      var itemNumber = i + 1;
      table += "<tr>";
      table += "<td>" + itemNumber + "</td>";
      table += "<td>" + foodname + "</td>";
      table += "<td>" + pricePeritem + "</td>";
      table += "<td>" + quantity + "</td>";
      table += "<td>" + discount + "%" + "</td>";
      table += "<td>" + priceAfterDiscount + "</td>";
      table += "</tr>";
    }

    table += "<tr>";
    table += "<td>" + "</td>";
    table += "<td>" + "</td>";
    table += "<td>" + "</td>";
    table += "<td>" + "</td>";
    table += "<td>" + "</td>";
    table += "<td>" + sum + "</td>";
    table += "</tr>";

    table += "</tbody></table>";
    $("#orderDetailsModal").modal("show");
    modalBody.append(orderIdInput, table);
    $(".modal-title").text("Order :" + order_id);
  } else {
    console.log("cccccccccc", orderDetails);
    var modalBody = $("#order-details-modal-body");
    modalBody.empty();
    sum = 0;
    var orderIdInput = $(
      '<input type="hidden" id="order-id" value="' + order_id + '">'
    );
    var table =
      '<table class="table table-bordered"><thead><tr><th>#</th><th>Food Name</th><th>Price (Rs)</th><th>Quantity</th><th>Discount</th><th>Total</th></tr></thead><tbody>';
    for (var i = 0; i < orderDetails.length; i++) {
      var foodname = orderDetails[i].item_name;
      var pricePeritem = orderDetails[i].unit_price;
      var priceAfterDiscount = parseInt(orderDetails[i].final_price);
      var quantity = orderDetails[i].quantity;
      var discount = orderDetails[i].discount;
      sum += priceAfterDiscount;
      var itemNumber = i + 1;
      table += "<tr>";
      table += "<td>" + itemNumber + "</td>";
      table += "<td>" + foodname + "</td>";
      table += "<td>" + pricePeritem + "</td>";
      table += "<td>" + quantity + "</td>";
      table += "<td>" + discount + "%" + "</td>";
      table += "<td>" + priceAfterDiscount + "</td>";
      table += "</tr>";
    }

    table += "<tr>";
    table += "<td>" + "</td>";
    table += "<td>" + "</td>";
    table += "<td>" + "</td>";
    table += "<td>" + "</td>";
    table += "<td>" + "</td>";
    table += "<td>" + sum + "</td>";
    table += "</tr>";

    table += "</tbody></table>";
    $("#orderDetailsModal").modal("show");
    modalBody.append(orderIdInput, table);
    $(".modal-title").text("Order :" + order_id);
  }
}

function cancelorder() {
  var order_id = $("#order-id").val();
  $("#orderDetailsModal").modal("hide");
  $(".confirmationmodal").modal("show");
  var cancelConfirmationButton = $(".cancel-order-button");
  cancelConfirmationButton.off().click(function () {
    $.ajax({
      type: "POST",
      url: "../../../../controller/order_controller.php?status=cancel-order",
      data: { order_id: order_id },
      dataType: "JSON",
      success: function (response) {},
    });

    $(".confirmationmodal").modal("hide");
    $("#orderDetailsModal").modal("hide");
    showAllOrders();
  });
  var closeConfirmationModalBtn = $(".close-confirmation-modal-button");
  closeConfirmationModalBtn.off().click(function () {
    $(".confirmationmodal").modal("hide");
    $("#orderDetailsModal").modal("show");
    showAllOrders();
  });
  console.log(order_id);
}

function finishorder() {
  var order_id = $("#order-id").val();
  $("#orderDetailsModal").modal("hide");
  $(".finishOrderconfirmationmodal").modal("show");

  var finishOrderConfirmationButton = $(".finishOrderconfirmation-button");
  finishOrderConfirmationButton.off().click(function () {
    $.ajax({
      type: "POST",
      url: "../../../../controller/order_controller.php?status=finish-order",
      data: { order_id: order_id },
      dataType: "JSON",
      success: function (response) {
        console.log(response);
        $(".finishOrderconfirmationmodal").modal("hide");
        $("#orderDetailsModal").modal("hide");
        getOrderDetailsForInvoice(order_id);
        showAllOrders();
      },
    });
  });
  var finishOrderConfirmationmodalCloseButton = $(
    ".finishOrderconfirmationmodal-close-button"
  );
  finishOrderConfirmationmodalCloseButton.off().click(function () {
    $(".finishOrderconfirmationmodal").modal("hide");
    $("#orderDetailsModal").modal("show");
  });
}
function switchToQuickSell() {
  var placeOrderBtn = $("#placeOrderBtn");
  var quickSellBtn = $(
    '<button class="btn btn-primary col-md-8" id="QuickSellBtn" onclick="quickSell()">' +
      " <h7>Sell</h7>" +
      "</button>"
  );

  $(placeOrderBtn).replaceWith(quickSellBtn);
}
function switchToOrder() {
  var quickSellBtn = $("#QuickSellBtn");
  var placeOrderBtn = $(
    '<button class="btn btn-primary col-md-8" id="placeOrderBtn" onclick="placeOrder()">' +
      " <h7>Place Order</h7>" +
      "</button>"
  );

  $(quickSellBtn).replaceWith(placeOrderBtn);
}

function quickSell() {
  var fooditemqtyselected = $(".foodItemqty").val();
  var fooditemsinCart = $(".food_item_name");
  var customerFName = $("#customerFName").val();

  if (fooditemsinCart.length === 0) {
    alert("Please add an item!");
  } else if (customerFName === "") {
    alert("Please enter the customer's first name!");
  } else {
    var hasZeroQuantity = false;

    $(".foodItemqty").each(function () {
      var quantity = $(this).val();

      // Check if the quantity is 0
      if (parseInt(quantity) === 0) {
        hasZeroQuantity = true;
        return false; // Break out of the loop early since we already found one with 0 quantity
      }
    });

    if (hasZeroQuantity) {
      alert("Add quantities to all items in the cart");
    } else {
      var customer_id = $("#customer_id").val();
      var customerLname = $("#customerLName").val();
      var customerEmail = $("#customerEmail").val();
      var customercontactNo = $("#customerCno").val();
      var foodItemsList = $(".foodRow").toArray();
      console.log(foodItemsList);
      var itemList = $(".itemRow").toArray();
      var total = $("#totalAmount").text();
      var customerdetails = [
        $("#customer_id").val(),
        $("#customerFName").val(),
        $("#customerLName").val(),
        $("#customerEmail").val(),
        $("#customerCno").val(),
      ];
    }
    var modalBody = $("#sales-details-modal-body");
    modalBody.empty();
    sum = 0;
    var discount = $("#discountpercentageinput").val();

    // Check if the value is NaN
    if (isNaN(discount)) {
      // If NaN, set it to 0
      discount = 0;
    }

    var table =
      '<table class="table table-bordered"><thead><tr><th>#</th><th>Item Name</th><th>Price (Rs)</th><th>Quantity</th><th>Discount</th><th>Total</th></tr></thead><tbody>';
    var i = 0;
    foodItemsList.forEach(function (foodItem) {
      var foodname = $(foodItem).find(".food_item_name").text();
      var pricePeritem = $(foodItem).find(".pricePeritem").text();
      pricePeritem = parseFloat(pricePeritem.replace("Rs.", "").trim());
      var priceAfterDiscount = parseInt(pricePeritem);
      var discountValue = (priceAfterDiscount * discount) / 100;
      priceAfterDiscount = priceAfterDiscount - discountValue;
      var quantity = $(foodItem).find(".foodItemqty").val();
      var totalPriceAfterDiscount = priceAfterDiscount * quantity;
      sum += totalPriceAfterDiscount;
      i += 1;
      table += "<tr>";
      table += "<td>" + i + "</td>";
      table += "<td>" + foodname + "</td>";
      table += "<td>" + pricePeritem + "</td>";
      table += "<td>" + quantity + "</td>";
      table += "<td>" + discount + "%" + "</td>";
      table += "<td>" + totalPriceAfterDiscount + "</td>";
      table += "</tr>";
    });

    itemList.forEach(function (Item) {
      console.log("---->");
      var Itemname = $(Item).find(".food_item_name").text();
      var pricePeritem = $(Item).find(".pricePeritem").text();
      pricePeritem = parseFloat(pricePeritem.replace("Rs.", "").trim());
      var quantity = $(Item).find(".foodItemqty").val();
      var priceAfterDiscount = parseInt(pricePeritem);
      var discountValue = (priceAfterDiscount * discount) / 100;
      priceAfterDiscount = priceAfterDiscount - discountValue;
      var totalPriceAfterDiscount = priceAfterDiscount * quantity;
      sum += totalPriceAfterDiscount;
      i += 1;
      table += "<tr>";
      table += "<td>" + i + "</td>";
      table += "<td>" + Itemname + "</td>";
      table += "<td>" + pricePeritem + "</td>";
      table += "<td>" + quantity + "</td>";
      table += "<td>" + discount + "%" + "</td>";
      table += "<td>" + totalPriceAfterDiscount + "</td>";
      table += "</tr>";
    });
    table += "<tr>";
    table += "<td>" + "</td>";
    table += "<td>" + "</td>";
    table += "<td>" + "</td>";
    table += "<td>" + "</td>";
    table += "<td>" + "</td>";
    table += "<td>" + sum + "</td>";
    table += "</tr>";

    table += "</tbody></table>";
    $("#quickSellmodal").modal("show");
    modalBody.append(table);
    $(".quick-sell-modal-title").empty();
    $(".quick-sell-modal-title").append(
      "Customer :",
      customerFName,
      " ",
      customerLname
    );
    var modalConfirmSaleBtn = $("#sellButton");
    modalConfirmSaleBtn.click(function () {
      var items = [];
      var discount = $(".discountinput").val();
      for (var i = 0; i < itemList.length; i++) {
        var item = [];
        var itemId = $(itemList[i]).find(".food_ids").val();
        var qty = Number($(itemList[i]).find(".foodItemqty").val());
        var priceperitem = $(itemList[i]).find(".pricePeritem").text();
        priceperitem = parseFloat(priceperitem.replace("Rs.", "").trim());
        item.push(itemId, qty, priceperitem);
        items.push(item);
      }
      var fooditems = [];
      for (var i = 0; i < foodItemsList.length; i++) {
        var item = [];
        var food_itemId = $(foodItemsList[i]).find(".food_ids").val();
        var qty = Number($(foodItemsList[i]).find(".foodItemqty").val());
        var priceperitem = $(foodItemsList[i]).find(".pricePeritem").text();
        priceperitem = parseFloat(priceperitem.replace("Rs.", "").trim());
        item.push(food_itemId, qty, priceperitem);
        fooditems.push(item);
      }
      $.ajax({
        type: "POST",
        url: "../../../../controller/customer_controller.php?status=add-customer",
        data: {
          customer_id: customer_id,
          customerFname: customerFName,
          customerLname: customerLname,
          customerEmail: customerEmail,
          customercontactNo: customercontactNo,
        },
        dataType: "text",
        success: function (response) {
          console.log(response);

          // Check if there are no problems before calling reduceStock
          if (response.trim() !== "") {
            reduceStock(foodItemsList, items);
          }

          // Reset form and display
        },
      });
      var currentDate = new Date();
      var formattedDate = currentDate.toISOString().slice(0, 10); // Format as YYYY-MM-DD
      var currentTime = currentDate.toTimeString().slice(0, 8);
      $.ajax({
        type: "POST",
        url: "../../../../controller/order_controller.php?status=quick-sell",
        data: {
          customer_id: customer_id,
          discount: discount,
          fooditems: fooditems,
          items: items,
          date: formattedDate,
          time: currentTime,
        },
        dataType: "text",
        success: function (response) {
          //successsfully inserted sales details
          $(
            "#customer_id, #customerFName, #customerLName, #customerEmail, #customerCno"
          ).val("");
          $("#fooditemslistcontainer").empty();
          $("#discountCheckbox").prop("checked", false);
          $("#discountpercentageinput").remove();
          RemoveDiscount();

          sum = 0;
          displayTotal(sum);
          showAllOrders();
          $("#quickSellmodal").modal("hide");
        },
      });
      $.ajax({
        type: "GET",
        url: "../../../../controller/order_controller.php?status=get-last-inserted-saleId",
        dataType: "JSON",
        success: function (response) {
          getSalesDetails(response);
        },
      });
    });
  }
}
function getSalesDetails(sale_id) {
  var sale_id = parseInt(sale_id);
  console.log("saleeeeee", sale_id);
  $.ajax({
    type: "POST",
    url: "../../../../controller/order_controller.php?status=get-quick-sale-details",
    data: { sale_id: sale_id },
    dataType: "JSON",
    success: function (response) {
      displayReceiptDetails(response);
    },
  });
}
function getOrderDetailsForInvoice(order_id) {
  var order_id = parseInt(order_id);
  $.ajax({
    type: "POST",
    url: "../../../../controller/order_controller.php?status=get-order-customer-details",
    data: { order_id: order_id },
    dataType: "JSON",
    success: function (response) {
      console.log(response);
      displayOrderReceiptDetails(response);
    },
  });
}
function displayOrderReceiptDetails(response) {
  console.log("hhhh", response);
  var customerAndOrderDetails = response.customerAndOrderDetails;
  var fooditemArray = response.fooditemArray;
  var otheritemArray = response.otheritemArray;
  var sum = 0;
  var count = 0;
  var itemsArray = [];

  if (customerAndOrderDetails) {
    var customerId = customerAndOrderDetails.customer_id;
    var customerEmail = customerAndOrderDetails.customer_email;
    var contactNo = customerAndOrderDetails.contact_number;
    var customerName =
      customerAndOrderDetails.customer_fname +
      " " +
      customerAndOrderDetails.customer_lname;
    var date = customerAndOrderDetails.order_date;
    var time = customerAndOrderDetails.order_time;
    var order_id = customerAndOrderDetails.order_id;
  }

  for (var i = 0; i < fooditemArray.length; i++) {
    var foodArray = fooditemArray[i];
    var discount = foodArray.discount;
    var quantity = foodArray.quantity;
    var unitPrice = foodArray.unit_price;
    var itemName = foodArray.item_name;
    var totalperitem = parseInt(foodArray.final_price);
    count++;
    sum += totalperitem;
    var item = {
      count: count,
      name: itemName,
      qty: quantity,
      price: unitPrice,
    };
    itemsArray.push(item);
  }
  for (var i = 0; i < otheritemArray.length; i++) {
    var itemArray = otheritemArray[i];
    var discount = itemArray.discount;
    var quantity = itemArray.quantity;
    var unitPrice = itemArray.unit_price;
    var itemName = itemArray.item_name;
    var totalperitem = parseInt(itemArray.final_price);
    count++;
    sum += totalperitem;
    var item = {
      count: count,
      name: itemName,
      qty: quantity,
      price: unitPrice,
    };
    itemsArray.push(item);
  }
  var invoice = ` 
 <style>
 body {
  font-family: 'Arial', sans-serif;
}
.container-fluid {
  width: 300px;
  border: 1px solid #ccc;
  padding: 20px;
}
.title {
  text-align: center;
  margin-bottom: 10px;
}
.info-section {
  margin-bottom: 15px;
}
.item-header {
  display: flex;
  justify-content: space-between;
  font-weight: bold;
  border-bottom: 1px solid #ccc;
  margin-bottom: 5px;
}
.item-row {
  display: flex;
  justify-content: space-evenly;
  margin-bottom: 5px;
}
.total-row {
  margin-top:5px;
}
.totalAmount{
  border-bottom: 1px solid black;
  border-top: 1px solid black;
}
 </style>
 <html><head><title>Order Id: ${order_id}</title>
 <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
 integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
 </head>
 <div class="container-fluid">
<div class="title" id="billTitle">
    <h4>XYZ</h4>
</div>
<div class="info-section">
    <div class="row">
        <h6 class="SaleId OrderId">Order Id: ${order_id}</h6>
    </div>
    <div class="row">
        <h6 class="date">Date: ${date}</h6>
    </div>
    <div class="row">
        <h6 class="time">Time: ${time}</h6>
    </div>
    <div class="row">
        <h6 class="col customerId ">CustomerID: ${customerId}</h6>
    </div>
    <div class="row">
        <h6 class="customerName">Name: ${customerName}</h6>
    </div>
    <div class="row">
        <h6 class="col customerEmail">Email: ${customerEmail}</h6>
    </div>
    <div class="row">
        <h6 class="col customerContactNo">Contact No: ${contactNo}</h6>
    </div>
</div>
<div class="row item-header">
    <h6 class="col itemNo">#</h6>
    <h6 class="col items">Item</h6>
    <h6 class="col qty">Qty</h6>
    <h6 class="col unitprice">Unit Price</h6>
</div>
<div class="row item-row">
${itemsArray.map(
  (itemsArray, index) =>
    `<div class="row itemRow" key=${index}>
    <h6 class="col itemcount">#${itemsArray.count}</p>
    <h6 class="col items">${itemsArray.name}</h6>
    <h6 class="col qty">${itemsArray.qty}</h6>
    <h6 class="col unitprice">${itemsArray.price}</h6>
    </div>`
)}
</div>
<div class="row item-header">
</div>
<div class="row discount-row">
    <h6 class="col discountAmount">Discount: ${discount}%</h6>
</div>
<div class="row total-row">
    <h6 class="col-md-8 total-title">Total</h6>
    <h6 class="col-md-4 totalAmount">${sum}</h6>
</div>
</div>`;

  console.log("array", itemsArray);
  var newWindow = window.open("", "_blank", "width=300,height=300");
  newWindow.document.write(invoice);
}

function displayReceiptDetails(response) {
  console.log(response);
  var customerAndsalesDetails = response.customerAndSalesDetails;
  var fooditemArray = response.fooditemArray;
  var otheritemArray = response.otheritemArray;
  var sum = 0;
  var count = 0;
  var itemsArray = [];

  if (customerAndsalesDetails) {
    var customerId = customerAndsalesDetails.customer_id;
    var customerEmail = customerAndsalesDetails.customer_email;
    var contactNo = customerAndsalesDetails.contact_number;
    var customerName =
      customerAndsalesDetails.customer_fname +
      " " +
      customerAndsalesDetails.customer_lname;
    var date = customerAndsalesDetails.date;
    var time = customerAndsalesDetails.time;
    var salesId = customerAndsalesDetails.sales_id;
  }

  for (var i = 0; i < fooditemArray.length; i++) {
    var foodArray = fooditemArray[i];
    var discount = foodArray.discount;
    var quantity = foodArray.qty;
    var unitPrice = foodArray.unit_price;
    var itemName = foodArray.item_name;
    var totalperitem = parseInt(foodArray.total);
    count++;
    sum += totalperitem;
    var item = {
      count: count,
      name: itemName,
      qty: quantity,
      price: unitPrice,
    };
    itemsArray.push(item);
  }
  for (var i = 0; i < otheritemArray.length; i++) {
    var itemArray = otheritemArray[i];
    var discount = itemArray.discount;
    var quantity = itemArray.qty;
    var unitPrice = itemArray.unit_price;
    var itemName = itemArray.item_name;
    var totalperitem = parseInt(itemArray.total);
    count++;
    sum += totalperitem;
    var item = {
      count: count,
      name: itemName,
      qty: quantity,
      price: unitPrice,
    };
    itemsArray.push(item);
  }
  var invoice = ` 
 <style>
 body {
  font-family: 'Arial', sans-serif;
}
.container-fluid {
  width: 300px;
  border: 1px solid #ccc;
  padding: 20px;
}
.title {
  text-align: center;
  margin-bottom: 10px;
}
.info-section {
  margin-bottom: 15px;
}
.item-header {
  display: flex;
  justify-content: space-between;
  font-weight: bold;
  border-bottom: 1px solid #ccc;
  margin-bottom: 5px;
}
.item-row {
  display: flex;
  justify-content: space-evenly;
  margin-bottom: 5px;
}
.total-row {
  margin-top:5px;
}
.totalAmount{
  border-bottom: 1px solid black;
  border-top: 1px solid black;
}
 </style>
 <html><head><title>Sales Id: ${salesId}</title>
 <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
 integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
 </head>
 <div class="container-fluid">
<div class="title" id="billTitle">
    <h4>XYZ</h4>
</div>
<div class="info-section">
    <div class="row">
        <h6 class="SaleId OrderId">Sales Id: ${salesId}</h6>
    </div>
    <div class="row">
        <h6 class="date">Date: ${date}</h6>
    </div>
    <div class="row">
        <h6 class="time">Time: ${time}</h6>
    </div>
    <div class="row">
        <h6 class="col customerId ">CustomerID: ${customerId}</h6>
    </div>
    <div class="row">
        <h6 class="customerName">Name: ${customerName}</h6>
    </div>
    <div class="row">
        <h6 class="col customerEmail">Email: ${customerEmail}</h6>
    </div>
    <div class="row">
        <h6 class="col customerContactNo">Contact No: ${contactNo}</h6>
    </div>
</div>
<div class="row item-header">
    <h6 class="col itemNo">#</h6>
    <h6 class="col items">Item</h6>
    <h6 class="col qty">Qty</h6>
    <h6 class="col unitprice">Unit Price</h6>
</div>
<div class="row item-row">
${itemsArray.map(
  (itemsArray, index) =>
    `<div class="row itemRow" key=${index}>
    <h6 class="col itemcount">#${itemsArray.count}</p>
    <h6 class="col items">${itemsArray.name}</h6>
    <h6 class="col qty">${itemsArray.qty}</h6>
    <h6 class="col unitprice">${itemsArray.price}</h6>
    </div>`
)}
</div>
<div class="row item-header">
</div>
<div class="row discount-row">
    <h6 class="col discountAmount">Discount: ${discount}%</h6>
</div>
<div class="row total-row">
    <h6 class="col-md-8 total-title">Total</h6>
    <h6 class="col-md-4 totalAmount">${sum}</h6>
</div>
</div>`;

  console.log("array", itemsArray);
  var newWindow = window.open("", "_blank", "width=300,height=300");
  newWindow.document.write(invoice);
}
$(document).ready(function () {
  showAllOrders(); //show all placed orders when the page loads 
  showallItems();//show all items when the page loads
  setInterval(function () {
    showAllOrders();
  }, 15000); //call the function every 15seconds
});