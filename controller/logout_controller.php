<?php
//destroys the session from the server
session_destroy();
//destroys the session from the client side
setcookie(session_name(), '', time() - 3600, '/');
//redirect
header('Location: ../view/login/login.php');
exit();
?>
