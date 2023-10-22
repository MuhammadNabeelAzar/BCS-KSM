<?php
session_start();
include '../model/user_model.php';
$userObj = new user();

if (isset($_GET['status']) && $_GET['status'] === 'add-user') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Getting the user details from the add-user form
        $firstname = $_POST['Fname'];
        $lastname = $_POST['Lname']; 
        $email = $_POST['Email'];     
        $nic = $_POST['Unic'];
        $dob = $_POST['Userdob'];
        $cno = $_POST['Contact'];
        $role = $_POST['userRole'];

        // Data validation before adding the user
        $response = array('status' => 'success', 'message' => 'User Added Successfully');

        try {
            if ($firstname == '') {
                throw new Exception("First Name cannot be empty!");
            }
            if ($lastname == '') {
                throw new Exception("Last Name cannot be empty!");
            }
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                throw new Exception("Email is invalid!");
            }

            $patnic = "/^[0-9]{12}[vVxX]?$/";
            if (!preg_match($patnic, $nic)) {
                throw new Exception("Invalid NIC format!");
            }

            $userObj->addUser($firstname, $lastname, $dob, $email, $nic, $cno, $role,);
        } catch (Exception $ex) {
            $response = array('status' => 'error', 'message' => $ex->getMessage());
        }

        // Send the response as JSON
        header('Content-Type: application/json');
        echo json_encode($response);
    }
}
?>
