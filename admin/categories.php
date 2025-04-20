<?php
$title = 'Categories';
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
                <h1 class="page-title">Categories</h1>
            </div>

            <div class="page-content fade-in-up">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h5 class="card-title mb-0 align-content-center">Category</h5>
                        <a href="category_create.php" class="btn btn-primary">Add New</a>
                    </div>
                    <div class="card-body">
                        <!-- alert msg -->
                         <?php include "alert_msg.php" ?>

                        <table class="table table-striped" id="categories">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Slug</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                $select = "SELECT * FROM categories";
                                $categories = $conn->query($select);

                                if ($categories->rowCount() > 0) {

                                    foreach ($categories as $key => $category) { ?>

                                        <tr>
                                            <td><?= $key + 1; ?></td>
                                            <td><?= $category['name']; ?></td>
                                            <td><?= $category['slug']; ?></td>
                                            <td>
                                                <a href="category_edit.php?id=<?= base64_encode($category['id']); ?>" class="btn btn-success">Edit <i class="fa fa-pencil-square-o"></i></a>

                                                <a onclick="return confirm('Are you sure you want to delete this category?')" href="category_del.php?id=<?= base64_encode($category['id']); ?>" class="btn btn-danger">Delete <i class="fa fa-trash"></i></a>
                                            </td>
                                        </tr>
                                <?php
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
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
    <script src="assets/vendors/DataTables/datatables.min.js" type="text/javascript"></script>
    <!-- CORE SCRIPTS-->
    <script src="assets/js/app.min.js" type="text/javascript"></script>
    <!-- PAGE LEVEL SCRIPTS-->
    <script type="text/javascript">
        $(function() {
            $('#categories').DataTable({
                pageLength: 10,
                
            });
        })
    </script>

</body>