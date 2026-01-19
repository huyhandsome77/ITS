<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/ITS/config/Connect_DB.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/ITS/helpers/flash.php';

$id = $_GET['id'] ?? null;

$conn->prepare("
    UPDATE stations SET is_maintenance = 0 WHERE station_id = ?
")->execute([$id]);

$conn->prepare("
    UPDATE vehicles 
    SET status = 'AVAILABLE' 
    WHERE station_id = ? AND status = 'MAINTENANCE'
")->execute([$id]);

setFlashAlert('success', 'Hoàn tất', 'Trạm đã hoạt động trở lại');
header('Location: /ITS/assets/html/layout/admin/manage_stations.php');
exit;