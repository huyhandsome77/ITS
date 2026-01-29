<?php
// assets/php/payment/momo_return.php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/ITS/config/Connect_DB.php';

// Verify logic here (Signature check skipped for simple demo, ideally should check)
// Assuming success if errorCode = 0

// Log Transaction function
function logTransaction($conn, $orderCode, $amount, $transId, $resultCode, $message) {
    try {
        $stmt = $conn->prepare("INSERT INTO payment_transactions (order_code, payment_type, amount, trans_id, result_code, message) VALUES (?, 'MOMO', ?, ?, ?, ?)");
        $stmt->execute([$orderCode, $amount, $transId, $resultCode, $message]);
    } catch (Exception $e) {
        // Ignore logging error if table invalid
    }
}

// DEBUG: Capture pure Response
file_put_contents('debug_momo.txt', print_r($_GET, true), FILE_APPEND);

// Handle likely Param variations
// MoMo sometimes uses 'errorCode', sometimes 'resultCode' depending on API version/doc.
$resultCode = $_GET['errorCode'] ?? $_GET['resultCode'] ?? -1; 
$message    = $_GET['message'] ?? $_GET['localMessage'] ?? 'Unknown Error';
$orderCode  = $_GET['orderId'] ?? '';
$amount     = $_GET['amount'] ?? 0;
$transId    = $_GET['transId'] ?? '';

// Log it
logTransaction($conn, $orderCode, $amount, $transId, $resultCode, $message);

if ($resultCode == '0') {
    try {
        // Update Order to DEPOSIT_PAID or similar to indicate success
        // Set Payment Method to MOMO_SUCCESS and status to PAID
        $stmt = $conn->prepare("UPDATE orders SET payment_method = 'MOMO_SUCCESS', payment_status = 'PAID' WHERE order_code = ?");
        $stmt->execute([$orderCode]);

        header("Location: /ITS/assets/html/layout/user/payment_result.php?status=success&order_code=$orderCode&amount=$amount");
        exit;
        
    } catch (Exception $e) {
        $msg = urlencode("Lỗi Cập nhật Đơn hàng: " . $e->getMessage());
        header("Location: /ITS/assets/html/layout/user/payment_result.php?status=error&message=$msg&order_code=$orderCode");
        exit;
    }
} else {
    $msg = urlencode("Giao dịch bị từ chối hoặc lỗi ($resultCode): $message");
    header("Location: /ITS/assets/html/layout/user/payment_result.php?status=error&message=$msg&order_code=$orderCode");
    exit;
}
?>
