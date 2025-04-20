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

            <div class="page-content fade-in-up">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h5 class="card-title mb-0 align-content-center">Post Details</h5>
                        <a href="posts.php" class="btn btn-primary">Back to Posts</a>
                    </div>
                    <div class="card-body">
                        <?php

                        if (isset($_GET['id']) && !empty($_GET['id'])) {
                            $id = $_GET['id'];
                            $sql = "SELECT posts.*, categories.name as category_name, users.name as Author FROM posts INNER JOIN categories ON posts.category_id=categories.id INNER JOIN users ON posts.user_id=users.id WHERE posts.id=:id;";
                            $stmt = $conn->prepare($sql);
                            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                            $stmt->execute();
                            $posts = $stmt->fetch(PDO::FETCH_OBJ);
                        }

                        if ($posts) { ?>
                            <h2 class="py-3"><?= $posts->title; ?></h2>
                            <span class="mb-3 badge badge-default badge-pill badge-big"><?= $posts->category_name; ?></span>

                            <img src="<?= $posts->image; ?>" alt="" class="mb-3">
                            <div>
                                <p><strong>Author: </strong><?= $posts->Author; ?></p>
                                <p><strong>Posted: </strong><?= $posts->created; ?> | <strong>Last Updated: </strong><?= $posts->updated; ?></p>
                                <hr>
                                <p><?= $posts->description; ?></p>
                            </div>
                        <?php
                        } else {
                            echo "<div class='alert alert-danger'>Post not found.</div>";
                        }
                        ?>

                        <div class="pb-4">
                            <?php
                            $sql = "SELECT tags.* FROM tags INNER JOIN post_tags ON tags.id = post_tags.tag_id WHERE post_id = :postId;";
                            $stmt = $conn->prepare($sql);
                            $stmt->bindParam(':postId', $posts->id, PDO::PARAM_INT);
                            $stmt->execute();
                            $tags = $stmt->fetchAll(PDO::FETCH_OBJ);
                            if ($tags) {
                                foreach ($tags as $key => $tag) { ?>
                                    <span class="btn btn-default"><?= $tag->name ?></span>
                            <?php
                                }
                            }
                            ?>
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