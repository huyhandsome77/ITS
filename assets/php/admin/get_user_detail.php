<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/ITS/config/Connect_DB.php';

$id = (int)($_GET['id'] ?? 0);

$stmt = $conn->prepare(
    "SELECT user_id, full_name, email, phone, role, status, birthday, created_at
     FROM users
     WHERE user_id = ?"
);
$stmt->execute([$id]);

$user = $stmt->fetch(PDO::FETCH_ASSOC);

echo json_encode($user);