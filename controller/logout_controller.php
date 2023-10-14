<?php
session_destroy();

//redirect
header('Location: ../view/login/login.php');
exit();
?>
