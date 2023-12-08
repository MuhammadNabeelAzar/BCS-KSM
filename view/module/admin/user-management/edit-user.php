<?php
include_once '../../../../model/user_model.php';
$userObj = new user();
$editroleResult = $userObj->getroles();

$user_id = $_GET['id'];
$userResult = $userObj->getaspecificuser($user_id);
$userrow = $userResult->fetch_assoc();
?>


<html>

<head>
    <title>Restaurant Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <link rel="stylesheet" type="text/css" href="../../../../style/style.css">
</head>

<body>
    <!--      navbar-->
    <nav class="navbar navbar-expand-sm navbar-light bg-light ">
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
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Account
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="#"><Span><i class="bi bi-lock"></i></Span>Settings</a>
                            </li>
                            <li><a class="dropdown-item" href="../../../../controller/logout_controller.php"><span><i
                                            class="bi bi-box-arrow-right"></i></span>Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <a class="btn btn-primary" data-bs-toggle="offcanvas" href="#offcanvasExample" role="button"
        aria-controls="offcanvasExample">
        <i class="bi bi-list"></i>
    </a>
    <a class="btn btn-primary" href="user.php">Back</a>
    <hr>
    <!--user navigation-->
    <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel"
        style="width:fit-content">
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
                            <li class="list-group-item"><a
                                    href="../../admin/menu-management/categories.php">Categories</a></li>
                            <li class="list-group-item"><a href="../../admin/menu-management/items.php">Items</a></li>
                            <li class="list-group-item"><a href="../../admin/menu-management/recipe.php">Recipes</a>
                            </li>
                            <li class="list-group-item"><a href="../../admin/menu-management/pricing.php">Pricing</a>
                            </li>
                            <li class="list-group-item"><a
                                    href="../../admin/menu-management/availability.php">Availability</a></li>
                        </ul>
                    </div>
                </li>
                <li class="list-group-item">
                    <a href="#" data-bs-toggle="collapse" data-bs-target="#ingredientsManagementSubMenu">Ingredients
                        Management</a>
                    <!-- Sublist -->
                    <div id="ingredientsManagementSubMenu" class="collapse">
                        <ul class="list-group">
                            <li class="list-group-item"><a
                                    href="../../admin/ingredients-management/ingredients.php">Ingredients</a></li>
                            <li class="list-group-item"><a href="../../admin/ingredients-management/stock.php">Stock</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="list-group-item">
                    <a href="#" data-bs-toggle="collapse" data-bs-target="#financialManagementSubMenu">Financial
                        Management</a>
                    <!-- Sublist -->
                    <div id="financialManagementSubMenu" class="collapse">
                        <ul class="list-group">
                            <li class="list-group-item"><a href="../../admin/financial-management/sales.php">Sales</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="list-group-item">
                    <a href="#" data-bs-toggle="collapse" data-bs-target="#customerSubMenu">Customer Management</a>
                    <!-- Sublist -->
                    <div id="customerSubMenu" class="collapse">
                        <ul class="list-group">
                            <li class="list-group-item"><a href="../../admin/customer-management/customer.php">Customers
                                    Details</a></li>
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
    <div class="container">
        <div class="row justify-content-center">
            <form action="../../../../controller/user_controller.php?status=edit-user" enctype="multipart/form-data"
                method="post">
                <div class="row">
                    <?php
                    if (isset($_GET["msg"])) {
                        $msg = base64_decode($_GET["msg"]);
                        ?>
                        <div class="row">
                            <div class="col-md-6 col-md-offset-3">
                                <p>
                                    <?php echo $msg; ?>
                                </p>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                </div>
                <input type="hidden" name="user_id" value="<?php echo $user_id ?>" />

                <div class="col">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="F-name">First Name</span>
                        </div>
                        <input type="text" class="form-control" id="firstName" name="users_fname"
                            value="<?php echo $userrow['Fname'] ?>">
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="L-name">Last Name</span>
                        </div>
                        <input type="text" class="form-control" id="lastName" name="users_lname"
                            value="<?php echo $userrow['Lname'] ?>">
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="Email">Email</span>
                        </div>
                        <input type="text" class="form-control" id="user_Email" name="users_email"
                            value="<?php echo $userrow['user_email'] ?>">
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="Unic">NIC</span>
                        </div>
                        <input type="text" class="form-control" id="user_Nic" name="users_nic"
                            value="<?php echo $userrow['user_nic'] ?>">
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="Udob">Date of birth</span>
                        </div>
                        <input type="date" class="form-control" id="user_dob" name="users_dob"
                            value="<?php echo $userrow['user_dob'] ?>">
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="Contact">Contact Number</span>
                        </div>
                        <input type="text" class="form-control" id="user_Contact" name="users_cno"
                            value="<?php echo $userrow['user_contactNo'] ?>">
                    </div>
                </div>

                <div class=" d-flex flex-column">
                    <select class="forms-select mb-3" id="userRole" aria-label="Users Role" name="users_role" required>
                        <option value="">----</option>
                        <?php
                        while ($rolerow = $editroleResult->fetch_assoc()) {
                            ?>
                            <option name="user_role" value="<?php echo $rolerow["role_id"]; ?>" <?php
                               if ($userrow["role_id"] == $rolerow["role_id"]) {
                                   ?> selected="selected" <?php
                               }
                               ?>>
                                <?php echo $rolerow["role_name"]; ?>
                            </option>
                            <?php
                        }
                        ?>
                    </select>
                </div>
                <div class="row">
                    <div class="col-md-6 col-md-offset-3">
                        <input type="submit" class="btn btn-Primary" value="Save" />
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-md-offset-3">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#removeUserModal">Delete
                        </button>
                    </div>
                </div>
        </div>
        </form>

    </div>
    <div class="modal fade" id="removeUserModal" tabindex="-1" role="dialog" aria-labelledby="RemoveusermodalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="removeUsertitle">Modal title</h5>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Are you sure?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <a type="button" class="btn btn-primary" href="../../../../controller/user_controller.php?status=delete-user&userid=<?php echo $user_id?>">Remove User</a>
      </div>
    </div>
  </div>
</div>
    
    <script type="text/javascript" src="edituser.js"></script>
    <script type="text/javascript" src="../../../../commons/clock.js"></script>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
    crossorigin="anonymous"></script>

</html>