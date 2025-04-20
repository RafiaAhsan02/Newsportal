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

    <!-- Breadcrumb Start -->
    <div class="breadcrumb-wrap">
        <div class="container">
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item"><a href="#">News</a></li>
                <li class="breadcrumb-item active">News details</li>
            </ul>
        </div>
    </div>
    <!-- Breadcrumb End -->

    <!-- Single News Start-->
    <div class="single-news">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <!-- Main News Article Start-->
                    <div class="sn-container">
                        <?php
                        if (isset($_GET['id']) && $_GET['id'] != null) {
                            $id = base64_decode($_GET['id']);
                            $sql = "SELECT posts.*, categories.id as categoryId, categories.name as category_name, users.name as Author FROM posts INNER JOIN categories ON posts.category_id=categories.id INNER JOIN users ON posts.user_id=users.id WHERE posts.id=:id;";

                            $stmt = $conn->prepare($sql);
                            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                            $stmt->execute();
                            $posts = $stmt->fetch(PDO::FETCH_OBJ);
                        }
                        ?>

                        <div class="sn-content">
                            <h1 class="sn-title"><?= $posts->title; ?></h1>
                            <h4><span class="badge badge-secondary"><?= $posts->category_name; ?></span></h4>
                            <div class="sn-img">
                                <img src="admin/<?= $posts->image; ?>" />
                            </div>
                            <br>
                            <div class="post-details">
                                <p><i class="fa fa-user"></i> Author: <?= $posts->Author; ?></p>
                                <p><i class="fa fa-calendar"></i> Posted: <?= $posts->created; ?> | <i class="fa fa-pencil-square-o"></i> Last Updated: <?= $posts->updated; ?></p>
                            </div>
                            <hr>
                            <p>
                                <?= $posts->description; ?>
                            </p>

                            <?php
                            $sql = "SELECT tags.* FROM tags INNER JOIN post_tags ON tags.id = post_tags.tag_id WHERE post_id = :postId;";
                            $stmt = $conn->prepare($sql);
                            $stmt->bindParam(':postId', $posts->id, PDO::PARAM_INT);
                            $stmt->execute();
                            $tags = $stmt->fetchAll(PDO::FETCH_OBJ);
                            if ($tags) {
                                foreach ($tags as $key => $tag) { ?>
                                    <a href="tag_news.php?tagId=<?= $tag->id; ?>" class="badge badge-info"><?= $tag->name ?></a>
                            <?php
                                }
                            }
                            ?>

                        </div>
                    </div>
                    <!-- Main News Article End-->


                    <!-- Related News -->
                    <div class="sn-related">
                        <h2>Related News</h2>
                        <div class="row sn-slider">
                            <?php
                            $sql = "SELECT * FROM posts WHERE category_id = :categoryId";
                            $stmt = $conn->prepare($sql);
                            $stmt->bindParam(':categoryId', $posts->categoryId, PDO::PARAM_INT);
                            $stmt->execute();
                            $relatedPosts = $stmt->fetchAll(PDO::FETCH_OBJ);
                            if ($relatedPosts != null) {
                                foreach ($relatedPosts as $relatedPost) { ?>
                                    <div class="col-md-4">
                                        <div class="sn-img">
                                            <img src="admin/<?= $relatedPost->image; ?>" />
                                            <div class="sn-title">
                                                <a href="view.php?id=<?= base64_encode($relatedPost->id); ?>"><?= $relatedPost->title; ?></a>
                                            </div>
                                        </div>
                                    </div>
                            <?php }
                            }
                            ?>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="col-lg-4">
                <?php include "layout/sidebar.php"; ?>
                </div>
            </div>
        </div>
    </div>
    <!-- Single News End-->

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