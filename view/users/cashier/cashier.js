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
      console.log(parsedResponse);
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
            '<input type="hidden" id="fooditemId" value="' +
            item.food_itemId +
            '">' +
            '<h6 class="card-title">' +
            item.item_name +
            "</h6>" +
            "<p>" +
            item.food_description +
            "</p>" +
            "<p>Rs." +
            item.price +
            "</p>" +
            '<button class="btn btn-primary" onclick="addfooditemtoCart(' +
            item.food_itemId +
            ')" >Add to Cart</button>' +
            "</div>"
        );

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
      console.log(parsedResponse);
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
            '<input type="hidden" id="fooditemId" value="' +
            item.food_itemId +
            '">' +
            '<h6 class="card-title">' +
            item.item_name +
            "</h6>" +
            "<p>" +
            item.food_description +
            "</p>" +
            "<p>Rs." +
            item.price +
            "</p>" +
            '<button class="btn btn-primary" onclick="addfooditemtoCart(' +
            item.food_itemId +
            ')" >Add to Cart</button>' +
            "</div>"
        );

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
  console.log("starting");
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
          '<form method="post" enctype="multipart/form-data" href="">' +
            ' <div class="row fooditemRow" > ' +
            ' <div class="col ml-auto"> ' +
            '<button type="button" class="bi bi-trash  btn-sm" onclick="removeItem(this)"></button>' +
            " </div> " +
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
            '<input style="width:10px;" class="col foodItemqty" type="number"  id="inputQuantitySelectorSm"   value="0" min="0">' +
            ' <div class="col"> ' +
            '<button type="button" class="btn bi-plus btn-secondary btn-sm" onclick="increaseCounter(this)"></button>' +
            " </div> " +
            "</div>" +
            " </div> " +
            "</div>" +
            "</div>" +
            "</form>"
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
  x = parseInt($(inputElement).val());
  x++;
  $(inputElement).val(x);
  console.log(x);
  AddTotal(button);
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
    $('#discountpercentageinput').remove();
  }
}
var sum = 0;

function updateTotal(btn, operation) {
  var priceperitem = $(btn).closest('.fooditemRow').find('.pricePeritem').text();
  priceperitem = parseFloat(priceperitem.replace('Rs.', '').trim());
  //var quantityInput = $(btn).closest('.fooditemRow').find('.foodItemqty').val();

  if (operation === 'add') {
    sum += priceperitem;
    console.log("Accumulated Total (Add): " + sum);
    displayTotal(sum);
  } else if (operation === 'subtract') {
    sum -= priceperitem;
    console.log("Accumulated Total (Subtract): " + sum);
    displayTotal(sum);
  }
}

function AddTotal(btn) {
  updateTotal(btn, 'add');
}

function SubtractTotal(btn) {
  updateTotal(btn, 'subtract');
}
function displayTotal(sum2){
  console.log(sum);
  console.log(sum2);
  var TotalDiv = $('#totalAmount');
  TotalDiv.html('Rs.'+sum2);

}

function removepricefromtotal(fooditemrow){
  
  var priceperitem  = $(fooditemrow).find('.pricePeritem').text();
  priceperitem = parseFloat(priceperitem.replace('Rs.', '').trim());
  var quantityInput = $(fooditemrow).find('.foodItemqty').val();
  quantityInput = parseInt(quantityInput);
  sum -= priceperitem * quantityInput ;
  displayTotal(sum);
}


function calculatediscount(input){
  
  $(input).on('keyup',function(){
     discount = $(this).val();
    console.log(discount);
    discountamount = (sum * discount) / 100; 
    console.log('discount is :' +  discountamount);
    var sum2 = sum -discountamount;
    displayTotal(sum2);
  });

}
