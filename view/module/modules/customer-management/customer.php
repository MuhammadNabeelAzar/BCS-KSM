<?php
session_start();
include_once '../../../../model/role_model.php';
if (!isset($_SESSION['user']) || !isset($_SESSION['user']['role_id'])) {
    // Redirect to the login page
    header("Location: http://localhost/BcsKSM/view/login/login.php");
    exit(); // Make sure to exit after a header redirect
}

$userRoleID = $_SESSION['user']['role_id'];
    // Redirect to the home page
    switch ($userRoleID) {
        case 2:
            header("Location: http://localhost/BcsKSM/view/users/chef/chef.php");
            break;
        case 3:
            header("Location: http://localhost/BcsKSM/view/users/stock-manager/stockmanager.php");
            break;
        }
include_once '../../../../model/customer_model.php';
$customerObj = new customer();
$customerResult = $customerObj->getcustomerdetails();
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
    <?php
    include '../../../commons/header.php';
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

    <!--user navigation-->
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
                            data-bs-target="#addcustomerModal">
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
                        <th scope="col">Email</th>
                        <th scope="col">Contact Number</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($customerrow = $customerResult->fetch_assoc()) {
                        $customer_id = $customerrow["customer_id"];
                        $customer_id = base64_encode($customer_id)
                            ?>
                        <tr class="customerdetailsrow table-light text-center">
                            <td>
                                <?php echo $customerrow["customer_id"] ?>
                            </td>
                            <td>
                                <?php echo $customerrow["customer_fname"] . " " . $customerrow["customer_lname"] ?>
                            </td>
                            <td>
                                <?php echo $customerrow["customer_email"] ?>
                            </td>
                            <td>
                                <?php echo $customerrow["contact_number"] ?>
                            </td>
                            <td><button type="button" class="btn btn-outline-primary" onclick="editCustomer(<?php echo htmlentities(json_encode($customerrow)); ?>)"><i class="bi bi-pencil-square"></button></td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <div class=" modal fade" id="editcustomerModal" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class=" modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editcustomerModalLabel" style="text-align:center">Edit</h5>
                        <button type="button" class="btn-close modalclosetbtn" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="col">
                                <input type="hidden" class="form-control" id="customerID">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="Fname">First Name</span>
                                    </div>
                                    <input type="text" class="form-control" id="cfirstName" placeholder=""
                                        aria-label="Customer First Name" aria-describedby="Customer Fname"
                                        maxlength="30" required>
                                </div>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="Lname">Last Name</span>
                                    </div>
                                    <input type="text" class="form-control" id="clastName" placeholder=""
                                        aria-label="CLast Name" aria-describedby="Customer Lname" maxlength="30"
                                        required>
                                </div>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="Email">Email</span>
                                    </div>
                                    <input type="text" class="form-control" id="cus_Email" placeholder=""
                                        aria-label="customer Email" aria-describedby="customers email" maxlength="100"
                                        required>
                                </div>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="CNo">Contact Number</span>
                                    </div>
                                    <input type="number"  class="form-control" id="cus_Contact" placeholder=""
                                        aria-label="Customer contact" aria-describedby="customercont" maxlength="20"
                                        required>
                                </div>
                            </div>
                        </form>
                        <div class="row  justify-content-end">
                        <div class="col-auto">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                        </div>   
                        <div class="col-auto">
                        <button type="button" class="btn btn-outline-primary" onclick="updatecustomer()">Update</button>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
        <div class=" modal fade" id="addcustomerModal" tabindex="-1" aria-labelledby="addcustomerModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class=" modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addcustomerModalLabel" style="text-align:center">Add</h5>
                        <button type="button" class="btn-close modalclosetbtn" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="col">
                            <input type="hidden" class="form-control" id="customerID">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="Fname">First Name</span>
                                    </div>
                                    <input type="text" class="form-control" id="cfirstName" placeholder=""
                                        aria-label="Customer First Name" aria-describedby="Customer Fname"
                                        maxlength="30" required>
                                </div>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="Lname">Last Name</span>
                                    </div>
                                    <input type="text" class="form-control" id="clastName" placeholder=""
                                        aria-label="CLast Name" aria-describedby="Customer Lname" maxlength="30"
                                        required>
                                </div>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="Email">Email</span>
                                    </div>
                                    <input type="text" class="form-control" id="cus_Email" placeholder=""
                                        aria-label="customer Email" aria-describedby="customers email" maxlength="100"
                                        required>
                                </div>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="Unic">Contact Number</span>
                                    </div>
                                    <input type="number" class="form-control" id="cus_Contact" placeholder=""
                                        aria-label="Customer contact" aria-describedby="customercont" maxlength="20"
                                        required>
                                </div>
                            </div>
                        </form>
                        <div class="row  justify-content-end">
                        <div class="col-auto">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                        </div>   
                        <div class="col-auto">
                        <button type="button" class="btn btn-outline-primary" onclick="addcustomer()">Add</button>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript" src="../../../../commons/clock.js"></script>
    <script type="text/javascript" src="customer.js"></script>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
    crossorigin="anonymous"></script>

</html>