<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/ITS/config/Connect_DB.php';

header('Content-Type: application/json');

// Kiểm tra đăng nhập
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'Vui lòng đăng nhập']);
    exit;
}

$userId = $_SESSION['user_id'];

try {
    // Lấy thông tin user
    $sql = "
        SELECT 
            user_id,
            full_name,
            email,
            phone,
            birthday,
            role,
            avatar,
            status,
            created_at
        FROM users 
        WHERE user_id = :user_id
    ";
    
    $stmt = $conn->prepare($sql);
    $stmt->execute([':user_id' => $userId]);
    $user = $stmt->fetch();

    if (!$user) {
        echo json_encode(['error' => 'Không tìm thấy thông tin người dùng']);
        exit;
    }

    // Format dữ liệu
    $user['birthday_formatted'] = $user['birthday'] ? date('d/m/Y', strtotime($user['birthday'])) : '';
    $user['created_at_formatted'] = date('d/m/Y', strtotime($user['created_at']));
    
    // Role text
    $roleText = [
        'USER' => 'Khách hàng',
        'STATION' => 'Quản lý trạm',
        'ADMIN' => 'Quản trị viên'
    ];
    $user['role_text'] = $roleText[$user['role']] ?? 'Người dùng';

    // Avatar URL
    if ($user['avatar']) {
        $user['avatar_url'] = '/ITS/assets/img/avatars/' . $user['avatar'];
    } else {
        // Generate UI Avatars
        $name = urlencode($user['full_name']);
        $user['avatar_url'] = "https://ui-avatars.com/api/?name={$name}&background=0D8ABC&color=fff&size=200";
    }

    echo json_encode([
        'success' => true,
        'user' => $user
    ]);

} catch (Exception $e) {
    echo json_encode([
        'error' => 'Lỗi hệ thống',
        'message' => 'Không thể tải thông tin người dùng'
    ]);
}
