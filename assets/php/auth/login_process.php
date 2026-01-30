<?php
session_start();
require_once '../../../config/Connect_DB.php';

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../../html/auth/login.php');
    exit();
}

// Get form data
$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';
$remember = isset($_POST['remember']);

// Validation
$errors = [];

// Validate email
if (empty($email)) {
    $errors[] = 'Email không được để trống';
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'Email không hợp lệ';
}

// Validate password
if (empty($password)) {
    $errors[] = 'Mật khẩu không được để trống';
}

// If there are validation errors, redirect back with errors
if (!empty($errors)) {
    $_SESSION['login_errors'] = $errors;
    $_SESSION['login_email'] = $email;
    header('Location: ../../html/auth/login.php');
    exit();
}

try {
    // Get user by email
    $stmt = $conn->prepare("SELECT user_id, full_name, email, password, role, status FROM users WHERE email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    
    $user = $stmt->fetch();
    
    if (!$user) {
        $_SESSION['login_errors'] = ['Email hoặc mật khẩu không chính xác'];
        $_SESSION['login_email'] = $email;
        header('Location: ../../html/auth/login.php');
        exit();
    }
    
    // Check if account is blocked
    if ($user['status'] === 'BLOCKED') {
        $_SESSION['login_errors'] = ['Tài khoản của bạn đã bị khóa. Vui lòng liên hệ quản trị viên'];
        $_SESSION['login_email'] = $email;
        header('Location: ../../html/auth/login.php');
        exit();
    }
    
    // Verify password
    if (!password_verify($password, $user['password'])) {
        $_SESSION['login_errors'] = ['Email hoặc mật khẩu không chính xác'];
        $_SESSION['login_email'] = $email;
        header('Location: ../../html/auth/login.php');
        exit();
    }
    
    // Login successful - Set session variables
    $_SESSION['user_id'] = $user['user_id'];
    $_SESSION['full_name'] = $user['full_name'];
    $_SESSION['email'] = $user['email'];
    $_SESSION['role'] = $user['role'];
    $_SESSION['logged_in'] = true;
    
    // Handle remember me
    if ($remember) {
        // Set cookie for 30 days
        $token = bin2hex(random_bytes(32));
        setcookie('remember_token', $token, time() + (86400 * 30), '/'); // 30 days
        
        // You should store this token in database for security
        // For now, we'll just set the cookie
    }
    
    // Check if there's pending booking data (user tried to book before login)
    if (isset($_SESSION['pending_booking_data'])) {
        // User was trying to book a vehicle, redirect back to booking page
        // The booking page should check for pending_booking_data and restore the form
        header('Location: /ITS/assets/html/layout/user/list_car.php?restore_booking=1');
        exit();
    }
    
    // Check if there's a redirect URL stored (e.g., from booking page)
    if (isset($_SESSION['redirect_after_login'])) {
        $redirectUrl = $_SESSION['redirect_after_login'];
        unset($_SESSION['redirect_after_login']); // Clear it after use
        header('Location: ' . $redirectUrl);
        exit();
    }
    
    // Default redirect based on role
    switch ($user['role']) {
        case 'ADMIN':
            header('Location: /ITS/assets/html/layout/admin/dashboard.php');
            break;
        case 'DISPATCHER':
            header('Location: /ITS/assets/html/layout/dispatcher/station_traffic.php');
            break;
        case 'STATION':
            header('Location: /ITS/assets/html/layout/station/manage_orders.php');
            break;
        case 'USER':
        default:
            header('Location: /ITS/public/index.php');
            break;
    }
    exit();
    
} catch (PDOException $e) {
    $_SESSION['login_errors'] = ['Có lỗi xảy ra: ' . $e->getMessage()];
    $_SESSION['login_email'] = $email;
    header('Location: ../../html/auth/login.php');
    exit();
}
