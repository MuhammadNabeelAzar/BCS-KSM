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
