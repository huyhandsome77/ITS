<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/ITS/config/Connect_DB.php';

require_once $_SERVER['DOCUMENT_ROOT'] . '/ITS/assets/php/payment/momo_create_payment.php';

/* 
  Form Submit Handler
*/

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /ITS/assets/html/layout/user/list_car.php');
    exit;
}

if (!isset($_SESSION['user_id'])) {
    die("Vui lòng đăng nhập"); 
}

$user_id = $_SESSION['user_id'];
$vehicle_id = $_POST['vehicle_id'] ?? 0;
$start_date = $_POST['start_date'] ?? '';
$start_time = $_POST['start_time'] ?? '00:00:00';
$end_date   = $_POST['end_date'] ?? '';
$end_time   = $_POST['end_time'] ?? '00:00:00';
$total_amount = str_replace(['.', 'đ'], '', $_POST['total_amount'] ?? '0');
$station_id = $_POST['station_id'] ?? 0;
$payment_method = $_POST['payment_method'] ?? 'CASH';

// Basic validation...

try {
    $conn->beginTransaction();

    // 1. LOCK the vehicle to prevent concurrent bookings
    $stmtLock = $conn->prepare("SELECT vehicle_name FROM vehicles WHERE vehicle_id = ? FOR UPDATE");
    $stmtLock->execute([$vehicle_id]);
    if ($stmtLock->rowCount() === 0) {
        throw new Exception("Xe không tồn tại.");
    }

    // 2. RE-CHECK AVAILABILITY (Server-side validation)
    $req_start = "$start_date $start_time";
    $req_end   = "$end_date $end_time";

    $checkSql = "
        SELECT COUNT(*) 
        FROM orders 
        WHERE vehicle_id = ?
        AND status IN ('NEW', 'RENTING', 'WAITING_RETURN', 'COMPLETED')
        AND (TIMESTAMP(end_date, end_time) + INTERVAL 30 MINUTE) > ?
        AND (TIMESTAMP(start_date, start_time) - INTERVAL 30 MINUTE) < ?
    ";
    
    $chk = $conn->prepare($checkSql);
    $chk->execute([$vehicle_id, $req_start, $req_end]);
    
    if ($chk->fetchColumn() > 0) {
        throw new Exception("Rất tiếc! Xe này vừa có khách khác đặt trong khung giờ này. Vui lòng tìm xe khác.");
    }

    // 3. GENERATE CODE & INSERT
    $order_code = 'DH' . strtoupper(substr(uniqid(), -5));
    // Initial status for MoMo is NEW (Pending Payment) but we track method
    // If MoMo, maybe set status to PENDING_PAYMENT? For now stick to NEW for simplicity or logic consistency
    
    $sql = "INSERT INTO orders 
            (order_code, station_id, user_id, vehicle_id, start_date, start_time, end_date, end_time, total_amount, status, payment_method)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 'NEW', ?)";
            
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        $order_code, $station_id, $user_id, $vehicle_id, 
        $start_date, $start_time, $end_date, $end_time, 
        (float)$total_amount, $payment_method
    ]);

    $conn->commit();

    // 4. PROCESS PAYMENT METHOD
    if ($payment_method === 'MOMO') {
        // Call MoMo API
        $momoRes = createMomoPayment($order_code, $total_amount);
        
        if (isset($momoRes['payUrl'])) {
            header('Location: ' . $momoRes['payUrl']);
            exit;
        } else {
            // MoMo Error
             echo "<script>
                alert('Lỗi tạo thanh toán MoMo: " . ($momoRes['message'] ?? 'Unknown Error') . "');
                window.history.back();
            </script>";
            exit;
        }
    } else {
        // CASH
        header("Location: /ITS/assets/html/layout/user/payment_result.php?status=success&order_code=$order_code&amount=$total_amount");
        exit;
    }

} catch (Exception $e) {
    if ($conn->inTransaction()) {
        $conn->rollBack();
    }
    $msg = urlencode($e->getMessage());
    header("Location: /ITS/assets/html/layout/user/payment_result.php?status=error&message=$msg");
    exit;
}
?>
