$(document).ready(function () {
  getAllOrders();
  setInterval(function () {
    getAllOrders(); //call this function every 15 sec to refresh orders
  }, 15000);
});

function getAllOrders() {
  //this gets all the order details
  $.ajax({
    type: "GET",
    url: "../../../../controller/order_controller.php?status=get-processing-orders",
    dataType: "json",
    success: function (response) {
      displayAllOrders(response); //pass it down to display 
    },
  });
}

function displayAllOrders(response) {
//The function that displays all the existing orders
  const orderDiv = $(".orders");//order div
  orderDiv.empty();
  // loop through the orders and seperate items 
  for (var orders in response) {
    count = 0;
    const order = response[orders];
    var fooditemRow = [];
    for (var i = 0; i < order.length; i++) {
      count++;
      const fooditemName = order[i].item_name;
      var customerName= order[i].customer_fname + " "+ order[i].customer_lname;
      var orderId = order[i].order_id;
      var status_id = order[i].status_id;
      var quantity = order[i].quantity;
      var fooditemrow = $(
        
            '<li class="list-group-item">' +
                '<div class="row align-items-center">' +
                    '<div class="col"><p style="font-weight: bold;">&bull; ' + count + '</p></div>' +
                    '<div class="col"><p style="font-weight: bold;">' + fooditemName + '</p></div>' +
                    '<div class="col-auto"><p style="font-weight: bold;">Qty: &times;' + quantity + '</p></div>' +
                '</div>' +
            '</li>' 
 
    );
    
      fooditemRow.push(fooditemrow); //push the created item row 
    }

    var Ordercard = $(
      ' <div class="card orders-card mt-4" >' +
        '<div class="row card-header allItem-card-header text-center"><h5 class="card-title">' +
        "Order Id :" +
        orderId +
        "</h5></div>" +
        '<div class="card-body orders-card-body">'+
        ' <div class="row justify-content-center customerName ">' +'<h6 class="row  justify-content-center" style="font-weight: bold;">Customer Name </h6>'+'<p class="row  justify-content-center">'+customerName+'</p>'+
        "</div>" +
        ' <div class="row" style="overflow-y: auto ;max-height:150px;" >' +
        '<ul class="list-group list-group-flush fooditemDetails" ></ul>'+
        "</div>" +
        "</div>" +
        '<div class =" row orderControlButton  justify-content-center align-items-center "><div class="col-auto orderControlButtonDiv mb-2">' +
        
        "</div>" +
        "</div>" +
        " </div>" +
        "</div>"
    );
    //these are the controlleing buttons for each order (accept and mark as ready) they display depending on the order status
    if (status_id === "1") {
      var orderControlButton = Ordercard.find(".orderControlButtonDiv").append(
        ' <button type="button" class="btn btn-outline-primary" onclick="acceptOrder(' +
          orderId +
          ')">Accept</button>'
      );
    } else if (status_id !== "3") {
      var orderControlButton = Ordercard.find(".orderControlButtonDiv").append(
        ' <button type="button" class="btn btn-outline-success" onclick="markOrderAsReady(' +
          orderId +
          ')">Ready</button>'
      );
    } else if (status_id === "3") {
      var orderControlButton = Ordercard.find(".orderControlButtonDiv").append(
        "<h6>Ready for collection</h6>"
      );
    }

    fooditemRow.forEach(function () {
      Ordercard.find(".fooditemDetails").append(fooditemRow);
    });
    orderDiv.append(Ordercard);
  }
}

function acceptOrder(orderId) {
  //this is the ajax call sent to the controller to mark the order as accepted
  $.ajax({
    type: "POST",
    url: "../../../../controller/order_controller.php?status=accept-order",
    data: { order_id: orderId },
    dataType: "JSON",
    success: function (response) {
      getAllOrders();
    },
  });
  //then a request is sent to the controller to fetch the items placed in the order to pass it down to the reduce stock function
  $.ajax({
    type: "POST",
    url: "../../../../controller/order_controller.php?status=get-orderSales-details",
    data: { order_id: orderId },
    dataType: "JSON",
    success: function (response) {
reduceStock(response);
    },
  });
}

function reduceStock(orderItems) {
  const foodItems = orderItems.foodItems;
  const items = orderItems.otherItems;

  //loop through the food items to reduce the stock
  for (var i = 0; i < foodItems.length; i++) {
    var foodItem = foodItems[i];
    var fooditem_id = foodItem.food_itemId;
    var fooditemqty = foodItem.quantity;

    //send the request to reduce the stock
    $.ajax({
      type: "POST",
      url: "../../../../controller/order_controller.php?status=update-stock",
      data: { fooditem_id: fooditem_id, fooditem_qty: fooditemqty },
      dataType: "text",
      success: function (response) {},
    });
  }

  //loop through the other items and reduce the stock value
  for (var i = 0; i < items.length; i++) {
    var Item = items[i];
    var item_id = Item.item_id;
    var qty = Item.quantity;
    //send the request
    $.ajax({
      type: "POST",
      url: "../../../../controller/order_controller.php?status=update-other-items-stock",
      data: { item_id: item_id, qty: qty },
      dataType: "text",
      success: function (response) {},
    });
  }
}
function markOrderAsReady(orderId) {
  // A confirmation modal is opened to confirm  that the user wants to set this order as ready
  $(".markOrderAsReadyConfirmationModal").modal("show");
  $(".modal-title").text("Order Id :" + " " + orderId);
  const confirmBtn = $("#orderReadyConfirmButton");
  //then when the confirm  button is clicked the order is marked as ready
  confirmBtn.click(function () {
    $.ajax({
      type: "POST",
      url: "../../../../controller/order_controller.php?status=mark-order-as-ready",
      data: { order_id: orderId },
      dataType: "JSON",
      success: function (response) {
        $(".markOrderAsReadyConfirmationModal").modal("hide");
        getAllOrders();
      },
    });
  });
}
