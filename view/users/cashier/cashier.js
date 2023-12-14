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
      
      if (!existingfoodItemsinCart){
        fooditemContainer.append(
          ' <div class="row fooditemRow" > ' +
          ' <div class="col ml-auto"> ' +
            '<button type="button" class="bi bi-trash  btn-sm" onclick="removeItem(this)"></button>'+
            ' </div> ' +
            '<h6 class="food_item_name">' +
            response.item_name +
            '</h6>' +
            ' <div class="row"> ' +
            ' <div class="col"> ' +
            '<p>' +
            response.price +
            '</p>' +
            ' </div> ' +
            ' <div class="col"> ' +
            '<div class="input-group"> '+
            ' <div class="col"> ' +
            '<button type="button" class="btn bi-file-minus btn-secondary btn-sm" onclick="decreaseCounter(this)" ></button>'+
            ' </div> ' +
            '<input style="width:10px;" class="col" type="number"  id="inputQuantitySelectorSm"   value="0" min="0">'+
            ' <div class="col"> ' +
            '<button type="button" class="btn bi-plus btn-secondary btn-sm" onclick="increaseCounter(this)"></button>'+
            ' </div> ' +
            '</div>'+
            ' </div> ' +
            '</div>'+ 
            '</div>'
        );
      } else {
        console.log('Item already exists. Cannot append.');
      }
    },
  });
}

function  checkItemsExistence(itemName){
  var fooditemNamesinCart = $(".food_item_name");

  for (var i= 0; i < fooditemNamesinCart.length; i++){
    var currentName = $(fooditemNamesinCart[i]).text();

    if (currentName  === itemName) {
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
  
  
}

function decreaseCounter(button) {

  var inputElement = button.parentNode.nextElementSibling;
  x = parseInt($(inputElement).val());
 if (x > 0){
  x--;
 }
$(inputElement).val(x);
  
}
function removeItem(deletebtn) {
 var fooditemRowtodelete = $(deletebtn).closest('.fooditemRow');
 
 fooditemRowtodelete.remove();
}

