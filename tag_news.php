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
                        <!-- Tag Heading -->
                        <?php
                        if (isset($_GET['tagId']) && !empty($_GET['tagId'])) {
                            $tagId = $_GET['tagId'];
                            $sql = "SELECT post_tags.*, tags.name FROM post_tags INNER JOIN tags ON post_tags.tag_id=tags.id WHERE tag_id = :tagId";
                            $stmt = $conn->prepare($sql);
                            $stmt->bindParam(':tagId', $tagId, PDO::PARAM_INT);
                            $stmt->execute();
                            $tag = $stmt->fetch(PDO::FETCH_OBJ);
                        ?>
                            <div class="col-12">
                                <h1>Tag: <?= $tag->name; ?></h1>
                            </div>

                            <!-- Tag-specific News -->
                            <?php
                            $sql = "SELECT posts.*, post_tags.tag_id FROM posts INNER JOIN post_tags ON posts.id = post_tags.post_id WHERE tag_id = :tagId;"; //join posts with post_tags
                            $stmt = $conn->prepare($sql);
                            $stmt->bindParam(':tagId', $tagId, PDO::PARAM_INT);
                            $stmt->execute();
                            $tagPosts = $stmt->fetchAll(PDO::FETCH_OBJ);

                            if ($tagPosts != null) {
                                foreach ($tagPosts as $tagPost) { ?>
                                    <div class="col-md-4">
                                        <div class="mn-img">
                                            <img src="admin/<?= $tagPost->image; ?>" />
                                            <div class="mn-title">
                                                <a href="view.php?id=<?= base64_encode($tagPost->id); ?>"><?= $tagPost->title; ?></a>
                                            </div>
                                        </div>
                                    </div>
                        <?php }
                            } else {
                                echo "No news available for the requested tag.";
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