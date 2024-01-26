document.addEventListener('DOMContentLoaded', function () {
    const selectElement = document.getElementById('factors');

    let originalValue = selectElement.value;

    selectElement.addEventListener('change', function () {
        if (selectElement.value !== originalValue) {
            alert('Note ! Changing ingredient measurement factor may cause inconsistencies in displaying the remaining quantity therefore make sure you update the remaining stock values that is related to the measurement factor ');

        }
    });
});

function search() {
    const searchValue = $("#seachBar").val().toUpperCase();
    const items = $(".list-group-item");
  
    for (var i = 0; i < items.length; i++) {
      let match = $(items[i]).find("p");
      
      if (match.length > 0) {
        let textValue = match.text().toUpperCase();
  
        if (textValue.indexOf(searchValue) > -1) {
          console.log("works");
          $(items[i]).show();
        } else {
          $(items[i]).hide();
        }
      } else {
        $(items[i]).hide();
      }
    }
  }
