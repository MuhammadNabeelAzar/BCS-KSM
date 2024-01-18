<!DOCTYPE html>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="receipt.css">
        <title>Invoice</title>

    </head>
    <body>
    <div class="container-fluid">
        <div class="title" id="billTitle">
            <h4>XYZ</h4>
        </div>

        <div class="info-section">
            <div class="row">
                <h6 class="SaleId OrderId"></h6>
            </div>
            <div class="row">
                <h6 class="date"></h6>
            </div>
            <div class="row">
                <h6 class="time"></h6>
            </div>
            <div class="row">
                <h6 class="col customerIdTitle">CustomerID:</h6>
                <h6 class="col customerId"></h6>
            </div>
            <div class="row">
                <h6 class="customerNameTitle">Name</h6>
                <h6 class="customerName"></h6>
            </div>
            <div class="row">
                <h6 class="col customerEmailTitle">Email:</h6>
                <h6 class="col customerEmail"></h6>
            </div>
            <div class="row">
                <h6 class="col customerContactTitle">Contact No:</h6>
                <h6 class="col customerContactNo"></h6>
            </div>
        </div>

        <div class="row item-header">
            <h6 class="col items">Item</h6>
            <h6 class="col qty">Qty</h6>
            <h6 class="col unitprice">Unit Price</h6>
        </div>

        <div class="row item-row">
            <h6 class="col items"></h6>
            <h6 class="col qty"></h6>
            <h6 class="col unitprice"></h6>
        </div>


        <div class="row item-header">
            
        </div>

        <div class="row discount-row">
        <h6 class="col-md-8 discount">Discount</h6>
            <h6 class="col-md-4 discountAmount"></h6>
        </div>

        <div class="row total-row">
            <h6 class="col-md-8 total-title">Total</h6>
            <h6 class="col-md-4 totalAmount"></h6>
        </div>
    </div>
        
        <script type="text/javascript" src="../view/users/cashier/cashier.js" ></script>
    </body>
</html>