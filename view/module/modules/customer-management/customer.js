function search() {
  const searchValue = $("#seachBar").val().toUpperCase();
  const customerdetails = $(".customerdetailsrow");

  for (var i = 0; i < customerdetails.length; i++) {
    let match = $(customerdetails[i]).find("td");

    if (match.length > 0) {
      let textValue = match.text().toUpperCase();

      if (textValue.indexOf(searchValue) > -1) {
        console.log("works");
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
  const customerFname = $("#cfirstName").val();
  const customerLname = $("#clastName").val();
  const customeremail = $("#cus_Email").val();
  const customerContactNo = $("#cus_Contact").val();

  $.ajax({
    type: "POST",
    url: "../../../../controller/customer_controller.php?status=add-customer",
    data: {
      customerFname: customerFname,
      customerLname: customerLname,
      customerEmail: customeremail,
      customercontactNo: customerContactNo,
    },
    dataType: "text",
    success: function (response) {
      $("#addcustomerModal").modal("hide");
      $("#cfirstName").val("");
      $("#clastName").val("");
      $("#cus_Email").val("");
      $("#cus_Contact").val("");
      Swal.fire("Customer added successfully");
    },
  });
}
