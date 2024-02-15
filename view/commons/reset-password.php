<?php
session_start();
include_once '../../model/role_model.php';
if (!isset($_SESSION['user']) || !isset($_SESSION['user']['role_id'])) {
    // Redirect to the login page
    header("Location: http://localhost/BcsKSM/view/login/login.php");
    exit(); // Make sure to exit after a header redirect
}

$userRoleID = $_SESSION['user']['role_id'];
$userID = $_SESSION['user']['user_id'];
include_once '../../model/user_model.php';
$userObj = new user();
$userResult = $userObj->getUserdetails();

?>


<html>

<head>
    <title>Restaurant Management System</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <link rel="stylesheet" type="text/css" href="../style/style.css">
    <link rel="stylesheet" type="text/css" href="../style/colors.css">
</head>

<body>
    <!--      navbar-->
    <?php
    include 'header.php';
    ?>

    
    <!--user navigation-->
    <?php
    // Include the sidebar file
    if ($userRoleID == 1) {
        include 'admin-navigation.php';
    } elseif ($userRoleID == 2) {
        include 'chef-navigation.php';
    } elseif ($userRoleID == 3) {
        include 'stock-manager-navigation.php';
    } elseif ($userRoleID == 4) {
        include 'cashier-navigation.php';
    }
    ?>
    <div class="container-fluid common-container  justify-content-center ">
        <div class="d-flex resetCardRow  align-items-center justify-content-center">
            <div class="col-auto   justify-content-center ">
                    <div class="card  PasswordResetCard">
                        <div class="card-header  ResetPassword-card-header p-2">
                        <h3 class="card-title text-center">Password Reset</h3>
                        </div>
                        <div class="card-body mt-4">
    <form id="reset-password" onsubmit="return resetPassword(<?php echo $userID ?>,event)">
        <div class="row m-0 ">
            <!-- Current Password -->
            <div class="input-group  justify-content-center mb-4 ">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroup-sizing-default">Current Password</span>
                </div>
                <input type="password" class="form-control row" id="currentPassword" name="currentPassword" required>  
            </div>

            <!-- New Password -->
            <div class="input-group  justify-content-center mb-2 ">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroup-sizing-default">New Password</span>
                </div>
                <input  type="password" class="form-control row" id="newPassword" name="newPassword" onkeyup="checkPasswordStrength()" required>          
            </div>
            <div class="row " id="password-strength-status"></div>
            <!-- Confirm Password -->
            <div class="input-group justify-content-center mt-2 mb-2 ">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroup-sizing-default">Confirm Password</span>
                </div>
             
                <input type="password" class="form-control row" id="confirmPassword" name="confirmPassword" required>


                </div>
                <div class="row m-0 password-match-status mb-4"></div>
        </div>

        <div class="row justify-content-center">
            <button type="submit" class="btn btn-outline-primary col-auto btn-block">Reset Password</button>
        </div>
    </form>
</div>

                    </div>
            </div>
        </div>
    </div>


    <script type="text/javascript" src="reset-password.js"></script>
    <script type="text/javascript" src="../../commons/clock.js"></script>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
    crossorigin="anonymous"></script>

</html>