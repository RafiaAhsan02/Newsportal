<?php
$title = 'Edit Tag';
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

                <?php
                $data = [];
                $error = [];

                if (isset($_POST["submit"])) {
                    $tag_id = $_POST["tag_id"];
                    $name = $_POST["name"];
                    $slug = $_POST["slug"];

                    if (empty($name)) {
                        $error["name"] = "Please enter a tag name.";
                    } else {
                        $data["name"] = $name;
                    }

                    if (empty($slug)) {
                        $error["slug"] = "Slug is required.";
                    } else {
                        $data["slug"] = $slug;
                    }

                    if (empty($error)) {
                        try {
                            $sql = "UPDATE tags SET name=:name, slug=:slug WHERE id=:id";

                            if ($stmt = $conn->prepare($sql)) {
                                $stmt->bindParam(':id', $tag_id, PDO::PARAM_INT);
                                $stmt->bindParam(':name', $data['name'], PDO::PARAM_STR);
                                $stmt->bindParam(':slug', $data['slug'], PDO::PARAM_STR);

                                if ($stmt->execute()) {
                                    $_SESSION['edit'] = "Tag updated successfully.";
                                    echo "<script>window.location.href = 'tags.php';</script>";
                                }
                            }
                        } catch (PDOException $e) {
                            echo $e->getMessage();
                        }
                    }
                }


                // get url param id and fetch data

                if (isset($_GET['id']) && !empty($_GET['id'])) {

                    $id = base64_decode($_GET['id']);
                    $sql = "SELECT * FROM tags WHERE id=:id";
                    $stmt = $conn->prepare($sql);
                    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                    $stmt->execute();
                    $data = $stmt->fetch(PDO::FETCH_ASSOC);
                }
                ?>

                <div class="ibox">
                    <div class="ibox-head">
                        <div class="ibox-title">Edit Tag</div>
                        <div class="ibox-title">
                            <a href="tags.php" class="btn btn-primary">Back to Tags</a>
                        </div>
                    </div>
                    <div class="ibox-body">
                        <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">

                            <input type="hidden" name="tag_id" value="<?= $data["id"] ?? ""; ?>">

                            <div class="form-group">
                                <label for="name">Tag Name</label>
                                <input type="text" name="name" id="name" class="form-control" value="<?= $data["name"] ?? ""; ?>">
                                <span class="text-danger"><?= $error["name"] ?? ""; ?></span>
                            </div>

                            <div class="form-group">
                                <label for="slug">Slug</label>
                                <input type="text" name="slug" id="slug" class="form-control" value="<?= $data["slug"] ?? ""; ?>">
                                <span class="text-danger"><?= $error["slug"] ?? ""; ?></span>
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
            $('#name').keyup(function() {
                let name = $(this).val();
                $('#slug').val(name.toLowerCase().replace(/ /g, '-'));
            });
        });
    </script>

    <!-- CORE SCRIPTS-->
    <script src="assets/js/app.min.js" type="text/javascript"></script>
    <!-- PAGE LEVEL SCRIPTS-->
</body>