<?php
$title = 'Dashboard';
$realpath = realpath(dirname(__FILE__));
include $realpath . "/layout/head.php";
?>

<body class="fixed-navbar">
    <div class="page-wrapper">
        <!-- START HEADER-->
        <?php
        include "layout/header.php";
        ?>
        <!-- END HEADER-->
        <!-- START SIDEBAR-->
        <?php
        include "layout/sidebar.php";
        ?>
        <!-- END SIDEBAR-->
        <div class="content-wrapper">
            <!-- START PAGE CONTENT-->
            <div class="page-heading">
                <h1 class="page-title">Admin Dashboard</h1>
            </div>

            <div class="page-content fade-in-up">

                <?php
                echo "Welcome " . $_SESSION['user_name'] . "!";
                ?>

            </div>

            <!-- END PAGE CONTENT-->
            <!-- footer -->
            <?php
            include "layout/footer.php";
            ?>

        </div>
    </div>
  
    <!-- BEGIN PAGA BACKDROPS-->
    <div class="sidenav-backdrop backdrop"></div>
    <div class="preloader-backdrop">
        <div class="page-preloader">Loading</div>
    </div>
    <!-- END PAGA BACKDROPS-->
    <!-- CORE PLUGINS-->
    <?php
    include "layout/corejs.php";
    ?>
    <!-- PAGE LEVEL PLUGINS-->
    <!-- CORE SCRIPTS-->
    <script src="assets/js/app.min.js" type="text/javascript"></script>
    <!-- PAGE LEVEL SCRIPTS-->
</body>

</html>