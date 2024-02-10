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
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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

  <div class="row Allitems-container justify-content-start m-0">
    <div class="row d-flex searchBarRow justify-content-start p-0">
      <?php
      if (isset($_GET["msg"])) {
        $msg = base64_decode($_GET["msg"]);
        ?>
        <div class="alert alert-success alert-dismissible fade show " role="alert">
          <div class="d-flex justify-content-between align-items-center">
            <p class="mb-0">
              <?php echo $msg; ?>
            </p>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
            </button>
          </div>
        </div>
        <?php
      }
      ?>
      <input class="form-control m-2 " type="search" id="seachBar" placeholder="Search" onkeyup="search()"
        aria-label="Search">

    </div>
    <div class="row itemcards justify-content-center">
      <?php
      while ($ingrow = $ingResult->fetch_assoc()) {
        $ing_id = $ingrow["ing_id"];
        $ing_id = base64_encode($ing_id);

        //display the ingredients where the factor_id is not null
      
        ?>
        <div class="card Ingredientcard">
          <div class="row">
            <div class="card-header allItem-card-header text-center">
              <h5>
                <?php echo $ingrow["ing_name"] ?>
              </h5>
            </div>
          </div>

          <div class="card-body m-0">
            <input type="hidden" value="<?php echo $ingrow["ing_id"] ?>">
            <div class="row">
              <img class="card-img-top m-0" src="../../../<?php echo $ingrow["img_path"] ?>" alt="Card image cap">
            </div>
            <div class="row text-center mt-2">
              <h5 class="card-title">Remaining:
                <?php
                $remainingG = $ingrow["remaining_qty(g)"];
                $remainingKg = $ingrow["remaining_qty(kg)"];
                $remainingL = $ingrow["remaining_qty(l)"];
                $remainingMl = $ingrow["remaining_qty(ml)"];
                $remainingOz = $ingrow["remaining_qty(oz)"];
                $remainingLb = $ingrow["remaining_qty(lb)"];
                $remainingNos = $ingrow["remaining_qty(nos)"];
                $factorsf = $ingrow["factorsf"];

                switch ($factorsf) {
                  case 'g':
                    echo intval($remainingG) . " " . $factorsf;
                    break;
                  case 'kg':
                    echo intval($remainingKg) . " " . $factorsf;
                    break;
                  case 'ml':
                    echo intval($remainingMl) . " " . $factorsf;
                    break;
                  case 'l':
                    echo intval($remainingL) . " " . $factorsf;
                    break;
                  case 'oz':
                    echo intval($remainingOz) . " " . $factorsf;
                    break;
                  case 'lb':
                    echo intval($remainingLb) . " " . $factorsf;
                    break;
                  case 'nos':
                    echo intval($remainingNos) . " " . $factorsf;
                    break;
                }

                ?>
              </h5>
              <div class="row mt-2 justify-content-center m-0">
                <button type="button" class="btn btn-outline-secondary" data-bs-toggle="popover"
                  data-bs-placement="bottom" title="Ingredient Description" data-bs-trigger="focus"
                  data-bs-content="<?php echo isset($ingrow["ing_description"]) ? $ingrow["ing_description"] : 'No description'; ?>">
                  Description
                </button>
              </div>
              <div class="row mt-2 justify-content-center m-0">
                <div class="col-auto ">
                  <button type="button" class="btn btn-outline-primary" id="editremQtybtn"
                    onclick="editIng('<?php echo $ing_id ?>')">
                    Update
                  </button>
                </div>

                <?php
                // Include the sidebar file
                if ($userRoleID == 2) { ?>
                  <div class="col-auto">
                    <button type="button" class="btn btn-outline-primary" id="reqIngbtn"
                      onclick="requestStock('<?php echo base64_decode($ing_id) ?>', '<?php echo $ingrow['ing_name'] ?>')">
                      Request
                    </button>
                  </div>
                  <?php
                } ?>

              </div>
            </div>
          </div>
        </div>

        <?php
      }
      ?>
    </div>
  </div>

  <div class="modal fade" id="updatestockModal" tabindex="-1" role="dialog" aria-labelledby="conversionModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modaltitle"></h5>
          <button type="button" class="btn-close  modalclosetbtn" data-bs-dismiss="modal" aria-label="Close">
          </button>
        </div>
        <div class="modal-body">
          <form action="../../../../controller/ingredients_controller.php?status=update-stock"
            enctype="multipart/form-data" method="post">
            <div class="input-group">
              <input type="hidden" class="form-control" aria-label="Text input with dropdown button"
                name="ingredient_id" id="ingredient_id">
              <input type="hidden" class="form-control" aria-label="Text input with dropdown button" name="factor_id"
                id="factor_id">
              <input type="number" class="form-control" aria-label="Text input with dropdown button"
                name="updatestockvalue" id="updatestockvalue" required>
              <div class="input-group-append">
                <select class="form-select" name="calculation-selector" id="calculation-selector">
                  <option value="add">&#43; Add <i class="bi bi-plus"></i></option>
                  <option value="subtract">&#45; Subtract <i class="bi bi-dash"></i></option>
                </select>

              </div>
            </div>
            <div class="row mt-3 justify-content-end">
              <div class="col-auto">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
              </div>
              <div class="col-auto">
                <button type="button" class="btn btn-outline-danger" onclick="resetstock()">Reset</button>
              </div>
              <div class="col-auto">
                <button type="submit" class="btn btn-outline-primary">Save changes</button>
              </div>


            </div>
          </form>
        </div>
      </div>
    </div>
  </div>



  <div class="modal" id="confirmationModal" tabindex="-1" role="dialog" aria-labelledby="confirmationModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="confirmationModalLabel">Reset Stock Level</h5>
          <button type="button" class="btn-close modalclosetbtn" data-bs-dismiss="modal" aria-label="Close">
          </button>
        </div>
        <div class="modal-body">
          Are you sure you want to reset the stock level?
          <div class="row mt-3 justify-content-end">
          <div class="col-auto">
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
          </div>
          <div class="col-auto">
            <button type="button" class="btn btn-outline-danger" id="confirmBtn">Confirm</button>
          </div>
        </div>
        </div>
        
      </div>
    </div>
  </div>

  <div class="modal fade" id="stockRequestModal" tabindex="-1" aria-labelledby="stockRequestModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="stockRequestModalLabel"></h5>
          <button type="button" class="btn-close modalclosetbtn" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <!-- Stock Request Form -->
          <form>

            <div class="row">
              <div class="input-group mb-3 ">
                <div class="input-group-prepend">
                  <span class="input-group-text placeholderdescription " id="inputGroup-sizing-default">
                    <h6>Quantity</h6>

                </div>
                <input type="number" class="form-control col" id="quantity" required> </span>

                <select class="forms-select " id="factors" aria-label="factors" name="factors" required>
                  <option value="">----</option>
                  <?php
                  while ($factorrow = $ingfactorResult->fetch_assoc()) {
                    ?>
                    <option id="factor_selected" name="factor_selected" value="<?php echo $factorrow["factor_id"]; ?>"
                      <?php echo (isset($ingredientrow["factor_id"]) && $ingredientrow["factor_id"] == $factorrow["factor_id"]) ? 'selected="selected"' : ''; ?>>
                      <?php echo isset($factorrow["factorsf"]) ? $factorrow["factorsf"] : ''; ?>
                    </option>
                    <?php
                  }
                  ?>
                </select>
              </div>
            </div>
            <div class="input-group mt-2">
              <div class="input-group-prepend">
                <span class="input-group-text placeholderdescription " id="inputGroup-sizing-default">
                  <h6>Reason for Request</h6>
                </span>
              </div>
              <textarea class="form-control" id="reason" rows="1" required></textarea>

            </div>
            <div class="row justify-content-end mt-3">
              <div class="col-auto">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
              </div>
              <div class="col-auto">
                <button type="button" id="requestBtn" class="btn btn-outline-primary">Submit Request</button>
              </div>
            </div>
        </div>


        </form>
      </div>

    </div>
  </div>
  </div </body>
  <script type="text/javascript" src="../../../../commons/clock.js"></script>
  <script type="text/javascript" src="stock.js"></script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
    crossorigin="anonymous"></script>

</html>