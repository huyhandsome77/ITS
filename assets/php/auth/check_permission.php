<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Kiểm tra xem người dùng đã đăng nhập chưa
 */
function requireLogin() {
    if (!isset($_SESSION['user_id'])) {
        // Lưu lại trang hiện tại để redirect sau khi login
        $_SESSION['redirect_after_login'] = $_SERVER['REQUEST_URI'];
        header('Location: /ITS/assets/html/auth/login.php');
        exit();
    }
}

/**
 * Kiểm tra quyền truy cập chung
 * @param array|string $allowedRoles Các role được phép truy cập
 */
function requireRole($allowedRoles) {
    requireLogin();

    if (is_string($allowedRoles)) {
        $allowedRoles = [$allowedRoles];
    }

    if (!in_array($_SESSION['role'], $allowedRoles)) {
        http_response_code(403);
        // Redirect về trang tương ứng với role của user
        redirectToRoleHomepage();
        exit();
    }
}

/**
 * Redirect người dùng về trang chủ tương ứng với role
 */
function redirectToRoleHomepage() {
    $role = $_SESSION['role'] ?? 'USER';
    
    switch ($role) {
        case 'ADMIN':
            $homepage = '/ITS/assets/html/layout/admin/dashboard.php';
            $message = 'Bạn không có quyền truy cập trang này. Đang chuyển về trang Admin...';
            break;
        case 'DISPATCHER':
            $homepage = '/ITS/assets/html/layout/dispatcher/station_traffic.php';
            $message = 'Bạn không có quyền truy cập trang này. Đang chuyển về trang Dispatcher...';
            break;
        case 'STATION':
            $homepage = '/ITS/assets/html/layout/station/manage_orders.php';
            $message = 'Bạn không có quyền truy cập trang này. Đang chuyển về trang Station...';
            break;
        case 'USER':
        default:
            $homepage = '/ITS/public/index.php';
            $message = 'Bạn không có quyền truy cập trang này. Đang chuyển về trang chủ...';
            break;
    }
    
    // Hiển thị thông báo và redirect
    echo "<!DOCTYPE html>
    <html lang='vi'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Truy cập bị từ chối</title>
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        <style>
            body { 
                font-family: 'Inter', Arial, sans-serif; 
                background: url('/ITS/assets/img/bg_meme.png') no-repeat center center fixed;
                background-size: cover;
                display: flex;
                align-items: center;
                justify-content: center;
                min-height: 100vh;
                margin: 0;
            }
        </style>
    </head>
    <body>
        <script>
            Swal.fire({
                icon: 'error',
                title: '403 - Truy cập bị từ chối',
                text: '{$message}',
                confirmButtonText: 'OK',
                confirmButtonColor: '#d33',
                allowOutsideClick: false
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '{$homepage}';
                }
            });

            setTimeout(() => {
                window.location.href = '{$homepage}';
            }, 3000);
        </script>
    </body>
    </html>";

}

/**
 * Yêu cầu quyền ADMIN
 */
function requireAdmin() {
    requireRole('ADMIN');
}

/**
 * Yêu cầu quyền DISPATCHER (Điều phối)
 */
function requireDispatcher() {
    requireRole(['DISPATCHER', 'ADMIN']); 
}

/**
 * Yêu cầu quyền STATION (Trạm trưởng)
 */
function requireStation() {
    requireRole(['STATION', 'ADMIN']);
}

/**
 * Yêu cầu quyền USER (Khách hàng)
 */
function requireUser() {
    requireRole(['USER', 'ADMIN']);
}

/**
 * Kiểm tra xem người dùng có phải là role cụ thể không
 * @param string $role Role cần kiểm tra
 * @return bool
 */
function hasRole($role) {
    return isset($_SESSION['role']) && $_SESSION['role'] === $role;
}

/**
 * Lấy thông tin role hiện tại
 * @return string|null
 */
function getCurrentRole() {
    return $_SESSION['role'] ?? null;
}
?>
