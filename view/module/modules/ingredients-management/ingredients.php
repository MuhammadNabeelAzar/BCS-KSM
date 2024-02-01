<?php
 session_start();
 include_once '../../../../model/role_model.php';
 if (!isset($_SESSION['user']) || !isset($_SESSION['user']['role_id'])) {
    // Redirect to the login page
    header("Location: http://localhost/BcsKSM/view/login/login.php");
    exit(); // Make sure to exit after a header redirect
}

$userRoleID = $_SESSION['user']['role_id'];
include_once '../../../../model/ingredients_model.php';
$ingredientObj = new ingredient();
$ingResult = $ingredientObj->getAllingredients();
$ingfactorResult = $ingredientObj->getfactors();

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

<?php 
    include '../../../commons/header.php';
    ?>
    <a class="btn btn-primary" data-bs-toggle="offcanvas" href="#offcanvasExample" role="button"
        aria-controls="offcanvasExample">
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
    <!--user navigation-->
    <div class="row">
        <div class="col-md-3" style="background-color:black">
            <div class="accordion">
                <div class="row">
                <input class="form-control "  id="seachBar" type="search" placeholder="Search" aria-label="Search" onkeyup="search()">
                            <button class="btn btn-outline-success " type="submit">Search</button>
                    <ul class="list-group">
                        <?php
                        while ($ingrow = $ingResult->fetch_assoc()) {
                            $ing_id = $ingrow["ing_id"];
                            $ing_id = base64_encode($ing_id);
                            ?>
                            <a type="button" class="list-group-item" href="edit-ingredients.php?status=edit-ingredient&ingid=<?php echo $ing_id ?>">
                              <p>  <?php echo $ingrow["ing_name"] ?></p>
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
<script type="text/javascript" src="ingredients.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
    crossorigin="anonymous"></script>

</html>