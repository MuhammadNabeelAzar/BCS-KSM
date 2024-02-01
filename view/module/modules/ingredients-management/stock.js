
    function editIng(ing_id) {
//this function gets the details to display the ingredient details 
        $(document).ready(function () {
            $('#updatestockModal').modal('show');
            const  ingredient_id = ing_id;
            $.ajax({
                type: 'POST',
                url: '../../../../controller/ingredients_controller.php?status=get-ingredient-details',
                data:  { data: ingredient_id},
                success: function (response){
                    const ingId = response.ing_id;
                    const ingName = response.ing_name;
                    const factorid = response.factor_id;

                $('#modaltitle').text(ingName);
                $('#ingredient_id').val(ingId);
                $('#factor_id').val(factorid);
                }
            })
        });
    }

    function resetstock(){

      //this function resets the stock value to 0
      $('#updatestockModal').modal('hide');
      $('#confirmationModal').modal('show');
      var confirmBtn = $('#confirmBtn');

      $(confirmBtn).click(function (e) { 
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
