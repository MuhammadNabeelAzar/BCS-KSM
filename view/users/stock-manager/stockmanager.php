<?php
session_start();
include_once '../../../model/role_model.php';
$userRoleID = isset($_SESSION['user']['role_id']) ? $_SESSION['user']['role_id'] : null;
?>
<html>
    <head>
        <title>Restaurant Management System</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">  
        <link rel="stylesheet" type="text/css" href="../../style/style.css">
    <link rel="stylesheet" type="text/css" href="../../style/colors.css">  
    </head>
    <body>
    <?php 
    include '../../commons/home-header.php';
    ?>
        <a class="btn btn-primary" data-bs-toggle="offcanvas" href="#offcanvasExample" role="button" aria-controls="offcanvasExample">
            <i class="bi bi-list"></i>
        </a>
        <hr>
        <!--user navigation-->
        <?php
    // Include the sidebar file
    if ($userRoleID == 1) {
        include '../../commons/admin-navigation.php';
    } elseif ($userRoleID == 2) {
        include '../../commons/chef-navigation.php';
    } elseif ($userRoleID == 3) {
        include '../../commons/stock-manager-navigation.php';
    } elseif ($userRoleID == 4) {
        include '../../commons/cashier-navigation.php';
    }
    ?>
        <!--user navigation-->

        <script type="text/javascript" src="../../../commons/clock.js"></script>
    </body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</html>