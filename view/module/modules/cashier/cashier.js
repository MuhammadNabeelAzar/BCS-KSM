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
        var popupContent = item.description !== null ?  item.description : "No description available.";

        // Create a card element
        var card = $(
          '<div class="card FoodItemCashiercard"></div>'
        );

        // Append card content while creating the content
        card.append(
          '<div class="row card-header allItem-card-header text-center">'+
          '<h6 class="card-title">' +
          item.item_name +
          "</h6>" +
           '</div>'+
            '<div class="card-body">' +
            '<div class="row">'+
               '<img  src="' +
            "../../../" +
            item.img_path +
            '" alt="Item Image">' +
            '</div>'+
            '<input class="item_ids" type="hidden" id="itemId" value="' +
            item.item_id +
            '">' +
            '<div class="row mt-2 justify-content-center m-0">'+
                '<button type="button" class="btn btn-outline-secondary" data-bs-toggle="popover"'+
                  'data-bs-placement="bottom" title="Item Description" data-bs-trigger="focus"'+
                  'data-bs-content="'+popupContent+'">'+
                  'Description'+
                '</button>'+
              '</div>'+
            "<div class='row cardDetailsRow'>" +
            "<div class='row availableQty align-items-center'><p class='card-text'>Available:" +
            item.available_quantity +'</p>'+
            "</div>" +
            "<div class='col'>" +
            "<p class='card-text'>Rs." +
            item.price +
            "</p>" +
            "</div>" +
            "</div>" +
            (item.available_quantity >= "1"
              ? '<div class="row justify-content-center">'+
                '<button class="btn col-auto btn-outline-primary" onclick="additemtoCart(' +
                item.item_id +
                ')" >Add to Cart</button>'+
                '<div>'
              : '<div class="row justify-content-center">'+
              '<button class="btn col-auto btn-outline-danger">Unavailable</button>') +
              '<div>'+
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
        var popupContent = item.food_description !== null ?  item.food_description : "No description available.";

        // Create a card element
        var card = $(
          '<div class="card FoodItemCashiercard"></div>'
        );

        // Append card content while creating the content
        card.append(
          '<div class="row card-header allItem-card-header text-center">'+
          '<h6 class="card-title">' +
          item.item_name +
          "</h6>" +
           '</div>'+
            '<div class="card-body">' +
            '<div class="row">'+
            '<img  src="' +
            "../../../" +
            item.img_path +
            '" alt="Item Image">' +
            '</div>'+
            '<input class="food_ids" type="hidden" id="fooditemId" value="' +
            item.food_itemId +
            '">' +
            '<div class="row mt-2 justify-content-center m-0">'+
                '<button type="button" class="btn btn-outline-secondary" data-bs-toggle="popover"'+
                  'data-bs-placement="bottom" title="Item Description" data-bs-trigger="focus"'+
                  'data-bs-content="'+popupContent+'">'+
                  'Description'+
                '</button>'+
              '</div>'+
            "<div class='row cardDetailsRow'>" +
            "<div class='row availableQty align-items-center'></div>" +
            "<div class='col'>" +
            "<p class='card-text'>Rs." +
            item.price +
            "</p>" +
            "</div>" +
            "</div>" +
            (item.availability === "1"
              ? '<div class="row justify-content-center">'+
              '<button class="btn col-auto btn-outline-primary" onclick="addfooditemtoCart(' +
                item.food_itemId +
                ')" >Add to Cart</button>'+
                '</div>'
              : '<div class="row justify-content-center">'+
              '<button class="btn col-auto btn-outline-danger">Unavailable</button>') +
              '</div>'+
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
        var popupContent = item.food_description !== null ?  item.food_description : "No description available.";
        // Create a card element
        var card = $(
          '<div class="card FoodItemCashiercard"></div>'
        );

        // Append card content while creating the content
        card.append(
          '<div class="row card-header allItem-card-header text-center">'+
          '<h6 class="card-title">' +
          item.item_name +
          "</h6>" +
           '</div>'+
            '<div class="card-body">' +
            '<div class="row">'+
            '<img  src="' +
            "../../../" +
            item.img_path +
            '" alt="Item Image">' +
            '</div>'+
            '<input class="food_ids" type="hidden" id="fooditemId" value="' +
            item.food_itemId +
            '">' +
            '<div class="row mt-2 justify-content-center m-0">'+
                '<button type="button" class="btn btn-outline-secondary" data-bs-toggle="popover"'+
                  'data-bs-placement="bottom" title="Item Description" data-bs-trigger="focus"'+
                  'data-bs-content="'+popupContent+'">'+
                  'Description'+
                '</button>'+
              '</div>'+
            "<div class='row cardDetailsRow'>" +
            "<div class='row availableQty align-items-center'></div>" +
            "<div class='col'>" +
            "<p class='card-text'>Rs." +
            item.price +
            "</p>" +
            "</div>" +
            "</div>" +
            (item.availability === "1"
            ? '<div class="row justify-content-center">'+
            '<button class="btn col-auto btn-outline-primary" onclick="addfooditemtoCart(' +
              item.food_itemId +
              ')" >Add to Cart</button>'+
              '</div>'
            : '<div class="row justify-content-center">'+
            '<button class="btn col-auto btn-outline-danger">Unavailable</button>') +
            '</div>'+
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
    dataType: "JSON",
    success: function (response) {
      // Get the container
      const container = $("#fooditems-container");

      for (var i = 0; i < response.length; i++) {
        var item = response[i];
        var popupContent = item.description !== null ?  item.description : "No description available.";

        // Create a card element
        var card = $(
          '<div class="card FoodItemCashiercard"></div>'
        );

        // Append card content while creating the content
        card.append(
          '<div class="row card-header allItem-card-header text-center">'+
          '<h6 class="card-title">' +
          item.item_name +
          "</h6>" +
           '</div>'+
            '<div class="card-body">' +
            '<div class="row">'+
               '<img  src="' +
            "../../../" +
            item.img_path +
            '" alt="Item Image">' +
            '</div>'+
            '<input class="item_ids" type="hidden" id="itemId" value="' +
            item.item_id +
            '">' +
            '<div class="row mt-2 justify-content-center m-0">'+
                '<button type="button" class="btn btn-outline-secondary" data-bs-toggle="popover"'+
                  'data-bs-placement="bottom" title="Item Description" data-bs-trigger="focus"'+
                  'data-bs-content="'+popupContent+'">'+
                  'Description'+
                '</button>'+
              '</div>'+
            "<div class='row cardDetailsRow '>" +
            "<div class='row availableQty align-items-center'><p class='card-text'>Available:" +
            item.available_quantity +'</p>'+
            "</div>" +
            "<div class='col'>" +
            "<p class='card-text'>Rs." +
            item.price +
            "</p>" +
            "</div>" +
            "</div>" +
            (item.available_quantity >= "1"
              ? '<div class="row justify-content-center">'+
                '<button class="btn col-auto btn-outline-primary" onclick="additemtoCart(' +
                item.item_id +
                ')" >Add to Cart</button>'+
                '<div>'
              : '<div class="row justify-content-center">'+
              '<button class="btn col-auto btn-outline-danger">Unavailable</button>') +
              '<div>'+
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
          ' <div class="row fooditemRow mb-2 m-0 cartItem commonrow itemRow" > ' +
          ' <div class="row  m-0 "> ' +
            '<button type="button" class="bi col-auto  bi-trash btn-danger  btn-sm" onclick="removeItem(this)"></button>' +
            " </div> " +
            '<input class="food_ids" type="hidden" id="itemId" value="' +
            response.item_id +
            '">' +
            '<h6 class="food_item_name">' +
            response.item_name +
            "</h6>" +
            ' <div class="row m-0"> ' +
            ' <div class="col  pricecol"> ' +
            '<p class="pricePeritem">' +
            "Rs." +
            response.price +
            "</p>" +
            " </div> " +
            ' <div class="row m-0 align-items-center"> ' +
            ' <div class="col"> ' +
            '<button type="button" class="btn bi-dash btn-outline-secondary btn-sm" onclick="decreaseCounter(this)" ></button>' +
            " </div> " +
            '<input  class="col form-control form-control-sm foodItemqty" type="number"  id="inputQuantitySelectorSm"  value="0" min="0" readonly>' +
            ' <div class="col"> ' +
            '<button type="button" class="btn bi-plus btn-outline-secondary btn-sm" onclick="increaseitemCounter(this,' +
            response.available_quantity +
            ')"></button>' +
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
          ' <div class="row fooditemRow cartItem mb-2 commonrow foodRow m-0 justify-content-center" > ' +
            ' <div class="row  m-0 "> ' +
            '<button type="button" class="bi bi-trash m-0 col-auto btn-danger btn-sm" onclick="removeItem(this)"></button>' +
            " </div> " +
            '<input class="food_ids" type="hidden" id="fooditemId" value="' +
            response.food_itemId +
            '">' +
            '<h6 class="food_item_name">' +
            response.item_name +
            "</h6>" +
            ' <div class="row m-0"> ' +
            ' <div class="col pricecol"> ' +
            '<p class="pricePeritem">' +
            "Rs." +
            response.price +
            "</p>" +
            " </div> " +
            ' <div class="row m-0 align-items-center"> ' +
            ' <div class="col"> ' +
            '<button type="button" class="btn bi-dash  btn-outline-secondary btn-sm" onclick="decreaseCounter(this)" ></button>' +
            " </div> " +
            '<input class="col form-control form-control-sm foodItemqty" type="number"  id="inputQuantitySelectorSm"  value="0" min="0" readonly>' +
            ' <div class="col"> ' +
            '<button type="button" class="btn bi-plus btn-outline-secondary btn-sm" onclick="increasefooditemCounter(this,' +
            response.food_itemId +
            ')"></button>' +
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
    discountInput.classList.add("discountinput", "form-control","col");
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
    discountamount = (sum * discount) / 100;
    var sum2 = sum - discountamount;
    displayTotal(sum2);
  }
}

function RemoveDiscount() {
  discount = 0;
  discountamount = (sum * discount) / 100;
  var sum2 = sum - discountamount;
  displayTotal(sum2);
}

function getcustomerdetails() {
  // this function gets customer details by using the phone number as a key to fetch details if a user is already a customer and auto fills the details in the customer details input fields to sell
  var customerNo = $("#customerCno").val();

  $.ajax({
    type: "POST",
    url: "../../../../controller/customer_controller.php?status=get-customer-details",
    data: { customerNo: customerNo },
    dataType: "JSON",
    success: function (response) {
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
      calculatefooditemavailabilqty(response, card);
    },
  });
}

function calculatefooditemavailabilqty(response, card) {
  // create an array to store all the maximum divisions of the required ingredients quantities and remianing ingredients quantites
  var itemavailableqty = [];
  for (var i = 0; i < response.length; i++) {
    var fooditem_id = response[i].food_itemId;
    var requiredqtyfactor = response[i].factor;
    var requiredqtyG = response[i]["qty_required(g)"];
    var requiredqtyML = response[i]["qty_required(ml)"];
    var remainingqtyG = response[i]["remaining_qty(g)"];
    var remainingqtyML = response[i]["remaining_qty(ml)"];

    //check if the ingredient is solid or liquid and calulate with grams or ml
    if (requiredqtyfactor <= 7) {
      itemavailableqty.push(Math.floor(remainingqtyG / requiredqtyG));
    } else {
      itemavailableqty.push(Math.floor(remainingqtyML / requiredqtyML));
    }
  }
  //get the maximum no of food items that could be prepared by getting the lowest no in the array to decided the maximum no of items that could be prepared

  var itemavailableqty = Math.min.apply(Math, itemavailableqty);
  displayfooditemavailableQty(fooditem_id, itemavailableqty, card);
}

function displayfooditemavailableQty(fooditem_id, itemavailableqty, card) {
  //this function displays the maximum possible no of food items that could be prepared with the remaining ingredients
  card.each(function () {
    var foodcard_id = card.find(".food_ids").val();
    if (foodcard_id == fooditem_id) {
      $(this)
        .find(".availableQty")
        .html("<p class='card-text'>Available :" + itemavailableqty+"</p>");
    }
  });
}
function placeOrder() {
  const fooditemsinCart = $(".food_item_name");
  const customerFName = $("#customerFName").val();

  if (fooditemsinCart.length === 0) {
    Swal.fire("Add a food item first !");
  } else if (customerFName === "") {
    Swal.fire("Enter the customer's first name !");
  } else {
    var hasZeroQuantity = false;

    $(".foodItemqty").each(function () {
      var quantity = $(this).val();

      // Check if the quantity is 0
      if (parseInt(quantity) === 0) {
        hasZeroQuantity = true;
        return false; // Break out of the loop early if there is an item with the quantity that is equal to 0
      }
    });
    //if the quantity is less than 0 alert a msg
    if (hasZeroQuantity) {
      Swal.fire("Add quantities to all items in the cart");
    } else {
      //else get the details to place the order
      const customer_id = $("#customer_id").val();
      const customerLname = $("#customerLName").val();
      const customerEmail = $("#customerEmail").val();
      const customercontactNo = $("#customerCno").val();
      var foodItemsList = $(".foodRow").toArray();
      var itemList = $(".itemRow").toArray();

      //push the items in the cart to the item array
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
      //push the food items in the cart to the item array
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
      //add the customer details or update it if there is any change or just leave it as it is
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
          //the response send a message saying succesfully inserted else returns nothing
          // Check if the response isnt empty before calling reduceStock
          if (response.trim() !== "") {
            //then call the function to reduce the ingredient stock levels
            reduceStock(foodItemsList, items);
          }
        },
      });

      var currentDate = new Date();
      var formattedDate = currentDate.toISOString().slice(0, 10); // Format as YYYY-MM-DD
      var currentTime = currentDate.toTimeString().slice(0, 8);

      //place the order
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
          // clear all the input fields and values if the order has been added succesfully
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
          Swal.fire("Order placed succesfully.");
        },
      });
    }
  }
}

