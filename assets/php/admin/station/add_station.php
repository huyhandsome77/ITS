<?php
session_start();

require_once $_SERVER['DOCUMENT_ROOT'] . '/ITS/config/Connect_DB.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/ITS/helpers/flash.php';

// ===== LẤY DATA =====
$name = trim($_POST['station_name'] ?? '');
$address = trim($_POST['address'] ?? '');
$city = trim($_POST['city'] ?? '');
$district = trim($_POST['district'] ?? '');
$is_maintenance = (int)($_POST['is_maintenance'] ?? 0);
$lat = !empty($_POST['latitude']) ? $_POST['latitude'] : null;
$lng = !empty($_POST['longitude']) ? $_POST['longitude'] : null;

// ===== VALIDATE =====
if ($name === '') {
    setFlashAlert('error', 'Lỗi', 'Tên trạm không được để trống');
    header('Location: /ITS/assets/html/layout/admin/manage_stations.php');
    exit;
}

if ($city === '' || $district === '') {
    setFlashAlert('error', 'Lỗi', 'Vui lòng chọn Thành phố và Quận/Huyện');
    header('Location: /ITS/assets/html/layout/admin/manage_stations.php');
    exit;
}

// ===== INSERT =====
$stmt = $conn->prepare("
    INSERT INTO stations (station_name, city, district, address, is_maintenance, latitude, longitude)
    VALUES (?, ?, ?, ?, ?, ?, ?)
");

$stmt->execute([
    $name,
    $city,
    $district,
    $address,
    $is_maintenance,
    $lat,
    $lng
]);

// ===== SUCCESS =====
setFlashAlert('success', 'Thành công', 'Đã thêm trạm mới');
header('Location: /ITS/assets/html/layout/admin/manage_stations.php');
exit;