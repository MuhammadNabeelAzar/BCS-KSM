
    function editIng(ing_id) {

        $(document).ready(function () {
            $('#convertModal').modal('show');
            var  ingredient_id = ing_id;
            $.ajax({
                type: 'POST',
                url: '../../../../controller/ingredients_controller.php?status=update-ingredient-qty',
                data:  { data: ingredient_id},
                success: function (response){
                    var ingId = response.ing_id;
                    var ingName = response.ing_name;
                    var factorid = response.factor_id;
                    // var remainingQty = response.remaining_qty;
                console.log('Remaining Quantity:', ing_id);
                $('#exampleModalLabel').text('Update ' + ingName);
                $('#ingredient_id').val(ingId);
                $('#factor_id').val(factorid);
                }
            })
        });
    }

    function resetstock(){
        $(document).ready(function () {
            var ing_id = $('#ingredient_id').val();
            console.log(ing_id);
            $.ajax({
                type: 'POST',
                url: '../../../../controller/ingredients_controller.php?status=reset-ingredient-qty',
                data: {ing_id: ing_id},
                success: function (response){
                    location.reload();
                } 
            })
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
