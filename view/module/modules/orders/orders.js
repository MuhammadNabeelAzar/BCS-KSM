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
      ' <div class="card orders-card" >' +
        '<div class="row card-header allItem-card-header text-center"><h5 class="card-title">' +
        "Order Id :" +
        orderId +
        "</h5></div>" +
        '<div class="card-body orders-card-body">'+
        ' <div class="row customerName ">' +'<h6 class="col-auto" style="font-weight: bold;">Customer Name: </h6>'+'<p class="col-auto">'+customerName+'</p>'+
        "</div>" +
        ' <div class="row">' +
        '<ul class="list-group list-group-flush fooditemDetails"></ul>'+
        "</div>" +
        '<div class ="row  orderControlButton justify-content-center "><div class="col-auto orderControlButtonDiv ">' +
        "</div>" +
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
  //this is the ajax call to mark the order as accepted
  $.ajax({
    type: "POST",
    url: "../../../../controller/order_controller.php?status=accept-order",
    data: { order_id: orderId },
    dataType: "JSON",
    success: function (response) {
      console.log(response);
      getAllOrders();
    },
  });
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
