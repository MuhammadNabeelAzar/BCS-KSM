<?php
include_once '../../../../model/menu_model.php';
$menuObj = new menu();
$categoryResult = $menuObj->getcategories();

?>
<html>

<head>
    <title>Restaurant Management System</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
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
                            <li class="list-group-item"><a href="../../admin/user-management/user.php">Users</a>
                            </li>
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
                            <li class="list-group-item"><a href="../../admin/menu-management/items.php">Items</a>
                            </li>
                            <li class="list-group-item"><a
                                    href="../../admin/menu-management/pricing.php">Pricing</a></li>
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
                                    href="../../admin/ingredients-management/ingredients.php">Ingredients</a>
                            </li>
                            <li class="list-group-item"><a
                                    href="../../admin/ingredients-management/stock.php">Stock</a></li>
                        </ul>
                    </div>
                </li>
                <li class="list-group-item">
                    <a href="#" data-bs-toggle="collapse" data-bs-target="#financialManagementSubMenu">Financial
                        Management</a>
                    <!-- Sublist -->
                    <div id="financialManagementSubMenu" class="collapse">
                        <ul class="list-group">
                            <li class="list-group-item"><a
                                    href="../../admin/financial-management/sales.php">Sales</a></li>
                        </ul>
                    </div>
                </li>
                <li class="list-group-item">
                    <a href="#" data-bs-toggle="collapse" data-bs-target="#customerSubMenu">Customer Management</a>
                    <!-- Sublist -->
                    <div id="customerSubMenu" class="collapse">
                        <ul class="list-group">
                            <li class="list-group-item"><a
                                    href="../../admin/customer-management/customer.php">Customers Details</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="list-group-item">
                    <a href="../../dashboards/dashboard.php">Dashboard</a>
                </li>

            </ul>
        </div>
    </div>
    <!--user navigation-->
    <div class="row">
        <a type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
            <span><i class="bi bi-plus"></i></span>
        </a>
    </div>
    <div class="row">
        <?php 
        if(isset($_GET['msg'])){
            $msg = base64_decode($_GET['msg']); ?>
            <p><?php echo $msg ?><p>
           <?php 
        }
        ?>
    </div>
    <div class="row" style="background-color:black">
        <?php
        while ($categoryrow = $categoryResult->fetch_assoc()) {
            $categoryid = $categoryrow["category_id"];
            $fooditemResult = $menuObj->getfoodItems(); //get all the foodItems
            ?>
            <div class="col-md-3">
                <div class="card">
                    <h5 class="card-header">
                    <input type="hidden" id="hiddenField" name="HiddenFoodID" value="<?php echo $categoryrow['category_id']; ?>">
                        <?php echo $categoryrow['category_name']; ?>
                        <button type="button" class="btn btn-primary" onclick="deletecategory(<?php echo $categoryid ?>)"><i class="bi bi-trash"></i></button>
                    </h5>
                    <div class="card-body">
                    <ul class="list-group">
                    <div class="row">
                        <?php 
                        while($foodrow = $fooditemResult->fetch_assoc()){ 
                            if($foodrow['category_id'] == $categoryid){ //display the food items if the categoryid matches the food item category id
                            ?>
                    <li class="list-group-item">
                    <form action="../../../../controller/menu_controller.php?status=remove-foodItem" enctype="multipart/form-data" method="post">
                    <input type="hidden" id="hiddenField" name="HiddenFoodID" value="<?php echo $foodrow['food_itemId']; ?>">
                    <input type="hidden" id="hiddenField" name="foodname" value="<?php echo $foodrow['item_name']; ?>">
                    <a><?php echo $foodrow['item_name'] . " " . $foodrow['price'] ." "  ?></a><button type="submit" class="btn btn-Danger"><i class="bi bi-file-minus"></i></button>
                            </form>
                </li>
                     <?php }}  ?>
                    </div>
                    </ul>
                    </div>
                </div>
            </div>
        <?php
        }
        ?>
    </div>

    <div class="modal fade" id="addCategoryModal" tabindex="-1" role="dialog" aria-labelledby="addCategoryModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Category</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="../../../../controller/menu_controller.php?status=add-category" enctype="multipart/form-data" method="post">
                        <div class="form-group">
                            <input type="text" class="form-control" id="Category"
                               name="Category" aria-describedby="newCategory" placeholder="Category Name" required> 
                        </div>
                        <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
                    </form>
                </div>
                
            </div>
        </div>
    </div>

    <div class="modal fade" id="deleteCategoryModal" tabindex="-1" role="dialog" aria-labelledby="deleteCategoryModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteCategoryModalLabel">Modal title</h5>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="../../../../controller/menu_controller.php?status=delete-category" enctype="multipart/form-data" method="post">
        <input type="hidden" id="CategoryId" name="categoryId" >
        <p>Are you sure you want  to delete this category ?</p>
        <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Delete</button>
      </div>
        </form>
      </div>
      
    </div>
  </div>
</div>
    <script type="text/javascript" src="../../../../commons/clock.js"></script>
    <script type="text/javascript" src="category.js"></script>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
    crossorigin="anonymous"></script>

</html>