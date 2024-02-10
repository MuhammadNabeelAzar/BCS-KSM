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
    <link rel="stylesheet" type="text/css" href="../../../style/style.css">
    <link rel="stylesheet" type="text/css" href="../../../style/colors.css">
</head>

<body>
    <!--      navbar-->
    <?php
    include '../../../commons/header.php';
    ?>

    <?php
    if (isset($_GET["msg"])) {
        $msg = base64_decode($_GET["msg"]);
        ?>
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <div class="d-flex justify-content-between align-items-center">
                <p class="mb-0">
                    <?php echo $msg; ?>
                </p>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                </button>
            </div>
        </div>

        <?php
    }
    ?>

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
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-9 justify-content-center">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="col-md-3 mb-2 mt-2">
                        <input type="text" id="seachBar" class="form-control" placeholder="Search"
                            aria-label="searchbar" aria-describedby="search" onkeyup="search()">
                    </div>
                    <div class="col-md-auto mb-2 mt-2" style="height:30px">
                        <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal"
                            data-bs-target="#add-userModal">
                            <i class="bi bi-person-plus"></i>
                        </button>
                    </div>
                </div>
                <div class="table-responsive tableRowLg">
                    <table class="table table-hover   table-striped  ">
                        <thead class="table-header table-header-lg text-center ">
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
                                <tr class="userRow table-light text-center">

                                    <td >
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
                                    <td><a class="btn btn-outline-primary"
                                            href="edit-user.php?id=<?php echo $userrow["user_id"] ?>"><i
                                                class="bi bi-pencil-square"> Edit</i></a></td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>


        <div class="modal fade" id="add-userModal" tabindex="-1" aria-labelledby="add_user" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="adduser_Modal"><strong>Add User</strong></h5>
                        <button type="button" class="btn-close modalclosetbtn" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                    </div>
                    <div class="modal-body">
                        <form id="adduserform" action="../../../../controller/user_controller.php"
                            enctype="multipart/form-data" method="post">
                            <div class="col">
                                <div id="response">

                                </div>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text " id="Fname">First Name</span>
                                    </div>
                                    <input type="text" class="form-control" name="Fname" id="firstName"
                                        aria-label="First Name" aria-describedby="Fname" maxlength="30" required>
                                </div>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="Lname">Last Name</span>
                                    </div>
                                    <input type="text" class="form-control" name="Lname" id="lastName"
                                        aria-label="Last Name" aria-describedby="Lname" maxlength="30" required>
                                </div>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="Email">Email</span>
                                    </div>
                                    <input type="text" class="form-control" name="Email" id="user_Email"
                                        aria-label="User Email" aria-describedby="Email" maxlength="100" required>
                                </div>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="Unic">NIC</span>
                                    </div>
                                    <input type="text" class="form-control" name="Unic" id="user_Nic"
                                        aria-label="User Nic" aria-describedby="Unic" maxlength="20" required>
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
                                        aria-label="User Contact" aria-describedby="Contact" maxlength="15" required>
                                </div>
                            </div>
                            <div class=" d-flex flex-column">
                                <select class="forms-select mb-3" name="userRole" id="userRole" aria-label="Users Role"
                                    required>
                                    <option disabled selected value="">Select</option>
                                    <?php
                                    while ($role = $addroleResult->fetch_assoc()) {
                                        echo '<option value=' . $role['role_id'] . '>' . $role['role_name'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Cancel</button>
                                <button id="adduserButton" type="submit" class="btn btn-outline-success">Add User</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
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