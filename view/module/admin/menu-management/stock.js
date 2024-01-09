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