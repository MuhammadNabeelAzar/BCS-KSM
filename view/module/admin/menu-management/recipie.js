
        $(document).on('click', '.form-check-input', function () {
            var formIngElement = $(this).closest('.form-check');
    
            if ($(this).is(":checked")) {
                // Add to the selected-ingredients container
                $('#selected-ingredients').append(formIngElement);
    
                var container = document.createElement('div');
                container.className = 'col';

                var formIngID = formIngElement.find('input[type="checkbox"]').val();

                var requiredqty = document.createElement('input');
                requiredqty.setAttribute('type', 'number');
                requiredqty.setAttribute('placeholder', 'required quantity');
                requiredqty.setAttribute('name', 'qtyrequired[]');
                requiredqty.setAttribute('id', 'required_quantity');
                requiredqty.required = true;
    
                var factor = document.createElement('select');
                factor.setAttribute('name', 'factor[]');
    
                var g = document.createElement('option');
                g.value = '1';
                g.text = 'g';
                factor.appendChild(g);
                var kg = document.createElement('option');
                kg.value = '2';
                kg.text = 'kg';
                factor.appendChild(kg);
                var c = document.createElement('option');
                c.value = '3';
                c.text = 'c';
                factor.appendChild(c);
                var tbsp = document.createElement('option');
                tbsp.value = '4';
                tbsp.text = 'tbsp';
                factor.appendChild(tbsp);
                var tsp = document.createElement('option');
                tsp.value = '5';
                tsp.text = 'tsp';
                factor.appendChild(tsp);
                var oz = document.createElement('option');
                oz.value = '6';
                oz.text = 'oz';
                factor.appendChild(oz);
                var lb = document.createElement('option');
                lb.value = '7';
                lb.text = 'lb';
                factor.appendChild(lb);
                var ml = document.createElement('option');
                ml.value = '8';
                ml.text = 'ml';
                factor.appendChild(ml);
                var l = document.createElement('option');
                l.value = '9';
                l.text = 'l';
                factor.appendChild(l);
    
    
                // container.appendChild(requiredqty);
                // container.appendChild(factor);
                
                formIngElement.append(container);
    
                
    
            } else {
                // Move it to the original container
                formIngElement.appendTo('#list');
                // remove the input element 
                formIngElement.find('.col').remove();
            }

           
        });   

        function submitValidation() {
            // Check if at least one checkbox is checked
            var selectedIngredients = $('.form-check-input:checked');
        
            if (selectedIngredients.length > 0) {
                // Ingredients are selected, allow form submission
                return true;
            } else {
                // No checkboxes are checked, show an error message
                alert('Please select at least one ingredient.');
                return false; // Prevent form submission
            }
        }
 // Function to move checked ingredients to the selected-ingredients container
function moveCheckedIngredients() {
    $('.form-check-input:checked').each(function () {
        var formIngElement = $(this).closest('.form-check');

        // Move to the selected-ingredients container
        $('#selected-ingredients').append(formIngElement);

        // Create and append the quantity and factor inputs
        var container = document.createElement('div');
        container.className = 'col';

        formIngElement.append(container);
    });
}

// Move checked ingredients on page load
$(document).ready(function () {
    $('[id^=factorSelect]').hide();
    $('.qtyrequired').hide();
    moveCheckedIngredients();
    $('#selected-ingredients [id^=factorSelect]').show();
    $('#selected-ingredients .qtyrequired').show();
   
});        
$(document).on('click', '.form-check-input', function () {
    $('#selected-ingredients [id^=factorSelect]').show();
    $('#selected-ingredients .qtyrequired').show();
});              

function getRecipe() {
    // Retrieve the food ID from the hidden input field
    var foodId = $('#food_id').val();

    // Make an AJAX request to get the recipe
    $.ajax({
        url: '/BcsKSM/controller/menu_controller.php?status=get-recipe&foodId=' + foodId,

        type: 'GET',
        dataType: 'json',
        success: function(response) {
            if (response.status === 'success') {
                // Handle the successful response
                console.log('Recipe data:', response.data);
                // Do something with the data (e.g., update the UI)
            } else {
                // Handle the error response
                console.error('Error:', response.message);
            }
        },
        error: function(xhr, status, error) {
            // Handle errors here
            console.error('AJAX Error:', error);
        }
    });
}

$(document).ready(function () {
    getRecipe();
});





        
                
        
       
      




