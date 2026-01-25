<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/ITS/config/Connect_DB.php';

$id        = $_POST['user_id'];
$full_name = $_POST['full_name'];
$email     = $_POST['email'];
$phone     = $_POST['phone'];
$birthday  = $_POST['birthday'] ?: null;
$role      = $_POST['role'];
$status    = $_POST['status'];
$managed_station_id = $_POST['managed_station_id'] ?? null;
$password  = $_POST['password'] ?? '';

$managed_station_id = ($role === 'STATION' && !empty($_POST['managed_station_id'])) ? $_POST['managed_station_id'] : null;

if ($password !== '') {
    // Có đổi mật khẩu
    $hashed = password_hash($password, PASSWORD_BCRYPT);

    $stmt = $conn->prepare(
        "UPDATE users
         SET full_name=?, email=?, phone=?, birthday=?, role=?, status=?, managed_station_id=?, password=?
         WHERE user_id=?"
    );

    $stmt->execute([
        $full_name, $email, $phone, $birthday, $role, $status, $managed_station_id, $hashed, $id
    ]);
} else {
    // Không đổi mật khẩu
    $stmt = $conn->prepare(
        "UPDATE users
         SET full_name=?, email=?, phone=?, birthday=?, role=?, status=?, managed_station_id=?
         WHERE user_id=?"
    );

    $stmt->execute([
        $full_name, $email, $phone, $birthday, $role, $status, $managed_station_id, $id
    ]);
}

$_SESSION['swal'] = [
    'type' => 'success',
    'title' => 'Cập nhật thành công',
    'text' => 'Thông tin người dùng đã được cập nhật'
];

header('Location: /ITS/assets/html/layout/admin/manage_users.php');
exit;