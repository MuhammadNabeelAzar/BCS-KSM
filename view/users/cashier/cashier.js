function filteritems(category_id) {
  var category_Id = category_id;
  $("#fooditems-container").empty();
  console.log(category_Id);
  $.ajax({
    type: "POST",
    url: "../../../controller/menu_controller.php?status=get-fooditems",
    data: { category: category_Id },
    dataType: "text",
    success: function (response) {
      // Parse the JSON response
      var parsedResponse = JSON.parse(response);
      // Get the container where you want to append the cards
      var container = $("#fooditems-container");

      for (var i = 0; i < parsedResponse.length; i++) {
        var item = parsedResponse[i];

        // Create a card element
        var card = $(
          '<div class="card " style="width: 15rem; margin: 2px;"></div>'
        );

        // Append card content (customize this part based on your data structure)
        card.append(
          '<div class="card row">' +
            '<img  src="' +
            "../../" +
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
        getavailableitemqty(fooditem_id, card);
        // Append the card to the container
        container.append(card);
      }
    },
  });
}
function showallfoodItems() {
  $("#fooditems-container").empty();
  $.ajax({
    type: "POST",
    url: "../../../controller/menu_controller.php?status=get-all-fooditems",
    dataType: "text",
    success: function (response) {
      // Parse the JSON response
      var parsedResponse = JSON.parse(response);

      // Get the container where you want to append the cards
      var container = $("#fooditems-container");

      for (var i = 0; i < parsedResponse.length; i++) {
        var item = parsedResponse[i];

        // Create a card element
        var card = $(
          '<div class="card " style="width: 15rem; margin: 2px;"></div>'
        );
        // Append card content (customize this part based on your data structure)
        card.append(
          '<div class="card row">' +
            '<img  src="' +
            "../../" +
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
                ')" >Add to Cart</button>'
              : '<button class="btn btn-danger">Unavailable</button>') +
            "</div>"
        );
        var fooditem_id = item.food_itemId;
        getavailableitemqty(fooditem_id, card);
        // Append the card to the container
        container.append(card);
      }
    },
  });
}

$(document).ready(function () {
  showallfoodItems();
});

function addfooditemtoCart(foodId) {
  $.ajax({
    type: "POST",
    url: "../../../controller/menu_controller.php?status=get-fooditem-details",
    data: { food_id: foodId },
    dataType: "JSON",
    success: function (response) {
      console.log(response);
      var fooditemContainer = $("#fooditemslistcontainer");
      var existingfoodItemsinCart = checkItemsExistence(response.item_name);

      if (!existingfoodItemsinCart) {
        fooditemContainer.append(
          ' <div class="row fooditemRow" > ' +
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
            '<button type="button" class="btn bi-plus btn-secondary btn-sm" onclick="increaseCounter(this)"></button>' +
            " </div> " +
            "</div>" +
            " </div> " +
            "</div>" +
            "</div>"
        );
      } else {
        console.log("Item already exists. Cannot append.");
      }
    },
  });
}

function checkItemsExistence(itemName) {
  var fooditemNamesinCart = $(".food_item_name");

  for (var i = 0; i < fooditemNamesinCart.length; i++) {
    var currentName = $(fooditemNamesinCart[i]).text();

    if (currentName === itemName) {
      return true;
    }
  }
  return false;
}

