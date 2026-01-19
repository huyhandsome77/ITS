<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/QuanTriMang/config/Connect_DB.php';

$id        = $_POST['user_id'];
$full_name = $_POST['full_name'];
$email     = $_POST['email'];
$phone     = $_POST['phone'];
$birthday  = $_POST['birthday'] ?: null;
$role      = $_POST['role'];
$status    = $_POST['status'];
$password  = $_POST['password'] ?? '';

if ($password !== '') {
    // Có đổi mật khẩu
    $hashed = password_hash($password, PASSWORD_BCRYPT);

    $stmt = $conn->prepare(
        "UPDATE users
         SET full_name=?, email=?, phone=?, birthday=?, role=?, status=?, password=?
         WHERE user_id=?"
    );

    $stmt->execute([
        $full_name, $email, $phone, $birthday, $role, $status, $hashed, $id
    ]);
} else {
    // Không đổi mật khẩu
    $stmt = $conn->prepare(
        "UPDATE users
         SET full_name=?, email=?, phone=?, birthday=?, role=?, status=?
         WHERE user_id=?"
    );

    $stmt->execute([
        $full_name, $email, $phone, $birthday, $role, $status, $id
    ]);
}

$_SESSION['swal'] = [
    'type' => 'success',
    'title' => 'Cập nhật thành công',
    'text' => 'Thông tin người dùng đã được cập nhật'
];

header('Location: /QuanTriMang/assets/html/layout/admin/manage_users.php');
exit;