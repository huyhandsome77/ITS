<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/ITS/config/Connect_DB.php';

$id = (int)($_GET['id'] ?? 0);

$stmt = $conn->prepare(
    "SELECT u.user_id, u.full_name, u.email, u.phone, u.role, u.status, u.birthday, u.created_at, s.station_name as managed_station_name
     FROM users u
     LEFT JOIN stations s ON u.managed_station_id = s.station_id
     WHERE u.user_id = ?"
);
$stmt->execute([$id]);

$user = $stmt->fetch(PDO::FETCH_ASSOC);

echo json_encode($user);