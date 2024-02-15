<html>

<head>
    <title>Restaurant Management System</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link rel="stylesheet" type="text/css" href="../style/style.css">
    <link rel="stylesheet" type="text/css" href="../style/colors.css">
</head>

<body class="loginBody">
    <div class="container-fluid common-container LoginContainer">
        <div class="row justify-content-center mb-4">
            <div class="col-auto">
                <h1 class="header-text"></h1></div>
          </div>

          <div class="row m-0  justify-content-center LogincardRow">
          <div class="col-auto">
    <div class="card login-card">
        <div class="row mt-3">
            <h2 class="text-bold" align="center">Sign in to <span id="TITLE">Flood</span></h2>
        </div>
        <div class="card-body  login-card-body">
            <div class="row alertRow">
                <?php
                if (isset($_GET["msg"])) {
                    $msg = base64_decode($_GET["msg"]);
                    ?>
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
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
            </div>
            <form action="../../controller/login_controller.php?status=login" method="POST">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="input-group mb-3">
                            <span class="input-group-text">
                                <i class="bi bi-envelope"></i>
                            </span>
                            <input type="text" placeholder="Email" class="form-control" style="height: 40px" id="username" name="username" required>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="input-group mb-3">
                            <span class="input-group-text">
                                <i class="bi bi-lock"></i>
                            </span>
                            <input type="password" placeholder="Password" class="form-control" style="height: 40px" id="password" name="password" required>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-auto">
                        <button type="submit" class="btn btn-outline-success btn-block">
                            Login
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

        </div>
</body>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
    crossorigin="anonymous"></script>

</html>