
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

