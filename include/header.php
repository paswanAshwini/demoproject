 <?php include "configure.php";
 ob_start();
 global $conn;
 ?>
 <?php
 if(empty($_SESSION['user'])){
     if(!empty($_COOKIE['user'])){
         $email=$_COOKIE['user'];
         $sql1 = "SELECT * FROM `register` where email ='$email'";
         $result1 = mysqli_query($conn, $sql1);
         $count1 = mysqli_num_rows($result1);
         if($count1==1) {
             $user =  mysqli_fetch_assoc($result1);
             $_SESSION['user']= $user;
         }else{
             header("location:./login.php");
             exit;
         }
     }else{
         header("location:./login.php");
         exit;
     }
 }
 ?>
<!DOCTYPE html>
<html lang="en">
<style>
    .errors{
        color:red;
    }
</style>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>QuantumPro | Dashboard</title>
    <!-- ================== GOOGLE FONTS ==================-->
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500" rel="stylesheet">
    <!-- ======================= GLOBAL VENDOR STYLES ========================-->
    <link rel="stylesheet" href="<?php echo WWW_BASE ;?>/assets/css/vendor/bootstrap.css">
    <link rel="stylesheet" href="<?php echo WWW_BASE ;?>/assets/vendor/metismenu/dist/metisMenu.css">
    <link rel="stylesheet" href="<?php echo WWW_BASE ;?>/assets/vendor/switchery-npm/index.css">
    <link rel="stylesheet" href="<?php echo WWW_BASE ;?>/assets/vendor/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.css">
    <!-- ======================= LINE AWESOME ICONS ===========================-->
    <link rel="stylesheet" href="<?php echo WWW_BASE ;?>/assets/css/icons/line-awesome.min.css">
    <link rel="stylesheet" href="<?php echo WWW_BASE ;?>/assets/css/icons/simple-line-icons.css">
    <!-- ======================= DRIP ICONS ===================================-->
    <link rel="stylesheet" href="<?php echo WWW_BASE ;?>/assets/css/icons/dripicons.min.css">
    <!-- ======================= MATERIAL DESIGN ICONIC FONTS =================-->
    <link rel="stylesheet" href="<?php echo WWW_BASE ;?>/assets/css/icons/material-design-iconic-font.min.css">
    <!-- ======================= PAGE VENDOR STYLES ===========================-->
    <link rel="stylesheet" href="<?php echo WWW_BASE ;?>/assets/vendor/datatables.net-bs4/css/dataTables.bootstrap4.css">
    <!-- ======================= GLOBAL COMMON STYLES ============================-->
    <link rel="stylesheet" href="<?php echo WWW_BASE ;?>/assets/css/common/main.bundle.css">
    <!-- ======================= LAYOUT TYPE ===========================-->
    <link rel="stylesheet" href="<?php echo WWW_BASE ;?>/assets/css/layouts/vertical/core/main.css">
    <!-- ======================= MENU TYPE ===========================-->
    <link rel="stylesheet" href="<?php echo WWW_BASE ;?>/assets/css/layouts/vertical/menu-type/default.css">
    <!-- ======================= THEME COLOR STYLES ===========================-->
    <link rel="stylesheet" href="<?php echo WWW_BASE ;?>/assets/css/layouts/vertical/themes/theme-a.css">


    <link rel="stylesheet" href="<?php  echo WWW_BASE ;?>/assets/js/toastr.min.css">
    <script src="<?php echo WWW_BASE ;?>/assets/vendor/modernizr/modernizr.custom.js"></script>
    <script src="<?php echo WWW_BASE ;?>/assets/vendor/jquery/dist/jquery.min.js"></script>
    <script src="<?php  echo WWW_BASE ;?>/assets/vendor/jquery/dist/toastr.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>

</head>
<body>

<!-- START APP WRAPPER -->
<div id="app">
<?php
include "sidebar.php";
include "navbar.php";
?>