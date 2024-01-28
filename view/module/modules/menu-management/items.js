function switchToAddOtherItemBtn() {
  //this switches the add item button to add other items
  const buttonDiv = $(".buttonDiv");
  $(".placeholdername").text("Item Name");
  buttonDiv.empty();
  const addItemBtn = $(
    '<button type="submit" onclick="addOtherItem()" class="btn btn-primary" >' +
      "Add Item" +
      "</button>"
  );
  buttonDiv.append(addItemBtn);
}
function switchToFoodItemBtn() {
    //this switches the add item button to add food items
  const buttonDiv = $(".buttonDiv");
  $(".placeholdername").text("Food item");
  buttonDiv.empty();
  const addFoodItemBtn = $(
    '<button type="submit" class="btn btn-primary" >' +
      "Add Food Item" +
      "</button>"
  );
  buttonDiv.append(addFoodItemBtn);
  //this changes the form action link to send the request to the controller and add a food item 
  var form = $('#add-item-form');
  form.attr('action', '../../../../controller/menu_controller.php?status=add-fooditem');
}

function addOtherItem() {
    //this changes the form action link to send the request to the controller and add an other item 
  var form = $('#add-item-form');
  form.attr('action', '../../../../controller/menu_controller.php?status=add-Item');
}

function search() {
  //search function
  const searchValue = $("#seachBar").val().toUpperCase();
  const Items = $(".list-group-item");

  for (var i = 0; i < Items.length; i++) {
    let match = $(Items[i]).find("p");
    
    if (match.length > 0) {
      let textValue = match.text().toUpperCase();

      if (textValue.indexOf(searchValue) > -1) {
        $(Items[i]).show();
      } else {
        $(Items[i]).hide();
      }
    } else {
      $(Items[i]).hide();
    }
  }
}

