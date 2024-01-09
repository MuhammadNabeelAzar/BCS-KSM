function setprice(foodid) {
    $(document).ready(function () {
        $('#setpriceModal').modal('show');
        var food_itemId = foodid;

        $.ajax({
            type: 'POST',
            url: '../../../../controller/menu_controller.php?status=get-foodItem',
            data: { data: food_itemId },
            success: function (response) {
                var foodname = response.item_name;
                var foodid = response.food_Id;
                var price = response.price;
                console.log(response);
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
    console.log("works");
    $('#setpriceModal').modal('show');
    $.ajax({
        type: "POST",
        url: "../../../../controller/menu_controller.php?status=get-Item-details",
        data: {itemId:itemId},
        dataType: "JSON",
        success: function (response) {
            console.log(response);
            var itemName = response.item_name;
                var itemId = response.item_id;
                var price = response.price;
                console.log(response);
                $('#exampleModalLabel').text('Set price for ' + itemName);
                $('#food_id').val(itemId);
                $('#price').val(price);
                var form = $('#set-price-form');
                form.attr('action','../../../../controller/menu_controller.php?status=set-Item-price');
        }
    });

}
