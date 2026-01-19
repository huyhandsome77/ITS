<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/ITS/config/Connect_DB.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/ITS/helpers/flash.php';

$name = trim($_POST['station_name'] ?? '');
$address = trim($_POST['address'] ?? '');
$is_maintenance = (int)($_POST['is_maintenance'] ?? 0);

if ($name === '') {
    setFlashAlert('error', 'Lỗi', 'Tên trạm không được để trống');
    header('Location: /ITS/assets/html/layout/admin/manage_stations.php');
    exit;
}

$stmt = $conn->prepare("
    INSERT INTO stations (station_name, address, is_maintenance)
    VALUES (?, ?, ?)
");
$stmt->execute([$name, $address, $is_maintenance]);

setFlashAlert('success', 'Thành công', 'Đã thêm trạm mới');
header('Location: /ITS/assets/html/layout/admin/manage_stations.php');
exit;