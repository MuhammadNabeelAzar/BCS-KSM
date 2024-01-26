function getSalesInfo(id, type) {
  console.log("type", id);
  if (type === "order") {
    $.ajax({
      type: "POST",
      url: "../../../../controller/sales_controller.php?status=get-orderSales-details",
      data: { id: id },
      dataType: "JSON",
      success: function (response) {
        displaySalesInfo(response, type);
      },
    });
  } else {
    $.ajax({
      type: "POST",
      url: "../../../../controller/sales_controller.php?status=get-quickSales-details",
      data: { id: id },
      dataType: "JSON",
      success: function (response) {
        displaySalesInfo(response, type);
      },
    });
  }
}
function displaySalesInfo(orderDetails, type) {
  //make  a button to filter the items from sales to orders and vice versa

  console.log(orderDetails);
  var itemNumber = 0;
  var order_id;
  var otheritemArray = orderDetails.otherItems;
  var fooditemArray = orderDetails.foodItems;
  if (type === "order") {
    var modalBody = $("#order-details-modal-body");
    modalBody.empty();
    sum = 0;
    var table =
      '<table class="table table-bordered"><thead><tr><th>#</th><th>Item Name</th><th>Price (Rs)</th><th>Quantity</th><th>Discount</th><th>Total</th></tr></thead><tbody>';
    for (var i = 0; i < otheritemArray.length; i++) {
      var itemName = otheritemArray[i].item_name;
      order_id = otheritemArray[i].order_id;
      var pricePeritem = otheritemArray[i].unit_price;
      var priceAfterDiscount = parseInt(otheritemArray[i].final_price);
      var quantity = otheritemArray[i].quantity;
      var discount = otheritemArray[i].discount;
      sum += priceAfterDiscount;
      itemNumber = i + 1;
      table += "<tr>";
      table += "<td>" + itemNumber + "</td>";
      table += "<td>" + itemName + "</td>";
      table += "<td>" + pricePeritem + "</td>";
      table += "<td>" + quantity + "</td>";
      table += "<td>" + discount + "%" + "</td>";
      table += "<td>" + priceAfterDiscount + "</td>";
      table += "</tr>";
    }

    for (var i = 0; i < fooditemArray.length; i++) {
      var itemName = fooditemArray[i].item_name;
      order_id = fooditemArray[i].order_id;
      var pricePeritem = fooditemArray[i].unit_price;
      var priceAfterDiscount = parseInt(fooditemArray[i].final_price);
      var quantity = fooditemArray[i].quantity;
      var discount = fooditemArray[i].discount;
      sum += priceAfterDiscount;
      itemNumber = i + 1;
      table += "<tr>";
      table += "<td>" + itemNumber + "</td>";
      table += "<td>" + itemName + "</td>";
      table += "<td>" + pricePeritem + "</td>";
      table += "<td>" + quantity + "</td>";
      table += "<td>" + discount + "%" + "</td>";
      table += "<td>" + priceAfterDiscount + "</td>";
      table += "</tr>";
    }

    table += "<tr>";
    table += "<td>" + "</td>";
    table += "<td>" + "</td>";
    table += "<td>" + "</td>";
    table += "<td>" + "</td>";
    table += "<td>" + "</td>";
    table += "<td>" + sum + "</td>";
    table += "</tr>";

    table += "</tbody></table>";

    $("#orderDetailsModal").modal("show");
    modalBody.append(table);
    $(".modal-title").text("ID :" + "O" + order_id);
  } else {
    var modalBody = $("#order-details-modal-body");
    modalBody.empty();
    sum = 0;

    var table =
      '<table class="table table-bordered"><thead><tr><th>#</th><th>Item Name</th><th>Price (Rs)</th><th>Quantity</th><th>Discount</th><th>Total</th></tr></thead><tbody>';
    for (var i = 0; i < otheritemArray.length; i++) {
      var itemName = otheritemArray[i].item_name;
      var pricePeritem = otheritemArray[i].unit_price;
      var priceAfterDiscount = parseInt(otheritemArray[i].total);
      var quantity = otheritemArray[i].qty;
      var discount = otheritemArray[i].discount;
      sum += priceAfterDiscount;
      itemNumber = i + 1;
      table += "<tr>";
      table += "<td>" + itemNumber + "</td>";
      table += "<td>" + itemName + "</td>";
      table += "<td>" + pricePeritem + "</td>";
      table += "<td>" + quantity + "</td>";
      table += "<td>" + discount + "%" + "</td>";
      table += "<td>" + priceAfterDiscount + "</td>";
      table += "</tr>";
    }
    for (var i = 0; i < fooditemArray.length; i++) {
      var itemName = fooditemArray[i].item_name;
      var pricePeritem = fooditemArray[i].unit_price;
      var priceAfterDiscount = parseInt(fooditemArray[i].total);
      var quantity = fooditemArray[i].qty;
      var discount = fooditemArray[i].discount;
      sum += priceAfterDiscount;
      itemNumber = i + 1;
      table += "<tr>";
      table += "<td>" + itemNumber + "</td>";
      table += "<td>" + itemName + "</td>";
      table += "<td>" + pricePeritem + "</td>";
      table += "<td>" + quantity + "</td>";
      table += "<td>" + discount + "%" + "</td>";
      table += "<td>" + priceAfterDiscount + "</td>";
      table += "</tr>";
    }

    table += "<tr>";
    table += "<td>" + "</td>";
    table += "<td>" + "</td>";
    table += "<td>" + "</td>";
    table += "<td>" + "</td>";
    table += "<td>" + "</td>";
    table += "<td>" + sum + "</td>";
    table += "</tr>";

    table += "</tbody></table>";
    var sales_id;

    if (
      fooditemArray.length > 0 &&
      fooditemArray[0].hasOwnProperty("sales_id")
    ) {
      sales_id = fooditemArray[0].sales_id;
    } else if (
      otheritemArray.length > 0 &&
      otheritemArray[0].hasOwnProperty("sales_id")
    ) {
      sales_id = otheritemArray[0].sales_id;
    }

    $("#orderDetailsModal").modal("show");
    modalBody.append(table);
    $(".modal-title").text("ID :" + "S" + sales_id);
  }
  console.log("...........................");
}
function filtersalesdetails(type) {
  // Hide all rows initially
  console.log("start");
  $(".salesRow").hide();
  if (type === "sales") {
    $(".quicksalesRow").show();
    $(".ordersalesRow").hide();
    $("#salesItemsSearchType").val("quickSales");

  } else if (type === "order") {
    $(".ordersalesRow").show();
    $(".quicksalesRow").hide();
    $("#salesItemsSearchType").val("orderSales")
  }
}

