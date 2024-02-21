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
            $user_id = $userObj->addUser($firstname, $lastname, $dob, $email, $nic, $cno, $role, );
            if ($user_id) {
                $nic = password_hash($nic, PASSWORD_DEFAULT);
                $userObj->addUserLogin($email, $nic, $user_id);
            }
            $response = array('status' => 'success', 'message' => 'User Added Successfully');
        } catch (Exception $ex) {
            $response = array('status' => 'error', 'message' => $ex->getMessage()); //handles the error and send the error message as a response
        }
        // Send the response as JSON
        header('Content-Type: application/json');
        echo json_encode($response);

    }
}

if (isset($_GET['status']) && $_GET['status'] === 'edit-user') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Getting the user details from the add-user form
        $firstname = $_POST['users_fname'];
        $lastname = $_POST['users_lname'];
        $email = $_POST['users_email'];
        $nic = $_POST['users_nic'];
        $dob = $_POST['users_dob'];
        $cno = $_POST['users_cno'];
        $role = $_POST['users_role'];
        $user_id = $_POST['user_id'];
        // Data validation before adding the user

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

            $patnic = "/^[a-zA-Z0-9]{1,12}$/";
            if (!preg_match($patnic, $nic)) {
                throw new Exception("NIC cannot be empty!");
            }

            $userObj->updateUser($firstname, $lastname, $email, $nic, $dob, $cno, $role, $user_id);
            $msg = "User information updated successfully";
            $msg = base64_encode($msg);
            header("location:../view/module/modules/user-management/user.php?msg=$msg");
        } catch (Exception $ex) {
            $msg = $ex->getMessage();
            $msg = base64_encode($msg);
            header("location:../view/module/modules/user-management/edit-user.php?id=$user_id&msg=$msg");

        }

    }
}
if (isset($_GET['status']) && $_GET['status'] === 'delete-user') {
    $user_id = $_GET['userid'];
    $userObj->removeUser($user_id);
    $msg = "User Successfully Deleted!";
    $msg = base64_encode($msg);
    header("location:../view/module/modules/user-management/user.php?msg=$msg");
}
if (isset($_GET['status']) && $_GET['status'] === 'verify-password') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $user_id = $_POST['user_id'];
        $userEnteredPassword = $_POST['current_password'];

        $result = $userObj->getPassword($user_id);
        $password = $result->fetch_assoc();

        $hashedStoredPassword = $password['login_password'];
        if (password_verify($userEnteredPassword,$hashedStoredPassword)){
          $response = true;
        } else {
            $response = false;
        }
        header('Content-Type: application/json');
        echo json_encode($response);
    }
}
if (isset($_GET['status']) && $_GET['status'] === 'reset-password') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $user_id = $_POST['user_id'];
        $new_password = $_POST['new_password'];

        $result = $userObj->resetPassword($user_id,$new_password);
        if($result) {
            $response = "Your password reset has been completed succesfully.";
        } else {
            $response = "Error in updating your password . Please try again later.";
        }
        header('Content-Type: application/json');
        echo json_encode($response);
    }
}
?>