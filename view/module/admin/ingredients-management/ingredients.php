<?php
include_once '../../../../model/ingredients_model.php';
$ingredientObj = new ingredient();
$ingResult = $ingredientObj->getAllingredients();
$ingfactorResult = $ingredientObj->getfactors();

?>
<html>

<head>
    <title>Restaurant Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
</head>

<body>

    <!--      navbar-->
    <nav class="navbar navbar-expand-sm navbar-light bg-light" style="height:70px">
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
                            <li><a class="dropdown-item" href="#"><span><i
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
                        <a href="../../module/chef/orders/orders.php" data-bs-toggle="collapse" >Orders</a>
                        
                    </li>
                <li class="list-group-item">
                    <a href="../../dashboards/dashboard.php">Dashboard</a>
                </li>

            </ul>
        </div>

    </div>
    <!--user navigation-->
    <div class="row">
        <div class="col-md-3" style="background-color:black">
            <div class="accordion">
                <div class="row">
                    <form class="form-inline">
                        <input class="form-control " type="search" placeholder="Search" aria-label="Search">
                        <button class="btn btn-outline-success " type="submit">Search</button>

                    </form>
                    <ul class="list-group">
                        <?php
                        while ($ingrow = $ingResult->fetch_assoc()) {
                            $ing_id = $ingrow["ing_id"];
                            $ing_id = base64_encode($ing_id);
                            ?>
                            <a type="button" class="list-group-item" href="edit-ingredients.php?status=edit-ingredient&ingid=<?php echo $ing_id ?>">
                                <?php echo $ingrow["ing_name"] ?>
                        </a> 
                        <?php } ?>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col" style="background-color:yellow">
            <div class="row">
                <form action="../../../../controller/ingredients_controller.php?status=add-ingredient"
                    enctype="multipart/form-data" method="post">
                    <div class="row" id="errormsg">
                        <?php
                        if (isset($_GET["addmsg"])) {
                            $addmsg = base64_decode($_GET["addmsg"]);
                            ?>
                            <div class="row">
                                <p>
                                    <?php echo $addmsg; ?>
                                </p>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Ingredient Name</span>
                        </div>
                        <input type="text" class="form-control" aria-label="Default" aria-describedby="inputGroup"
                            name="ing_Name">
                    </div>
                    <div class="input-group">
                        <label for="exampleFormControlTextarea1">Description</label>
                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"
                            name="ing_descript"></textarea>
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <input type="file" class="form-control" aria-label="Default" aria-describedby="inputGroup"
                                name="ing_image" id="ing_image" >
                        </div>   
                        <select class="forms-select mb-3" name="factors" id="factors" aria-label="factors" required>
    <option disabled selected value="">Select</option>
    <?php
    while ($factor = $ingfactorResult->fetch_assoc()) {
        echo '<option value="' . $factor['factor_id'] . '">' . $factor['factorsf'] . '</option>';
    }
    ?>
</select>
      
                        <div class="col-md-3">
                        <img id="imgprev" src="" alt="Image Preview" style="height: 100px; width: 100px;">
                                </div>

                    </div>
                    <button type="submit" class="btn btn-primary">
                        Add
                    </button>
                </form>
            </div>
        </div>
    </div>
  </div>
</div>

    <script type="text/javascript" src="../../../../commons/clock.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

        </script>
    <script>
            $(document).ready(() => {
                $("#ing_image").change(function () {
                    const file = this.files[0];
                    if (file) {
                        let reader = new FileReader();
                        reader.onload = function (event) {
                            $("#imgprev")
                              .attr("src", event.target.result);
                        };
                        reader.readAsDataURL(file);
                    }
                });
            });
        </script>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
    crossorigin="anonymous"></script>

</html>