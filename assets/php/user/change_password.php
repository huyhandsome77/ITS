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

// Kiểm tra phương thức POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['error' => 'Phương thức không hợp lệ']);
    exit;
}

// Lấy dữ liệu từ POST
$data = json_decode(file_get_contents('php://input'), true);
$currentPassword = trim($data['current_password'] ?? '');
$newPassword = trim($data['new_password'] ?? '');
$confirmPassword = trim($data['confirm_password'] ?? '');

// Validate dữ liệu
if (empty($currentPassword)) {
    echo json_encode(['error' => 'Vui lòng nhập mật khẩu hiện tại']);
    exit;
}

if (empty($newPassword)) {
    echo json_encode(['error' => 'Vui lòng nhập mật khẩu mới']);
    exit;
}

if (empty($confirmPassword)) {
    echo json_encode(['error' => 'Vui lòng xác nhận mật khẩu mới']);
    exit;
}

// Kiểm tra mật khẩu mới và xác nhận có khớp không
if ($newPassword !== $confirmPassword) {
    echo json_encode(['error' => 'Mật khẩu mới và xác nhận không khớp']);
    exit;
}

// Kiểm tra độ dài mật khẩu mới
if (strlen($newPassword) < 6) {
    echo json_encode(['error' => 'Mật khẩu mới phải có ít nhất 6 ký tự']);
    exit;
}

// Kiểm tra mật khẩu mới không được giống mật khẩu cũ
if ($currentPassword === $newPassword) {
    echo json_encode(['error' => 'Mật khẩu mới phải khác mật khẩu hiện tại']);
    exit;
}

try {
    // Lấy mật khẩu hiện tại từ database
    $sql = "SELECT password FROM users WHERE user_id = :user_id";
    $stmt = $conn->prepare($sql);
    $stmt->execute([':user_id' => $userId]);
    $user = $stmt->fetch();

    if (!$user) {
        echo json_encode(['error' => 'Không tìm thấy thông tin người dùng']);
        exit;
    }

    // Kiểm tra mật khẩu hiện tại có đúng không
    if (!password_verify($currentPassword, $user['password'])) {
        echo json_encode(['error' => 'Mật khẩu hiện tại không đúng']);
        exit;
    }

    // Hash mật khẩu mới
    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

    // Cập nhật mật khẩu
    $updateSql = "
        UPDATE users 
        SET password = :password 
        WHERE user_id = :user_id
    ";
    
    $updateStmt = $conn->prepare($updateSql);
    $updateStmt->execute([
        ':password' => $hashedPassword,
        ':user_id' => $userId
    ]);

    echo json_encode([
        'success' => true,
        'message' => 'Đổi mật khẩu thành công'
    ]);

} catch (Exception $e) {
    echo json_encode([
        'error' => 'Lỗi hệ thống',
        'message' => 'Không thể đổi mật khẩu. Vui lòng thử lại.'
    ]);
}
