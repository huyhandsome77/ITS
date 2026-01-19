<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/QuanTriMang/config/Connect_DB.php';

$code = $_GET['code'] ?? '';

if ($code === '') {
    $_SESSION['alert'] = [
        'type' => 'error',
        'title' => 'Lỗi',
        'text' => 'Mã đơn không hợp lệ'
    ];
    header('Location: /QuanTriMang/assets/html/layout/admin/manage_orders.php');
    exit;
}

try {
    $conn->beginTransaction();

    // Lấy trạng thái đơn
    $stmt = $conn->prepare("
        SELECT status 
        FROM orders 
        WHERE order_code = :code
        FOR UPDATE
    ");
    $stmt->execute([':code' => $code]);
    $status = $stmt->fetchColumn();

    // Kiểm tra nghiệp vụ
    if ($status !== 'NEW') {
        $conn->rollBack();
        $_SESSION['alert'] = [
            'type' => 'error',
            'title' => 'Không thể hủy',
            'text' => 'Chỉ được hủy khi đơn ở trạng thái ĐƠN MỚI'
        ];
        header('Location: /QuanTriMang/assets/html/layout/admin/manage_orders.php');
        exit;
    }

    // Hủy đơn
    $conn->prepare("
        UPDATE orders 
        SET status = 'CANCELLED'
        WHERE order_code = :code
    ")->execute([':code' => $code]);

    $conn->commit();

    $_SESSION['alert'] = [
        'type' => 'success',
        'title' => 'Đã hủy đơn',
        'text' => "Đơn hàng #$code đã được hủy thành công"
    ];

} catch (Exception $e) {
    if ($conn->inTransaction()) {
        $conn->rollBack();
    }

    $_SESSION['alert'] = [
        'type' => 'error',
        'title' => 'Lỗi hệ thống',
        'text' => 'Không thể hủy đơn. Vui lòng thử lại.'
    ];
}

header('Location: /QuanTriMang/assets/html/layout/admin/manage_orders.php');
exit;