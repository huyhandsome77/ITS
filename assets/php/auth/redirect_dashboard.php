<?php
/**
 * File này dùng để redirect người dùng về đúng dashboard của role
 * Có thể gọi từ logout hoặc các trường hợp cần redirect về home
 */

session_start();

// Kiểm tra đăng nhập
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role'])) {
    header('Location: /ITS/assets/html/auth/login.php');
    exit();
}

// Redirect theo role
switch ($_SESSION['role']) {
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
