<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/ITS/config/Connect_DB.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /ITS/assets/html/layout/admin/manage_orders.php');
    exit;
}

try {
    // Lấy dữ liệu từ form
    $user_id = (int)$_POST['user_id'];
    $station_id = (int)$_POST['station_id'];
    $vehicle_id = (int)$_POST['vehicle_id'];
    $start_date = trim($_POST['start_date']);
    $end_date = trim($_POST['end_date']);
    $notes = trim($_POST['notes'] ?? '');

    // Validate dữ liệu
    if (empty($user_id) || empty($station_id) || empty($vehicle_id) || empty($start_date) || empty($end_date)) {
        throw new Exception('Vui lòng điền đầy đủ thông tin bắt buộc');
    }

    // Kiểm tra ngày hợp lệ
    if (strtotime($end_date) < strtotime($start_date)) {
        throw new Exception('Ngày trả xe phải sau ngày nhận xe');
    }

    // Kiểm tra xe có sẵn không
    $vehicleCheckSql = "SELECT status, price_per_day FROM vehicles WHERE vehicle_id = :vehicle_id";
    $vehicleCheckStmt = $conn->prepare($vehicleCheckSql);
    $vehicleCheckStmt->execute([':vehicle_id' => $vehicle_id]);
    $vehicle = $vehicleCheckStmt->fetch(PDO::FETCH_ASSOC);

    if (!$vehicle) {
        throw new Exception('Không tìm thấy phương tiện');
    }

    if ($vehicle['status'] !== 'AVAILABLE') {
        throw new Exception('Phương tiện không sẵn sàng để thuê');
    }

    // Tính tổng tiền
    $start = new DateTime($start_date);
    $end = new DateTime($end_date);
    $days = $start->diff($end)->days + 1;
    $total_amount = $days * $vehicle['price_per_day'];

    // Tạo mã đơn
    $order_code = 'ORD' . date('Ymd') . str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT);

    // Bắt đầu transaction
    $conn->beginTransaction();

    // Thêm đơn đặt xe
    $sql = "
        INSERT INTO orders (
            order_code, user_id, station_id, vehicle_id,
            start_date, end_date, total_amount, notes, status
        ) VALUES (
            :order_code, :user_id, :station_id, :vehicle_id,
            :start_date, :end_date, :total_amount, :notes, 'NEW'
        )
    ";

    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':order_code' => $order_code,
        ':user_id' => $user_id,
        ':station_id' => $station_id,
        ':vehicle_id' => $vehicle_id,
        ':start_date' => $start_date,
        ':end_date' => $end_date,
        ':total_amount' => $total_amount,
        ':notes' => $notes
    ]);

    $conn->commit();

    $_SESSION['swal'] = [
        'type' => 'success',
        'title' => 'Thành công',
        'text' => "Tạo đơn đặt xe thành công. Mã đơn: {$order_code}"
    ];

} catch (Exception $e) {
    if ($conn->inTransaction()) {
        $conn->rollBack();
    }
    $_SESSION['swal'] = [
        'type' => 'error',
        'title' => 'Lỗi',
        'text' => $e->getMessage()
    ];
}

header('Location: /ITS/assets/html/layout/admin/manage_orders.php');
exit;
