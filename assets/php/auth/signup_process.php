<?php
session_start();
require_once '../../../config/Connect_DB.php';

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../../html/auth/signup.php');
    exit();
}

// Get form data
$fullname = trim($_POST['fullname'] ?? '');
$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';
$confirm_password = $_POST['confirm_password'] ?? '';
$terms = isset($_POST['terms']);

// Validation
$errors = [];

// Validate fullname
if (empty($fullname)) {
    $errors[] = 'Họ và tên không được để trống';
} elseif (strlen($fullname) < 3) {
    $errors[] = 'Họ và tên phải có ít nhất 3 ký tự';
}

// Validate email
if (empty($email)) {
    $errors[] = 'Email không được để trống';
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'Email không hợp lệ';
}

// Validate password
if (empty($password)) {
    $errors[] = 'Mật khẩu không được để trống';
} elseif (strlen($password) < 8) {
    $errors[] = 'Mật khẩu phải có ít nhất 8 ký tự';
} elseif (!preg_match('/[A-Z]/', $password)) {
    $errors[] = 'Mật khẩu phải chứa ít nhất một chữ hoa';
} elseif (!preg_match('/[a-z]/', $password)) {
    $errors[] = 'Mật khẩu phải chứa ít nhất một chữ thường';
} elseif (!preg_match('/[0-9]/', $password)) {
    $errors[] = 'Mật khẩu phải chứa ít nhất một chữ số';
}

// Validate confirm password
if ($password !== $confirm_password) {
    $errors[] = 'Mật khẩu xác nhận không khớp';
}

// Validate terms
if (!$terms) {
    $errors[] = 'Bạn phải đồng ý với điều khoản dịch vụ';
}

// If there are validation errors, redirect back with errors
if (!empty($errors)) {
    $_SESSION['signup_errors'] = $errors;
    $_SESSION['signup_data'] = [
        'fullname' => $fullname,
        'email' => $email
    ];
    header('Location: ../../html/auth/signup.php');
    exit();
}

try {
    // Check if email already exists
    $stmt = $conn->prepare("SELECT user_id FROM users WHERE email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    
    if ($stmt->rowCount() > 0) {
        $_SESSION['signup_errors'] = ['Email đã được sử dụng'];
        $_SESSION['signup_data'] = [
            'fullname' => $fullname,
            'email' => $email
        ];
        header('Location: ../../html/auth/signup.php');
        exit();
    }
    
    // Hash password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
    // Insert new user
    $stmt = $conn->prepare("INSERT INTO users (full_name, email, password, role, status) VALUES (:fullname, :email, :password, 'USER', 'ACTIVE')");
    $stmt->bindParam(':fullname', $fullname);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $hashed_password);
    
    if ($stmt->execute()) {
        $_SESSION['signup_success'] = 'Đăng ký thành công! Vui lòng đăng nhập.';
        header('Location: ../../html/auth/login.php');
        exit();
    } else {
        throw new Exception('Không thể tạo tài khoản');
    }
    
} catch (PDOException $e) {
    $_SESSION['signup_errors'] = ['Có lỗi xảy ra: ' . $e->getMessage()];
    $_SESSION['signup_data'] = [
        'fullname' => $fullname,
        'email' => $email
    ];
    header('Location: ../../html/auth/signup.php');
    exit();
}
