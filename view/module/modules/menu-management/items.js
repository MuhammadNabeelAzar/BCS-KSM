function switchToAddOtherItemBtn() {
  var buttonDiv = $(".buttonDiv");
  $(".placeholdername").text("Item Name");
  buttonDiv.empty();
  var addItemBtn = $(
    '<button type="submit" onclick="addOtherItem()" class="btn btn-primary" >' +
      "Add Item" +
      "</button>"
  );
  buttonDiv.append(addItemBtn);
}
function switchToFoodItemBtn() {
  var buttonDiv = $(".buttonDiv");
  $(".placeholdername").text("Food item");
  buttonDiv.empty();
  var addFoodItemBtn = $(
    '<button type="submit" class="btn btn-primary" >' +
      "Add Food Item" +
      "</button>"
  );
  buttonDiv.append(addFoodItemBtn);
  var form = $('#add-item-form');
  form.attr('action', '../../../../controller/menu_controller.php?status=add-fooditem');
}

function addOtherItem() {
  var form = $('#add-item-form');
  form.attr('action', '../../../../controller/menu_controller.php?status=add-Item');
}

function search() {
  const searchValue = $("#seachBar").val().toUpperCase();
  const Items = $(".list-group-item");

  for (var i = 0; i < Items.length; i++) {
    let match = $(Items[i]).find("p");
    
    if (match.length > 0) {
      let textValue = match.text().toUpperCase();

      if (textValue.indexOf(searchValue) > -1) {
        console.log("works");
        $(Items[i]).show();
      } else {
        $(Items[i]).hide();
      }
    } else {
      $(Items[i]).hide();
    }
  }
}

