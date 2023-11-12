
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
                requiredqty.setAttribute('name', 'required_quantity[]');
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
    
    
                container.appendChild(requiredqty);
                container.appendChild(factor);
    
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
        
        
                
        
       
      




