<?php
session_start();
require_once dirname(__DIR__, 3) . '/config/Connect_DB.php';

header('Content-Type: application/json');

// Check Role
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'DISPATCHER') {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

$reviewId = $_GET['review_id'] ?? null;
if (!$reviewId) {
    echo json_encode(['success' => false, 'message' => 'Thiếu ID đánh giá']);
    exit;
}

try {
    /* 
    // Dispatcher can view ALL reviews
    // Get dispatcher station
    $stmtUser = $conn->prepare("SELECT managed_station_id FROM users WHERE user_id = :uid");
    $stmtUser->execute([':uid' => $_SESSION['user_id']]);
    $stationId = $stmtUser->fetchColumn();

    if (!$stationId) {
        echo json_encode(['success' => false, 'message' => 'Bạn không quản lý trạm nào']);
        exit;
    }
    */

    $sql = "
        SELECT 
            r.*,
            u.full_name,
            u.email,
            u.phone,
            o.order_code,
            o.start_date,
            o.end_date,
            o.total_amount,
            v.vehicle_name,
            v.license_plate,
            s.station_name,
            s.address as station_address
        FROM reviews r
        JOIN users u ON r.user_id = u.user_id
        JOIN orders o ON r.order_id = o.order_id
        LEFT JOIN vehicles v ON o.vehicle_id = v.vehicle_id
        LEFT JOIN stations s ON o.station_id = s.station_id
        WHERE r.review_id = :id 
    ";

    $stmt = $conn->prepare($sql);
    $stmt->execute([':id' => $reviewId]);
    $review = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($review) {
        echo json_encode(['success' => true, 'data' => $review]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Không tìm thấy đánh giá hoặc không có quyền truy cập']);
    }

} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
