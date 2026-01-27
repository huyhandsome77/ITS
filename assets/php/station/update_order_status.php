<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/ITS/config/Connect_DB.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

header('Content-Type: application/json');

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'STATION') {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['order_code']) || !isset($data['action'])) {
    echo json_encode(['success' => false, 'message' => 'Order code and action required']);
    exit;
}

$orderCode = $data['order_code'];
$action = $data['action'];
$userId = $_SESSION['user_id'];

// Lấy station_id
$stationQuery = "SELECT managed_station_id FROM users WHERE user_id = :user_id AND role = 'STATION'";
$stmtStation = $conn->prepare($stationQuery);
$stmtStation->execute([':user_id' => $userId]);
$stationData = $stmtStation->fetch();

if (!$stationData || !$stationData['managed_station_id']) {
    echo json_encode(['success' => false, 'message' => 'Station not found']);
    exit;
}

$stationId = $stationData['managed_station_id'];

// Kiểm tra đơn hàng thuộc trạm
$checkQuery = "SELECT order_id, vehicle_id, status FROM orders WHERE order_code = :order_code AND station_id = :station_id";
$checkStmt = $conn->prepare($checkQuery);
$checkStmt->execute([':order_code' => $orderCode, ':station_id' => $stationId]);
$order = $checkStmt->fetch();

if (!$order) {
    echo json_encode(['success' => false, 'message' => 'Order not found or access denied']);
    exit;
}

try {
    $conn->beginTransaction();

    switch ($action) {
        case 'confirm_pickup':
            // NEW -> RENTING
            if ($order['status'] !== 'NEW') {
                throw new Exception('Chỉ có thể xác nhận nhận xe cho đơn mới');
            }

            $updateQuery = "UPDATE orders SET status = 'RENTING' WHERE order_code = :order_code";
            $updateStmt = $conn->prepare($updateQuery);
            $updateStmt->execute([':order_code' => $orderCode]);

            // Cập nhật trạng thái xe thành RENTED
            $updateVehicleQuery = "UPDATE vehicles SET status = 'RENTED' WHERE vehicle_id = :vehicle_id";
            $updateVehicleStmt = $conn->prepare($updateVehicleQuery);
            $updateVehicleStmt->execute([':vehicle_id' => $order['vehicle_id']]);

            $message = 'Đã xác nhận khách nhận xe thành công';
            break;

        case 'confirm_return':
            // RENTING -> WAITING_RETURN
            if ($order['status'] !== 'RENTING') {
                throw new Exception('Chỉ có thể xác nhận trả xe cho đơn đang thuê');
            }

            $updateQuery = "UPDATE orders SET status = 'WAITING_RETURN', actual_return_date = NOW() WHERE order_code = :order_code";
            $updateStmt = $conn->prepare($updateQuery);
            $updateStmt->execute([':order_code' => $orderCode]);

            $message = 'Đã xác nhận khách trả xe, đang chờ xử lý hoàn tất';
            break;

        case 'complete_order':
            // WAITING_RETURN -> COMPLETED
            if ($order['status'] !== 'WAITING_RETURN') {
                throw new Exception('Chỉ có thể hoàn thành đơn đang chờ trả xe');
            }

            $updateQuery = "UPDATE orders SET status = 'COMPLETED', completed_at = NOW() WHERE order_code = :order_code";
            $updateStmt = $conn->prepare($updateQuery);
            $updateStmt->execute([':order_code' => $orderCode]);

            // Cập nhật trạng thái xe về AVAILABLE
            $updateVehicleQuery = "UPDATE vehicles SET status = 'AVAILABLE' WHERE vehicle_id = :vehicle_id";
            $updateVehicleStmt = $conn->prepare($updateVehicleQuery);
            $updateVehicleStmt->execute([':vehicle_id' => $order['vehicle_id']]);

            $message = 'Đã hoàn thành đơn hàng thành công';
            break;

        case 'cancel_order':
            // NEW -> CANCELLED
            if ($order['status'] !== 'NEW') {
                throw new Exception('Chỉ có thể hủy đơn mới');
            }

            $cancelReason = $data['cancel_reason'] ?? 'Trạm hủy đơn';

            $updateQuery = "UPDATE orders SET status = 'CANCELLED', cancel_reason = :cancel_reason, cancelled_at = NOW() WHERE order_code = :order_code";
            $updateStmt = $conn->prepare($updateQuery);
            $updateStmt->execute([
                ':order_code' => $orderCode,
                ':cancel_reason' => $cancelReason
            ]);

            $message = 'Đã hủy đơn hàng thành công';
            break;

        default:
            throw new Exception('Invalid action');
    }

    $conn->commit();
    echo json_encode(['success' => true, 'message' => $message]);

} catch (Exception $e) {
    $conn->rollBack();
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
