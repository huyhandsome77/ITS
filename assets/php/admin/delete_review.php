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

    if (!$reviewId) {
        echo json_encode(['success' => false, 'message' => 'Thiếu thông tin đánh giá']);
        exit;
    }

    try {
        $conn->beginTransaction();

        // Xóa đánh giá
        $sql = "DELETE FROM reviews WHERE review_id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->execute([':id' => $reviewId]);

        if ($stmt->rowCount() > 0) {
            $conn->commit();
            setFlashAlert('success', 'Thành công!', 'Đã xóa đánh giá vĩnh viễn');
            echo json_encode(['success' => true, 'message' => 'Đã xóa đánh giá']);
        } else {
            $conn->rollBack();
            setFlashAlert('error', 'Lỗi!', 'Không tìm thấy đánh giá');
            echo json_encode(['success' => false, 'message' => 'Không tìm thấy đánh giá']);
        }

    } catch (PDOException $e) {
        $conn->rollBack();
        setFlashAlert('error', 'Lỗi!', 'Có lỗi xảy ra: ' . $e->getMessage());
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
