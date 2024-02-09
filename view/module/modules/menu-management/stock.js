function updatestock(itemId, itemName) {
  //this function displays stock information to manage
  $("#updatestockModal").modal("show");
  $("#item_id").val(itemId);
  $(".modal-title").text("Update" + " " + itemName);
}

function resetstock() {
  //the function that resets the stock value
  $("#confirmModal").modal("show");
  $("#updatestockModal").modal("hide");

  $("#confirmBtn").click(function (e) {
    const itemId = $("#item_id").val();
    $.ajax({
      type: "POST",
      url: "../../../../controller/menu_controller.php?status=reset-stock",
      data: { itemId: itemId },
      dataType: "JSON",
      success: function (response) {
        Swal.fire(response).then(() => {
          window.location.href = 'http://localhost/BcsKSM/view/module/modules/menu-management/stock.php';
      });
       
      },
    });
  });
}

function search() {
  //search  function
  const searchValue = $("#seachBar").val().toUpperCase();
  const cards = $(".card");

  for (var i = 0; i < cards.length; i++) {
    let match = $(cards[i]).find("h5");

    if (match.length > 0) {
      let textValue = match.text().toUpperCase();

      if (textValue.indexOf(searchValue) > -1) {
        $(cards[i]).show();
      } else {
        $(cards[i]).hide();
      }
    } else {
      $(cards[i]).hide();
    }
  }
}