function increaseCounter(button) {
  var inputElement = button.parentNode.previousElementSibling;
 
  var food_id_inCart = $(button)
    .closest(".fooditemRow")
    .find(".food_ids")
    .val();
  var foodcard = $('.card:has(.food_ids[value="' + food_id_inCart + '"])');
  var maxItemQty = $(foodcard).find(".availableQty").text();
  maxItemQty = parseInt(maxItemQty.replace(/\D/g, ""));
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

function decreaseCounter(button) {
  var inputElement = button.parentNode.nextElementSibling;

  x = parseInt($(inputElement).val());
  if (x > 0) {
    x--;
    SubtractTotal(button);
  }
  $(inputElement).val(x);
  console.log(x);
  calculateDiscountOnquantityChange();

}
function removeItem(deletebtn) {
  var fooditemRowtodelete = $(deletebtn).closest(".fooditemRow");

  fooditemRowtodelete.remove();
  removepricefromtotal(fooditemRowtodelete);
}

function displayDate() {
  var dateDiv = document.getElementById("datediv");

  var currentDate = date();

  dateDiv.innerHTML = currentDate;
}

function date() {
  return new Date().toLocaleDateString();
}

$(document).ready(function () {
  displayDate();
  showAllOrders();

  // setInterval(function () {
  //   addOrderToList();
  // }, 15000);
});

function showDiscountInput() {
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
var sum = 0;

function updateTotal(btn, operation) {
  var priceperitem = $(btn)
    .closest(".fooditemRow")
    .find(".pricePeritem")
    .text();
  priceperitem = parseFloat(priceperitem.replace("Rs.", "").trim());
  //var quantityInput = $(btn).closest('.fooditemRow').find('.foodItemqty').val();

  if (operation === "add") {
    sum += priceperitem;
    console.log("Accumulated Total (Add): " + sum);
    displayTotal(sum);
  } else if (operation === "subtract") {
    sum -= priceperitem;
    console.log("Accumulated Total (Subtract): " + sum);
    displayTotal(sum);
  }
}

function AddTotal(btn) {
  updateTotal(btn, "add");
}

function SubtractTotal(btn) {
  updateTotal(btn, "subtract");
}
function displayTotal(sum) {
  console.log(sum);
  var TotalDiv = $("#totalAmount");
  TotalDiv.html("Rs." + sum);
}

function removepricefromtotal(fooditemrow) {
  var priceperitem = $(fooditemrow).find(".pricePeritem").text();
  priceperitem = parseFloat(priceperitem.replace("Rs.", "").trim());
  var quantityInput = $(fooditemrow).find(".foodItemqty").val();
  quantityInput = parseInt(quantityInput);
  sum -= priceperitem * quantityInput;
  displayTotal(sum);
}

function calculatediscount(input) {
  $(input).on("keyup", function () {
    discount = $(this).val();
    if (discount > 100) {
      $(this).val(100); // Set the value to the maximum allowed
      alert("Discount cannot be more than 100%");
    } else if (isNaN(discount)) {
      $(this).val(""); // Clear the input if the entered value is not a number
    }
    console.log(discount);
    discountamount = (sum * discount) / 100;
    console.log("discount is :" + discountamount);
    var sum2 = sum - discountamount;
    displayTotal(sum2);
  });
}

function calculateDiscountOnquantityChange(){
  discount = $('#discountpercentageinput').val();
    if (discount > 100) {
      $(this).val(100); // Set the value to the maximum allowed
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
    url: "../../../controller/customer_controller.php?status=get-customer-details",
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
    url: "../../../controller/menu_controller.php?status=get-food-availability-qty",
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
      var foodItemsList = $(".fooditemRow").toArray();
      var total = $("#totalAmount").text();
      var customerdetails = [
        $("#customer_id").val(),
        $("#customerFName").val(),
        $("#customerLName").val(),
        $("#customerEmail").val(),
        $("#customerCno").val(),
      ];
      var fooditems = [];
      var discount = $(".discountinput").val();
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
        url: "../../../controller/customer_controller.php?status=add-customer",
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
            // reduceStock(foodItemsList);
          }

          // Reset form and display
        },
      });
      var currentDate = new Date();
      var formattedDate = currentDate.toISOString().slice(0, 10); // Format as YYYY-MM-DD
      var currentTime = currentDate.toTimeString().slice(0, 8);
      $.ajax({
        type: "POST",
        url: "../../../controller/order_controller.php?status=add-order",
        data: {
          customer_id: customer_id,
          discount: discount,
          fooditems: fooditems,
          date: formattedDate,
          time: currentTime,
        },
        dataType: "text",
        success: function (response) {
          alert(response);
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

function reduceStock(foodItems) {
  for (var i = 0; i < foodItems.length; i++) {
    var foodItem = $(foodItems[i]);

    var fooditem_id = foodItem.find(".food_ids").val();
    var fooditemqty = foodItem.find(".foodItemqty").val();

    $.ajax({
      type: "POST",
      url: "../../../controller/order_controller.php?status=update-stock",
      data: { fooditem_id: fooditem_id, fooditem_qty: fooditemqty },
      dataType: "text",
      success: function (response) {
        console.log(response);
      },
    });
    console.log(fooditem_id + "qty:" + fooditemqty);
  }
}

function showAllOrders() {
  $(".customerPendingorderList").empty();
  var orderListDiv = $(".customerPendingorderList");
  $.ajax({
    type: "GET",
    url: "../../../controller/order_controller.php?status=get-processing-orders",
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
                order_id +','+ orderStatusId + 
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
          console.log("order item", orderItems);
        }
      }
    },
    // console.log(response);
    ///goot the processing order data
  });
}

function getorderDetails(order_id , orderStatusId) {
  var orderStatusId = orderStatusId;
  console.log("getting  id ---->" , orderStatusId);
  $.ajax({
    type: "POST",
    url: "../../../controller/order_controller.php?status=get-order-details",
    data: { order_id: order_id },
    dataType: "JSON",
    success: function (response) {
      console.log("succccc", response);
      displayOrderDetails(response, order_id, orderStatusId);
    },
  });

  console.log(order_id);
}
function displayOrderDetails(orderDetails, order_id,orderStatusId) {
  var statusId = orderStatusId;
  console.log("details adas",statusId);
  if (statusId !== 1){
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
  table += "<td>" + discount + "%"+ "</td>";
  table += "<td>" +  priceAfterDiscount + "</td>";
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
  
  else
  
  {
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
  table += "<td>" + discount + "%"+ "</td>";
  table += "<td>" +  priceAfterDiscount + "</td>";
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
      url: "../../../controller/order_controller.php?status=cancel-order",
      data: { order_id: order_id },
      dataType: "JSON",
      success: function (response) {
        
      },
    });

        $(".confirmationmodal").modal("hide");
        $("#orderDetailsModal").modal("hide");
        showAllOrders(); 
  });
 var closeConfirmationModalBtn = $('.close-confirmation-modal-button');
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
  $('.finishOrderconfirmationmodal').modal('show');

  var finishOrderConfirmationButton = $(".finishOrderconfirmation-button");
  finishOrderConfirmationButton.off().click(function () {
     $.ajax({
      type: "POST",
      url: "../../../controller/order_controller.php?status=finish-order",
      data: { order_id: order_id },
      dataType: "JSON",
      success: function (response) {
        console.log(response);
        $('.finishOrderconfirmationmodal').modal('hide');
        $("#orderDetailsModal").modal("hide");
        showAllOrders();
      }
     });
  });
  var finishOrderConfirmationmodalCloseButton = $(".finishOrderconfirmationmodal-close-button");
  finishOrderConfirmationmodalCloseButton.off().click(function () {
    $('.finishOrderconfirmationmodal').modal('hide');
    $("#orderDetailsModal").modal("show");
  });
}