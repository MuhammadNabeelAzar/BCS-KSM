$(document).ready(function () {
  getAllOrders();
  setInterval(function () {
    getAllOrders();
  }, 15000);
});
function getAllOrders() {
  $.ajax({
    type: "GET",
    url: "../../../../controller/order_controller.php?status=get-processing-orders",
    dataType: "json",
    success: function (response) {
      displayAllOrders(response);
    },
  });
}

function displayAllOrders(response) {
  var orderDiv = $(".orders");
  orderDiv.empty();
  for (var orders in response) {
    count = 0;
    var order = response[orders];
    var fooditemRow = [];
    for (var i = 0; i < order.length; i++) {
      count++;
      var fooditemName = order[i].item_name;
      var customerName= order[i].customer_fname + " "+ order[i].customer_lname;
      var orderId = order[i].order_id;
      var status_id = order[i].status_id;
      var quantity = order[i].quantity;
      var fooditemrow = $(
        '<div class="row"><div class="col"><p>#' +
          count +
          '</p></div><div class="col"><p>' +
          fooditemName +
          "</p></div>" +
          '<div class="col"><p>x' +
          quantity +
          "</p></div>" +
          "</div>"
      );
      fooditemRow.push(fooditemrow);
      console.log("here", order);
    }

    var Ordercard = $(
      ' <div class="card " style="width: 15rem; margin: 2px;">' +
        '<div class="row"><h5 class="card-title">' +
        "Order Id :" +
        orderId +
        "</h5></div>" +
        ' <div class="row customerName">' +'<p>'+customerName+'</p>'+
        "</div>" +
        ' <div class="row fooditemDetails">' +
        "</div>" +
        '<div class ="row orderControlButton"><div class="col orderControlButtonDiv">' +
        "</div>" +
        "</div>" +
        " </div>" +
        "</div>"
    );
    if (status_id === "1") {
      var orderControlButton = Ordercard.find(".orderControlButtonDiv").append(
        ' <button type="button" class="btn btn-primary" onclick="acceptOrder(' +
          orderId +
          ')">Accept</button>'
      );
    } else if (status_id !== "3") {
      var orderControlButton = Ordercard.find(".orderControlButtonDiv").append(
        ' <button type="button" class="btn btn-success" onclick="markOrderAsReady(' +
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
    console.log(fooditemRow);
  }
}

function acceptOrder(orderId) {
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
  $(".markOrderAsReadyConfirmationModal").modal("show");
  $(".modal-title").text("Order Id :" + " " + orderId);
  var confirmBtn = $("#orderReadyConfirmButton");
  confirmBtn.click(function () {
    $.ajax({
      type: "POST",
      url: "../../../../controller/order_controller.php?status=mark-order-as-ready",
      data: { order_id: orderId },
      dataType: "JSON",
      success: function (response) {
        console.log(response);
        $(".markOrderAsReadyConfirmationModal").modal("hide");
        getAllOrders();
      },
    });
  });
}
