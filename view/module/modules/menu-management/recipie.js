function addIngredientsToRecipe(formCheckInput) {
  //this function adds the ingredient to the recipe
  const formIngElement = $(formCheckInput).closest(".form-check");
  //when the ingredients have been checked in the list of available ingredients the function appends it to the container

  if ($(formCheckInput).is(":checked")) {
    // Add to the selected-ingredients container
    $("#selected-ingredients").append(formIngElement);

    var container = document.createElement("div");
    container.className = "col";
    //creates the factor options(measurement factors for ingredients)
    var factor = document.createElement("select");
    factor.setAttribute("name", "factor[]");
    factor.setAttribute("class", "factor");

    var g = document.createElement("option");
    g.value = "1";
    g.text = "g";
    factor.appendChild(g);
    var kg = document.createElement("option");
    kg.value = "2";
    kg.text = "kg";
    factor.appendChild(kg);
    var c = document.createElement("option");
    c.value = "3";
    c.text = "c";
    factor.appendChild(c);
    var tbsp = document.createElement("option");
    tbsp.value = "4";
    tbsp.text = "tbsp";
    factor.appendChild(tbsp);
    var tsp = document.createElement("option");
    tsp.value = "5";
    tsp.text = "tsp";
    factor.appendChild(tsp);
    var oz = document.createElement("option");
    oz.value = "6";
    oz.text = "oz";
    factor.appendChild(oz);
    var lb = document.createElement("option");
    lb.value = "7";
    lb.text = "lb";
    factor.appendChild(lb);
    var ml = document.createElement("option");
    ml.value = "8";
    ml.text = "ml";
    factor.appendChild(ml);
    var l = document.createElement("option");
    l.value = "9";
    l.text = "l";
    factor.appendChild(l);

    formIngElement.append(container);
  } else {
    //if its not checked then move it back to the list
    moveIngtoOriginalContainer(formIngElement);
  }
}
function moveIngtoOriginalContainer(formIngElement) {
  //this function moves the ingredient back to the list
  removeIngredientmodalpopup();
  // Add an event listener to the button inside the popup
  $("#removeIngBtn").on("click", function () {
    // Move to the original container
    formIngElement.appendTo("#list");
    $("#list .qtyrequired").hide(); //hide the requiredqty  input  field
    $("#list [id^=factorSelect]").hide(); //hide the factor options field

    // Hide the modal
    $("#removeIngredientModal").modal("hide");
  });
}

function moveCheckedIngredients() {
  // Function to move checked ingredients to the selected-ingredients container(The ingredients that are already present in the recipe)
  $(".form-check-input:checked").each(function () {
    const formIngElement = $(this).closest(".form-check");

    // Move to the selected-ingredients container
    $("#selected-ingredients").append(formIngElement);

    // Create and append the quantity and factor inputs
    let container = document.createElement("div");
    container.className = "col";

    formIngElement.append(container);
  });
}

$(document).ready(function () {
  // Move checked ingredients on page load
  $("[id^=factorSelect]").hide();
  $(".qtyrequired").hide();
  moveCheckedIngredients();
  $("#selected-ingredients [id^=factorSelect]").show();
  $("#selected-ingredients .qtyrequired").show();
  removeIngredientmodalpopup();
});

$(document).on("click", ".form-check-input", function () {
  $("#selected-ingredients [id^=factorSelect]").show();
  $("#selected-ingredients .qtyrequired").show();
});

function getRecipe() {
  //this function gets all the ingredients and other details of the recipe

  // Retrieve the food ID from the hidden input field
  const foodId = $("#food_id").val();

  // Make an AJAX request to get the recipe
  $.ajax({
    url:
      "/BcsKSM/controller/menu_controller.php?status=get-recipe&foodId=" +
      foodId,

    type: "GET",
    dataType: "json",
    success: function (response) {
      if (response.status === "success") {
  
      } else {
        // Handle the error response
        Swal.fire("Error:", response.message);
      }
    },
  });
}

$(document).ready(function () {
  getRecipe(); //call the function on page load
});

function removeIngredientmodalpopup() {
  // this opens a confirmation modal to remove an ingredient from the recipe
  $(".specific-checkbox").on("change", function () {
    //get the required quantity value
    const qtyrequired = $(this).closest(".form-check").find(".qtyrequired");

    if (!$(this).prop("checked")) {
      var ingId = qtyrequired.closest(".form-check").find("#ing_id").val();
      $("#removeIngredientModal").modal("show");
      $("#ingId").val(ingId);
      $(".ing-list .qtyrequired").val("");
    }
  });
}

function removeingHandler() {
  //get the ing id and make the call
  const ingId = $("#ingId").val();

  //send the request to the controller to remove the ingredient
  $.ajax({
    type: "POST",
    url:
      "../../../../controller/menu_controller.php?status=remove-ingredient&ing_id=" +
      ingId,
    data: { data: ingId },
    success: function (response) {
      Swal.fire("Ingredient removed successfully!");
    },
    error: function (xhr, status, error) {
      // Handle errors here
      Swal.fire("AJAX Error:", error);
    },
  });
  $("#removeIngredientModal").modal("hide");
}

function closeRemoveIngmodal(button) {
  //this is the close modal function if the remove ingredient hasnt been confirmed 
  $("#removeIngredientModal").modal("hide");
  $('#selected-ingredients input[type="checkbox"]').prop("checked", true);
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
