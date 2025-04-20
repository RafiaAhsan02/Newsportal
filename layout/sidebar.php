<div class="sidebar">
    <!-- Categories -->
    <div class="sidebar-widget">
        <h2 class="sw-title">Categories</h2>
        <div class="category">
            <?php
            $sql = "SELECT * FROM categories";
            $stmt = $conn->query($sql);
            $categories = $stmt->fetchAll(PDO::FETCH_OBJ);
            ?>

            <ul>
                <?php
                if ($categories != null) {
                    foreach ($categories as $category) { ?>
                        <li><a href="category_news.php?category=<?= $category->id; ?>"><?= $category->name; ?></a><span>(4)</span>
                        </li>
                        <!-- sql count! -->
                <?php }
                }
                ?>
            </ul>
        </div>
    </div>

    <!-- Ad image -->
    <div class="sidebar-widget">
        <div class="image">
            <a href="https://htmlcodex.com"><img src="img/ads-2.jpg" alt="Image"></a>
        </div>
    </div>

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