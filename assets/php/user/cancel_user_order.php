<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/ITS/config/Connect_DB.php';

header('Content-Type: application/json');

// Kiểm tra đăng nhập
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'Vui lòng đăng nhập']);
    exit;
}

$userId = $_SESSION['user_id'];

// Kiểm tra phương thức POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['error' => 'Phương thức không hợp lệ']);
    exit;
}

// Lấy dữ liệu từ POST
$data = json_decode(file_get_contents('php://input'), true);
$orderCode = $data['order_code'] ?? '';
$cancelReason = $data['cancel_reason'] ?? '';

if ($orderCode === '') {
    echo json_encode(['error' => 'Thiếu mã đơn hàng']);
    exit;
}

try {
    $conn->beginTransaction();

    // Kiểm tra đơn hàng có thuộc về user này không
    $checkSql = "
        SELECT status, vehicle_id 
        FROM orders 
        WHERE order_code = :order_code 
        AND user_id = :user_id
        FOR UPDATE
    ";
    
    $checkStmt = $conn->prepare($checkSql);
    $checkStmt->execute([
        ':order_code' => $orderCode,
        ':user_id' => $userId
    ]);
    
    $orderData = $checkStmt->fetch();
    
    if (!$orderData) {
        $conn->rollBack();
        echo json_encode(['error' => 'Không tìm thấy đơn hàng hoặc bạn không có quyền hủy']);
        exit;
    }

    // Kiểm tra trạng thái - chỉ được hủy khi đơn ở trạng thái NEW
    if ($orderData['status'] !== 'NEW') {
        $conn->rollBack();
        echo json_encode([
            'error' => 'Không thể hủy đơn',
            'message' => 'Chỉ được hủy đơn hàng khi đơn đang ở trạng thái "Đang xử lý"'
        ]);
        exit;
    }

    // Cập nhật trạng thái đơn hàng
    $updateSql = "
        UPDATE orders 
        SET status = 'CANCELLED',
            cancel_reason = :cancel_reason,
            cancelled_at = NOW()
        WHERE order_code = :order_code
    ";
    
    $updateStmt = $conn->prepare($updateSql);
    $updateStmt->execute([
        ':cancel_reason' => $cancelReason ?: 'Khách hàng hủy đơn',
        ':order_code' => $orderCode
    ]);

    // Cập nhật trạng thái xe về AVAILABLE
    $updateVehicleSql = "
        UPDATE vehicles 
        SET status = 'AVAILABLE'
        WHERE vehicle_id = :vehicle_id
        AND status = 'RENTED'
    ";
    
    $updateVehicleStmt = $conn->prepare($updateVehicleSql);
    $updateVehicleStmt->execute([':vehicle_id' => $orderData['vehicle_id']]);

    $conn->commit();

    echo json_encode([
        'success' => true,
        'message' => "Đơn hàng #$orderCode đã được hủy thành công"
    ]);

} catch (Exception $e) {
    if ($conn->inTransaction()) {
        $conn->rollBack();
    }

    echo json_encode([
        'error' => 'Lỗi hệ thống',
        'message' => 'Không thể hủy đơn hàng. Vui lòng thử lại sau.'
    ]);
}
