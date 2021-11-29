<?php
include "include/configure.php";

unset($_SESSION['user']);
session_destroy();
$_SESSION['SUCCESS_MESSAGE']= "logout  SUCCESSFULLY";
    header("location:login.php");

setcookie("user", "", time()-3600);
?>
