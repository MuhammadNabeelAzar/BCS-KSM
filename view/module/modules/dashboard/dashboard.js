$(document).ready(function () {
  getData();
});
function getData() {
  //gets all the sold items details
  $.ajax({
    type: "GET",
    url: "../../../../controller/dashboard_controller.php?status=get-all-sold-items",
    dataType: "JSON",
    success: function (response) {
      salesItemPieChart(response);
    },
  });
  //gets all the sold item categories
  $.ajax({
    type: "GET",
    url: "../../../../controller/dashboard_controller.php?status=get-all-sold-categories",
    dataType: "JSON",
    success: function (response) {
      displayTopCategories(response);
    },
  });
  //gets all the customer details
  $.ajax({
    type: "GET",
    url: "../../../../controller/dashboard_controller.php?status=get-sales-customer-details",
    dataType: "JSON",
    success: function (response) {
      displayAveragePurchasesDayAndNight(response);
    },
  });
  //gets ingredients stock levels
  $.ajax({
    type: "GET",
    url: "../../../../controller/dashboard_controller.php?status=get-ingredients-stock-levels",
    dataType: "JSON",
    success: function (response) {
      displayIngredientStockLevels(response);
    },
  });
}

function salesItemPieChart(itemsData) {
  //this function displays the no of items sold to compare most selling items and least in a pie chart
  var total = 0;
  var foodItemCount = {};
  itemsData.forEach(function (item) {
    var itemname = item.item_name;
    foodItemCount[itemname] = (foodItemCount[itemname] || 0) + 1;
    var price = parseFloat(item.price);
    total += price;
  });
  total = parseFloat(total);
  var chartData = {
    series: Object.values(foodItemCount),
    labels: Object.keys(foodItemCount),
  };
  var options = {
    chart: {
      type: "donut",
    },
    series: chartData.series,
    labels: chartData.labels,
  };
  var chart = new ApexCharts(
    document.querySelector(".salesItemsChart"),
    options
  );

  chart.render();

  //A total sum is being calculated through the loop to display the total sales 
  displaytotal(total);
}

function displaytotal(total) {
  var totalDiv = $(".totalDiv");
  var totalcard = `<div class="card justify-content-center text-center " style="background-color:#3765ad;">
    <div class="row " ><h5 >Total Sales = Rs.${total}</h6></div>
    </div>`;
  totalDiv.append(totalcard);
}

function displayTopCategories(categoryDetails) {
  //this function shows the most selling category items and displays it in a bar chart
  var CategoryCount = {};
  categoryDetails.forEach(function (category) {
    var categoryName = category.category_name;
    CategoryCount[categoryName] = (CategoryCount[categoryName] || 0) + 1;
  });
  var chartData = {
    series: [
      {
        name: "Count",
        data: Object.values(CategoryCount),
      },
    ],
    labels: Object.keys(CategoryCount),
  };

  var options = {
    chart: {
      type: "bar",
    },
    series: chartData.series,
    xaxis: {
      categories: chartData.labels,
    },
  };
  var chart = new ApexCharts(
    document.querySelector(".topcategoriesChart"),
    options
  );

  chart.render();
}

function displayAveragePurchasesDayAndNight(customerAndSalesTimeData) {
  //this function shows the most no of customers visited during day and night (day(8am-6pm),night(6pm Afterwards))
  var data = { Day: 0, Night: 0 };

  //the no of customers visited most is calculated with the  number of sales made during that time period
  customerAndSalesTimeData.forEach(function (customerData) {
    var time = customerData.time;
    if (time) {
      var [hrs, min, sec] = time.split(":").map(Number);

      // Check if the time is during the day or night
      var TimeofTheDay = hrs >= 8 && hrs <= 18 ? "Day" : "Night";

      data[TimeofTheDay]++;
    }
  });
  const AvgPurchaseTimeDiv = $(".AvgPurchaseTime");
  AvgPurchaseTimeDiv.empty();

  var chartData = {
    series: [
      {
        name: "No.of.Customers",
        data: Object.values(data),
      },
    ],
    labels: Object.keys(data),
  };

  var options = {
    chart: {
      type: "bar",
    },
    plotOptions: {
      bar: {
        horizontal: true,
      },
    },
    series: chartData.series,
    labels: chartData.labels,
  };
  var chart = new ApexCharts(
    document.querySelector(".AvgPurchaseTime"),
    options
  );

  chart.render();
}

function displayIngredientStockLevels(ingData) {
  //this function shows the stock levels of ingredients in kilograms for solid items and litres for liquids
  var solidItemsData = {};
  var liquidItemsData = {};
  var solidIngredients = ingData.solidItems;
  var liquidIngredients = ingData.liquidItems;

  solidIngredients.forEach(function (ingDetails) {
    var ingName = ingDetails.ing_name;
    var remainingQty = ingDetails["remaining_qty(kg)"];
    solidItemsData[ingName] = remainingQty;
  });

  liquidIngredients.forEach(function (ingDetails) {
    var ingName = ingDetails.ing_name;
    var remainingQty = ingDetails["remaining_qty(l)"];
    liquidItemsData[ingName] = remainingQty;
  });

  var chartData = {
    series: [
      {
        name: "Kilograms",
        data: Object.values(solidItemsData),
      },
      {
        name: "Litres",
        data: Object.values(liquidItemsData),
      },
    ],
    labels: Object.keys(solidItemsData), // Assuming solidItemsData has the same keys as liquidItemsData
  };
  var options = {
    chart: {
      type: "bar",
    },
    series: chartData.series,
    labels: chartData.labels,
  };
  var chart = new ApexCharts(
    document.querySelector(".ingStockLevels"),
    options
  );

  chart.render();
}
