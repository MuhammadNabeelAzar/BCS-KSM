document.addEventListener('DOMContentLoaded', function () {
    const selectElement = document.getElementById('factors');

    let originalValue = selectElement.value;

    selectElement.addEventListener('change', function () {
        if (selectElement.value !== originalValue) {
            alert('Note ! Changing ingredient measurement factor may cause inconsistencies in displaying the remaining quantity therefore make sure you update the remaining stock values that is related to the measurement factor ');

        }
    });
});


