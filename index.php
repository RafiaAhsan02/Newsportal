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

    <!-- Top News Start -->
    <div class="top-news">
        <div class="container">
            <div class="row">
                <div class="col-md-6 tn-left">
                    <div class="row tn-slider">
                        <?php
                        $sql = "SELECT id, title, slug, image FROM posts ORDER BY id DESC LIMIT 3";
                        $stmt = $conn->query($sql);
                        $latestPosts = $stmt->fetchAll(PDO::FETCH_OBJ);

                        foreach ($latestPosts as $latestPost) { ?>
                            <div class="col-md-6">
                                <div class="tn-img">
                                    <img src="admin/<?= $latestPost->image; ?>" />
                                    <div class="tn-title">
                                        <!-- <a href="view.php?slug=<? //= $latestPost->slug; 
                                                                    ?>"><? //= $latestPost->title; 
                                                                        ?></a> -->
                                        <a href="view.php?id=<?= base64_encode($latestPost->id); ?>"><?= $latestPost->title; ?></a>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>

                    </div>
                </div>
                <div class="col-md-6 tn-right">
                    <div class="row">
                        <?php
                        $sql = "SELECT id, title, slug, image FROM posts ORDER BY id DESC LIMIT 4";
                        $stmt = $conn->query($sql);
                        $recentPosts = $stmt->fetchAll(PDO::FETCH_OBJ);

                        foreach ($recentPosts as $recentPost) { ?>
                            <div class="col-md-6">
                                <div class="tn-img">
                                    <img src="admin/<?= $recentPost->image; ?>" />
                                    <div class="tn-title">
                                        <!-- <a href="view.php?slug=<? //= $recentPost->slug; 
                                                                    ?>"><? //= $recentPost->title; 
                                                                        ?></a> -->
                                        <a href="view.php?id=<?= base64_encode($recentPost->id); ?>"><?= $recentPost->title; ?></a>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Top News End -->

    <!-- Row 1 Category News Start -->
    <div class="cat-news">
        <div class="container">
            <div class="row">
                <!-- Business Category -->
                <div class="col-md-6">
                    <h2>Business</h2>
                    <div class="row cn-slider">
                        <?php
                        $sql = "SELECT id, category_id, title, slug, image FROM posts WHERE category_id = 1 ORDER BY id DESC LIMIT 3";
                        $stmt = $conn->query($sql);
                        $busPosts = $stmt->fetchAll(PDO::FETCH_OBJ);

                        foreach ($busPosts as $busPost) { ?>
                            <div class="col-md-6">
                                <div class="cn-img">
                                    <img src="admin/<?= $busPost->image; ?>" />
                                    <div class="cn-title">
                                        <a href="view.php?id=<?= base64_encode($busPost->id); ?>"><?= $busPost->title; ?></a>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>

                <!-- International Category -->
                <div class="col-md-6">
                    <h2>International</h2>
                    <div class="row cn-slider">
                        <?php
                        $sql = "SELECT id, category_id, title, slug, image FROM posts WHERE category_id = 3 ORDER BY id DESC LIMIT 3";
                        $stmt = $conn->query($sql);
                        $intPosts = $stmt->fetchAll(PDO::FETCH_OBJ);

                        foreach ($intPosts as $intPost) { ?>
                            <div class="col-md-6">
                                <div class="cn-img">
                                    <img src="admin/<?= $intPost->image; ?>" />
                                    <div class="cn-title">
                                        <a href="view.php?id=<?= base64_encode($intPost->id); ?>"><?= $intPost->title; ?></a>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Row 1 Category News End -->

    <!-- Row 2 Category News Start -->
    <div class="cat-news">
        <div class="container">
            <div class="row">
                <!-- Youth Category -->
                <div class="col-md-6">
                    <h2>Youth</h2>
                    <div class="row cn-slider">
                        <?php
                        $sql = "SELECT id, category_id, title, slug, image FROM posts WHERE category_id = 5 ORDER BY id DESC LIMIT 3";
                        $stmt = $conn->query($sql);
                        $youthPosts = $stmt->fetchAll(PDO::FETCH_OBJ);

                        foreach ($youthPosts as $youthPost) { ?>
                            <div class="col-md-6">
                                <div class="cn-img">
                                    <img src="admin/<?= $youthPost->image; ?>" />
                                    <div class="cn-title">
                                        <a href="view.php?id=<?= base64_encode($youthPost->id); ?>"><?= $youthPost->title; ?></a>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>

                <!-- Technology Category -->
                <div class="col-md-6">
                    <h2>Technology</h2>
                    <div class="row cn-slider">
                        <?php
                        $sql = "SELECT id, category_id, title, slug, image FROM posts WHERE category_id = 6 ORDER BY id DESC LIMIT 3";
                        $stmt = $conn->query($sql);
                        $techPosts = $stmt->fetchAll(PDO::FETCH_OBJ);

                        foreach ($techPosts as $techPost) { ?>
                            <div class="col-md-6">
                                <div class="cn-img">
                                    <img src="admin/<?= $techPost->image; ?>" />
                                    <div class="cn-title">
                                        <a href="view.php?id=<?= base64_encode($techPost->id); ?>"><?= $techPost->title; ?></a>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Row 2 Category News End -->

    <!-- Row 3 Category News Start -->
    <div class="cat-news">
        <div class="container">
            <div class="row">
                <!-- Sports Category -->
                <div class="col-md-6">
                    <h2>Sports</h2>
                    <div class="row cn-slider">
                        <?php
                        $sql = "SELECT id, category_id, title, slug, image FROM posts WHERE category_id = 4 ORDER BY id DESC LIMIT 3";
                        $stmt = $conn->query($sql);
                        $sportsPosts = $stmt->fetchAll(PDO::FETCH_OBJ);

                        foreach ($sportsPosts as $sportsPost) { ?>
                            <div class="col-md-6">
                                <div class="cn-img">
                                    <img src="admin/<?= $sportsPost->image; ?>" />
                                    <div class="cn-title">
                                        <a href="view.php?id=<?= base64_encode($sportsPost->id); ?>"><?= $sportsPost->title; ?></a>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>

                <!-- Entertainment Category -->
                <div class="col-md-6">
                    <h2>Entertainment</h2>
                    <div class="row cn-slider">
                        <?php
                        $sql = "SELECT id, category_id, title, slug, image FROM posts WHERE category_id = 2 ORDER BY id DESC LIMIT 3";
                        $stmt = $conn->query($sql);
                        $entPosts = $stmt->fetchAll(PDO::FETCH_OBJ);

                        foreach ($entPosts as $entPost) { ?>
                            <div class="col-md-6">
                                <div class="cn-img">
                                    <img src="admin/<?= $entPost->image; ?>" />
                                    <div class="cn-title">
                                        <a href="view.php?id=<?= base64_encode($entPost->id); ?>"><?= $entPost->title; ?></a>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Row 3 Category News End -->

    <!-- Tab News Start -->
    <div class="tab-news">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <!-- Tab Nav Left -->
                    <ul class="nav nav-pills nav-justified">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="pill" href="#featured">Featured News</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="pill" href="#popular">Popular News</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="pill" href="#latest">Latest News</a>
                        </li>
                    </ul>

                    <div class="tab-content">
                        <!-- Featured Tab -->
                        <div id="featured" class="container tab-pane active">
                            <?php
                            $sql = "SELECT id, title, slug, image FROM posts WHERE featured = 1 ORDER BY id DESC LIMIT 3";
                            $stmt = $conn->query($sql);
                            $featTabPosts = $stmt->fetchAll(PDO::FETCH_OBJ);

                            foreach ($featTabPosts as $featTabPost) { ?>
                                <div class="tn-news">
                                    <div class="tn-img">
                                        <img src="admin/<?= $featTabPost->image; ?>" />
                                    </div>
                                    <div class="tn-title">
                                        <a href="view.php?id=<?= base64_encode($featTabPost->id); ?>"><?= $featTabPost->title; ?></a>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>

                        <!-- Popular Tab -->
                        <div id="popular" class="container tab-pane fade">
                            <?php
                            $sql = "SELECT id, title, slug, image FROM posts ORDER BY id DESC LIMIT 3";
                            // order by hits? shares?
                            $stmt = $conn->query($sql);
                            $popTabPosts = $stmt->fetchAll(PDO::FETCH_OBJ);

                            foreach ($popTabPosts as $popTabPost) { ?>
                                <div class="tn-news">
                                    <div class="tn-img">
                                        <img src="admin/<?= $popTabPost->image; ?>" />
                                    </div>
                                    <div class="tn-title">
                                        <a href="view.php?id=<?= base64_encode($popTabPost->id); ?>"><?= $popTabPost->title; ?></a>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>

                        <!-- Latest Tab -->
                        <div id="latest" class="container tab-pane fade">
                            <?php
                            $sql = "SELECT id, title, slug, image FROM posts ORDER BY updated DESC LIMIT 3";
                            $stmt = $conn->query($sql);
                            $latestTabPosts = $stmt->fetchAll(PDO::FETCH_OBJ);

                            foreach ($latestTabPosts as $latestTabPost) { ?>
                                <div class="tn-news">
                                    <div class="tn-img">
                                        <img src="admin/<?= $latestTabPost->image; ?>" />
                                    </div>
                                    <div class="tn-title">
                                        <a href="view.php?id=<?= base64_encode($latestTabPost->id); ?>"><?= $latestTabPost->title; ?></a>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <!-- Tab Nav Right -->
                    <ul class="nav nav-pills nav-justified">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="pill" href="#m-viewed">Most Viewed</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="pill" href="#m-read">Most Read</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="pill" href="#m-recent">Most Recent</a>
                        </li>
                    </ul>

                    <div class="tab-content">
                        <!-- Viewed Tab -->
                        <div id="m-viewed" class="container tab-pane active">
                            <?php
                            $sql = "SELECT id, title, slug, image FROM posts ORDER BY id DESC LIMIT 3";
                            // order by hits
                            $stmt = $conn->query($sql);
                            $viewTabPosts = $stmt->fetchAll(PDO::FETCH_OBJ);

                            foreach ($viewTabPosts as $viewTabPost) { ?>
                                <div class="tn-news">
                                    <div class="tn-img">
                                        <img src="admin/<?= $viewTabPost->image; ?>" />
                                    </div>
                                    <div class="tn-title">
                                        <a href="view.php?id=<?= base64_encode($viewTabPost->id); ?>"><?= $viewTabPost->title; ?></a>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>

                        <!-- Read Tab -->
                        <div id="m-read" class="container tab-pane fade">
                            <?php
                            $sql = "SELECT id, title, slug, image FROM posts ORDER BY id DESC LIMIT 3";
                            // order by hits
                            $stmt = $conn->query($sql);
                            $readTabPosts = $stmt->fetchAll(PDO::FETCH_OBJ);

                            foreach ($readTabPosts as $readTabPost) { ?>
                                <div class="tn-news">
                                    <div class="tn-img">
                                        <img src="admin/<?= $readTabPost->image; ?>" />
                                    </div>
                                    <div class="tn-title">
                                        <a href="view.php?id=<?= base64_encode($readTabPost->id); ?>"><?= $readTabPost->title; ?></a>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>

                        <!-- Recent Tab -->
                        <div id="m-recent" class="container tab-pane fade">
                            <?php
                            $sql = "SELECT id, title, slug, image FROM posts ORDER BY created DESC LIMIT 3";
                            $stmt = $conn->query($sql);
                            $recentTabPosts = $stmt->fetchAll(PDO::FETCH_OBJ);

                            foreach ($recentTabPosts as $recentTabPost) { ?>
                                <div class="tn-news">
                                    <div class="tn-img">
                                        <img src="admin/<?= $recentTabPost->image; ?>" />
                                    </div>
                                    <div class="tn-title">
                                        <a href="view.php?id=<?= base64_encode($recentTabPost->id); ?>"><?= $recentTabPost->title; ?></a>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Tab News End -->

    <!-- Main News Start -->
    <div class="main-news">
        <div class="container">
            <div class="row">
                <div class="col-lg-9">
                    <div class="row">
                    <?php
                        $sql = "SELECT id, title, slug, image FROM posts ORDER BY RAND() DESC LIMIT 9";
                        $stmt = $conn->query($sql);
                        $newsPosts = $stmt->fetchAll(PDO::FETCH_OBJ);

                        foreach ($newsPosts as $newsPost) { ?>
                            <div class="col-md-4">
                                <div class="mn-img">
                                    <img src="admin/<?= $newsPost->image; ?>" />
                                    <div class="mn-title">
                                        <a href="view.php?id=<?= base64_encode($newsPost->id); ?>"><?= $newsPost->title; ?></a>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>

                <div class="col-lg-3">
                    <div class="sidebar">
                        <!-- Tags -->
                        <div class="sidebar-widget">
                            <h2 class="sw-title">Tags</h2>
                            <?php
                            $sql = "SELECT * FROM tags LIMIT 20";
                            $stmt = $conn->query($sql);
                            $tags = $stmt->fetchAll(PDO::FETCH_OBJ);
                            ?>
                            <div class="tags">
                                <?php
                                if ($tags != null) {
                                    foreach ($tags as $tag) { ?>
                                        <a href="tag_news.php?tagId=<?= $tag->id; ?>"><?= $tag->name; ?></a>
                                <?php }
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Main News End -->

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