<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/ITS/config/Connect_DB.php';

// Kiểm tra đăng nhập và quyền admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'ADMIN') {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $reviewId = $_GET['review_id'] ?? null;

    if (!$reviewId) {
        echo json_encode(['success' => false, 'message' => 'Thiếu thông tin đánh giá']);
        exit;
    }

    try {
        // Lấy chi tiết đánh giá
        $sql = "
            SELECT 
                r.review_id,
                r.user_id,
                r.rating,
                r.comment,
                r.status,
                r.review_type,
                r.is_reported,
                r.report_reason,
                r.admin_note,
                r.created_at,
                r.updated_at,
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
        $review = $stmt->fetch();

        if ($review) {
            echo json_encode(['success' => true, 'data' => $review]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Không tìm thấy đánh giá']);
        }

    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
