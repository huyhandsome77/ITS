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
            created_at,
            id_card_number,
            id_card_name,
            id_card_date,
            id_card_place,
            id_card_front,
            id_card_back,
            face_image,
            driver_license_number,
            driver_license_front,
            driver_license_back,
            bank_account_number,
            bank_account_name,
            bank_name,
            address,
            emergency_contact,
            emergency_name,
            is_verified,
            verified_at,
            verification_note
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
    $user['id_card_date_formatted'] = $user['id_card_date'] ? date('d/m/Y', strtotime($user['id_card_date'])) : '';
    $user['verified_at_formatted'] = $user['verified_at'] ? date('d/m/Y H:i', strtotime($user['verified_at'])) : '';
    
    // Role text
    $roleText = [
        'USER' => 'Khách hàng',
        'STATION' => 'Quản lý trạm',
        'ADMIN' => 'Quản trị viên'
    ];
    $user['role_text'] = $roleText[$user['role']] ?? 'Người dùng';

    // Verification status text
    $verificationText = [
        'PENDING' => 'Chờ xác minh',
        'VERIFIED' => 'Đã xác minh',
        'REJECTED' => 'Bị từ chối'
    ];
    $user['verification_status_text'] = $verificationText[$user['is_verified']] ?? 'Chưa xác minh';

    // Avatar URL
    if ($user['avatar']) {
        $user['avatar_url'] = '/ITS/assets/img/avatars/' . $user['avatar'];
    } else {
        // Generate UI Avatars
        $name = urlencode($user['full_name']);
        $user['avatar_url'] = "https://ui-avatars.com/api/?name={$name}&background=0D8ABC&color=fff&size=200";
    }

    // Verification documents URLs
    $verificationDir = '/ITS/assets/img/verification/';
    $user['id_card_front_url'] = $user['id_card_front'] ? $verificationDir . $user['id_card_front'] : null;
    $user['id_card_back_url'] = $user['id_card_back'] ? $verificationDir . $user['id_card_back'] : null;
    $user['face_image_url'] = $user['face_image'] ? $verificationDir . $user['face_image'] : null;
    $user['driver_license_front_url'] = $user['driver_license_front'] ? $verificationDir . $user['driver_license_front'] : null;
    $user['driver_license_back_url'] = $user['driver_license_back'] ? $verificationDir . $user['driver_license_back'] : null;

    // Kiểm tra đã upload đủ tài liệu chưa
    $user['has_id_card'] = !empty($user['id_card_front']) && !empty($user['id_card_back']);
    $user['has_face_image'] = !empty($user['face_image']);
    $user['has_driver_license'] = !empty($user['driver_license_front']) && !empty($user['driver_license_back']);
    $user['has_bank_info'] = !empty($user['bank_account_number']) && !empty($user['bank_account_name']) && !empty($user['bank_name']);
    $user['has_id_info'] = !empty($user['id_card_number']) && !empty($user['id_card_name']);
    
    // Kiểm tra đã hoàn thành KYC chưa
    $user['kyc_completed'] = $user['has_id_card'] && $user['has_face_image'] && $user['has_bank_info'] && $user['has_id_info'];
    
    // Có thể đặt xe khi đã verified
    $user['can_book'] = $user['is_verified'] === 'VERIFIED';

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
