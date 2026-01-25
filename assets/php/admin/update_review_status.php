<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/ITS/config/Connect_DB.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/ITS/helpers/flash.php';

// Kiểm tra đăng nhập và quyền admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'ADMIN') {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $reviewId = $_POST['review_id'] ?? null;
    $action = $_POST['action'] ?? null; // approve, reject, hide, unhide

    if (!$reviewId || !$action) {
        echo json_encode(['success' => false, 'message' => 'Thiếu thông tin']);
        exit;
    }

    try {
        $conn->beginTransaction();

        switch ($action) {
            case 'approve':
                // Duyệt đánh giá
                $sql = "UPDATE reviews SET status = 'APPROVED', is_reported = 0, report_reason = NULL WHERE review_id = :id";
                $stmt = $conn->prepare($sql);
                $stmt->execute([':id' => $reviewId]);
                
                setFlashAlert('success', 'Thành công!', 'Đã duyệt đánh giá');
                echo json_encode(['success' => true, 'message' => 'Đã duyệt đánh giá']);
                break;

            case 'reject':
                // Từ chối đánh giá
                $sql = "UPDATE reviews SET status = 'REJECTED' WHERE review_id = :id";
                $stmt = $conn->prepare($sql);
                $stmt->execute([':id' => $reviewId]);
                
                setFlashAlert('success', 'Thành công!', 'Đã từ chối đánh giá');
                echo json_encode(['success' => true, 'message' => 'Đã từ chối đánh giá']);
                break;

            case 'hide':
                // Ẩn đánh giá
                $sql = "UPDATE reviews SET status = 'HIDDEN' WHERE review_id = :id";
                $stmt = $conn->prepare($sql);
                $stmt->execute([':id' => $reviewId]);
                
                setFlashAlert('success', 'Thành công!', 'Đã ẩn đánh giá');
                echo json_encode(['success' => true, 'message' => 'Đã ẩn đánh giá']);
                break;

            case 'unhide':
                // Bỏ ẩn đánh giá
                $sql = "UPDATE reviews SET status = 'APPROVED' WHERE review_id = :id";
                $stmt = $conn->prepare($sql);
                $stmt->execute([':id' => $reviewId]);
                
                setFlashAlert('success', 'Thành công!', 'Đã bỏ ẩn đánh giá');
                echo json_encode(['success' => true, 'message' => 'Đã bỏ ẩn đánh giá']);
                break;

            case 'clear_report':
                // Xóa báo cáo vi phạm
                $sql = "UPDATE reviews SET is_reported = 0, report_reason = NULL WHERE review_id = :id";
                $stmt = $conn->prepare($sql);
                $stmt->execute([':id' => $reviewId]);
                
                setFlashAlert('success', 'Thành công!', 'Đã xóa báo cáo vi phạm');
                echo json_encode(['success' => true, 'message' => 'Đã xóa báo cáo']);
                break;

            default:
                echo json_encode(['success' => false, 'message' => 'Hành động không hợp lệ']);
                exit;
        }

        $conn->commit();

    } catch (PDOException $e) {
        $conn->rollBack();
        setFlashAlert('error', 'Lỗi!', 'Có lỗi xảy ra: ' . $e->getMessage());
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
