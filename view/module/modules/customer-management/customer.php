<?php 
session_start();
include_once '../../../../model/role_model.php';
if (!isset($_SESSION['user']) || !isset($_SESSION['user']['role_id'])) {
    // Redirect to the login page
    header("Location: http://localhost/BcsKSM/view/login/login.php");
    exit(); // Make sure to exit after a header redirect
}

$userRoleID = $_SESSION['user']['role_id'];
include_once '../../../../model/customer_model.php';
$customerObj = new customer();
$customerResult = $customerObj->getcustomerdetails();
?>
<html>
    <head>
        <title>Restaurant Management System</title>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">   
        <link rel="stylesheet" type="text/css" href="../../../../style/style.css">
    </head>
    <body>
        <!--      navbar-->
        <nav class="navbar navbar-expand-sm navbar-light bg-light"style="height:70px">
            <div class="container-fluid">
                <div class="d-flex flex-column datetime m-2">
                    <div class="date">
                        <span id="dayname">Day</span>
                        <span id="month">Month</span>:
                        <span id="daynum">00</span>
                        <span id="year">Year</span>
                    </div>
                    <div class="time">
                        <span id="hour">00</span>:
                        <span id="minutes">00</span>:
                        <span id="seconds">00</span>:
                        <span id="period">AM</span>
                    </div>

                </div>

                <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto"> <!-- Use "ml-auto" to push items to the right -->
                        <button type="button" class="btn btn-light" id="bell"><i class="bi  bi-bell"></i></button>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Account
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="#"><Span><i class="bi bi-lock"></i></Span>Settings</a></li>
                                <li><a class="dropdown-item" href="#"><span><i class="bi bi-box-arrow-right"></i></span>Logout</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <a class="btn btn-primary" data-bs-toggle="offcanvas" href="#offcanvasExample" role="button" aria-controls="offcanvasExample">
            <i class="bi bi-list"></i>
        </a>
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

        </div>
        <!--user navigation-->
        <div class="container  justify-content-center align-items-center" style="width:100%;">
        <input class="form-control "  id="seachBar" type="search" placeholder="Search" aria-label="Search" onkeyup="search()">
                            <button class="btn btn-outline-success " type="submit">Search</button>
    <button type="button" class="btn bi bi-plus" data-bs-toggle="modal" data-bs-target="#addcustomerModal"></button>
</div>
        <div>
            
            <div class="table-responsive">
                <table class="table">
                    <thead>
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
                          While($customerrow=$customerResult->fetch_assoc())
                          {
                              $customer_id=$customerrow["customer_id"];
                              $customer_id= base64_encode($customer_id)
                          ?>
                        <tr class="customerdetailsrow">
                            <td><?php echo $customerrow["customer_id"] ?></td>
                            <td><?php echo $customerrow["customer_fname"]."".$customerrow["customer_lname"] ?></td>
                            <td><?php echo $customerrow["customer_email"] ?></td>
                            <td><?php echo $customerrow["contact_number"] ?></td>
                            <td><button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editcustomerModal">1</button></td>
                        </tr>
                        <?php
                          }
                          ?>
                    </tbody>
                </table>
                
            </div>
            <div class=" modal fade" id="editcustomerModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class=" modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editcustomerModalLabel"  style="text-align:center">Edit</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form>
                                <div class="col">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="Fname">First Name</span>
                                        </div>
                                        <input type="text" class="form-control" id="cfirstName" placeholder="" aria-label="Customer First Name" aria-describedby="Customer Fname" maxlength="30" required>
                                    </div>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="Lname">Last Name</span>
                                        </div>
                                        <input type="text" class="form-control" id="clastName" placeholder="" aria-label="CLast Name" aria-describedby="Customer Lname" maxlength="30" required>
                                    </div>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="Email">Email</span>
                                        </div>
                                        <input type="text" class="form-control" id="cus_Email" placeholder="" aria-label="customer Email" aria-describedby="customers email" maxlength="100" required>
                                    </div>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="Unic">Contact Number</span>
                                        </div>
                                        <input type="text" class="form-control" id="cus_Contact" placeholder="" aria-label="Customer contact" aria-describedby="customercont" maxlength="20" required>
                                    </div>                                   
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary">Save changes</button>
                        </div>
                    </div>
                </div>
            </div>           
            <div class=" modal fade" id="addcustomerModal" tabindex="-1" aria-labelledby="addcustomerModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class=" modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addcustomerModalLabel"  style="text-align:center">Edit</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form>
                                <div class="col">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="Fname">First Name</span>
                                        </div>
                                        <input type="text" class="form-control" id="cfirstName" placeholder="" aria-label="Customer First Name" aria-describedby="Customer Fname" maxlength="30" required>
                                    </div>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="Lname">Last Name</span>
                                        </div>
                                        <input type="text" class="form-control" id="clastName" placeholder="" aria-label="CLast Name" aria-describedby="Customer Lname" maxlength="30" required>
                                    </div>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="Email">Email</span>
                                        </div>
                                        <input type="text" class="form-control" id="cus_Email" placeholder="" aria-label="customer Email" aria-describedby="customers email" maxlength="100" required>
                                    </div>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="Unic">Contact Number</span>
                                        </div>
                                        <input type="text" class="form-control" id="cus_Contact" placeholder="" aria-label="Customer contact" aria-describedby="customercont" maxlength="20" required>
                                    </div>                                   
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" onclick="addcustomer()">Add</button>
                        </div>
                    </div>
                </div>
            </div>           
        </div>
         
        <script type="text/javascript" src="../../../../commons/clock.js"></script>
        <script type="text/javascript" src="customer.js"></script>
    </body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</html>