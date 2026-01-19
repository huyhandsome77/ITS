<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/ITS/config/Connect_DB.php';

$id = (int)($_GET['id'] ?? 0);

$stmt = $conn->prepare(
    "SELECT user_id, full_name, email, phone, role, status, birthday
     FROM users WHERE user_id = ?"
);
$stmt->execute([$id]);

echo json_encode($stmt->fetch(PDO::FETCH_ASSOC));