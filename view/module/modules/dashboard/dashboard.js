$(document).ready(function(){
  getData ();
});
function getData (){
    $.ajax({
        type: "GET",
        url: "../../../../controller/dashboard_controller.php?status=get-all-sold-items",
        dataType: "JSON",
        success: function (response) {
            salesItemPieChart (response);
        }
    });
    $.ajax({
        type: "GET",
        url: "../../../../controller/dashboard_controller.php?status=get-all-sold-categories",
        dataType: "JSON",
        success: function (response) {
          displayTopCategories(response);
        }
    });
    $.ajax({
        type: "GET",
        url: "../../../../controller/dashboard_controller.php?status=get-sales-customer-details",
        dataType: "JSON",
        success: function (response) {
          displayAveragePurchasesDayAndNight(response);
        }
    });
    $.ajax({
        type: "GET",
        url: "../../../../controller/dashboard_controller.php?status=get-ingredients-stock-levels",
        dataType: "JSON",
        success: function (response) {
          displayIngredientStockLevels(response);
        }
    });
}
function salesItemPieChart (itemsData){
    var total = 0;
    // console.log(itemsData);
var foodItemCount = {};
    itemsData.forEach(function (item){
        var itemname = item.item_name;
         foodItemCount[itemname] = (foodItemCount[itemname] || 0) + 1;
         var price = parseFloat(item.price);
         total += price;
    });
    total = (parseFloat(total));
var chartData = {
    series: Object.values(foodItemCount), 
    labels: Object.keys(foodItemCount)
  };
console.log(foodItemCount);
    var options = {
        chart: {
            type: 'donut'
          },
        series: chartData.series,
        labels: chartData.labels,
      };
      // console.log(total);
      var chart = new ApexCharts(document.querySelector(".salesItemsChart"), options);
      
      chart.render();
      displaytotal(total);
}
function displaytotal(total){
    var totalDiv = $('.totalDiv');
    var totalcard = 
    `<div class="card justify-content-center text-center " style="background-color:#3765ad;">
    <div class="row " ><h5 >Total Sales = Rs.${total}</h6></div>
    </div>`
    totalDiv.append(totalcard);
}
function displayTopCategories(categoryDetails){


var CategoryCount = {};
categoryDetails.forEach(function (category){
  var categoryName = category.category_name;
  CategoryCount[categoryName] = (CategoryCount[categoryName] || 0) + 1;
});
console.log(CategoryCount);
var chartData = {
  series: [{
    name: 'Count',
    data: Object.values(CategoryCount)
  }], 
  labels: Object.keys(CategoryCount)
};

    var options = {
        chart: {
          type: 'bar',
        },
        series: chartData.series,
    xaxis: {
      categories: chartData.labels
    }
      };
      var chart = new ApexCharts(document.querySelector(".topcategoriesChart"), options);
      
      chart.render();
}

function displayAveragePurchasesDayAndNight(customerAndSalesTimeData) {
  var data = {'Day':0 ,'Night':0};

  customerAndSalesTimeData.forEach(function (customerData) {
    var time = customerData.time;
    var customerCount = customerData.customer_id;

    if (time) {
      var [hrs, min, sec] = time.split(':').map(Number);

      // Check if the time is during the day or night
      var TimeofTheDay = (hrs >= 8 && hrs <= 18) ? 'Day' : 'Night';

   
      data[TimeofTheDay]++;
    }
  });
var  AvgPurchaseTimeDiv = $('.AvgPurchaseTime');
AvgPurchaseTimeDiv.empty();

var chartData = {
  series: [{
    name: "No.of.Customers",
    data: Object.values(data)
  }], 
  labels: Object.keys(data)
};

var options = {
  chart: {
    type: 'bar',
  },
  plotOptions: {
    bar: {
      horizontal: true
    }
  },
  series: chartData.series,
 labels: chartData.labels

};
var chart = new ApexCharts(document.querySelector(".AvgPurchaseTime"), options);

chart.render();
  console.log(data);
}

function displayIngredientStockLevels(ingData){
  console.log(ingData);
  var solidItemsData  = {};
  var liquidItemsData  = {};
  var solidIngredients = ingData.solidItems;
  var liquidIngredients = ingData.liquidItems;
  solidIngredients.forEach(function (ingDetails){
    var ingName = ingDetails.ing_name;
    var remainingQty = ingDetails['remaining_qty(kg)'];
    solidItemsData[ingName] = remainingQty;
  });
  liquidIngredients.forEach(function (ingDetails){
    var ingName = ingDetails.ing_name;
    var remainingQty = ingDetails['remaining_qty(l)'];
    liquidItemsData[ingName] = remainingQty;
  });
  
console.log(solidItemsData,liquidItemsData);
var chartData = {
  series: [
    {
      name: "Kilograms",
      data: Object.values(solidItemsData)
    },
    {
      name: "Litres",
      data: Object.values(liquidItemsData)
    }
  ],
  labels: Object.keys(solidItemsData) // Assuming solidItemsData has the same keys as liquidItemsData
};
  var options = {
    chart: {
      type: 'bar',
    },
    series: chartData.series,
   labels: chartData.labels
  
  };
  var chart = new ApexCharts(document.querySelector(".ingStockLevels"), options);
  
  chart.render();
}