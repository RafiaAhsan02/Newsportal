<?php
$title = 'Edit Post';
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

                    // post id and old img
                    $id = $_POST['id'];
                    $postOldImg = $_POST['postOldImg'];
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


                    if ($fileName) {
                        $ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
                        $allowItem = array('jpg', 'jpeg', 'png', 'webp');
                        $uniqueImgName = uniqid() . time() . '.' . $ext;
                        $upload_Image = 'uploads/post/' . $uniqueImgName;

                        if ($fileSize > 1048576) {
                            /* max photo size 1mb */
                            $error['image'] = "Maximum image size is 1 MB.";
                        } else {
                            if (!in_array($ext, $allowItem)) {
                                $error['image'] = "Supported formats: jpg, jpeg, webp, png.";
                            } else {
                                unlink($postOldImg); //deletes old img
                                move_uploaded_file($fileTmp, $upload_Image);
                                $data['image'] = $upload_Image;
                            }
                        }
                    } else {
                        $data['image'] = $postOldImg;
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
                            $sql = "UPDATE posts SET title=:title, slug=:slug, description=:description, meta_title=:meta_title, meta_description=:meta_description, status=:status, image=:image, featured=:featured, category_id=:category_id, user_id=:user_id, updated=:updated WHERE id=:postId";

                            if ($stmt = $conn->prepare($sql)) {
                                $currentTime = date('Y-m-d H-i-s');
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
                                $stmt->bindParam(':updated', $currentTime, PDO::PARAM_STR);
                                $stmt->bindParam(':postId', $id, PDO::PARAM_INT);
                                $stmt->execute();

                                // select existing tags
                                $query = "SELECT * FROM post_tags WHERE post_id=:postId";
                                $stmtForTag = $conn->prepare($query);
                                $stmtForTag->bindParam('postId', $id, PDO::PARAM_INT);
                                $stmtForTag->execute();
                                $tagIds = $stmtForTag->fetchAll(PDO::FETCH_ASSOC);

                                // delete existing tags
                                if ($tagIds) {
                                    foreach ($tagIds as $tagId) {
                                        $sql = "DELETE FROM post_tags WHERE post_id=:postId";
                                        $stmt = $conn->prepare($sql);
                                        $stmt->bindParam(':postId', $id, PDO::PARAM_INT);
                                        $stmt->execute();
                                    }
                                }

                                // insert updated tags
                                if ($data['tags']) {
                                    foreach ($tags as $key => $tag) {
                                        $sql = "INSERT INTO post_tags(post_id, tag_id) VALUES(:post_id, :tag_id)";
                                        if ($stmt = $conn->prepare($sql)) {
                                            $stmt->bindParam(':post_id', $id, PDO::PARAM_INT);
                                            $stmt->bindParam(':tag_id', $tags[$key], PDO::PARAM_INT);
                                            $stmt->execute();
                                        }
                                    }
                                }

                                $_SESSION['success'] = "Post has been updated.";
                                echo "<script>window.location.href = 'posts.php';</script>";
                            }
                        } catch (PDOException $e) {
                            echo $e->getMessage();
                        }
                    }
                }
                ?>

                <!-- get post via id -->
                <?php
                if (isset($_GET['id']) && !empty($_GET['id'])) {
                    $id = $_GET['id'];

                    try {
                        $sql = "SELECT * FROM posts WHERE id=:id";
                        $stmt = $conn->prepare($sql);
                        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                        $stmt->execute();

                        $result = $stmt->fetch(PDO::FETCH_OBJ);
                        $data = [
                            'id' => $result->id,
                            'title' => $result->title,
                            'slug' => $result->slug,
                            'description' => $result->description,
                            'image' => $result->image,
                            'category' => $result->category_id,
                            'status' => $result->status,
                            'featured' => $result->featured,
                            'meta_title' => $result->meta_title,
                            'meta_description' => $result->meta_description,
                        ];
                    } catch (PDOException $e) {
                        echo $e->getMessage();
                    }
                }
                ?>

                <div class="ibox">
                    <div class="ibox-head">
                        <div class="ibox-title">Edit Post</div>
                        <div class="ibox-title">
                            <a href="posts.php" class="btn btn-primary">Back to Posts</a>
                        </div>
                    </div>
                    <div class="ibox-body">

                        <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="id" value="<?= $data["id"] ?? ""; ?>">
                            <input type="hidden" name="postOldImg" value="<?= $data["image"] ?? ""; ?>">

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
                                        <textarea name="description" id="description" class="form-control"><?= $data["description"] ?? ""; ?></textarea>
                                        <span class="text-danger"><?= $error["description"] ?? ""; ?></span>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="status">Status</label>
                                                <div>
                                                    <label class="ui-radio ui-radio-inline">
                                                        <input type="radio" name="status" <?= $result->status == 'draft' ? 'checked' : ''; ?> value="draft">
                                                        <span class="input-span"></span>Draft
                                                    </label>
                                                    <label class="ui-radio ui-radio-inline">
                                                        <input type="radio" name="status" <?= $result->status == 'published' ? 'checked' : ''; ?> value="published">
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
                                                        <input type="radio" name="featured" <?= $result->featured == 1 ? 'checked' : ''; ?> value="1">
                                                        <span class="input-span"></span>Yes
                                                    </label>
                                                    <label class="ui-radio ui-radio-inline">
                                                        <input type="radio" name="featured" <?= $result->featured == 0 ? 'checked' : ''; ?> value="0">
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
                                        <input type="file" name="image" id="image" class="form-control" data-allowed-file-extensions="jpg jpeg png webp" data-default-file="<?= $data["image"] ?? ""; ?>">
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
                                                    <option
                                                        <?= $result->category_id == $category['id'] ? 'selected' : ''; ?>
                                                        value="<?= $category['id']; ?>"><?= $category['name']; ?></option>
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
                                            // get post tags id
                                            $query = "SELECT * FROM post_tags WHERE post_id=:postId";
                                            $stmtForTag = $conn->prepare($query);
                                            $stmtForTag->bindParam('postId', $data['id'], PDO::PARAM_INT); // could replace $data with $result->id
                                            $stmtForTag->execute();
                                            $tagIds = $stmtForTag->fetchAll(PDO::FETCH_OBJ);
                                            ?>

                                            <?php
                                            if ($tags) {
                                                foreach ($tags as $tag) { ?>
                                                    <option
                                                        <?php
                                                        foreach ($tagIds as $tagId) {
                                                            if ($tagId->tag_id == $tag['id']) {
                                                                echo 'selected';
                                                            }
                                                        }
                                                        ?>
                                                        value="<?= $tag['id']; ?>"><?= $tag['name']; ?></option>
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
                                        <!-- <span class="text-danger"><?= $error["meta_title"] ?? ""; ?></span> -->
                                    </div>

                                    <div class="form-group">
                                        <label for="meta_description">Meta Description</label>
                                        <textarea name="meta_description" id="meta_description" class="form-control" placeholder="Meta Description" rows="4"><?= $data["meta_description"] ?? ""; ?></textarea>
                                        <!-- <span class="text-danger"><?= $error["meta_description"] ?? ""; ?></span> -->
                                    </div>
                                </div>
                            </div>

                            <button type="submit" name="submit" class="btn btn-primary">Update</button>
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
    <script src="./assets/vendors/dropify/js/dropify.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
</body>