function reduceStock(foodItems, items) {
  //loop through the food items to reduce the stock
  for (var i = 0; i < foodItems.length; i++) {
    var foodItem = $(foodItems[i]);
    var fooditem_id = foodItem.find(".food_ids").val();
    var fooditemqty = foodItem.find(".foodItemqty").val();

    //send the request to reduce the stock
    $.ajax({
      type: "POST",
      url: "../../../../controller/order_controller.php?status=update-stock",
      data: { fooditem_id: fooditem_id, fooditem_qty: fooditemqty },
      dataType: "text",
      success: function (response) {},
    });
  }

  //loop through the other items and reduce the stock value
  for (var i = 0; i < items.length; i++) {
    var Item = $(items[i]);
    var item_id = Item[0];
    var qty = Item[1];
    //send the request
    $.ajax({
      type: "POST",
      url: "../../../../controller/order_controller.php?status=update-other-items-stock",
      data: { item_id: item_id, qty: qty },
      dataType: "text",
      success: function (response) {},
    });
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
                '<button type="button" class="btn btn-outline-primary  pending-order-btns d-block mb-2" onclick="getorderDetails(' +
                order_id +
                "," +
                orderStatusId +
                ')">' +
                '<h5>' +
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
                "</button>" 
            );
          }

          orderListDiv.append(orderCard);
        }
      }
    },
  });
}

