<?php
session_start();
require_once dirname(__DIR__, 3) . '/config/Connect_DB.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'DISPATCHER') {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $reviewId = $_POST['review_id'] ?? null;
    $action = $_POST['action'] ?? null; 

    if (!$reviewId || !$action) {
        echo json_encode(['success' => false, 'message' => 'Thiếu thông tin']);
        exit;
    }

    try {
        /*
    // Verify station ownership - Removed
    $stmtUser = $conn->prepare("SELECT managed_station_id FROM users WHERE user_id = :uid");
    $stmtUser->execute([':uid' => $_SESSION['user_id']]);
    $stationId = $stmtUser->fetchColumn();

    $checkSql = "SELECT r.review_id FROM reviews r JOIN orders o ON r.order_id = o.order_id WHERE r.review_id = :rid AND o.station_id = :sid";
    $checkStmt = $conn->prepare($checkSql);
    $checkStmt->execute([':rid' => $reviewId, ':sid' => $stationId]);
    
    if (!$checkStmt->fetch()) {
            echo json_encode(['success' => false, 'message' => 'Không có quyền thực hiện thao tác']);
            exit;
    }
    */

        $conn->beginTransaction();

        switch ($action) {
            case 'approve':
                $sql = "UPDATE reviews SET status = 'APPROVED', is_reported = 0, report_reason = NULL WHERE review_id = :id";
                $message = "Đã duyệt đánh giá";
                break;
            case 'reject':
                $sql = "UPDATE reviews SET status = 'REJECTED' WHERE review_id = :id";
                $message = "Đã từ chối đánh giá";
                break;
            case 'hide':
                $sql = "UPDATE reviews SET status = 'HIDDEN' WHERE review_id = :id";
                $message = "Đã ẩn đánh giá";
                break;
            case 'unhide':
                $sql = "UPDATE reviews SET status = 'APPROVED' WHERE review_id = :id";
                $message = "Đã bỏ ẩn đánh giá";
                break;
            case 'clear_report':
                $sql = "UPDATE reviews SET is_reported = 0, report_reason = NULL WHERE review_id = :id";
                $message = "Đã xóa báo cáo";
                break;
            default:
                throw new Exception("Hành động không hợp lệ");
        }

        $stmt = $conn->prepare($sql);
        $stmt->execute([':id' => $reviewId]);
        
        $conn->commit();
        echo json_encode(['success' => true, 'message' => $message]);

    } catch (Exception $e) {
        if ($conn->inTransaction()) $conn->rollBack();
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
