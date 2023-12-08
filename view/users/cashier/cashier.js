function filteritems(category_id){
    var category_Id = category_id;
    $("#fooditems-container").empty();
    console.log(category_Id)
    $.ajax({
        type: "POST",
        url: "../../../controller/menu_controller.php?status=get-fooditems",
        data: {category:category_Id},
        dataType: "text",
        success: function (response) {

            // Parse the JSON response
    var parsedResponse = JSON.parse(response);
    console.log(parsedResponse);
    // Get the container where you want to append the cards
    var container = $('#fooditems-container');

    for (var i = 0; i < parsedResponse.length; i++) {
        var item = parsedResponse[i];

        // Create a card element
        var card = $('<div class="card col" style="margin:2px;"></div>');

        // Append card content (customize this part based on your data structure)
        card.append('<div class="row"><img src="' + "../../"+ item.img_path + '" alt="Item Image"></div>' + 
        '<div class="card-body"><h6 class="card-title">' + item.item_name + '</h6></div>' + 
          '<p>'+ item.food_description +'</p>' + '<p>'+'Rs.' + item.price +'</p>' + '<div class="row"><div class="col"><button><i class="bi bi-dash"></i></button></div>'+
          '<div class="col">a</div><div class="col"><button><i class="bi bi-plus"></i></button></div></div>' 
        );

        // Append the card to the container
        container.append(card);
    }
            
        }
    });
}
