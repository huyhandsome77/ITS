<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/ITS/config/Connect_DB.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit;
}

try {
    $data = json_decode(file_get_contents('php://input'), true);
    $order_code = trim($data['order_code']);

    // Lấy thông tin đơn hàng
    $orderSql = "SELECT * FROM orders WHERE order_code = :order_code";
    $orderStmt = $conn->prepare($orderSql);
    $orderStmt->execute([':order_code' => $order_code]);
    $order = $orderStmt->fetch(PDO::FETCH_ASSOC);

    if (!$order) {
        throw new Exception('Không tìm thấy đơn đặt xe');
    }

    // Chỉ cho phép xóa đơn đã HỦY hoặc HOÀN THÀNH
    if (!in_array($order['status'], ['CANCELLED', 'COMPLETED'])) {
        throw new Exception('Chỉ có thể xóa đơn đã hủy hoặc hoàn thành');
    }

    // Xóa đơn (soft delete bằng cách thêm is_deleted hoặc hard delete)
    // Ở đây tôi sử dụng hard delete
    $deleteSql = "DELETE FROM orders WHERE order_code = :order_code";
    $deleteStmt = $conn->prepare($deleteSql);
    $deleteStmt->execute([':order_code' => $order_code]);

    echo json_encode([
        'success' => true,
        'message' => 'Đã xóa đơn đặt xe thành công'
    ]);

} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
