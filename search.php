<!DOCTYPE html>
<html lang="en">
<!-- insert page head -->
<?php include "layout/head.php"; ?>

<body>
    <!-- Top Bar Start -->
    <?php include "layout/topbar.php"; ?>
    <!-- Top Bar End -->

    <!-- Brand Start -->
    <?php include "layout/brand.php"; ?>
    <!-- Brand End -->

    <!-- Nav Bar Start -->
    <?php include "layout/navbar.php"; ?>
    <!-- Nav Bar End -->

    <div class="main-news py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-9">
                    <div class="row">
                        <!-- Heading -->
                        <?php
                        if (isset($_GET['query']) && !empty($_GET['query'])) {
                            $search = validate($_GET['query']);
                        ?>
                            <div class="col-12">
                                <h1>Search by: <?= $search; ?></h1>
                            </div>

                            <!-- Keyword Relevant News -->
                            <?php
                            $sql = "SELECT posts.*, categories.name as categoryName, users.name as Author FROM posts
                            INNER JOIN categories ON posts.category_id = categories.id
                            INNER JOIN users ON posts.user_id = users.id WHERE posts.status='published'
                            AND title LIKE :search OR description LIKE :search ORDER BY posts.id DESC";
                            $bindings = [
                                ':search' => '%' . $search . '%'
                            ];
                            $stmt = $conn->prepare($sql);
                            $stmt->execute($bindings);
                            $posts = $stmt->fetchAll(PDO::FETCH_OBJ);

                            if ($posts != null) {
                                foreach ($posts as $post) { ?>
                                    <div class="col-md-4">
                                        <div class="mn-img">
                                            <img src="admin/<?= $post->image; ?>" />
                                            <div class="mn-title">
                                                <a href="view.php?id=<?= base64_encode($post->id); ?>"><?= $post->title; ?></a>
                                            </div>
                                        </div>
                                    </div>
                        <?php }
                            } else {
                                echo "No news available for the requested keyword(s).";
                            }
                        }
                        ?>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="col-lg-3">
                    <?php include "layout/sidebar.php"; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer Start -->
    <?php include "layout/footer.php"; ?>
    <!-- Footer End -->

    <!-- Back to Top -->
    <a href="#" class="back-to-top"><i class="fa fa-chevron-up"></i></a>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/slick/slick.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
</body>

</html>