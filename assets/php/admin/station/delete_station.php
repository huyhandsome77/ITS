<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/ITS/config/Connect_DB.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/ITS/helpers/flash.php';

$id = $_GET['id'] ?? null;

$stmt = $conn->prepare("
    SELECT 
        is_maintenance,
        (SELECT COUNT(*) FROM vehicles WHERE station_id = ?) AS total_vehicles
    FROM stations
    WHERE station_id = ?
");
$stmt->execute([$id, $id]);
$station = $stmt->fetch();

if (!$station || $station['is_maintenance'] || $station['total_vehicles'] > 0) {
    setFlashAlert('error', 'Không thể xóa', 'Trạm đang có xe hoặc đang bảo trì');
    header('Location: /ITS/assets/html/layout/admin/manage_stations.php');
    exit;
}

$conn->prepare("DELETE FROM stations WHERE station_id = ?")->execute([$id]);

setFlashAlert('success', 'Đã xóa', 'Trạm đã được xóa thành công');
header('Location: /ITS/assets/html/layout/admin/manage_stations.php');
exit;