<div class="nav-bar">
    <div class="container">
        <nav class="navbar navbar-expand-md bg-dark navbar-dark">
            <a href="#" class="navbar-brand">MENU</a>
            <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                <div class="navbar-nav mr-auto">
                    <a href="index.php" class="nav-item nav-link active">Home</a>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Categories</a>
                        <div class="dropdown-menu">
                            <?php
                            $sql = "SELECT * FROM categories ORDER BY name";
                            $stmt = $conn->query($sql);
                            $categories = $stmt->fetchAll(PDO::FETCH_OBJ);
                            ?>

                            <ul class="list-unstyled">
                                <?php
                                if ($categories != null) {
                                    foreach ($categories as $category) { ?>
                                        <li class="dropdown-item"><a href="category_news.php?category=<?= $category->id; ?>"><?= $category->name; ?></a></li>
                                <?php }
                                }
                                ?>
                            </ul>
                        </div>
                    </div>
                    <a href="contact.php" class="nav-item nav-link">Contact Us</a>
                </div>
                <div class="social ml-auto">
                    <a href="javascript:void(0);"><i class="fab fa-twitter"></i></a>
                    <a href="javascript:void(0);"><i class="fab fa-facebook-f"></i></a>
                    <a href="javascript:void(0);"><i class="fab fa-linkedin-in"></i></a>
                    <a href="javascript:void(0);"><i class="fab fa-instagram"></i></a>
                    <a href="javascript:void(0);"><i class="fab fa-youtube"></i></a>
                </div>
            </div>
        </nav>
    </div>
</div>