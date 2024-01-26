function deactivatefoodItem(button){
    console.log("here");
    var food_id = $(button).data('foodid');
    $('#confirmdeactivateModal').show('modal');
    console.log(food_id);
        $('#deactivatebtn').on('click',function(){
            $.ajax({
                type: "post",
                url: "../../../../controller/menu_controller.php?status=deactivate-food-availability",
                data: {food_id:food_id},
                success: function (response) {
                    // console.log(food_id);
                    console.log(response);
                },
                error: function (xhr, status, error) {
                    // Handle errors here
                    console.error(error);
                }
            });
            location.reload();
            $('#confirmdeactivateModal').hide('modal');
        });
        $('#closemodalbtn1').on('click',function(){
            $('#confirmdeactivateModal').hide('modal');
        });
        $('#closemodalbtn2').on('click',function(){
            $('#confirmdeactivateModal').hide('modal');
        });
        
}
function activatefoodItem(button){
    var food_id = $(button).data('foodid');
    $('#confirmactivateModal').show('modal');
    $('#activatebtn').on('click',function(){
        $.ajax({
            type: "post",
            url: "../../../../controller/menu_controller.php?status=activate-food-availability",
            data: {food_id:food_id},
            success: function (response) {
                // console.log(food_id);
                console.log(response);
            },
            error: function (xhr, status, error) {
                // Handle errors here
                console.error(error);
            }
        });
        location.reload();
        $('#confirmactivateModal').hide('modal');
    });
    $('#closeActivatemodalbtn1').on('click',function(){
        $('#confirmactivateModal').hide('modal');
    });
    $('#closeActivatemodalbtn2').on('click',function(){
        $('#confirmactivateModal').hide('modal');
    });
    
}

function search() {
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
