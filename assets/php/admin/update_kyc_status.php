<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/ITS/config/Connect_DB.php';

header('Content-Type: application/json');

// Kiểm tra đăng nhập
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'Vui lòng đăng nhập']);
    exit;
}

// Kiểm tra quyền admin
if ($_SESSION['role'] !== 'ADMIN') {
    echo json_encode(['error' => 'Bạn không có quyền thực hiện thao tác này']);
    exit;
}

// Kiểm tra phương thức POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['error' => 'Phương thức không hợp lệ']);
    exit;
}

// Lấy dữ liệu từ POST
$data = json_decode(file_get_contents('php://input'), true);
$userId = $data['user_id'] ?? '';
$action = $data['action'] ?? ''; // 'approve' hoặc 'reject'
$note = $data['note'] ?? '';

if ($userId === '') {
    echo json_encode(['error' => 'Thiếu thông tin user_id']);
    exit;
}

if (!in_array($action, ['approve', 'reject'])) {
    echo json_encode(['error' => 'Hành động không hợp lệ']);
    exit;
}

if ($action === 'reject' && trim($note) === '') {
    echo json_encode(['error' => 'Vui lòng nhập lý do từ chối']);
    exit;
}

try {
    $conn->beginTransaction();
    
    // Kiểm tra user tồn tại
    $checkSql = "SELECT user_id, full_name, email, is_verified FROM users WHERE user_id = :user_id";
    $checkStmt = $conn->prepare($checkSql);
    $checkStmt->execute([':user_id' => $userId]);
    $user = $checkStmt->fetch();
    
    if (!$user) {
        $conn->rollBack();
        echo json_encode(['error' => 'Không tìm thấy người dùng']);
        exit;
    }
    
    // Xác định trạng thái mới
    $newStatus = $action === 'approve' ? 'VERIFIED' : 'REJECTED';
    $verifiedAt = $action === 'approve' ? date('Y-m-d H:i:s') : null;
    $verificationNote = $action === 'reject' ? $note : null;
    
    // Cập nhật trạng thái
    $updateSql = "
        UPDATE users 
        SET 
            is_verified = :status,
            verified_at = :verified_at,
            verification_note = :note
        WHERE user_id = :user_id
    ";
    
    $updateStmt = $conn->prepare($updateSql);
    $updateStmt->execute([
        ':status' => $newStatus,
        ':verified_at' => $verifiedAt,
        ':note' => $verificationNote,
        ':user_id' => $userId
    ]);
    
    $conn->commit();
    
    $message = $action === 'approve' 
        ? "Đã phê duyệt xác minh cho tài khoản {$user['full_name']}" 
        : "Đã từ chối xác minh cho tài khoản {$user['full_name']}";
    
    echo json_encode([
        'success' => true,
        'message' => $message,
        'user' => [
            'user_id' => $user['user_id'],
            'full_name' => $user['full_name'],
            'email' => $user['email'],
            'is_verified' => $newStatus,
            'verified_at' => $verifiedAt ? date('d/m/Y H:i', strtotime($verifiedAt)) : null,
            'verification_note' => $verificationNote
        ]
    ]);

} catch (Exception $e) {
    if ($conn->inTransaction()) {
        $conn->rollBack();
    }
    
    echo json_encode([
        'error' => 'Lỗi hệ thống',
        'message' => $e->getMessage()
    ]);
}
