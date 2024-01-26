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