function getorderDetails(order_id, orderStatusId) {
  //get order details to display details in the placed order modal
  var orderStatusId = orderStatusId;
  console.log("getting  id ---->", orderStatusId);
  $.ajax({
    type: "POST",
    url: "../../../../controller/order_controller.php?status=get-order-details",
    data: { order_id: order_id },
    dataType: "JSON",
    success: function (response) {
      displayOrderDetails(response, order_id, orderStatusId);
    },
  });
}

function displayOrderDetails(orderDetails, order_id, orderStatusId) {
  var statusId = orderStatusId;

  if (statusId !== 1) {
    var modalBody = $("#order-details-modal-body");
    modalBody.empty();
    var total = 0;
    var orderIdInput = $(
      '<input type="hidden" id="order-id" value="' + order_id + '">'
    );
    //create a table with the order details
    var table =
      '<table class="table table-hover table-bordered  table-striped   "><thead class="table-header table-header-lg text-center" ><tr><th>#</th><th>Food Name</th><th>Price (Rs)</th><th>Quantity</th><th>Discount</th><th>Total</th></tr></thead><tbody>';
    for (var i = 0; i < orderDetails.length; i++) {
      const foodname = orderDetails[i].item_name;
      const pricePeritem = orderDetails[i].unit_price;
      const priceAfterDiscount = parseInt(orderDetails[i].final_price);
      const quantity = orderDetails[i].quantity;
      const discount = orderDetails[i].discount;
      total += priceAfterDiscount;
      var itemNumber = i + 1;
      table += "<tr class='userRow table-light text-center'>";
      table += "<td>" + itemNumber + "</td>";
      table += "<td>" + foodname + "</td>";
      table += "<td>" + pricePeritem + "</td>";
      table += "<td>" + quantity + "</td>";
      table += "<td>" + discount + "%" + "</td>";
      table += "<td>" + priceAfterDiscount + "</td>";
      table += "</tr>";
    }

    table += "<tr class='userRow table-light text-center'>";
    table += "<td>" + "</td>";
    table += "<td>" + "</td>";
    table += "<td>" + "</td>";
    table += "<td>" + "</td>";
    table += "<td>" + "</td>";
    table += "<td>" + total + "</td>";
    table += "</tr>";
    table += "</tbody></table>";
    $("#orderDetailsModal").modal("show");

    if (statusId === 3) {
      //hide the finish order button because the order hasnt been accepted yet
      $("#finishOrderButton").show();
      $("#cancelOrderButton").hide();
    } else if (statusId === 2) {
      //hide the finish order button and cancel order because the order is being prepared
      $("#finishOrderButton").hide();
      $("#cancelOrderButton").hide();
    }

    modalBody.append(orderIdInput, table);
    $(".modal-title").text("Order :" + order_id);
  } else {
    
    //if the status id is equal to 1 then
    var modalBody = $("#order-details-modal-body");
    modalBody.empty();
    var total = 0;
    var orderIdInput = $(
      '<input type="hidden" id="order-id" value="' + order_id + '">'
    );

    var table =
      '<table class="table table-hover  table-bordered table-striped"><thead class="table-header table-header-lg text-center"><tr><th>#</th><th>Food Name</th><th>Price (Rs)</th><th>Quantity</th><th>Discount</th><th>Total</th></tr></thead><tbody>';

    for (var i = 0; i < orderDetails.length; i++) {
      const foodname = orderDetails[i].item_name;
      const pricePeritem = orderDetails[i].unit_price;
      const priceAfterDiscount = parseInt(orderDetails[i].final_price);
      const quantity = orderDetails[i].quantity;
      const discount = orderDetails[i].discount;
      total += priceAfterDiscount;
      var itemNumber = i + 1;
      table += "<tr class='userRow table-light text-center'>";
      table += "<td>" + itemNumber + "</td>";
      table += "<td>" + foodname + "</td>";
      table += "<td>" + pricePeritem + "</td>";
      table += "<td>" + quantity + "</td>";
      table += "<td>" + discount + "%" + "</td>";
      table += "<td>" + priceAfterDiscount + "</td>";
      table += "</tr>";
    }

    table += "<tr class='userRow table-light text-center'>";
    table += "<td>" + "</td>";
    table += "<td>" + "</td>";
    table += "<td>" + "</td>";
    table += "<td>" + "</td>";
    table += "<td>" + "</td>";
    table += "<td>" + total + "</td>";
    table += "</tr>";

    table += "</tbody></table>";
    $("#orderDetailsModal").modal("show");
    //hide the finish order button and show the cancel order button because the order hasnt been accepted yet
    $("#finishOrderButton").hide();
    $("#cancelOrderButton").show();
    modalBody.append(orderIdInput, table);
    $(".modal-title").text("Order :" + order_id);
  }
}

