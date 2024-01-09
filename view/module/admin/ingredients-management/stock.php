<!DOCTYPE html>
<?php
include_once '../../../../model/ingredients_model.php';
$ingredientObj = new ingredient();
$ingResult = $ingredientObj->getAllingredients();
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
                            <li class="list-group-item"><a href="../../admin/menu-management/recipe.php">Recipes</a>
                            </li>
                            <li class="list-group-item"><a
                                    href="../../admin/menu-management/pricing.php">Pricing</a></li>
                            <li class="list-group-item"><a
                                    href="../../admin/menu-management/availability.php">Availability</a></li>
                            <li class="list-group-item"><a
                                    href="../../admin/menu-management/stock.php">stock</a></li>
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
                        <a href="../../module/chef/orders/orders.php" data-bs-toggle="collapse" >Orders</a>
                        
                    </li>
                <li class="list-group-item">
                    <a href="../../dashboards/dashboard.php">Dashboard</a>
                </li>

            </ul>
        </div>

    </div>
    <!--user navigation-->
    
    <div class="row" style="background-color:yellow;">
    <div class="row">
    <div class="col-md-3">
    <input type="text" class="form-control" placeholder="Search" aria-label="searchbar"
                aria-describedby="search">
            <div class="input-group-append">
                <button class="btn btn-outline-secondary" type="button"><i class="bi bi-search"></i></button>
            </div>
    </div>
    </div>
    <div id="errormsg">
        <?php 
        if (isset($_GET["msg"])) {
            $msg = base64_decode($_GET["msg"]);
        echo $msg;
        }
        ?>
    </div>
    <?php
    while ($ingrow = $ingResult->fetch_assoc()){
        $ing_id = $ingrow["ing_id"];
    $ing_id = base64_encode($ing_id);

    //display the ingredients where the factor_id is not null
    
        ?>
        <div class="card" style="width: 18rem;margin:2px;">
            <img class="card-img-top" src="../../../<?php echo $ingrow["img_path"] ?>" alt="Card image cap">
            <div class="card-body">
                <input type="hidden" value="<?php echo $ingrow["ing_id"] ?>">
                <div class="row"><p class="card-title"><?php echo $ingrow["ing_name"] ?></p></div>
                <div class="row"><p class="card-title"><?php echo $ingrow["ing_description"] ?></p></div>
                <div class="row"><p class="card-title">Remaining: <?php 
                $remainingG = $ingrow["remaining_qty(g)"];
                $remainingKg = $ingrow["remaining_qty(kg)"];
                $remainingL = $ingrow["remaining_qty(l)"];
                $remainingMl = $ingrow["remaining_qty(ml)"];
                $remainingOz = $ingrow["remaining_qty(oz)"];
                $remainingLb = $ingrow["remaining_qty(lb)"];
                $remainingNos = $ingrow["remaining_qty(nos)"];
                $factorsf = $ingrow["factorsf"];

                if ($factorsf === 'g') {
                    echo intval($remainingG) ." " . $factorsf ; // Display as an integer
                } else if ($factorsf ==='kg') {
                    echo intval($remainingKg) ." " . $factorsf ; // Display as an integer
                }
                 else if ($factorsf ==='ml') {
                    echo intval($remainingMl) ." " . $factorsf ; // Display as an integer
                }
                 else if ($factorsf ==='l') {
                    echo intval($remainingL) ." " . $factorsf ; // Display as an integer
                }
                 else if ($factorsf ==='oz') {
                    echo intval($remainingOz) ." " . $factorsf ; // Display as an integer
                }
                 else if ($factorsf ==='lb') {
                    echo intval($remainingLb) ." " . $factorsf ; // Display as an integer
                }
                 else if ($factorsf ==='nos') {
                    echo intval($remainingNos) ." " . $factorsf ; // Display as an integer
                }
                ?></p> 
                <button type="button" class="btn btn-primary"  id="editremQtybtn" onclick="editIng('<?php echo $ing_id ?>')">
  Launch demo modal
    </button></div>
            </div>
        </div>
    <?php 
    }
    ?>
    </div>
    <div class="modal fade" id="convertModal" tabindex="-1" role="dialog" aria-labelledby="conversionModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"></h5>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form action="../../../../controller/ingredients_controller.php?status=update-stock" enctype="multipart/form-data" method="post" >
      <div class="input-group">
  <input type="hidden" class="form-control" aria-label="Text input with dropdown button" name="ingredient_id" id="ingredient_id" >
  <input type="hidden" class="form-control" aria-label="Text input with dropdown button" name="factor_id" id="factor_id" >
  <input type="text" class="form-control" aria-label="Text input with dropdown button" name="updatestockvalue" id="updatestockvalue" required >
  <div class="input-group-append">
    <select name="calculation-selector" id="calculation-selector">
  <option value="add">&#43; Add <i class="bi bi-plus"></i></option>
  <option value="subtract">&#45; Subtract <i class="bi bi-dash"></i></option>
</select>

  </div>
</div>
<button type="submit" class="btn btn-primary">Save changes</button>
<button type="button" class="btn btn-danger" onclick="resetstock()">Reset</button>
      </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        
      </div>
    </div>
  </div>
</div>






    <script type="text/javascript" src="../../../../commons/clock.js"></script>
    <script type="text/javascript" src="updatestock.js"></script>
    
</body>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
    crossorigin="anonymous"></script>

</html>