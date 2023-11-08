$(document).ready(function(){
    $(document).on('click', '.form-check-input' , function(){
        var formIngElement = $(this).closest('.form-check');
        
        if($(this).is(":checked")){
            // Add to the selected-ingredients container
            formIngElement.appendTo('#selected-ingredients');
            var requiredqty = document.createElement('INPUT');
            requiredqty.setAttribute('type','number');
            requiredqty.setAttribute('placeholder','required quantity');
            requiredqty.setAttribute('name', 'required_quantity');
            
            // requiredqty.style.float = 'left';
            requiredqty.style.marginLeft = '40px';

            formIngElement.append(requiredqty);
        } else {
            // Move it to the original container
            formIngElement.appendTo('#list');
            //remove the input element 
            formIngElement.find('input[name="required_quantity"]').remove();

        }
    });
});
