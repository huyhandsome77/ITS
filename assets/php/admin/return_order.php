<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/ITS/config/Connect_DB.php';

$code = $_GET['code'] ?? '';

if ($code === '') {
    $_SESSION['alert'] = [
        'type' => 'error',
        'title' => 'Lỗi',
        'text' => 'Mã đơn không hợp lệ'
    ];
    header('Location: /ITS/assets/html/layout/admin/manage_orders.php');
    exit;
}

try {
    $conn->beginTransaction();

    // Lấy trạng thái đơn + vehicle
    $stmt = $conn->prepare("
        SELECT status, vehicle_id 
        FROM orders 
        WHERE order_code = :code
        FOR UPDATE
    ");
    $stmt->execute([':code' => $code]);
    $order = $stmt->fetch();

    // Kiểm tra nghiệp vụ
    if (!$order || $order['status'] !== 'WAITING_RETURN') {
        $conn->rollBack();
        $_SESSION['alert'] = [
            'type' => 'error',
            'title' => 'Không hợp lệ',
            'text' => 'Chỉ xác nhận trả xe khi đơn đang CHỜ TRẢ XE'
        ];
        header('Location: /ITS/assets/html/layout/admin/manage_orders.php');
        exit;
    }

    // Cập nhật đơn → COMPLETED
    $conn->prepare("
        UPDATE orders 
        SET status = 'COMPLETED'
        WHERE order_code = :code
    ")->execute([':code' => $code]);

    // Cập nhật xe → AVAILABLE
    $conn->prepare("
        UPDATE vehicles 
        SET status = 'AVAILABLE'
        WHERE vehicle_id = :vid
    ")->execute([':vid' => $order['vehicle_id']]);

    $conn->commit();

    $_SESSION['alert'] = [
        'type' => 'success',
        'title' => 'Hoàn tất',
        'text' => "Đã xác nhận trả xe cho đơn #$code"
    ];

} catch (Exception $e) {
    if ($conn->inTransaction()) {
        $conn->rollBack();
    }

    $_SESSION['alert'] = [
        'type' => 'error',
        'title' => 'Lỗi hệ thống',
        'text' => 'Không thể xác nhận trả xe. Vui lòng thử lại.'
    ];
}

header('Location: /ITS/assets/html/layout/admin/manage_orders.php');
exit;