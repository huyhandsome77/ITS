<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/ITS/config/Connect_DB.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /ITS/assets/html/layout/admin/manage_users.php');
    exit;
}

$full_name = trim($_POST['full_name']);
$email     = trim($_POST['email']);
$phone     = trim($_POST['phone']);
$password  = $_POST['password'];
$birthday  = $_POST['birthday'] ?: null;
$role      = $_POST['role'];
$status    = $_POST['status'];

if (!$full_name || !$email || !$password) {
    $_SESSION['swal'] = [
        'type' => 'error',
        'title' => 'Lỗi',
        'text' => 'Vui lòng nhập đầy đủ thông tin bắt buộc'
    ];
    header('Location: /ITS/assets/html/layout/admin/manage_users.php');
    exit;
}

// Check email trùng
$check = $conn->prepare("SELECT COUNT(*) FROM users WHERE email = ?");
$check->execute([$email]);
if ($check->fetchColumn() > 0) {
    $_SESSION['swal'] = [
        'type' => 'warning',
        'title' => 'Email đã tồn tại',
        'text' => 'Vui lòng sử dụng email khác'
    ];
    header('Location: /ITS/assets/html/layout/admin/manage_users.php');
    exit;
}

// Hash password
$hashedPassword = password_hash($password, PASSWORD_BCRYPT);

// Insert
$stmt = $conn->prepare(
    "INSERT INTO users (full_name, email, phone, password, birthday, role, status)
     VALUES (?, ?, ?, ?, ?, ?, ?)"
);
$stmt->execute([
    $full_name,
    $email,
    $phone,
    $hashedPassword,
    $birthday,
    $role,
    $status
]);

$_SESSION['swal'] = [
    'type' => 'success',
    'title' => 'Thành công',
    'text' => 'Đã thêm người dùng mới'
];

header('Location: /ITS/assets/html/layout/admin/manage_users.php');
exit;