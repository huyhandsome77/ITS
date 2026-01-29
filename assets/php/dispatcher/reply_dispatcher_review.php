<?php
require_once dirname(__DIR__, 3) . '/config/Connect_DB.php';
header('Content-Type: application/json');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'DISPATCHER') {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit;
}

$reviewId = $_POST['review_id'] ?? null;
$reply = $_POST['reply'] ?? null;

if (!$reviewId || !$reply) {
    echo json_encode(['success' => false, 'message' => 'Vui lòng nhập nội dung']);
    exit;
}

try {
    /*
    // Verify station ownership - Removed for Global Dispatcher Access
    $stmtUser = $conn->prepare("SELECT managed_station_id FROM users WHERE user_id = :uid");
    $stmtUser->execute([':uid' => $_SESSION['user_id']]);
    $stationId = $stmtUser->fetchColumn();

    $checkSql = "SELECT r.review_id FROM reviews r JOIN orders o ON r.order_id = o.order_id WHERE r.review_id = :rid AND o.station_id = :sid";
    $checkStmt = $conn->prepare($checkSql);
    $checkStmt->execute([':rid' => $reviewId, ':sid' => $stationId]);
    
    if (!$checkStmt->fetch()) {
         echo json_encode(['success' => false, 'message' => 'Không có quyền trả lời đánh giá này']);
         exit;
    }
    */

    $updateSql = "UPDATE reviews SET reply = :reply, replied_at = NOW(), admin_note = 'Replied by Dispatcher' WHERE review_id = :rid";
    $updateStmt = $conn->prepare($updateSql);
    $updateStmt->execute([':reply' => $reply, ':rid' => $reviewId]);

    echo json_encode(['success' => true, 'message' => 'Đã gửi phản hồi']);

} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Lỗi: ' . $e->getMessage()]);
}