function cancelorder() {
  //this function is called to confirm and cancel the order when the cancel order button is clicked
  const order_id = $("#order-id").val();
  $("#orderDetailsModal").modal("hide");
  $(".confirmationmodal").modal("show");
  const cancelConfirmationButton = $(".cancel-order-button");

  //cancel order after the confirm button has been clicked on the order cancel modal
  cancelConfirmationButton.off().click(function () {
    $.ajax({
      type: "POST",
      url: "../../../../controller/order_controller.php?status=cancel-order",
      data: { order_id: order_id },
      dataType: "JSON",
      success: function (response) {
        Swal.fire(response);
      },
    });

    $(".confirmationmodal").modal("hide");
    $("#orderDetailsModal").modal("hide");
    showAllOrders();
  });
  //if the cancel order declines confirmation then close the confirmation modal
  var closeConfirmationModalBtn = $(".close-confirmation-modal-button");
  closeConfirmationModalBtn.off().click(function () {
    $(".confirmationmodal").modal("hide");
    $("#orderDetailsModal").modal("show");
    showAllOrders();
  });
}

function finishorder() {
  //this function completes and finishes the order
  const order_id = $("#order-id").val();
  $("#orderDetailsModal").modal("hide");
  $(".finishOrderconfirmationmodal").modal("show");
  const finishOrderConfirmationButton = $(".finishOrderconfirmation-button");

  //closee order after the confirm button has been clicked on the finish order modal
  finishOrderConfirmationButton.off().click(function () {
    $.ajax({
      type: "POST",
      url: "../../../../controller/order_controller.php?status=finish-order",
      data: { order_id: order_id },
      dataType: "JSON",
      success: function (response) {
        $(".finishOrderconfirmationmodal").modal("hide");
        $("#orderDetailsModal").modal("hide");
        Swal.fire(response);
        getOrderDetailsForInvoice(order_id);
        showAllOrders();
      },
    });
  });

  const finishOrderConfirmationmodalCloseButton = $(
    ".finishOrderconfirmationmodal-close-button"
  );
  //close and complete the order when the confirmation button has been clicked
  finishOrderConfirmationmodalCloseButton.off().click(function () {
    $(".finishOrderconfirmationmodal").modal("hide");
    $("#orderDetailsModal").modal("show");
  });
}

