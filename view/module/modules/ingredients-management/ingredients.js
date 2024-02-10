function search() {
  //search function
    const searchValue = $("#seachBar").val().toUpperCase();
    const items = $(".list-group-item");
  
    for (var i = 0; i < items.length; i++) {
      let match = $(items[i]).find("h5");
      
      if (match.length > 0) {
        let textValue = match.text().toUpperCase();
  
        if (textValue.indexOf(searchValue) > -1) {
          $(items[i]).show();
        } else {
          $(items[i]).hide();
        }
      } else {
        $(items[i]).hide();
      }
    }
  }