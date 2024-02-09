function setprice(foodid) {
  //this function gets the details to display on the modal to set the price for a food item
    $(document).ready(function () {
        $('#setpriceModal').modal('show');
        var food_itemId = foodid;

        $.ajax({
            type: 'POST',
            url: '../../../../controller/menu_controller.php?status=get-foodItem',
            data: { data: food_itemId },
            success: function (response) {
                const foodname = response.item_name;
                const foodid = response.food_Id;
                const price = response.price;
                $('#exampleModalLabel').text('Set price for ' + foodname);
                $('#food_id').val(foodid);
                $('#price').val(price);
                var form = $('#set-price-form');
                form.attr('action','../../../../controller/menu_controller.php?status=set-price');
            },
        });
    });
}
function setItemprice(itemId){
//this function gets the details to display on the modal to set the price for an other item
    $('#setpriceModal').modal('show');
    $.ajax({
        type: "POST",
        url: "../../../../controller/menu_controller.php?status=get-Item-details",
        data: {itemId:itemId},
        dataType: "JSON",
        success: function (response) {
            const itemName = response.item_name;
            const itemId = response.item_id;
            const price = response.price;
                $('#exampleModalLabel').text('Set price for ' + itemName);
                $('#food_id').val(itemId);
                $('#price').val(price);
                var form = $('#set-price-form');
                form.attr('action','../../../../controller/menu_controller.php?status=set-Item-price');
        }
    });

}

function search() {
  //search function
    const searchValue = $("#seachBar").val().toUpperCase();
    const cards = $(".card");
  
    for (var i = 0; i < cards.length; i++) {
      let match = $(cards[i]).find("p , h5");
      
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

  $(document).ready(function(){
  
    $('[data-bs-toggle="popover"]').popover();
    //close all the popvers unless the last one toggled
    $('[data-bs-toggle="popover"]').on('shown.bs.popover', function () {
      var currentPopover = $(this);
      $('[data-bs-toggle="popover"]').each(function () {
          if (!$(this).is(currentPopover)) {
              $(this).popover('hide');
          }
      });
  });
  });