$(document).ready(function () {
  $(".ordersalesRow").hide();
  $("#salesItemsSearchType").val("quickSales");
});

function search() {
  const searchValue = $("#seachBar").val().toUpperCase();
  const table = $(".table");
  const SalesRows = $(".quicksalesRow");
  const OrderSalesRows = $(".ordersalesRow");
const searchSalesType = $("#salesItemsSearchType").val();
  if (searchSalesType === "quickSales"){
    for (var i = 0; i < SalesRows.length; i++) {
      let match = $(SalesRows[i]).find("td");
      // console.log(match);
      if (match) {
        let textValue = match.text().toUpperCase();
        console.log(textValue);
        if (textValue.indexOf(searchValue) > -1) {
          console.log("works");
          $(SalesRows[i]).show();
        } else {
          $(SalesRows[i]).hide();
        }
      }
    }
  }
  if (searchSalesType === "orderSales"){
  for (var i = 0; i < OrderSalesRows.length; i++) {
    let match = $(OrderSalesRows[i]).find("td");
    // console.log(match);
    if (match) {
      let textValue = match.text().toUpperCase();
      console.log(textValue);
      if (textValue.indexOf(searchValue) > -1) {
        console.log("works");
        $(OrderSalesRows[i]).show();
      } else {
        $(OrderSalesRows[i]).hide();
      }
    }
  }
  }
}
