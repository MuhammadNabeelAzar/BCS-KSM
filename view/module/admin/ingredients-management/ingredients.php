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
    <!--user navigation-->
    <div class="row">
        <div class="col-md-3" style="background-color:black">
            <div class="accordion">
                <div class="row">
                    <form class="form-inline">
                        <input class="form-control " type="search" placeholder="Search" aria-label="Search">
                        <button class="btn btn-outline-success " type="submit">Search</button>

                    </form>
                </div>
                <div class="row">
                    <div class="col" style="background-color:green">
                        <div class="card-header" id="headingOne">
                            <h5 class="mb-0">
                                <button class="btn btn-link" data-bs-toggle="collapse" data-bs-target="#collapseOne"
                                    aria-expanded="true" aria-controls="collapseOne">
                                    Collapsible Group Item #1
                                </button>
                            </h5>
                        </div>
                    </div>
                    <div class="col" style="background-color:blue">
                        <div class="card-header" id="headingTwo">
                            <h5 class="mb-0">
                                <button class="btn btn-link collapsed" data-bs-toggle="collapse"
                                    data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    Collapsible Group Item #2
                                </button>
                            </h5>
                        </div>
                    </div>
                    <div class="col" style="background-color:aqua">
                        <div class="card-header" id="headingThree">
                            <h5 class="mb-0">
                                <button class="btn btn-link collapsed" data-bs-toggle="collapse"
                                    data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                    Collapsible Group Item #3
                                </button>
                            </h5>
                        </div>
                    </div>
                    <div class="row">
                        <div id="collapseOne" class="collapse show" aria-labelledby="headingOne"
                            data-parent="#accordion">
                            <div class="card-body" style="background-color:lightblue">
                                this is the first one
                            </div>
                        </div>

                        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion" style="max-height: 200px; overflow-y: auto;">
                            <div class="card-body" style="background-color:lightgreen">
                                Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad
                                squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck
                                quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it
                                squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica,
                                craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur
                                butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth
                                
                            </div>
                        </div>

                        <div id="collapseThree" class="collapse" aria-labelledby="headingThree"
                            data-parent="#accordion">
                            <div class="card-body" style="background-color:grey">
                                3rd one
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col" style="background-color:yellow">
            <div class="row">
                <form>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Default</span>
                        </div>
                        <input type="text" class="form-control" aria-label="Default" aria-describedby="inputGroup">
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <label class="input-group-text" for="inputGroupSelect01">Options</label>
                        </div>
                        <select class="custom-select" id="inputGroupSelect01">
                            <option selected>Choose...</option>
                        </select>
                    </div>
                    <div class="input-group">
                        <label for="exampleFormControlTextarea1">Example textarea</label>
                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <input type="file" class="form-control" aria-label="Default" aria-describedby="inputGroup">
                        </div>

                    </div>
                    <button type="submit" class="btn btn-primary">
                        Add
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script type="text/javascript" src="../../../../commons/clock.js"></script>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
    crossorigin="anonymous"></script>

</html>