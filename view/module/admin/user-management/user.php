<?php 
include_once '../../../../model/user_model.php';
$userObj = new user();
$userResult = $userObj->getUserdetails();
?>


<html>
    <head>
        <title>Restaurant Management System</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">    
        <link rel="stylesheet" type="text/css" href="../../../../style/style.css">
    </head>
    <body>
            <!--      navbar-->
            <nav  class="navbar navbar-expand-sm navbar-light bg-light ">
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
                                <li><a class="dropdown-item" href="../../../../controller/logout_controller.php"><span><i class="bi bi-box-arrow-right"></i></span>Logout</a></li>
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
        <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel" style="width:fit-content">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="offcanvasExampleLabel"></h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <ul class="list-group">
                    <li class="list-group-item">
                        <a href="#" data-bs-toggle="collapse" data-bs-target="#userManagementSubMenu">User Management</a>
                        <!-- Sublist -->
                        <div id="userManagementSubMenu" class="collapse">
                            <ul class="list-group">
                                <li class="list-group-item"><a href="../../admin/user-management/user.php">Users</a></li>
                            </ul>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <a href="#" data-bs-toggle="collapse" data-bs-target="#menuManagementSubMenu">Menu Management</a>
                        <!-- Sublist -->
                        <div id="menuManagementSubMenu" class="collapse">
                            <ul class="list-group">
                                <li class="list-group-item"><a href="../../admin/menu-management/categories.php" >Categories</a></li>
                                <li class="list-group-item"><a href="../../admin/menu-management/items.php">Items</a></li>
                                <li class="list-group-item"><a href="../../admin/menu-management/pricing.php">Pricing</a></li>
                                <li class="list-group-item"><a href="../../admin/menu-management/availability.php">Availability</a></li> 
                            </ul>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <a href="#" data-bs-toggle="collapse" data-bs-target="#ingredientsManagementSubMenu">Ingredients Management</a>
                        <!-- Sublist -->
                        <div id="ingredientsManagementSubMenu" class="collapse">
                            <ul class="list-group">
                                <li class="list-group-item"><a href="../../admin/ingredients-management/ingredients.php">Ingredients</a></li>
                                <li class="list-group-item"><a href="../../admin/ingredients-management/stock.php">Stock</a></li>
                            </ul>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <a href="#" data-bs-toggle="collapse" data-bs-target="#financialManagementSubMenu">Financial Management</a>
                        <!-- Sublist -->
                        <div id="financialManagementSubMenu" class="collapse">
                            <ul class="list-group">
                                <li class="list-group-item"><a href="../../admin/financial-management/sales.php">Sales</a></li>
                            </ul>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <a href="#" data-bs-toggle="collapse" data-bs-target="#customerSubMenu">Customer Management</a>
                        <!-- Sublist -->
                        <div id="customerSubMenu" class="collapse">
                            <ul class="list-group">
                                <li class="list-group-item"><a href="../../admin/customer-management/customer.php">Customers Details</a></li>
                            </ul>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <a href="../../dashboards/dashboard.php">Dashboard</a>
                    </li>

                </ul>
            </div>

        </div>
        <!--user navigation end-->
            <div class="container  justify-content-center align-items-center" style="width:100%;">
            <div class="input-group mb-3">
  <input type="text" class="form-control" placeholder="Search" aria-label="searchbar" aria-describedby="search">
  <div class="input-group-append">
      <button class="btn btn-outline-secondary" type="button"><i class="bi bi-search"></i></button>
  </div>
  <button type="button" class="btn bi bi-plus" data-bs-toggle="modal" data-bs-target="#add-userModal"></button>
   <div class=" modal fade" id="add-userModal" tabindex="-1" aria-labelledby="add_user" aria-hidden="true">
                <div class="modal-dialog">
                    <div class=" modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="adduser_Modal"  style="text-align:center">Add User</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form>
                                            <div class="col">
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="Fname">First Name</span>
                                                    </div>
                                                    <input type="text" class="form-control" id="firstName" placeholder="User's First Name" aria-label="First Name" aria-describedby="Fname" maxlength="30" required>
                                                </div>
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="Lname">Last Name</span>
                                                    </div>
                                                    <input type="text" class="form-control" id="lastName" placeholder="User's Last Name" aria-label="Last Name" aria-describedby="Lname" maxlength="30" required>
                                                </div>
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="Email">Email</span>
                                                    </div>
                                                    <input type="text" class="form-control" id="user_Email" placeholder="User's Email" aria-label="User Email" aria-describedby="Email" maxlength="100" required>
                                                </div>
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="Unic">NIC</span>
                                                    </div>
                                                    <input type="text" class="form-control" id="user_Nic" placeholder="User's Nic" aria-label="User Nic" aria-describedby="Unic" maxlength="20" required>
                                                </div>
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="Userdob">Date of Birth</span>
                                                    </div>
                                                    <input type="Date" class="form-control" id="user_Dob"  aria-label="User Date of Birth" aria-describedby="Userdob"  required>
                                                </div>
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="Contact">Contact Number</span>
                                                    </div>
                                                    <input type="text" class="form-control" id="user_Contact" placeholder="User's Contact Number" aria-label="User Contact" aria-describedby="Contact" maxlength="15" required>
                                                </div>
                                            </div>
                                            <div class=" d-flex flex-column">
                                                <select class="forms-select mb-3" id="userRole" aria-label="Users Role" required>
                                                    <option  disabled selected value="">Select</option>
                                                    <option value="1">1</option>
                                                </select>
                                                <div class="mb-3">

                                                    <input class="form-control " type="file"  id="formFile" required>
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
</div
        </div>
            
            <div class="table-responsive" style="height:400px">
                <table class="table" >
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
                          While($userrow=$userResult->fetch_assoc())
                          {
                              $user_id=$userrow["user_id"];
                              $user_id= base64_encode($user_id)
                          ?>
                        <tr>

                            <td><?php echo $userrow["user_id"] ?></td>
                            <td><?php echo $userrow["Fname"]." ".$userrow["Lname"]?></td>
                            <td><?php echo $userrow["user_dob"] ?></td>
                            <td><?php echo $userrow["user_email"] ?></td>
                            <td><?php echo $userrow["user_nic"] ?></td>
                            <td><?php echo $userrow["user_contactNo"] ?></td>
                            <td><?php echo $userrow["role_name"] ?></td>
                            <td><button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editUserModal">1</button></td>

                        </tr>
                        <?php
                          }
                         ?>
                    </tbody>
                </table>
            </div>
            <div class=" modal fade" id="editUserModal" tabindex="-1" aria-labelledby="edituserModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class=" modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="Modaltitle"  style="text-align:center">Edit</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form>
                                            <div class="col">
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="F-name">First Name</span>
                                                    </div>
                                                    <input type="text" class="form-control" id="firstName" placeholder="User's First Name" aria-label="First Name" aria-describedby="Fname" maxlength="30" required>
                                                </div>
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="L-name">Last Name</span>
                                                    </div>
                                                    <input type="text" class="form-control" id="lastName" placeholder="User's Last Name" aria-label="Last Name" aria-describedby="Lname" maxlength="30" required>
                                                </div>
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="Email">Email</span>
                                                    </div>
                                                    <input type="text" class="form-control" id="user_Email" placeholder="User's Email" aria-label="User Email" aria-describedby="Email" maxlength="100" required>
                                                </div>
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="Unic">NIC</span>
                                                    </div>
                                                    <input type="text" class="form-control" id="user_Nic" placeholder="User's Nic" aria-label="User Nic" aria-describedby="Unic" maxlength="20" required>
                                                </div>
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="Userdob">Date of Birth</span>
                                                    </div>
                                                    <input type="Date" class="form-control" id="user_Dob"  aria-label="User Date of Birth" aria-describedby="Userdob"  required>
                                                </div>
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="Contact">Contact Number</span>
                                                    </div>
                                                    <input type="text" class="form-control" id="user_Contact" placeholder="User's Contact Number" aria-label="User Contact" aria-describedby="Contact" maxlength="15" required>
                                                </div>
                                            </div>
                                            <div class=" d-flex flex-column">
                                                <select class="forms-select mb-3" id="userRole" aria-label="Users Role" required>
                                                    <option  disabled selected value="">Select</option>
                                                    <option value="1">1</option>
                                                </select>
                                                <div class="mb-3">
                                                    <input class="form-control " type="file"  id="formFile" required>
                                                </div>
                                            </div>
                                        </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-Danger">Delete</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary">Save changes</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>





        
    </body>
    <script type="text/javascript">
            function updateClock() {
                var now = new Date();
                var dname = now.getDay(),
                        mo = now.getMonth(),
                        dnum = now.getDate(),
                        yr = now.getFullYear(),
                        hou = now.getHours(),
                        min = now.getMinutes(),
                        sec = now.getSeconds(),
                        pe = "AM";
                if (hou == 0) {
                    hou = 12;
                }
                if (hou > 12) {
                    hou = hou - 12;
                    pe = "PM";
                }
                Number.prototype.pad = function (digits) {
                    for (var n = this.toString(); n.length < digits; n = 0 + n)
                        ;
                    return n;

                }

                var months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
                var week = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
                var ids = ["dayname", "month", "daynum", "year", "hour", "minutes", "seconds", "period"];
                var values = [week[dname], months[mo], dnum.pad(2), yr, hou.pad(2), min.pad(2), sec.pad(2), pe];
                for (var i = 0; i < ids.length; i++)
                    document.getElementById(ids[i]).firstChild.nodeValue = values[i];
            }
            function initClock() {
                updateClock();
                window.setInterval(updateClock, 1000);
            }
            initClock();
        </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</html>