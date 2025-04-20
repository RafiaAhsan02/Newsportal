<?php
$title = 'Posts';
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
                <h1 class="page-title">All Posts</h1>
            </div>

            <div class="page-content fade-in-up">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h5 class="card-title mb-0 align-content-center">Post</h5>
                        <a href="post_create.php" class="btn btn-primary">Add New</a>
                    </div>
                    <div class="card-body">
                        <!-- alert msg -->
                        <?php include "alert_msg.php" ?>

                        <div class="dataTables_wrapper container-fluid">
                            <table class="table table-striped table-bordered dataTable" cellspacing="0" width="100%" id="posts" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Title</th>
                                        <th scope="col">Category</th>
                                        <th scope="col">Author</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Featured?</th>
                                        <th scope="col">Created at</th>
                                        <th scope="col" style="width: 100px;">Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php
                                    $sql = "SELECT posts.*, categories.name as category_name, users.name as Author FROM posts INNER JOIN categories ON posts.category_id=categories.id INNER JOIN users ON posts.user_id=users.id ORDER BY posts.id DESC;";
                                    $stmt = $conn->query($sql);
                                    $posts = $stmt->fetchAll(PDO::FETCH_OBJ);

                                    if ($posts != null) {

                                        foreach ($posts as $key => $post) { ?>

                                            <tr>
                                                <td><?= $key + 1; ?></td>
                                                <td><?= $post->title; ?></td>
                                                <td><?= $post->category_name ?? '' ?></td>
                                                <td><?= $post->Author ?? ''; ?></td>
                                                <td>
                                                    <?php
                                                    if ($post->status == 'published') {
                                                        echo "<span class='badge badge-success'>Published</span>";
                                                    } else {
                                                        echo "<span class='badge badge-warning'>Draft</span>";
                                                    }
                                                    ?>
                                                </td>
                                                <td><?php
                                                    if ($post->featured == 1) {
                                                        echo "<span class='badge badge-success'>Yes</span>";
                                                    } else {
                                                        echo "<span class='badge badge-warning'>No</span>";
                                                    }
                                                    ?></td>
                                                <td><?= $post->created; ?></td>
                                                <td>
                                                    <a href="post_view.php?id=<?= $post->id; ?>" class="btn btn-primary" title="View post details"><i class="fa fa-eye"></i></a>

                                                    <a href="post_edit.php?id=<?= $post->id; ?>" class="btn btn-success" title="Edit post"><i class="fa fa-pencil-square-o"></i></a>

                                                    <a onclick="return confirm('Are you sure you want to delete this post?')" href="post_del.php?id=<?= $post->id; ?>" class="btn btn-danger" title="Delete post"><i class="fa fa-trash"></i></a>
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
            $('#posts').DataTable({
                pageLength: 10,

            });
        })
    </script>

</body>