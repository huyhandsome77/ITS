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
    $status = trim($data['status']);

    // Validate status
    $validStatuses = ['NEW', 'RENTING', 'WAITING_RETURN', 'COMPLETED', 'CANCELLED'];
    if (!in_array($status, $validStatuses)) {
        throw new Exception('Trạng thái không hợp lệ');
    }

    // Lấy thông tin đơn hàng
    $orderSql = "SELECT * FROM orders WHERE order_code = :order_code";
    $orderStmt = $conn->prepare($orderSql);
    $orderStmt->execute([':order_code' => $order_code]);
    $order = $orderStmt->fetch(PDO::FETCH_ASSOC);

    if (!$order) {
        throw new Exception('Không tìm thấy đơn đặt xe');
    }

    // Kiểm tra logic chuyển trạng thái
    $currentStatus = $order['status'];
    
    // Không cho phép chuyển từ COMPLETED hoặc CANCELLED
    if (in_array($currentStatus, ['COMPLETED', 'CANCELLED'])) {
        throw new Exception('Không thể thay đổi trạng thái đơn đã hoàn thành hoặc đã hủy');
    }

    // Bắt đầu transaction
    $conn->beginTransaction();

    // Cập nhật trạng thái đơn
    $sql = "UPDATE orders SET status = :status WHERE order_code = :order_code";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':status' => $status,
        ':order_code' => $order_code
    ]);

    // Cập nhật trạng thái xe tương ứng
    $vehicle_id = $order['vehicle_id'];
    
    if ($status === 'RENTING') {
        // Xe đang được thuê
        $vehicleSql = "UPDATE vehicles SET status = 'RENTED' WHERE vehicle_id = :vehicle_id";
        $vehicleStmt = $conn->prepare($vehicleSql);
        $vehicleStmt->execute([':vehicle_id' => $vehicle_id]);
    } elseif (in_array($status, ['COMPLETED', 'CANCELLED'])) {
        // Xe trở về sẵn sàng
        $vehicleSql = "UPDATE vehicles SET status = 'AVAILABLE' WHERE vehicle_id = :vehicle_id";
        $vehicleStmt = $conn->prepare($vehicleSql);
        $vehicleStmt->execute([':vehicle_id' => $vehicle_id]);
    }

    $conn->commit();

    $statusText = match($status) {
        'NEW' => 'đơn mới',
        'RENTING' => 'đang thuê',
        'WAITING_RETURN' => 'chờ trả xe',
        'COMPLETED' => 'hoàn thành',
        'CANCELLED' => 'đã hủy',
        default => ''
    };

    echo json_encode([
        'success' => true,
        'message' => "Đã chuyển đơn sang trạng thái {$statusText}"
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
