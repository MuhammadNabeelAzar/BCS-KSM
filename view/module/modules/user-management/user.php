<?php
session_start();
include_once '../../../../model/role_model.php';
if (!isset($_SESSION['user']) || !isset($_SESSION['user']['role_id'])) {
    // Redirect to the login page
    header("Location: http://localhost/BcsKSM/view/login/login.php");
    exit(); // Make sure to exit after a header redirect
}

$userRoleID = $_SESSION['user']['role_id'];
include_once '../../../../model/user_model.php';
$userObj = new user();
$userResult = $userObj->getUserdetails();
$addroleResult = $userObj->getroles();
$editroleResult = $userObj->getroles();

?>


<html>

<head>
    <title>Restaurant Management System</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <link rel="stylesheet" type="text/css" href="../../../../style/style.css">
</head>

<body>
    <!--      navbar-->
    <?php 
    include '../../../commons/header.php';
    ?>

    <a class="btn btn-primary" data-bs-toggle="offcanvas" href="#offcanvasExample" role="button"
        aria-controls="offcanvasExample">
        <i class="bi bi-list"></i>
    </a>
    <?php
    if (isset($_GET["msg"])) {
        $msg = base64_decode($_GET["msg"]);
        ?>
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <p>
            <div class="row">
                <p>
                    <?php echo $msg; ?>
                </p>
            </div>

            </p>
            <button type="button" class="close" data-bs-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <?php
    }
    ?>
    <hr>
    <!--user navigation-->
    <?php
    // Include the sidebar file
    if ($userRoleID == 1) {
        include '../../../commons/admin-navigation.php';
    } elseif ($userRoleID == 2) {
        include '../../../commons/chef-navigation.php';
    } elseif ($userRoleID == 3) {
        include '../../../commons/stock-manager-navigation.php';
    } elseif ($userRoleID == 4) {
        include '../../../commons/cashier-navigation.php';
    }
    ?>


    <!--user navigation end-->
    <div class="container  justify-content-center align-items-center" style="width:100%;">
        <div class="input-group mb-3">
            <input type="text" id="seachBar" class="form-control" placeholder="Search" aria-label="searchbar"
                aria-describedby="search" onkeyup="search()">
            <div class="input-group-append">
                <button class="btn btn-outline-secondary" type="button"><i class="bi bi-search"></i></button>
            </div>
            <button type="button" class="btn bi bi-plus" data-bs-toggle="modal"
                data-bs-target="#add-userModal"></button>
            <div class=" modal fade" id="add-userModal" tabindex="-1" aria-labelledby="add_user" aria-hidden="true">
                <div class="modal-dialog">
                    <div class=" modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="adduser_Modal" style="text-align:center">Add User</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="adduserform" action="../../../../controller/user_controller.php"
                                enctype="multipart/form-data" method="post">
                                <div class="col">
                                    <div id="response">

                                    </div>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="Fname">First Name</span>
                                        </div>
                                        <input type="text" class="form-control" name="Fname" id="firstName"
                                            placeholder="User's First Name" aria-label="First Name"
                                            aria-describedby="Fname" maxlength="30" required>
                                    </div>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="Lname">Last Name</span>
                                        </div>
                                        <input type="text" class="form-control" name="Lname" id="lastName"
                                            placeholder="User's Last Name" aria-label="Last Name"
                                            aria-describedby="Lname" maxlength="30" required>
                                    </div>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="Email">Email</span>
                                        </div>
                                        <input type="text" class="form-control" name="Email" id="user_Email"
                                            placeholder="User's Email" aria-label="User Email" aria-describedby="Email"
                                            maxlength="100" required>
                                    </div>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="Unic">NIC</span>
                                        </div>
                                        <input type="text" class="form-control" name="Unic" id="user_Nic"
                                            placeholder="User's Nic" aria-label="User Nic" aria-describedby="Unic"
                                            maxlength="20" required>
                                    </div>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="Userdob">Date of Birth</span>
                                        </div>
                                        <input type="Date" class="form-control" name="Userdob" id="user_Dob"
                                            aria-label="User Date of Birth" aria-describedby="Userdob" required>
                                    </div>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="Contact">Contact Number</span>
                                        </div>
                                        <input type="text" class="form-control" name="Contact" id="user_Contact"
                                            placeholder="User's Contact Number" aria-label="User Contact"
                                            aria-describedby="Contact" maxlength="15" required>
                                    </div>
                                </div>
                                <div class=" d-flex flex-column">
                                    <select class="forms-select mb-3" name="userRole" id="userRole"
                                        aria-label="Users Role" required>
                                        <option disabled selected value="">Select</option>
                                        <?php
                                        while ($role = $addroleResult->fetch_assoc()) {
                                            echo '<option value=' . $role['role_id'] . '>' . $role['role_name'] . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Cancel</button>
                                    <button id="adduserButton" type="submit" class="btn btn-primary">Add User</button>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="table-responsive" style="height:400px">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">Date of Birth</th>
                    <th scope="col">Email</th>
                    <th scope="col">NIC</th>
                    <th scope="col">Contact Number</th>
                    <th scope="col">Role</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($userrow = $userResult->fetch_assoc()) {
                    $user_id = $userrow["user_id"];
                    $user_id = base64_encode($user_id)
                        ?>
                    <tr class="userRow">

                        <td>
                            <?php echo $userrow["user_id"] ?>
                        </td>
                        <td>
                            <?php echo $userrow["Fname"] . " " . $userrow["Lname"] ?>
                        </td>
                        <td>
                            <?php echo $userrow["user_dob"] ?>
                        </td>
                        <td>
                            <?php echo $userrow["user_email"] ?>
                        </td>
                        <td>
                            <?php echo $userrow["user_nic"] ?>
                        </td>
                        <td>
                            <?php echo $userrow["user_contactNo"] ?>
                        </td>
                        <td>
                            <?php echo $userrow["role_name"] ?>
                        </td>
                        <td><a class="btn btn-primary" href="edit-user.php?id=<?php echo $userrow["user_id"] ?>">1</a></td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
    </div>

    <script type="text/javascript" src="adduser.js"></script>
    <script type="text/javascript" src="edituser.js"></script>
    <script type="text/javascript" src="user.js"></script>
    <script type="text/javascript" src="../../../../commons/clock.js"></script>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
    crossorigin="anonymous"></script>

</html>