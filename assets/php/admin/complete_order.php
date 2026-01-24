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
    $actual_return_date = date('Y-m-d H:i:s');

    // Lấy thông tin đơn hàng
    $orderSql = "SELECT * FROM orders WHERE order_code = :order_code";
    $orderStmt = $conn->prepare($orderSql);
    $orderStmt->execute([':order_code' => $order_code]);
    $order = $orderStmt->fetch(PDO::FETCH_ASSOC);

    if (!$order) {
        throw new Exception('Không tìm thấy đơn đặt xe');
    }

    // Kiểm tra trạng thái
    if (!in_array($order['status'], ['RENTING', 'WAITING_RETURN'])) {
        throw new Exception('Chỉ có thể xử lý trả xe cho đơn đang thuê hoặc chờ trả xe');
    }

    // Bắt đầu transaction
    $conn->beginTransaction();

    // Cập nhật đơn hàng
    $sql = "
        UPDATE orders 
        SET status = 'COMPLETED',
            actual_return_date = :actual_return_date,
            completed_at = NOW()
        WHERE order_code = :order_code
    ";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':actual_return_date' => $actual_return_date,
        ':order_code' => $order_code
    ]);

    // Cập nhật trạng thái xe về sẵn sàng
    $vehicleSql = "UPDATE vehicles SET status = 'AVAILABLE' WHERE vehicle_id = :vehicle_id";
    $vehicleStmt = $conn->prepare($vehicleSql);
    $vehicleStmt->execute([':vehicle_id' => $order['vehicle_id']]);

    $conn->commit();

    echo json_encode([
        'success' => true,
        'message' => 'Đã xác nhận trả xe thành công'
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