function switchToQuickSell() {
  //switch the sell button to quick sale instead of place order
  const placeOrderBtn = $("#placeOrderBtn");
  const quickSellBtn = $(
    '<button class="btn col-auto btn-outline-success " id="QuickSellBtn" onclick="quickSell()">' +
      " <h7>Sell</h7>" +
      "</button>"
  );
  $(placeOrderBtn).replaceWith(quickSellBtn);
}

function switchToOrder() {
  //switch the sell button to place order instead of quick sale
  const quickSellBtn = $("#QuickSellBtn");
  const placeOrderBtn = $(
    '<button class="btn col-auto btn-outline-success" id="placeOrderBtn" onclick="placeOrder()">' +
      " <h7>Place Order</h7>" +
      "</button>"
  );
  $(quickSellBtn).replaceWith(placeOrderBtn);
}

function quickSell() {
  var fooditemsinCart = $(".food_item_name");
  const customerFName = $("#customerFName").val();

  if (fooditemsinCart.length === 0) {
    Swal.fire("Add a food item first !");
  } else if (customerFName === "") {
    Swal.fire("Enter the customer's first name !");
  } else {
    var hasZeroQuantity = false;

    $(".foodItemqty").each(function () {
      var quantity = $(this).val();

      // Check if the quantity is 0
      if (parseInt(quantity) === 0) {
        hasZeroQuantity = true;
        return false; // Break out of the loop early if there is an item with 0 quantity
      }
    });

    if (hasZeroQuantity) {
      Swal.fire("Add quantities to all items in the cart");
    } else {
      var customer_id = $("#customer_id").val();
      var customerLname = $("#customerLName").val();
      var customerEmail = $("#customerEmail").val();
      var customercontactNo = $("#customerCno").val();
      var foodItemsList = $(".foodRow").toArray();
      var itemList = $(".itemRow").toArray();
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
      '<table class="table table-hover table-bordered  table-striped  "><thead class="table-header table-header-lg text-center"><tr><th>#</th><th>Item Name</th><th>Price (Rs)</th><th>Quantity</th><th>Discount</th><th>Total</th></tr></thead><tbody>';
    var i = 0;

    //display food items and other items in the modal to confirm the sale
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
      table += "<tr class='userRow table-light text-center'>";
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
      table += "<tr class='userRow table-light text-center'>";
      table += "<td>" + i + "</td>";
      table += "<td>" + Itemname + "</td>";
      table += "<td>" + pricePeritem + "</td>";
      table += "<td>" + quantity + "</td>";
      table += "<td>" + discount + "%" + "</td>";
      table += "<td>" + totalPriceAfterDiscount + "</td>";
      table += "</tr>";
    });
    table += "<tr class='userRow table-light text-center'>";
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

    // store all food items and other items in arrays seperately when the sell button has been clicked to use the data
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
      //add customer details or update if its already available
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
          // Check if there are no problems before calling reduceStock
          if (response.trim() !== "") {
            reduceStock(foodItemsList, items);
          }
        },
      });

      var currentDate = new Date();
      var formattedDate = currentDate.toISOString().slice(0, 10); // Format as YYYY-MM-DD
      var currentTime = currentDate.toTimeString().slice(0, 8);

      //send the request to store the data to the db
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
          //successsfully inserted sales details then reset all the values
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

      //get the last inserted sales id to generaete the invoice
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

  //get sales quick details to generate the invoice
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

  //get order quick details to generate the invoice
  $.ajax({
    type: "POST",
    url: "../../../../controller/order_controller.php?status=get-order-customer-details",
    data: { order_id: order_id },
    dataType: "JSON",
    success: function (response) {
      displayOrderReceiptDetails(response);
    },
  });
}

