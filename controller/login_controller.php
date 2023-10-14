<?php
session_start();
if (!isset($_GET["status"])) {
    ?>
    <script>window.location = "../view/login/login.php"</script>
    <?php
}

include '../model/login_model.php';
$loginObj = new Login();

$status = $_GET["status"];

switch ($status) {
    case "login":
        $username = $_POST["username"];
        $password = $_POST["password"];

        try {
            if ($username === "") {
                throw new Exception("Username cannot be Empty!");
            }
            if ($password === "") {
                throw new Exception("Password cannot be Empty!");
            }

            $loginResult = $loginObj->validateLogin($username, $password);
            if ($loginResult->num_rows > 0) {
                $userrow = $loginResult->fetch_assoc();
                $_SESSION["user"] = $userrow;
                ?>
                <script>window.location = "../view/admin/admin.php"</script>
                <?php
            } else {
                echo "Login Invalid";
            }
        } catch (Exception $ex) {
            $msg = $ex->getMessage();
            $msg = base64_encode($msg);
            ?>
            <script>window.location = "../view/login/login.php?msg= <?php echo $msg; ?>"</script>
            <?php
        }

        break;
}
