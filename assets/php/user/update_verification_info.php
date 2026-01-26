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

// Thông tin CCCD
$idCardNumber = trim($data['id_card_number'] ?? '');
$idCardName = trim($data['id_card_name'] ?? '');
$idCardDate = trim($data['id_card_date'] ?? '');
$idCardPlace = trim($data['id_card_place'] ?? '');

// Thông tin bằng lái (optional)
$driverLicenseNumber = trim($data['driver_license_number'] ?? '');

// Thông tin ngân hàng
$bankAccountNumber = trim($data['bank_account_number'] ?? '');
$bankAccountName = trim($data['bank_account_name'] ?? '');
$bankName = trim($data['bank_name'] ?? '');

// Thông tin liên hệ
$address = trim($data['address'] ?? '');
$emergencyContact = trim($data['emergency_contact'] ?? '');
$emergencyName = trim($data['emergency_name'] ?? '');

// Validate dữ liệu bắt buộc
$errors = [];

if (empty($idCardNumber)) {
    $errors[] = 'Số CCCD/CMND không được để trống';
}

if (empty($idCardName)) {
    $errors[] = 'Họ tên trên CCCD không được để trống';
}

if (empty($bankAccountNumber)) {
    $errors[] = 'Số tài khoản ngân hàng không được để trống';
}

if (empty($bankAccountName)) {
    $errors[] = 'Tên chủ tài khoản không được để trống';
}

if (empty($bankName)) {
    $errors[] = 'Tên ngân hàng không được để trống';
}

if (empty($address)) {
    $errors[] = 'Địa chỉ thường trú không được để trống';
}

if (empty($emergencyContact)) {
    $errors[] = 'Số điện thoại khẩn cấp không được để trống';
}

if (empty($emergencyName)) {
    $errors[] = 'Tên người liên hệ khẩn cấp không được để trống';
}

if (!empty($errors)) {
    echo json_encode([
        'error' => 'Thiếu thông tin bắt buộc',
        'messages' => $errors
    ]);
    exit;
}

// Validate số CCCD (12 chữ số)
if (!preg_match('/^\d{9,12}$/', $idCardNumber)) {
    echo json_encode(['error' => 'Số CCCD/CMND không hợp lệ (9-12 chữ số)']);
    exit;
}

// Validate bằng lái nếu có
if (!empty($driverLicenseNumber) && !preg_match('/^\d{10,12}$/', $driverLicenseNumber)) {
    echo json_encode(['error' => 'Số bằng lái xe không hợp lệ (10-12 chữ số)']);
    exit;
}

// Validate số tài khoản ngân hàng
if (!preg_match('/^\d{6,20}$/', $bankAccountNumber)) {
    echo json_encode(['error' => 'Số tài khoản ngân hàng không hợp lệ (6-20 chữ số)']);
    exit;
}

// Validate số điện thoại khẩn cấp
$emergencyContact = preg_replace('/[^0-9+]/', '', $emergencyContact);
if (strlen($emergencyContact) < 10 || strlen($emergencyContact) > 15) {
    echo json_encode(['error' => 'Số điện thoại khẩn cấp không hợp lệ']);
    exit;
}

try {
    $conn->beginTransaction();

    // Kiểm tra CCCD đã được sử dụng chưa
    $checkIdSql = "
        SELECT user_id 
        FROM users 
        WHERE id_card_number = :id_card_number 
        AND user_id != :user_id
    ";
    
    $checkStmt = $conn->prepare($checkIdSql);
    $checkStmt->execute([
        ':id_card_number' => $idCardNumber,
        ':user_id' => $userId
    ]);
    
    if ($checkStmt->fetch()) {
        $conn->rollBack();
        echo json_encode(['error' => 'Số CCCD/CMND này đã được đăng ký bởi tài khoản khác']);
        exit;
    }

    // Kiểm tra bằng lái đã được sử dụng chưa (nếu có)
    if (!empty($driverLicenseNumber)) {
        $checkLicenseSql = "
            SELECT user_id 
            FROM users 
            WHERE driver_license_number = :driver_license_number 
            AND user_id != :user_id
        ";
        
        $checkLicenseStmt = $conn->prepare($checkLicenseSql);
        $checkLicenseStmt->execute([
            ':driver_license_number' => $driverLicenseNumber,
            ':user_id' => $userId
        ]);
        
        if ($checkLicenseStmt->fetch()) {
            $conn->rollBack();
            echo json_encode(['error' => 'Số bằng lái xe này đã được đăng ký bởi tài khoản khác']);
            exit;
        }
    }

    // Cập nhật thông tin - reset trạng thái về PENDING khi cập nhật
    $updateSql = "
        UPDATE users 
        SET 
            id_card_number = :id_card_number,
            id_card_name = :id_card_name,
            id_card_date = :id_card_date,
            id_card_place = :id_card_place,
            driver_license_number = :driver_license_number,
            bank_account_number = :bank_account_number,
            bank_account_name = :bank_account_name,
            bank_name = :bank_name,
            address = :address,
            emergency_contact = :emergency_contact,
            emergency_name = :emergency_name,
            is_verified = 'PENDING'
        WHERE user_id = :user_id
    ";
    
    $updateStmt = $conn->prepare($updateSql);
    $updateStmt->execute([
        ':id_card_number' => $idCardNumber,
        ':id_card_name' => $idCardName,
        ':id_card_date' => $idCardDate ?: null,
        ':id_card_place' => $idCardPlace ?: null,
        ':driver_license_number' => $driverLicenseNumber ?: null,
        ':bank_account_number' => $bankAccountNumber,
        ':bank_account_name' => $bankAccountName,
        ':bank_name' => $bankName,
        ':address' => $address,
        ':emergency_contact' => $emergencyContact,
        ':emergency_name' => $emergencyName,
        ':user_id' => $userId
    ]);

    $conn->commit();

    echo json_encode([
        'success' => true,
        'message' => 'Cập nhật thông tin xác minh thành công. Vui lòng chờ quản trị viên xác nhận.'
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
