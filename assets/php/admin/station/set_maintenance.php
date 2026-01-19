<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/ITS/config/Connect_DB.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/ITS/helpers/flash.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    setFlashAlert('error', 'Lỗi', 'ID trạm không hợp lệ');
    header('Location: /ITS/assets/html/layout/admin/manage_stations.php');
    exit;
}

$conn->prepare("
    UPDATE stations SET is_maintenance = 1 WHERE station_id = ?
")->execute([$id]);

$conn->prepare("
    UPDATE vehicles SET status = 'MAINTENANCE' WHERE station_id = ?
")->execute([$id]);

setFlashAlert('warning', 'Bảo trì', 'Trạm đã được chuyển sang chế độ bảo trì');
header('Location: /ITS/assets/html/layout/admin/manage_stations.php');
exit;