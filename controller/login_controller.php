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
        //throw error message if username & password are empty
        try {
            if ($username === "") {
                throw new Exception("Username cannot be Empty!");
            }
            if ($password === "") {
                throw new Exception("Password cannot be Empty!");
            }
          //if details are valid then redirect
            $loginResult = $loginObj->validateLogin($username,$password);
            
            if ($loginResult->num_rows > 0) {
                $userrow = $loginResult->fetch_assoc();
                $_SESSION["user"] = $userrow;
                $roleID = $userrow["role_id"];
                
                //redirecting users according to roles
                if ($roleID == 1){
                    header('LOCATION: ../view/users/admin/admin.php');
                }
                elseif ($roleID == 2){
                    header('LOCATION: ../view/users/chef/chef.php');
                }
                elseif ($roleID == 3){
                    header('LOCATION: ../view/users/stock-manager/stockmanager.php');
                }
                elseif ($roleID == 4){
                    header('LOCATION: ../view/users/cashier/cashier.php');
                } 
                else{
                    throw new Exception("Unknown Role");
                }
            } else {    
                throw new Exception ("Login Invalid");
            }
        }
        catch (Exception $ex) {
            $msg = $ex->getMessage();
            $msg = base64_encode($msg);
            ?>
            <script>window.location = "../view/login/login.php?msg= <?php echo $msg; ?>"</script>
            <?php
        }

        break;
}