function displayOrderReceiptDetails(response) {
  //display order sales receipt details
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
  //create the invoice content
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

  //create and open a new window and  write the content into it
  var newWindow = window.open("", "_blank", "width=300,height=300");
  newWindow.document.write(invoice);
}

function displayReceiptDetails(response) {
  //display quick sales receipt details
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
  //create the invoice content
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

  //create and open a new window and  write the content into it
  var newWindow = window.open("", "_blank", "width=300,height=300");
  newWindow.document.write(invoice);
}
$(document).ready(function () {
  showAllOrders(); //show all placed orders when the page loads
  showallItems(); //show all items when the page loads
  setInterval(function () {
    showAllOrders();
  }, 15000); //call the function every 15seconds
});

$(document).ready(function() {
  // Attach the popover initialization to a parent element (in this case, 'body')
  $('body').on('click', '[data-bs-toggle="popover"]', function() {
    $(this).popover('toggle');
    //close all the popovers unless the last one toggled
    var currentPopover = $(this);
    $('[data-bs-toggle="popover"]').not(currentPopover).popover('hide');
  });
});

function search() {
  ///search function
  const searchValue = $("#seachBar").val().toUpperCase();
  const itemCards = $(".FoodItemCashiercard");

  for (var i = 0; i < itemCards.length; i++) {
    let match = $(itemCards[i]).find("h6");
    if (match) {
      let textValue = match.text().toUpperCase();
      if (textValue.indexOf(searchValue) > -1) {
        $(itemCards[i]).show();
      } else {
        $(itemCards[i]).hide();
      }
    }
  }
}