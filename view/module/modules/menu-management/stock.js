function updatestock(itemId,itemName){
    $('#updatestockModal').modal('show');
    $('#item_id').val(itemId);
    $('.modal-title').text("Update"+" "+itemName);
$.ajax({
    type: "POST",
    url: "../../../../controller/menu_controller.php?status=update-otherItems-stock",
    data: {item_Id:itemId},
    dataType: "JSON",
    success: function (response) {
        console.log(response);
    }
});
}

function resetstock(){
   var itemId = $('#item_id').val();
   $.ajax({
    type: "POST",
    url: "../../../../controller/menu_controller.php?status=reset-stock",
    data: {itemId:itemId},
    dataType: "JSON",
    success: function (response) {
        $('#errormsg').text(response);
        $('#updatestockModal').modal('hide');
    }
   });
}
function search() {
    console.log("yes");
    const searchValue = $("#seachBar").val().toUpperCase();
    const cards = $(".card");
 
    for (var i = 0; i < cards.length; i++) {
      let match = $(cards[i]).find("p");
      
      if (match.length > 0) {
        let textValue = match.text().toUpperCase();
  
        if (textValue.indexOf(searchValue) > -1) {
          console.log("works");
          $(cards[i]).show();
        } else {
          $(cards[i]).hide();
        }
      } else {
        $(cards[i]).hide();
      }
    }
  }