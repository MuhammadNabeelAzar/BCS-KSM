document.addEventListener('DOMContentLoaded', function () {
  //this is an event listener to display a msg when an ingredients measurement factor has been changed
    const selectElement = document.getElementById('factors');

    let originalValue = selectElement.value;

    selectElement.addEventListener('change', function () {
        if (selectElement.value !== originalValue) {
            Swal.fire('Note: Modifying the ingredient measurement factor may lead to discrepancies in the displayed remaining quantity. Ensure that you update the corresponding stock values accordingly to maintain accuracy.');

        }
    });
});

function search() {
  // search function
    const searchValue = $("#seachBar").val().toUpperCase();
    const items = $(".list-group-item");
  
    for (var i = 0; i < items.length; i++) {
      let match = $(items[i]).find("p");
      
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
