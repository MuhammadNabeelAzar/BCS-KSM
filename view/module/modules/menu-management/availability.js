function deactivatefoodItem(button){
//this deactivates  the food item tempararily to disable sales of the item
const food_id = $(button).data('foodid');

    $('#confirmdeactivateModal').show('modal');
        $('#deactivatebtn').on('click',function(){
            $.ajax({
                type: "post",
                url: "../../../../controller/menu_controller.php?status=deactivate-food-availability",
                data: {food_id:food_id},
                success: function (response) {
                    $('#confirmdeactivateModal').hide('modal');
                    Swal.fire("Item deactivated Successfully");
                },
            });  
        });
        $('#closemodalbtn1').on('click',function(){
            $('#confirmdeactivateModal').hide('modal');
        });
        $('#closemodalbtn2').on('click',function(){
            $('#confirmdeactivateModal').hide('modal');
        });
}

function activatefoodItem(button){
    //this activates  the food item 
    const food_id = $(button).data('foodid');
    $('#confirmactivateModal').show('modal');
    $('#activatebtn').on('click',function(){
        $.ajax({
            type: "post",
            url: "../../../../controller/menu_controller.php?status=activate-food-availability",
            data: {food_id:food_id},
            success: function (response) {
                $('#confirmactivateModal').hide('modal');
        Swal.fire("Item activated Successfully");
            },
        });
    });
    $('#closeActivatemodalbtn1').on('click',function(){
        $('#confirmactivateModal').hide('modal');
    });
    $('#closeActivatemodalbtn2').on('click',function(){
        $('#confirmactivateModal').hide('modal');
    });
}

function search() {
    //search function
    const searchValue = $("#seachBar").val().toUpperCase();
    const cards = $(".card");
  
    for (var i = 0; i < cards.length; i++) {
      let match = $(cards[i]).find("p");
      
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
