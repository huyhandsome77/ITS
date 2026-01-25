<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/ITS/config/Connect_DB.php';

$code = $_GET['code'] ?? '';

if ($code === '') {
    $_SESSION['alert'] = ['type' => 'error', 'title' => 'Lỗi', 'text' => 'Mã đơn không hợp lệ'];
    header('Location: /ITS/assets/html/layout/dispatcher/dispatcher_orders.php');
    exit;
}

try {
    $conn->beginTransaction();

    $stmt = $conn->prepare("SELECT status FROM orders WHERE order_code = :code FOR UPDATE");
    $stmt->execute([':code' => $code]);
    $status = $stmt->fetchColumn();

    if ($status !== 'WAITING_RETURN') {
        $conn->rollBack();
        $_SESSION['alert'] = [
            'type' => 'error',
            'title' => 'Không hợp lệ',
            'text' => 'Đơn hàng không ở trạng thái Chờ Trả Xe'
        ];
        header('Location: /ITS/assets/html/layout/dispatcher/dispatcher_orders.php');
        exit;
    }

    $now = date('Y-m-d H:i:s');
    $conn->prepare("
        UPDATE orders 
        SET status = 'COMPLETED', actual_return_date = :now, completed_at = :now
        WHERE order_code = :code
    ")->execute([':now' => $now, ':code' => $code]);

    $conn->commit();

    $_SESSION['alert'] = [
        'type' => 'success',
        'title' => 'Hoàn tất trả xe',
        'text' => "Đơn hàng #$code đã hoàn thành"
    ];

} catch (Exception $e) {
    if ($conn->inTransaction()) $conn->rollBack();
    $_SESSION['alert'] = ['type' => 'error', 'title' => 'Lỗi hệ thống', 'text' => $e->getMessage()];
}

header('Location: /ITS/assets/html/layout/dispatcher/dispatcher_orders.php');
exit;
?>
