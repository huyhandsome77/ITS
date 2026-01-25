<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/ITS/config/Connect_DB.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/ITS/helpers/flash.php';

$id = $_POST['station_id'] ?? null;
$name = trim($_POST['station_name'] ?? '');
$address = trim($_POST['address'] ?? '');
$lat = !empty($_POST['latitude']) ? $_POST['latitude'] : null;
$lng = !empty($_POST['longitude']) ? $_POST['longitude'] : null;

if (!$id || $name === '') {
    setFlashAlert('error', 'Lỗi', 'Dữ liệu không hợp lệ');
    header('Location: /ITS/assets/html/layout/admin/manage_stations.php');
    exit;
}

// Không cho sửa khi đang bảo trì
$check = $conn->prepare("SELECT is_maintenance FROM stations WHERE station_id = ?");
$check->execute([$id]);

if ($check->fetchColumn()) {
    setFlashAlert('error', 'Không thể chỉnh sửa', 'Trạm đang trong trạng thái bảo trì');
    header('Location: /ITS/assets/html/layout/admin/manage_stations.php');
    exit;
}

// Update
$stmt = $conn->prepare("
    UPDATE stations
    SET station_name = ?, address = ?, latitude = ?, longitude = ?
    WHERE station_id = ?
");
$stmt->execute([$name, $address, $lat, $lng, $id]);

setFlashAlert('success', 'Thành công', 'Đã cập nhật thông tin trạm');
header('Location: /ITS/assets/html/layout/admin/manage_stations.php');
exit;