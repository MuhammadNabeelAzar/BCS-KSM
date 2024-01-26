document.addEventListener('DOMContentLoaded', function () {

    var addUserButton = document.getElementById('adduserButton'); //retrieving the add user button by its id
    var adduserModal = new bootstrap.Modal(document.getElementById('add-userModal')); // adduser modal 
    var errormsg = document.getElementById('response'); // getting the div id to display the error msg

    //  An event listener for the button click
    addUserButton.addEventListener('click', function (event) {
            // Prevent the default form submission
        event.preventDefault();

        // Perform PHP validation through an AJAX request
        validateWithPHP();
        
    });

    // Function to validate form data using PHP (AJAX request)
    function validateWithPHP() {
        var form = document.getElementById('adduserform'); 

        //  New FormData object to send form data
        var formData = new FormData(form);

        var xhr = new XMLHttpRequest();
        xhr.open('POST', '../../../../controller/user_controller.php?status=add-user', true);
        xhr.onload = function () {
            if (xhr.status === 200) {
                try {
                    // Attempt to parse the response as JSON
                    var responseData = JSON.parse(xhr.responseText);

                    if (responseData.status === 'success') {
                        // If PHP validation succeeds, display a success message
                        alert(''+ responseData.message);

                        // Close the modal
                        adduserModal.hide();
                    } else if (responseData.status === 'error') {
                        // If PHP validation fails, display an error message
                        errormsg.innerHTML = responseData.message;
                        // Keep the modal open
                    }
                } catch (error) {
                    alert('Enter your details in the form ! ');
                }
            }
        };

        // Sends the form data to the PHP validation script
        xhr.send(formData);
    }
});

