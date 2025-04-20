<nav class="page-sidebar" id="sidebar">
    <div id="sidebar-collapse">
        <div class="admin-block d-flex">
            <div>
                <img src="./assets/img/admin-avatar.png" width="45px" />
            </div>
            <div class="admin-info">
                <div class="font-strong">
                    <?php
                    echo $_SESSION['user_name'];
                    ?>
                </div>
                <small>
                    <?php
                    echo $_SESSION['role'];
                    ?>
                </small>
            </div>
        </div>
        <ul class="side-menu metismenu">
            <li class="<?=isset($title) && $title == 'Dashboard' ? 'active' : '' ; ?>">
                <a href="dashboard.php"><i class="sidebar-item-icon fa fa-home"></i>
                    <span class="nav-label">Dashboard</span>
                </a>
            </li>

            <li class="<?=isset($title) && $title == 'Categories' ? 'active' : '' ; ?>">
                <a href="categories.php"><i class="sidebar-item-icon fa fa-list-ul"></i>
                    <span class="nav-label">Categories</span>
                </a>
            </li>

            <li class="<?=isset($title) && $title == 'Posts' ? 'active' : '' ; ?>">
                <a href="posts.php"><i class="sidebar-item-icon fa fa-newspaper-o"></i>
                    <span class="nav-label">Posts</span>
                </a>
            </li>

            <li class="<?=isset($title) && $title == 'Tags' ? 'active' : '' ; ?>">
                <a href="tags.php"><i class="sidebar-item-icon fa fa-hashtag"></i>
                    <span class="nav-label">Tags</span>
                </a>
            </li>

        </ul>
    </div>
</nav>