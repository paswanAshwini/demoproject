
</div>
<script src="<?php echo WWW_BASE ;?>/assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo WWW_BASE ;?>/assets/vendor/js-storage/js.storage.js"></script>
<script src="<?php echo WWW_BASE ;?>/assets/vendor/js-cookie/src/js.cookie.js"></script>
<script src="<?php echo WWW_BASE ;?>/assets/vendor/pace/pace.js"></script>
<script src="<?php echo WWW_BASE ;?>/assets/vendor/metismenu/dist/metisMenu.js"></script>
<script src="<?php echo WWW_BASE ;?>/assets/vendor/switchery-npm/index.js"></script>
<script src="<?php echo WWW_BASE ;?>/assets/vendor/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js"></script>
<!-- ================== PAGE LEVEL VENDOR SCRIPTS ==================-->
<script src="<?php echo WWW_BASE ;?>/assets/vendor/countup.js/dist/countUp.min.js"></script>
<script src="<?php echo WWW_BASE ;?>/assets/vendor/chart.js/dist/Chart.bundle.min.js"></script>
<script src="<?php echo WWW_BASE ;?>/assets/vendor/flot/jquery.flot.js"></script>
<script src="<?php echo WWW_BASE ;?>/assets/vendor/jquery.flot.tooltip/js/jquery.flot.tooltip.min.js"></script>
<script src="<?php echo WWW_BASE ;?>/assets/vendor/flot/jquery.flot.resize.js"></script>
<script src="<?php echo WWW_BASE ;?>/assets/vendor/flot/jquery.flot.time.js"></script>
<script src="<?php echo WWW_BASE ;?>/assets/vendor/flot.curvedlines/curvedLines.js"></script>
<script src="<?php echo WWW_BASE ;?>/assets/vendor/datatables.net/js/jquery.dataTables.js"></script>
<script src="<?php echo WWW_BASE ;?>/assets/vendor/datatables.net-bs4/js/dataTables.bootstrap4.js"></script>
<!-- ================== GLOBAL APP SCRIPTS ==================-->
<script src="<?php echo WWW_BASE ;?>/assets/js/global/app.js"></script>
<!-- ================== PAGE LEVEL SCRIPTS ==================-->
<script src="<?php echo WWW_BASE ;?>/assets/js/components/countUp-init.js"></script>
<script src="<?php echo WWW_BASE ;?>/assets/js/cards/counter-group.js"></script>
<script src="<?php echo WWW_BASE ;?>/assets/js/cards/recent-transactions.js"></script>
<script src="<?php echo WWW_BASE ;?>/assets/js/cards/monthly-budget.js"></script>
<script src="<?php echo WWW_BASE ;?>/assets/js/cards/users-chart.js"></script>
<script src="<?php echo WWW_BASE ;?>/assets/js/cards/bounce-rate-chart.js"></script>
<script src="<?php echo WWW_BASE ;?>/assets/js/cards/session-duration-chart.js"></script>


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
    toastr['success']("<?php  echo $_SESSION['SUCCESS_MESSAGE']; ?>");
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
