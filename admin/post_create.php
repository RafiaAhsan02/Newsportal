<?php
$title = 'Create Post';
$realpath = realpath(dirname(__FILE__));
include $realpath . "/layout/head.php";
include $realpath . "/../../helper/Helper.php";
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

                <?php
                $data = [];
                $error = [];

                if (isset($_POST['submit'])) {
                    $title = validate($_POST['title']);
                    $slug = validate($_POST['slug']);
                    $description = $_POST['description'];
                    $category = $_POST['category'] ?? null;
                    $tags = $_POST['tags'] ?? null;
                    $status = $_POST['status'] ?? null;
                    $featured = $_POST['featured'] ?? null;
                    $meta_title = validate($_POST['meta_title']);
                    $meta_description = validate($_POST['meta_description']);

                    // get file info
                    $fileName = $_FILES['image']['name'];
                    $fileTmp = $_FILES['image']['tmp_name'];
                    $fileSize = $_FILES['image']['size'];
                    //$fileType = $_FILES['image']['type'];

                    if (empty($title)) {
                        $error['title'] = 'Please title your post.';
                    } else {
                        $data['title'] = $title;
                    }

                    if (empty($slug)) {
                        $error['slug'] = 'Slug is required.';
                    } else {
                        $data['slug'] = $slug;
                    }

                    if (empty($description)) {
                        $error['description'] = 'Please add a description.';
                    } else {
                        $data['description'] = $description;
                    }

                    if (empty($category)) {
                        $error['category'] = 'Please select a category.';
                    } else {
                        $data['category'] = $category;
                    }

                    if (is_array_empty($tags)) {
                        $data['tags'] = $tags;
                    } else {
                        $error['tags'] = 'Please select at least one tag.';
                    }

                    if (empty($status)) {
                        $error['status'] = 'Post status is required.';
                    } else {
                        $data['status'] = $status;
                    }

                    if (!isset($_POST['featured'])) {
                        $error['featured'] = 'Please specify whether the post is featured or not.';
                    } else {
                        $data['featured'] = $featured;
                    }

                    $ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
                    $allowItem = array('jpg', 'jpeg', 'png', 'webp');
                    $uniqueImgName = uniqid() . time() . '.' . $ext;
                    $upload_Image = 'uploads/post/' . $uniqueImgName;

                    if (empty($fileName)) {
                        $error['image'] = "Please add a thumbnail.";
                    } elseif ($fileSize > 1048576) {
                        /* max photo size 1mb */
                        $error['image'] = "Maximum image size is 1 MB.";
                    } else {
                        if (!in_array($ext, $allowItem)) {
                            $error['image'] = "Supported formats: jpg, jpeg, webp, png.";
                        } else {
                            $data['image'] = $upload_Image;
                        }
                    }

                    /*if (empty($meta_title)) {
                        $error['meta_title'] = 'Meta title is required.';
                    } else {
                        $data['meta_title'] = $meta_title;
                    }

                    if (empty($meta_description)) {
                        $error['meta_description'] = 'Meta description is required.';
                    } else {
                        $data['meta_description'] = $meta_description;
                    }*/

                    if (empty($error)) {
                        try {
                            $sql = "INSERT INTO posts(title, slug, description, meta_title, meta_description, status, image, featured, category_id, user_id, created, updated) VALUES(:title, :slug, :description, :meta_title, :meta_description, :status, :image, :featured, :category_id, :user_id, :created, :updated)";

                            if ($stmt = $conn->prepare($sql)) {
                                $currentTime = date('Y-m-d H-i-s');
                                // uses UTC timezone!
                                $stmt->bindParam(':title', $data['title'], PDO::PARAM_STR);
                                $stmt->bindParam(':slug', $data['slug'], PDO::PARAM_STR);
                                $stmt->bindParam(':description', $data['description'], PDO::PARAM_STR);
                                $stmt->bindParam(':meta_title', $meta_title, PDO::PARAM_STR);
                                $stmt->bindParam(':meta_description', $meta_description, PDO::PARAM_STR);
                                $stmt->bindParam(':status', $status, PDO::PARAM_STR);
                                $stmt->bindParam(':image', $data['image'], PDO::PARAM_STR);
                                $stmt->bindParam(':featured', $data['featured'], PDO::PARAM_BOOL);
                                $stmt->bindParam(':category_id', $data['category'], PDO::PARAM_INT);
                                $stmt->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
                                $stmt->bindParam(':created', $currentTime, PDO::PARAM_STR);
                                $stmt->bindParam(':updated', $currentTime, PDO::PARAM_STR);

                                $stmt->execute();

                                $postId = $conn->lastInsertId();

                                // insert post tags
                                if ($data['tags']) {
                                    foreach ($tags as $key => $tag) {
                                        $sql = "INSERT INTO post_tags(post_id, tag_id) VALUES(:post_id, :tag_id)";
                                        if ($stmt = $conn->prepare($sql)) {
                                            $stmt->bindParam(':post_id', $postId, PDO::PARAM_INT);
                                            $stmt->bindParam(':tag_id', $tags[$key], PDO::PARAM_INT);
                                            $stmt->execute();
                                        }
                                    }
                                }

                                if ($postId) {
                                    if ($fileName != null) {
                                        move_uploaded_file($fileTmp, $upload_Image);
                                    }

                                    $_SESSION['success'] = "A new post has been created.";
                                    echo "<script>window.location.href = 'posts.php';</script>";
                                };
                            }
                        } catch (PDOException $e) {
                            echo $e->getMessage();
                        }
                    }
                }
                ?>

                <div class="ibox">
                    <div class="ibox-head">
                        <div class="ibox-title">Create New Post</div>
                        <div class="ibox-title">
                            <a href="posts.php" class="btn btn-primary">Back to Posts</a>
                        </div>
                    </div>
                    <div class="ibox-body">
                        <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-lg-8">
                                    <div class="form-group">
                                        <label for="title">Post Title</label>
                                        <input type="text" name="title" id="title" class="form-control" placeholder="Post Title" value="<?= $data["title"] ?? ""; ?>">
                                        <span class="text-danger"><?= $error["title"] ?? ""; ?></span>
                                    </div>

                                    <div class="form-group">
                                        <label for="slug">Slug</label>
                                        <input type="text" name="slug" id="slug" class="form-control" placeholder="Slug" value="<?= $data["slug"] ?? ""; ?>">
                                        <span class="text-danger"><?= $error["slug"] ?? ""; ?></span>
                                    </div>

                                    <div class="form-group">
                                        <label for="description">Description</label>
                                        <textarea name="description" id="description" class="form-control" value="<?= $data["description"] ?? ""; ?>"><?= $data["description"] ?? ""; ?></textarea>
                                        <span class="text-danger"><?= $error["description"] ?? ""; ?></span>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="status">Status</label>
                                                <div>
                                                    <label class="ui-radio ui-radio-inline">
                                                        <input type="radio" name="status" value="draft" checked>
                                                        <span class="input-span"></span>Draft
                                                    </label>
                                                    <label class="ui-radio ui-radio-inline">
                                                        <input type="radio" name="status" value="published">
                                                        <span class="input-span"></span>Published
                                                    </label>
                                                </div>
                                                <span class="text-danger"><?= $error["status"] ?? ""; ?></span>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="status">Is the post featured?</label>
                                                <div>
                                                    <label class="ui-radio ui-radio-inline">
                                                        <input type="radio" name="featured" value="1">
                                                        <span class="input-span"></span>Yes
                                                    </label>
                                                    <label class="ui-radio ui-radio-inline">
                                                        <input type="radio" name="featured" value="0" checked>
                                                        <span class="input-span"></span>No
                                                    </label>
                                                </div>
                                                <span class="text-danger"><?= $error["featured"] ?? ""; ?></span>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="image">Post Thumbnail</label>
                                        <input type="file" name="image" id="image" class="form-control" data-allowed-file-extensions="jpg jpeg png webp" value="<?= $data["image"] ?? ""; ?>">
                                        <span class="text-danger"><?= $error["image"] ?? ""; ?></span>
                                    </div>

                                    <?php
                                    $sql = "SELECT * FROM categories";
                                    $stmt = $conn->prepare($sql);
                                    $stmt->execute();
                                    $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                    ?>

                                    <div class="form-group">
                                        <label for="category">Select Category</label>
                                        <select name="category" id="category" class="form-control">
                                            <option value="" selected disabled>Choose a Category</option>
                                            <?php
                                            if ($categories) {
                                                foreach ($categories as $category) { ?>
                                                    <option value="<?= $category['id']; ?>"><?= $category['name']; ?></option>
                                            <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                        <span class="text-danger"><?= $error["category"] ?? ""; ?></span>
                                    </div>

                                    <?php
                                    $sql = "SELECT * FROM tags";
                                    $stmt = $conn->prepare($sql);
                                    $stmt->execute();
                                    $tags = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                    ?>

                                    <div class="form-group">
                                        <label for="tags">Select Tags</label>
                                        <select name="tags[]" id="tags" class="form-control select2" multiple>
                                            <?php
                                            if ($tags) {
                                                foreach ($tags as $tag) { ?>
                                                    <option value="<?= $tag['id']; ?>"><?= $tag['name']; ?></option>
                                            <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                        <span class="text-danger"><?= $error["tags"] ?? ""; ?></span>
                                    </div>

                                    <div class="form-group">
                                        <label for="meta_title">Meta Title</label>
                                        <input type="text" name="meta_title" id="meta_title" class="form-control" placeholder="Meta Title" value="<?= $data["meta_title"] ?? ""; ?>">
                                        <!-- <span class="text-danger"><? //= $error["meta_title"] ?? ""; 
                                                                        ?></span> -->
                                    </div>

                                    <div class="form-group">
                                        <label for="meta_description">Meta Description</label>
                                        <textarea name="meta_description" id="meta_description" class="form-control" placeholder="Meta Description" rows="4"><?= $data["meta_description"] ?? ""; ?></textarea>
                                        <!-- <span class="text-danger"><? //= $error["meta_description"] ?? ""; 
                                                                        ?></span> -->
                                    </div>
                                </div>
                            </div>

                            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                        </form>
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
    <script>
        $(document).ready(function() {
            $('#title').keyup(function() {
                let title = $(this).val();
                $('#slug').val(title.toLowerCase().replace(/ /g, '-'));
            });

            // summernote
            $('#description').summernote({
                height: 270,
                placeholder: 'Your post description here',
                tabsize: 2,
            });

            // dropify
            $('#image').dropify({
                height: 100,
            });

            // select2
            $('#tags').select2();

        });
    </script>

    <!-- CORE SCRIPTS-->
    <script src="assets/js/app.min.js" type="text/javascript"></script>
    <!-- PAGE LEVEL SCRIPTS-->
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote.min.js"></script>
    <script src="./assets/vendors/dropify/js/dropify.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
</body>