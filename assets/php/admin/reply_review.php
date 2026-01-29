<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/ITS/config/Connect_DB.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit;
}

$reviewId = $_POST['review_id'] ?? null;
$reply = $_POST['reply'] ?? null;

if (!$reviewId || !$reply) {
    echo json_encode(['success' => false, 'message' => 'Missing required fields']);
    exit;
}

try {
    $stmt = $conn->prepare("UPDATE reviews SET reply = :reply, replied_at = NOW() WHERE review_id = :review_id");
    $stmt->execute([
        ':reply' => $reply,
        ':review_id' => $reviewId
    ]);

    echo json_encode(['success' => true, 'message' => 'Đã gửi câu trả lời thành công']);

} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Lỗi hệ thống: ' . $e->getMessage()]);
}
