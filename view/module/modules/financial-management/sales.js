function getSalesInfo(id, type) {
  //this function gets all the sales information when a button is clicked to get quick sales information or order sales
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
  //this displays additional sales information with the items and discount etc,depending on the sale type (order sales,quick sales)

  var itemNumber = 0;
  var order_id;
  var otheritemArray = orderDetails.otherItems;
  var fooditemArray = orderDetails.foodItems;

  //if the sale type is order then display the details
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

      itemNumber++;
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
      itemNumber++;
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
  } //else display quick sales details
  else {
    var itemNumber = 0;
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
      itemNumber++;
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
      itemNumber++;
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
    //get the sales id from one of the present arrays
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
}

function filtersalesdetails(type) {
  // Hide all rows initially
  $(".salesRow").hide();
  //then depending on the type show all thhe related sales details 
  if (type === "sales") {
    $(".quicksalesRow").show();
    $(".ordersalesRow").hide();
    $("#salesItemsSearchType").val("quickSales"); //this hidden input type is set to search different type of rows (quicksales,ordersales)
  } else if (type === "order") {
    $(".ordersalesRow").show();
    $(".quicksalesRow").hide();
    $("#salesItemsSearchType").val("orderSales");
  }
}

$(document).ready(function () {
  $(".ordersalesRow").hide(); //hide order sales row initially to display quick sales only by default
  $("#salesItemsSearchType").val("quickSales"); //set the default value to quick sales
});

function search() {
//the search function
  const searchValue = $("#seachBar").val().toUpperCase();
  const table = $(".table");
  const SalesRows = $(".quicksalesRow");
  const OrderSalesRows = $(".ordersalesRow");
  const searchSalesType = $("#salesItemsSearchType").val();

  if (searchSalesType === "quickSales") {
    for (var i = 0; i < SalesRows.length; i++) {
      
      let match = $(SalesRows[i]).find("td");
      if (match) {
        let textValue = match.text().toUpperCase();

        if (textValue.indexOf(searchValue) > -1) {
          $(SalesRows[i]).show();
        } else {
          $(SalesRows[i]).hide();
        }
      }
    }
  }
  
  if (searchSalesType === "orderSales") {
    for (var i = 0; i < OrderSalesRows.length; i++) {

      let match = $(OrderSalesRows[i]).find("td");
      if (match) {
        let textValue = match.text().toUpperCase();

        if (textValue.indexOf(searchValue) > -1) {
          $(OrderSalesRows[i]).show();
        } else {
          $(OrderSalesRows[i]).hide();
        }
      }
    }
  }
}
