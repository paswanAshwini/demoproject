</div>
<script src="<?php  echo WWW_BASE ;?>/assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?php  echo WWW_BASE ;?>/assets/vendor/js-storage/js.storage.js"></script>
<script src="<?php  echo WWW_BASE ;?>/assets/vendor/js-cookie/src/js.cookie.js"></script>
<script src="<?php  echo WWW_BASE ;?>/assets/vendor/pace/pace.js"></script>
<script src="<?php  echo WWW_BASE ;?>/assets/vendor/metismenu/dist/metisMenu.js"></script>
<script src="<?php  echo WWW_BASE ;?>/assets/vendor/switchery-npm/index.js"></script>
<script src="<?php  echo WWW_BASE ;?>/assets/vendor/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js"></script>
<!-- ================== GLOBAL APP SCRIPTS ==================-->
<script src="<?php  echo WWW_BASE ;?>/assets/js/global/app.js"></script>
<script>
// Command: toastr["success"]("My name is Inigo Montoya. You killed my father. Prepare to die!")

toastr.options = {
"closeButton": false,
"debug": false,
"newestOnTop": false,
"progressBar": false,
"positionClass": "toast-top-full-width",
"preventDuplicates": false,
"onclick": null,
"showDuration": "300",
"hideDuration": "1000",
"timeOut": "5000",
"extendedTimeOut": "1000",
"showEasing": "swing",
"hideEasing": "linear",
"showMethod": "fadeIn",
"hideMethod": "fadeOut"
}
<?php if(!empty ($_SESSION['SUCCESS_MESSAGE'])) { ?>
toastr['success']("<?php  echo ($_SESSION['SUCCESS_MESSAGE']); ?>");
<?php  unset($_SESSION['SUCCESS_MESSAGE']); ?>
<?php } ?>

<?php if(!empty ($_SESSION['ERROR_MESSAGE'])) { ?>
toastr['error']("<?php echo $_SESSION['ERROR_MESSAGE']; ?>");
<?php unset ($_SESSION['ERROR_MESSAGE']) ?>
<?php } ?>


</script>
</body>
<!-- Mirrored from www.authenticgoods.co/themes/quantum-pro/demos/demo1/auth.sign-in.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 19 Jun 2018 12:51:41 GMT -->
</html>