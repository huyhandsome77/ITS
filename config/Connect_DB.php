<?php
$host = "127.0.0.1";
$dbname = "its";
$username = "root";
$password = "";
$port = "3307";

try {
    $conn = new PDO(
        "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4",
        $username,
        $password,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // bật báo lỗi
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
    );
} catch (PDOException $e) {
    die("Kết nối CSDL thất bại: " . $e->getMessage());
}