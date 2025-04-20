<?php
$realpath = realpath(dirname(__FILE__));
include $realpath . "/../database/db_connect.php";

session_start();


if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = base64_decode($_GET['id']);
    try {
        $sql = "DELETE FROM tags WHERE id=:id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $_SESSION['del'] = "Tag deleted successfully.";
        echo "<script>window.location.href = 'tags.php';</script>";
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}
