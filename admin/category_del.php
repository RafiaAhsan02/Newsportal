<?php
$realpath = realpath(dirname(__FILE__));
include $realpath . "/../database/db_connect.php";

session_start();


if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = base64_decode($_GET['id']);
    try {
        $sql = "DELETE FROM categories WHERE id=:id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $_SESSION['del'] = "Category deleted successfully.";
        echo "<script>window.location.href = 'categories.php';</script>";
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}
