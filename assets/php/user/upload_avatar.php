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

// Kiểm tra có file upload không
if (!isset($_FILES['avatar']) || $_FILES['avatar']['error'] === UPLOAD_ERR_NO_FILE) {
    echo json_encode(['error' => 'Vui lòng chọn ảnh đại diện']);
    exit;
}

$file = $_FILES['avatar'];

// Kiểm tra lỗi upload
if ($file['error'] !== UPLOAD_ERR_OK) {
    echo json_encode(['error' => 'Lỗi khi tải ảnh lên. Vui lòng thử lại.']);
    exit;
}

// Kiểm tra kích thước file (max 5MB)
$maxSize = 5 * 1024 * 1024; // 5MB
if ($file['size'] > $maxSize) {
    echo json_encode(['error' => 'Kích thước ảnh không được vượt quá 5MB']);
    exit;
}

// Kiểm tra loại file
$allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
$fileType = mime_content_type($file['tmp_name']);

if (!in_array($fileType, $allowedTypes)) {
    echo json_encode(['error' => 'Chỉ chấp nhận file ảnh định dạng JPG, PNG, GIF']);
    exit;
}

// Kiểm tra extension
$allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
$fileExtension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

if (!in_array($fileExtension, $allowedExtensions)) {
    echo json_encode(['error' => 'Định dạng file không hợp lệ']);
    exit;
}

try {
    // Tạo tên file unique
    $newFileName = $userId . '_' . time() . '.' . $fileExtension;
    $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/ITS/assets/img/avatars/';
    
    // Tạo thư mục nếu chưa có
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }
    
    $uploadPath = $uploadDir . $newFileName;

    // Lấy avatar cũ để xóa
    $sql = "SELECT avatar FROM users WHERE user_id = :user_id";
    $stmt = $conn->prepare($sql);
    $stmt->execute([':user_id' => $userId]);
    $user = $stmt->fetch();
    $oldAvatar = $user['avatar'];

    // Upload file mới
    if (!move_uploaded_file($file['tmp_name'], $uploadPath)) {
        echo json_encode(['error' => 'Không thể lưu ảnh. Vui lòng thử lại.']);
        exit;
    }

    // Cập nhật database
    $updateSql = "
        UPDATE users 
        SET avatar = :avatar 
        WHERE user_id = :user_id
    ";
    
    $updateStmt = $conn->prepare($updateSql);
    $updateStmt->execute([
        ':avatar' => $newFileName,
        ':user_id' => $userId
    ]);

    // Xóa avatar cũ nếu có
    if ($oldAvatar && file_exists($uploadDir . $oldAvatar)) {
        @unlink($uploadDir . $oldAvatar);
    }

    echo json_encode([
        'success' => true,
        'message' => 'Cập nhật ảnh đại diện thành công',
        'avatar_url' => '/ITS/assets/img/avatars/' . $newFileName
    ]);

} catch (Exception $e) {
    // Xóa file đã upload nếu có lỗi
    if (isset($uploadPath) && file_exists($uploadPath)) {
        @unlink($uploadPath);
    }

    echo json_encode([
        'error' => 'Lỗi hệ thống',
        'message' => 'Không thể cập nhật ảnh đại diện. Vui lòng thử lại.'
    ]);
}
