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
    $cancel_reason = trim($data['cancel_reason'] ?? 'Admin hủy đơn');

    // Lấy thông tin đơn hàng
    $orderSql = "SELECT * FROM orders WHERE order_code = :order_code";
    $orderStmt = $conn->prepare($orderSql);
    $orderStmt->execute([':order_code' => $order_code]);
    $order = $orderStmt->fetch(PDO::FETCH_ASSOC);

    if (!$order) {
        throw new Exception('Không tìm thấy đơn đặt xe');
    }

    // Kiểm tra trạng thái
    if (in_array($order['status'], ['COMPLETED', 'CANCELLED'])) {
        throw new Exception('Không thể hủy đơn đã hoàn thành hoặc đã hủy');
    }

    if ($order['status'] === 'RENTING') {
        throw new Exception('Không thể hủy đơn đang trong quá trình thuê');
    }

    // Bắt đầu transaction
    $conn->beginTransaction();

    // Cập nhật trạng thái đơn
    $sql = "
        UPDATE orders 
        SET status = 'CANCELLED', 
            cancel_reason = :cancel_reason,
            cancelled_at = NOW()
        WHERE order_code = :order_code
    ";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':cancel_reason' => $cancel_reason,
        ':order_code' => $order_code
    ]);

    // Cập nhật trạng thái xe về sẵn sàng
    $vehicleSql = "UPDATE vehicles SET status = 'AVAILABLE' WHERE vehicle_id = :vehicle_id";
    $vehicleStmt = $conn->prepare($vehicleSql);
    $vehicleStmt->execute([':vehicle_id' => $order['vehicle_id']]);

    $conn->commit();

    echo json_encode([
        'success' => true,
        'message' => 'Đã hủy đơn đặt xe thành công'
    ]);

} catch (Exception $e) {
    if ($conn->inTransaction()) {
        $conn->rollBack();
    }
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
