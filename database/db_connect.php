<?php
include ("config.php");

// PDO method:
try{
    $conn = new PDO("mysql:host=".DB_HOST."; dbname=".DB_NAME.";charset=utf8", DB_USER, DB_PASS);
    // set PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Connected successfully!";
} catch(PDOException $e) {
    echo "Connection failed:" . $e->getMessage();
}
?>
