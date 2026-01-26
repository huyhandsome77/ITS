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
    echo json_encode(['error' => 'Bạn không có quyền truy cập']);
    exit;
}

try {
    // Lấy các tham số tìm kiếm và phân trang
    $page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
    $limit = 20;
    $offset = ($page - 1) * $limit;
    
    $search = isset($_GET['search']) ? trim($_GET['search']) : '';
    $status = isset($_GET['status']) ? $_GET['status'] : '';
    $sort = isset($_GET['sort']) ? $_GET['sort'] : 'newest';
    
    // Build WHERE clause
    $where = ["1=1"];
    $params = [];
    
    if ($search !== '') {
        $where[] = "(u.full_name LIKE :search OR u.email LIKE :search OR u.id_card_number LIKE :search OR u.phone LIKE :search)";
        $params[':search'] = "%{$search}%";
    }
    
    if ($status !== '') {
        $where[] = "u.is_verified = :status";
        $params[':status'] = $status;
    }
    
    $whereClause = implode(' AND ', $where);
    
    // Sorting
    $orderBy = match($sort) {
        'oldest' => 'u.created_at ASC',
        'name_asc' => 'u.full_name ASC',
        'name_desc' => 'u.full_name DESC',
        'verified_first' => 'FIELD(u.is_verified, "VERIFIED", "PENDING", "REJECTED"), u.created_at DESC',
        'pending_first' => 'FIELD(u.is_verified, "PENDING", "VERIFIED", "REJECTED"), u.created_at DESC',
        default => 'u.created_at DESC'
    };
    
    // Lấy tổng số bản ghi
    $countSql = "SELECT COUNT(*) as total FROM users u WHERE {$whereClause}";
    $countStmt = $conn->prepare($countSql);
    $countStmt->execute($params);
    $totalRecords = $countStmt->fetch()['total'];
    
    // Lấy danh sách user KYC
    $sql = "
        SELECT 
            u.user_id,
            u.full_name,
            u.email,
            u.phone,
            u.avatar,
            u.id_card_number,
            u.id_card_name,
            u.id_card_date,
            u.id_card_place,
            u.id_card_front,
            u.id_card_back,
            u.face_image,
            u.driver_license_number,
            u.driver_license_front,
            u.driver_license_back,
            u.bank_account_number,
            u.bank_account_name,
            u.bank_name,
            u.address,
            u.emergency_contact,
            u.emergency_name,
            u.is_verified,
            u.verified_at,
            u.verification_note,
            u.created_at,
            u.status
        FROM users u
        WHERE {$whereClause}
        ORDER BY {$orderBy}
        LIMIT :limit OFFSET :offset
    ";
    
    $stmt = $conn->prepare($sql);
    foreach ($params as $key => $value) {
        $stmt->bindValue($key, $value);
    }
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    
    $users = $stmt->fetchAll();
    
    // Format dữ liệu
    $verificationDir = '/ITS/assets/img/verification/';
    $avatarDir = '/ITS/assets/img/avatars/';
    
    foreach ($users as &$user) {
        // Format dates
        $user['created_at_formatted'] = date('d/m/Y H:i', strtotime($user['created_at']));
        $user['verified_at_formatted'] = $user['verified_at'] ? date('d/m/Y H:i', strtotime($user['verified_at'])) : null;
        $user['id_card_date_formatted'] = $user['id_card_date'] ? date('d/m/Y', strtotime($user['id_card_date'])) : null;
        
        // Avatar URL
        if ($user['avatar']) {
            $user['avatar_url'] = $avatarDir . $user['avatar'];
        } else {
            $name = urlencode($user['full_name']);
            $user['avatar_url'] = "https://ui-avatars.com/api/?name={$name}&background=0D8ABC&color=fff&size=200";
        }
        
        // Document URLs
        $user['id_card_front_url'] = $user['id_card_front'] ? $verificationDir . $user['id_card_front'] : null;
        $user['id_card_back_url'] = $user['id_card_back'] ? $verificationDir . $user['id_card_back'] : null;
        $user['face_image_url'] = $user['face_image'] ? $verificationDir . $user['face_image'] : null;
        $user['driver_license_front_url'] = $user['driver_license_front'] ? $verificationDir . $user['driver_license_front'] : null;
        $user['driver_license_back_url'] = $user['driver_license_back'] ? $verificationDir . $user['driver_license_back'] : null;
        
        // Check completion
        $user['has_id_card'] = !empty($user['id_card_front']) && !empty($user['id_card_back']);
        $user['has_face_image'] = !empty($user['face_image']);
        $user['has_bank_info'] = !empty($user['bank_account_number']) && !empty($user['bank_account_name']) && !empty($user['bank_name']);
        $user['has_id_info'] = !empty($user['id_card_number']) && !empty($user['id_card_name']);
        $user['kyc_completed'] = $user['has_id_card'] && $user['has_face_image'] && $user['has_bank_info'] && $user['has_id_info'];
        
        // Status badge
        $user['status_badge'] = match($user['is_verified']) {
            'VERIFIED' => 'Đã xác minh',
            'PENDING' => 'Chờ duyệt',
            'REJECTED' => 'Từ chối',
            default => 'Chưa xác minh'
        };
        
        $user['status_color'] = match($user['is_verified']) {
            'VERIFIED' => 'green',
            'PENDING' => 'yellow',
            'REJECTED' => 'red',
            default => 'gray'
        };
    }
    
    // Lấy thống kê
    $statsSql = "
        SELECT 
            COUNT(*) as total_users,
            SUM(CASE WHEN is_verified = 'PENDING' THEN 1 ELSE 0 END) as total_pending,
            SUM(CASE WHEN is_verified = 'VERIFIED' THEN 1 ELSE 0 END) as total_verified,
            SUM(CASE WHEN is_verified = 'REJECTED' THEN 1 ELSE 0 END) as total_rejected
        FROM users
    ";
    $statsStmt = $conn->prepare($statsSql);
    $statsStmt->execute();
    $stats = $statsStmt->fetch();
    
    // Pagination
    $totalPages = ceil($totalRecords / $limit);
    
    echo json_encode([
        'success' => true,
        'users' => $users,
        'stats' => $stats,
        'pagination' => [
            'current_page' => $page,
            'total_pages' => $totalPages,
            'total_records' => $totalRecords,
            'per_page' => $limit
        ]
    ]);

} catch (Exception $e) {
    echo json_encode([
        'error' => 'Lỗi hệ thống',
        'message' => $e->getMessage()
    ]);
}
