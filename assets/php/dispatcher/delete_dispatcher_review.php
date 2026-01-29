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

    if (!$reviewId) {
        echo json_encode(['success' => false, 'message' => 'Thiếu ID']);
        exit;
    }

    try {
        $stmt = $conn->prepare("DELETE FROM reviews WHERE review_id = :id");
        $stmt->execute([':id' => $reviewId]);

        echo json_encode(['success' => true, 'message' => 'Đã xóa đánh giá']);

    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Lỗi: ' . $e->getMessage()]);
    }
}
