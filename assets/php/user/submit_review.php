<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/ITS/config/Connect_DB.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Vui lòng đăng nhập để đánh giá.']);
    exit;
}

$userId = $_SESSION['user_id'];

// Get JSON input
$input = json_decode(file_get_contents('php://input'), true);

$orderCode = $input['order_code'] ?? '';
$rating = isset($input['rating']) ? (int)$input['rating'] : 0;
$comment = trim($input['comment'] ?? '');

// Validation
if (empty($orderCode)) {
    echo json_encode(['success' => false, 'message' => 'Mã đơn hàng không hợp lệ.']);
    exit;
}

if ($rating < 1 || $rating > 5) {
    echo json_encode(['success' => false, 'message' => 'Vui lòng chọn số sao từ 1 đến 5.']);
    exit;
}

if (empty($comment)) {
    echo json_encode(['success' => false, 'message' => 'Vui lòng nhập nội dung đánh giá.']);
    exit;
}

try {
    // Verify order ownership and get details
    $sql = "SELECT order_id, vehicle_id, status FROM orders WHERE order_code = :order_code AND user_id = :user_id";
    $stmt = $conn->prepare($sql);
    $stmt->execute([':order_code' => $orderCode, ':user_id' => $userId]);
    $order = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$order) {
        echo json_encode(['success' => false, 'message' => 'Đơn hàng không tồn tại hoặc bạn không có quyền đánh giá.']);
        exit;
    }

    if ($order['status'] !== 'COMPLETED') {
        echo json_encode(['success' => false, 'message' => 'Chỉ có thể đánh giá đơn hàng đã hoàn thành.']);
        exit;
    }

    // Check if already reviewed
    $checkSql = "SELECT review_id FROM reviews WHERE order_id = :order_id";
    $checkStmt = $conn->prepare($checkSql);
    $checkStmt->execute([':order_id' => $order['order_id']]);
    
    if ($checkStmt->rowCount() > 0) {
        echo json_encode(['success' => false, 'message' => 'Bạn đã đánh giá đơn hàng này rồi.']);
        exit;
    }

    // Insert review
    $insertSql = "INSERT INTO reviews (user_id, order_id, rating, comment, review_type, status) 
                  VALUES (:user_id, :order_id, :rating, :comment, 'VEHICLE', 'PENDING')";
    $insertStmt = $conn->prepare($insertSql);
    $insertStmt->execute([
        ':user_id' => $userId,
        ':order_id' => $order['order_id'],
        ':rating' => $rating,
        ':comment' => $comment
    ]);

    echo json_encode(['success' => true, 'message' => 'Gửi đánh giá thành công! Vui lòng chờ duyệt.']);

} catch (PDOException $e) {
    error_log("Review Error: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Đã xảy ra lỗi hệ thống. Vui lòng thử lại sau.']);
}
