<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Kiểm tra xem người dùng đã đăng nhập chưa
 */
function requireLogin() {
    if (!isset($_SESSION['user_id'])) {
        // Lưu lại trang hiện tại để redirect sau khi login (nếu cần)
        // $_SESSION['redirect_after_login'] = $_SERVER['REQUEST_URI'];
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

    // Luôn cho phép ADMIN truy cập (nếu muốn)
    // if ($_SESSION['role'] === 'ADMIN') return;

    if (!in_array($_SESSION['role'], $allowedRoles)) {
        http_response_code(403);
        // Có thể redirect đến trang 403 hoặc thông báo
        echo "<div style='font-family: Arial, sans-serif; text-align: center; margin-top: 50px;'>";
        echo "<h1 style='color: red;'>403 - Forbidden</h1>";
        echo "<p>Bạn không có quyền truy cập vào trang này.</p>";
        echo "<a href='/ITS/public/index.php'>Quay về trang chủ</a>";
        echo "</div>";
        exit();
    }
}

/**
 * Yêu cầu quyền ADMIN
 */
function requireAdmin() {
    requireRole('ADMIN');
}

/**
 * Yêu cầu quyền DISPATCHER (Điều phối)
 * Admin cũng có thể truy cập nếu cần (bỏ comment dòng dưới)
 */
function requireDispatcher() {
    requireRole(['DISPATCHER', 'ADMIN']); 
}

/**
 * Yêu cầu quyền STATION (Trạm trưởng)
 * Admin cũng có thể truy cập nếu cần (bỏ comment dòng dưới)
 */
function requireStation() {
    requireRole(['STATION', 'ADMIN']);
}
?>
