<!DOCTYPE html>
<?php
 session_start();
 include_once '../../../../model/role_model.php';
 if (!isset($_SESSION['user']) || !isset($_SESSION['user']['role_id'])) {
    // Redirect to the login page
    header("Location: http://localhost/BcsKSM/view/login/login.php");
    exit(); // Make sure to exit after a header redirect
}

$userRoleID = $_SESSION['user']['role_id'];
include_once '../../../../model/menu_model.php';
$menuObj = new menu();
$otherItemResult = $menuObj->getOtherItems();

?>

<html>

<head>
    <title>Restaurant Management System</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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

    </div>
    <!--user navigation-->

    <div class="container-ffluid">
    <div class="row" style="background-color:yellow;">
        <div class="row">
            <div class="col"><input class="form-control " id="seachBar" type="search" placeholder="Search"
                    aria-label="Search" onkeyup="search()">
                <button class="btn btn-outline-success " type="submit">Search</button>
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
        while ($itemsrow = $otherItemResult->fetch_assoc()) {
            $item_id = $itemsrow["item_id"];
            $item_id = base64_encode($item_id);

            //display the items where the
        
            ?>
            <div class="card" style="width: 18rem;margin:2px;">
                <img class="card-img-top" src="../../../<?php echo $itemsrow["img_path"] ?>" alt="Card image cap">
                <div class="card-body">
                    <input type="hidden" value="<?php echo $itemsrow["item_id"] ?>">
                    <div class="row">
                        <p class="card-title">
                            <?php echo $itemsrow["item_name"] ?>
                        </p>
                    </div>
                    <div class="row">
                        <p class="card-title">
                            <?php echo $itemsrow["description"] ?>
                        </p>
                    </div>
                    <div class="row">
                        <p class="card-title">Remaining:
                            <?php
                            echo $itemsrow["available_quantity"];

                            ?>
                        </p>
                        <button type="button" class="btn btn-primary" id="editremQtybtn"
                            onclick="updatestock('<?php echo base64_decode($item_id) ?>', '<?php echo $itemsrow['item_name'] ?>')">
                            Update
                        </button>
                    </div>
                </div>
            </div>
        <?php
        }
        ?>
    </div>
    <div class="modal fade" id="updatestockModal" tabindex="-1" role="dialog" aria-labelledby="updatestockModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"></h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="../../../../controller/menu_controller.php?status=update-item-stock"
                        enctype="multipart/form-data" method="post">
                        <div class="input-group">
                            <input type="hidden" class="form-control" aria-label="Text input with dropdown button"
                                name="item_id" id="item_id">
                            <input type="text" class="form-control" aria-label="Text input with dropdown button"
                                name="updatestockvalue" id="updatestockvalue" required>
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
    </div>

    <div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="confirmModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="confirmModalLabel">Confirmation</h5>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Are you sure you want reset the values of this item?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-danger" id="confirmBtn">Confirm</button>
      </div>
    </div>
  </div>
</div>




    <script type="text/javascript" src="../../../../commons/clock.js"></script>
    <script type="text/javascript" src="stock.js"></script>

</body>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
    crossorigin="anonymous"></script>

</html>