function filteritems(category_id){
    var category_Id = category_id;
    $("#fooditems-container").empty();
    console.log(category_Id)
    $.ajax({
        type: "POST",
        url: "../../../controller/menu_controller.php?status=get-fooditems",
        data: {category:category_Id},
        dataType: "text",
        success: function (response) {

            // Parse the JSON response
    var parsedResponse = JSON.parse(response);
    console.log(parsedResponse);
    // Get the container where you want to append the cards
    var container = $('#fooditems-container');

    for (var i = 0; i < parsedResponse.length; i++) {
        var item = parsedResponse[i];

        // Create a card element
        var card = $('<div class="card " style="width: 15rem; margin: 2px;"></div>');

        // Append card content (customize this part based on your data structure)
        card.append('<div class="card row">' +
        '<img  src="' + "../../" + item.img_path + '" alt="Item Image" style="height:100px;>' +
      '</div>' + 
      '<div class="card-body">' +
        '<h6 class="card-title">' + item.item_name + '</h6>' +
        '<p>' + item.food_description + '</p>' +
        '<p>Rs.' + item.price + '</p>' +
        '<div class="row">' +
          '<div class="col">' +
            '<button class="subtract-btn" onclick="increaseDecreasefooditemqty(this)"><i class="bi bi-dash"></i></button>' +
          '</div>' +
          '<input class="col qty-box" type="number" value="0" onchange="increaseDecreasefooditemqtymanually(this.value)">' +
          '<div class="col" >' +
            '<button class="add-btn" onclick="increaseDecreasefooditemqty(this)"><i class="bi bi-plus"></i></button>' +
          '</div>' +
        '</div>' +
      '</div>'
);

        // Append the card to the container
        container.append(card);
    }
            
        }
    });
}
function showallfoodItems(){

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
    var container = $('#fooditems-container');

    for (var i = 0; i < parsedResponse.length; i++) {
        var item = parsedResponse[i];

        // Create a card element
        var card = $('<div class="card " style="width: 15rem; margin: 2px;"></div>');

        // Append card content (customize this part based on your data structure)
        card.append('<div class="card row">' +
        '<img  src="' + "../../" + item.img_path + '" alt="Item Image" style="height:100px;>' +
      '</div>' + 
      '<div class="card-body">' +
        '<h6 class="card-title">' + item.item_name + '</h6>' +
        '<p>' + item.food_description + '</p>' +
        '<p>Rs.' + item.price + '</p>' +
        '<div class="row">' +
          '<div class="col">' +
            '<button class="subtract-btn" onclick="increaseDecreasefooditemqty(this)"><i class="bi bi-dash"></i></button>' +
          '</div>' +
          '<input class="col qty-box" type="number" value="0" onchange="increaseDecreasefooditemqtymanually(this.value)">' +
          '<div class="col">' +
            '<button class="add-btn" onclick="increaseDecreasefooditemqty(this)"><i class="bi bi-plus"></i></button>' +
          '</div>' +
        '</div>' +
      '</div>'
);

        // Append the card to the container
        container.append(card);
    }
            
        }
    });
}

$(document).ready(function () {
     showallfoodItems();
  });


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

   itemsContainer.appendChild(clonedcard);
    
 }
 
