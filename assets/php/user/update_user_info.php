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
$fullName = trim($data['full_name'] ?? '');
$phone = trim($data['phone'] ?? '');
$birthday = trim($data['birthday'] ?? '');

// Validate dữ liệu
if (empty($fullName)) {
    echo json_encode(['error' => 'Họ tên không được để trống']);
    exit;
}

// Validate phone nếu có
if (!empty($phone)) {
    // Loại bỏ khoảng trắng và ký tự đặc biệt
    $phone = preg_replace('/[^0-9+]/', '', $phone);
    
    if (strlen($phone) < 10 || strlen($phone) > 15) {
        echo json_encode(['error' => 'Số điện thoại không hợp lệ (10-15 ký tự)']);
        exit;
    }
}

// Validate birthday nếu có
if (!empty($birthday)) {
    $birthDate = DateTime::createFromFormat('Y-m-d', $birthday);
    if (!$birthDate) {
        echo json_encode(['error' => 'Ngày sinh không hợp lệ']);
        exit;
    }
    
    // Kiểm tra tuổi hợp lệ (phải >= 16 tuổi)
    $today = new DateTime();
    $age = $today->diff($birthDate)->y;
    
    if ($age < 16) {
        echo json_encode(['error' => 'Bạn phải đủ 16 tuổi để sử dụng dịch vụ']);
        exit;
    }
    
    if ($age > 120) {
        echo json_encode(['error' => 'Ngày sinh không hợp lệ']);
        exit;
    }
}

try {
    $conn->beginTransaction();

    // Kiểm tra số điện thoại đã được sử dụng chưa (nếu thay đổi)
    if (!empty($phone)) {
        $checkPhoneSql = "
            SELECT user_id 
            FROM users 
            WHERE phone = :phone 
            AND user_id != :user_id
        ";
        
        $checkStmt = $conn->prepare($checkPhoneSql);
        $checkStmt->execute([
            ':phone' => $phone,
            ':user_id' => $userId
        ]);
        
        if ($checkStmt->fetch()) {
            $conn->rollBack();
            echo json_encode(['error' => 'Số điện thoại này đã được sử dụng']);
            exit;
        }
    }

    // Cập nhật thông tin
    $updateSql = "
        UPDATE users 
        SET 
            full_name = :full_name,
            phone = :phone,
            birthday = :birthday
        WHERE user_id = :user_id
    ";
    
    $updateStmt = $conn->prepare($updateSql);
    $updateStmt->execute([
        ':full_name' => $fullName,
        ':phone' => $phone ?: null,
        ':birthday' => $birthday ?: null,
        ':user_id' => $userId
    ]);

    // Cập nhật session nếu cần
    $_SESSION['full_name'] = $fullName;

    $conn->commit();

    echo json_encode([
        'success' => true,
        'message' => 'Cập nhật thông tin thành công'
    ]);

} catch (Exception $e) {
    if ($conn->inTransaction()) {
        $conn->rollBack();
    }

    echo json_encode([
        'error' => 'Lỗi hệ thống',
        'message' => 'Không thể cập nhật thông tin. Vui lòng thử lại.'
    ]);
}
