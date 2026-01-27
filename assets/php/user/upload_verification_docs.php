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

// Lấy loại document từ POST
$docType = $_POST['doc_type'] ?? '';

// Validate document type
$allowedTypes = ['id_card_front', 'id_card_back', 'face_image', 'driver_license_front', 'driver_license_back'];
if (!in_array($docType, $allowedTypes)) {
    echo json_encode(['error' => 'Loại tài liệu không hợp lệ']);
    exit;
}

// Kiểm tra có file upload không
if (!isset($_FILES['file']) || $_FILES['file']['error'] === UPLOAD_ERR_NO_FILE) {
    echo json_encode(['error' => 'Vui lòng chọn file']);
    exit;
}

$file = $_FILES['file'];

// Kiểm tra lỗi upload
if ($file['error'] !== UPLOAD_ERR_OK) {
    echo json_encode(['error' => 'Lỗi khi tải file lên. Vui lòng thử lại.']);
    exit;
}

// Kiểm tra kích thước file (max 10MB cho documents)
$maxSize = 10 * 1024 * 1024; // 10MB
if ($file['size'] > $maxSize) {
    echo json_encode(['error' => 'Kích thước file không được vượt quá 10MB']);
    exit;
}

// Kiểm tra loại file
$allowedMimeTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'application/pdf'];
$fileType = mime_content_type($file['tmp_name']);

if (!in_array($fileType, $allowedMimeTypes)) {
    echo json_encode(['error' => 'Chỉ chấp nhận file ảnh (JPG, PNG, GIF) hoặc PDF']);
    exit;
}

// Kiểm tra extension
$allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'pdf'];
$fileExtension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

if (!in_array($fileExtension, $allowedExtensions)) {
    echo json_encode(['error' => 'Định dạng file không hợp lệ']);
    exit;
}

try {
    // Tạo tên file unique
    $newFileName = $userId . '_' . $docType . '_' . time() . '.' . $fileExtension;
    $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/ITS/assets/img/verification/';
    
    // Tạo thư mục nếu chưa có
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }
    
    $uploadPath = $uploadDir . $newFileName;

    // Lấy file cũ để xóa
    $sql = "SELECT {$docType} FROM users WHERE user_id = :user_id";
    $stmt = $conn->prepare($sql);
    $stmt->execute([':user_id' => $userId]);
    $user = $stmt->fetch();
    $oldFile = $user[$docType] ?? null;

    // Upload file mới
    if (!move_uploaded_file($file['tmp_name'], $uploadPath)) {
        echo json_encode(['error' => 'Không thể lưu file. Vui lòng thử lại.']);
        exit;
    }

    // Cập nhật database - khi upload tài liệu mới, reset trạng thái về PENDING
    $updateSql = "
        UPDATE users 
        SET {$docType} = :file_name,
            is_verified = 'PENDING'
        WHERE user_id = :user_id
    ";
    
    $updateStmt = $conn->prepare($updateSql);
    $updateStmt->execute([
        ':file_name' => $newFileName,
        ':user_id' => $userId
    ]);

    // Xóa file cũ nếu có
    if ($oldFile && file_exists($uploadDir . $oldFile)) {
        @unlink($uploadDir . $oldFile);
    }

    // Tên hiển thị cho từng loại document
    $docNames = [
        'id_card_front' => 'CCCD mặt trước',
        'id_card_back' => 'CCCD mặt sau',
        'face_image' => 'Ảnh khuôn mặt',
        'driver_license_front' => 'Bằng lái mặt trước',
        'driver_license_back' => 'Bằng lái mặt sau'
    ];

    echo json_encode([
        'success' => true,
        'message' => 'Tải lên ' . $docNames[$docType] . ' thành công',
        'file_url' => '/ITS/assets/img/verification/' . $newFileName,
        'doc_type' => $docType
    ]);

} catch (Exception $e) {
    // Xóa file đã upload nếu có lỗi
    if (isset($uploadPath) && file_exists($uploadPath)) {
        @unlink($uploadPath);
    }

    echo json_encode([
        'error' => 'Lỗi hệ thống',
        'message' => 'Không thể tải file lên. Vui lòng thử lại.'
    ]);
}
