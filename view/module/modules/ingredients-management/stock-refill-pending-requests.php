<?php
 session_start();
 include_once '../../../../model/role_model.php';
 if (!isset($_SESSION['user']) || !isset($_SESSION['user']['role_id'])) {
    // Redirect to the login page
    header("Location: http://localhost/BcsKSM/view/login/login.php");
    exit(); // Make sure to exit after a header redirect
}

$userRoleID = $_SESSION['user']['role_id'];
    // Redirect to the home page
    switch ($userRoleID) {
        case 4:
            header("Location: http://localhost/BcsKSM/view/users/cashier/cashier.php");
            break;
        }
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

<?php
      if (isset($_GET["msg"])) {
        $msg = base64_decode($_GET["msg"]);
        ?>

          <div class="alert alert-success alert-dismissible fade show" role="alert">
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
    <!--user navigation-->
    <div class="container-fluid common-container">
        <div class="row requestsCards"></div>
    </div>
   
    <div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog" aria-labelledby="confirmationModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="confirmationModalLabel">Confirmation</h5>
        <button type="button" class="btn-close modalclosetbtn" data-bs-dismiss="modal" aria-label="Close">
        </button>
      </div>
      <div class="modal-body">
      </div>
      <div class="modal-footer">
        <button type="button " class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-outline-Danger" id="confirmBtn">Confirm</button>
      </div>
    </div>
  </div>
</div>
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
<script type="text/javascript" src="../../../../commons/clock.js"></script>
<script type="text/javascript" src="stock-refill-pending-requests.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
    crossorigin="anonymous"></script>

</html>