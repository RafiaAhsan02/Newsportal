<?php
$realpath = realpath(dirname(__FILE__));
include $realpath . "/../database/db_connect.php";

session_start();


if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];

    try {
        // get post for image deletion
        $sql = "SELECT * FROM posts WHERE id=:id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_OBJ);
        if ($result && $result->image) {
            unlink($result->image);
        }

        // delete post
        $sql = "DELETE FROM posts WHERE id=:id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $_SESSION['del'] = "Post deleted successfully.";
        echo "<script>window.location.href = 'posts.php';</script>";
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}
