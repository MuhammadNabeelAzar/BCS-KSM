function search() {
  const searchValue = $("#seachBar").val().toUpperCase();
  const customerdetails = $(".customerdetailsrow");

  for (var i = 0; i < customerdetails.length; i++) {
    let match = $(customerdetails[i]).find("td");

    if (match.length > 0) {
      let textValue = match.text().toUpperCase();

      if (textValue.indexOf(searchValue) > -1) {
        $(customerdetails[i]).show();
      } else {
        $(customerdetails[i]).hide();
      }
    } else {
      $(customerdetails[i]).hide();
    }
  }
}

function addcustomer() {
  const customerID = '';
  const customerFname = $('#addcustomerModal').find("#cfirstName").val();
  const customerLname = $('#addcustomerModal').find("#clastName").val();
  const customeremail = $('#addcustomerModal').find("#cus_Email").val();
  const customerContactNo = $('#addcustomerModal').find("#cus_Contact").val();
  if (customerFname === '' || customerLname === '' || customeremail === '' || customerContactNo === '') {
    Swal.fire("Enter all the user's details !");
    return; // Add this to stop further execution
}

  $.ajax({
    type: "POST",
    url: "../../../../controller/customer_controller.php?status=add-customer",
    data: {
      customer_id:  customerID,
      customerFname: customerFname,
      customerLname: customerLname,
      customerEmail: customeremail,
      customercontactNo: customerContactNo,
    },
    dataType: "JSON",
    success: function (response) {
      console.log(response);
      $("#addcustomerModal").modal('hide');
        Swal.fire({
            text: "Customer added successfully",
        }).then(function() {
            // Reload the page after the user clicks OK
            location.reload();
        });
    },
  });
}

function editCustomer(customerRow){
  const customerID = customerRow.customer_id;
  const customerFName = customerRow.customer_fname 
  const customerLName =  customerRow.customer_lname;
  const contactNo = customerRow.contact_number;
  const email = customerRow.customer_email;
  
  $('#editcustomerModal').modal('show');
  //clear the values first 
  $('#customerID').val('');
  $('#cfirstName').val('');
  $('#clastName').val('');
  $('#cus_Contact').val('');
  $('#cus_Email').val('');

  $('#customerID').val(customerID);
  $('#cfirstName').val(customerFName);
  $('#clastName').val(customerLName);
  $('#cus_Contact').val(contactNo);
  $('#cus_Email').val(email);
}

 function updatecustomer() {
  const customerID = $('#editcustomerModal').find('#customerID').val();
  var customerFname = $('#editcustomerModal').find("#cfirstName").val();
  var customerLname = $('#editcustomerModal').find("#clastName").val();
  var customeremail = $('#editcustomerModal').find("#cus_Email").val();
  var customerContactNo = $('#editcustomerModal').find("#cus_Contact").val();

  if (customerFname === '' || customerLname === '' || customeremail === '' || customerContactNo === '') {
    Swal.fire("Enter all the user's details !");
    return; // Add this to stop further execution
}
  $.ajax({
    type: "POST",
    url: "../../../../controller/customer_controller.php?status=add-customer",
    data: {
      customer_id:  customerID,
      customerFname: customerFname,
      customerLname: customerLname,
      customerEmail: customeremail,
      customercontactNo: customerContactNo,
    },
    dataType: "JSON",
    success: function (response) {
      $('#editcustomerModal').modal('hide');
        Swal.fire({
            text: "Customer details updated successfully",
        }).then(function() {
            // Reload the page after the user clicks OK
            location.reload();
        });
    },
  });
 }