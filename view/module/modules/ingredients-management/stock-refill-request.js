function getAllStockRefillRequests(){
    //request to get all the stock refill requests 
    $.ajax({
        type: "GET",
        url: "../../../../controller/ingredients_controller.php?status=get-stock-refill-requests",
        dataType: "JSON",
        success: function (response) {
            
            if(response === false){
                Swal.fire("No requests found !");
            } else {
                displayRequests(response);
            }
        }
    });
}
function displayRequests(data){
    const requestContainer = $('.requestsCards');
    var requests = [];
    data.forEach(item => {
        const ing_name = item.ing_name;
        const reqDate = item.req_date;  
        const reqTime = item.req_time;
        const reqStatus = item.request_status;
        const req_Id =  item.req_id;
        const  quantity = item.quantity + ' '+ item.factorsf ;
        const reason = item.reason;
        var item={
            name : ing_name,
            date : reqDate,
            time: reqTime,
            status : reqStatus,
            req_Id : req_Id,
            quantity : quantity,
            reason : reason
        }
        requests.push(item);
    });

    var cards = `
    ${requests.map((request, index) => `
        <div key=${index}>
            <div class="card mb-3" style="width: 18rem;" >
                <div class="card-header">
                </div>
                <div class="card-body">
                    <h5 class="card-title">Request Information</h5>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><strong>Ingredient:</strong><span id="name"> ${request.name}</span></li>
                        <input type="hidden" value="">
                        <li class="list-group-item"><strong>Request Date:</strong> <span id="requestDate">${request.date}</span></li>
                        <li class="list-group-item"><strong>Request Time:</strong> <span id="requestTime">${request.time}</span></li>
                        <li class="list-group-item"><strong>Request Status:</strong> <span id="requestStatus">${request.status}</span></li>
                        <li class="list-group-item"><strong>Required Amount:</strong> <span id="requiredAmount">${request.quantity}</span></li>
                        <li class="list-group-item"><strong>Reason:</strong> <span id="reasont"><button type="button" onclick="displayRequestReason('${request.reason}')" class="btn btn-primary">Reason</button></span></li>
                    </ul>
                    ${(() => {
                        switch (request.status) {
                            case "pending":
                                return `<button type="button" onclick="acceptRefillRequest(${request.req_Id})" class="btn btn-primary">Accept</button>`;
                            case "accepted":
                                return `<button type="button" onclick="completeRefillRequest(${request.req_Id})" class="btn btn-success">Ready</button>`;
                        }
                    })()}
                </div>
            </div>
        </div>
    `).join('')}
`;

    requestContainer.append(cards);
}
$(document).ready(function(){
    getAllStockRefillRequests();
});

function displayRequestReason(reason){
    Swal.fire(reason);
}

function acceptRefillRequest(req_id){
    //send the request to mark the request as accepted
    $("#confirmationModal").modal('show');
    $(".modal-body").text('');
    $(".modal-body").text('Are you sure you want to accept the request?');
    const confirmBtn = $("#confirmBtn");

    $(confirmBtn).click(function () { 
        $.ajax({
            type: "POST",
            url: "../../../../controller/ingredients_controller.php?status=accept-refill-requests",
            data: {req_id:req_id},
            dataType: "JSON",
            success: function (response) {
                $("#confirmationModal").modal('hide');
                Swal.fire({
                    text: response,
                    didClose: function () {
                        // This will be executed after the Swal.fire alert is closed
                        location.reload();
                    }
                });
            }
        });
    });
}
function completeRefillRequest(req_id){
    //send the request to mark the request as completed and close the request
    $("#confirmationModal").modal('show');
    $(".modal-body").text('');
    $(".modal-body").text('Are you sure you want to mark the request as ready and close the request?');
    const confirmBtn = $("#confirmBtn");

    $(confirmBtn).click(function () { 
        $.ajax({
            type: "POST",
            url: "../../../../controller/ingredients_controller.php?status=mark-as-ready-refill-requests",
            data: {req_id:req_id},
            dataType: "JSON",
            success: function (response) {
                $("#confirmationModal").modal('hide');
                Swal.fire({
                    text: response,
                    didClose: function () {
                        // This will be executed after the Swal.fire alert is closed
                        location.reload();
                    }
                });
            }
        });
    });
}