$(document).ready(function () {
    displayAllOrders();
  });
function displayAllOrders(){
    $.ajax({
        type: "GET",
        url: "../../../../controller/order_controller.php?status=get-placed-orders",
        dataType: "JSON",
        success: function (response) {
            console.log(response);
        }
    });
}