<?php
session_start();
require_once '../../../config/Connect_DB.php';

// Check if user is admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'ADMIN') {
    http_response_code(403);
    echo json_encode([
        'success' => false,
        'message' => 'Unauthorized access'
    ]);
    exit;
}

// Get JSON input
$input = json_decode(file_get_contents('php://input'), true);
$order_code = $input['order_code'] ?? '';
$transaction_id = $input['transaction_id'] ?? 0;

// Validation
if (empty($order_code)) {
    echo json_encode([
        'success' => false,
        'message' => 'Thiếu mã đơn hàng'
    ]);
    exit;
}

try {
    $conn->beginTransaction();

    // 1. Update orders table - set payment_status to PAID
    $stmtOrder = $conn->prepare("
        UPDATE orders 
        SET payment_status = 'PAID' 
        WHERE order_code = :order_code 
        AND payment_status = 'UNPAID'
    ");
    $stmtOrder->bindParam(':order_code', $order_code);
    $stmtOrder->execute();

    if ($stmtOrder->rowCount() === 0) {
        throw new Exception('Không tìm thấy đơn hàng hoặc đơn hàng đã được thanh toán');
    }

    // 2. Update payment_transactions table - set result_code to 0 (success)
    $stmtTxn = $conn->prepare("
        UPDATE payment_transactions 
        SET result_code = 0,
            message = 'Đã xác nhận thanh toán tại trạm'
        WHERE order_code = :order_code
    ");
    $stmtTxn->bindParam(':order_code', $order_code);
    $stmtTxn->execute();

    $conn->commit();

    echo json_encode([
        'success' => true,
        'message' => 'Đã xác nhận thanh toán thành công'
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
?>
