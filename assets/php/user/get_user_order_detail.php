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

// Kiểm tra tham số
if (!isset($_GET['order_code'])) {
    echo json_encode(['error' => 'Thiếu mã đơn hàng']);
    exit;
}

$orderCode = trim($_GET['order_code']);

/* ================== LẤY CHI TIẾT ĐƠN HÀNG ================== */

$sql = "
    SELECT 
        o.*,
        s.station_name,
        s.address as station_address,
        u.full_name as customer_name,
        u.email as customer_email,
        u.phone as customer_phone,
        v.vehicle_id,
        v.vehicle_name,
        v.license_plate,
        v.brand,
        v.model,
        v.vehicle_type,
        v.year,
        v.seats,
        v.price_per_day,
        v.price_per_hour,
        v.description as vehicle_description,
        v.image as vehicle_image,
        DATEDIFF(o.end_date, o.start_date) + 1 as rental_days
    FROM orders o
    JOIN stations s ON o.station_id = s.station_id
    JOIN users u ON o.user_id = u.user_id
    JOIN vehicles v ON o.vehicle_id = v.vehicle_id
    WHERE o.order_code = :order_code 
    AND o.user_id = :user_id
";

$stmt = $conn->prepare($sql);
$stmt->execute([
    ':order_code' => $orderCode,
    ':user_id' => $userId
]);

$order = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$order) {
    echo json_encode(['error' => 'Không tìm thấy đơn hàng hoặc bạn không có quyền xem']);
    exit;
}

/* ================== XỬ LÝ TRẠNG THÁI ================== */

switch ($order['status']) {
    case 'NEW':
        $order['status_text'] = 'Đang xử lý';
        $order['status_class'] = 'pending';
        $order['status_color'] = 'yellow';
        $order['can_cancel'] = true;
        $order['can_rebook'] = false;
        $order['can_review'] = false;
        break;
    case 'RENTING':
        $order['status_text'] = 'Đang thuê';
        $order['status_class'] = 'confirmed';
        $order['status_color'] = 'blue';
        $order['can_cancel'] = false;
        $order['can_rebook'] = false;
        $order['can_review'] = false;
        break;
    case 'WAITING_RETURN':
        $order['status_text'] = 'Chờ trả xe';
        $order['status_class'] = 'confirmed';
        $order['status_color'] = 'blue';
        $order['can_cancel'] = false;
        $order['can_rebook'] = false;
        $order['can_review'] = false;
        break;
    case 'COMPLETED':
        $order['status_text'] = 'Hoàn thành';
        $order['status_class'] = 'completed';
        $order['status_color'] = 'green';
        $order['can_cancel'] = false;
        $order['can_rebook'] = true;
        $order['can_review'] = true;
        break;
    case 'CANCELLED':
        $order['status_text'] = 'Đã hủy';
        $order['status_class'] = 'cancelled';
        $order['status_color'] = 'red';
        $order['can_cancel'] = false;
        $order['can_rebook'] = true;
        $order['can_review'] = false;
        break;
}

/* ================== FORMAT DỮ LIỆU ================== */

// Format số tiền
$order['total_amount_formatted'] = number_format($order['total_amount'], 0, ',', '.') . '₫';
$order['price_per_day_formatted'] = number_format($order['price_per_day'], 0, ',', '.') . '₫';
$order['price_per_hour_formatted'] = number_format($order['price_per_hour'], 0, ',', '.') . '₫';

// Format ngày giờ
$order['start_date_formatted'] = date('d/m/Y', strtotime($order['start_date']));
$order['end_date_formatted'] = date('d/m/Y', strtotime($order['end_date']));
$order['created_at_formatted'] = date('d/m/Y H:i', strtotime($order['created_at']));

if ($order['actual_return_date']) {
    $order['actual_return_date_formatted'] = date('d/m/Y H:i', strtotime($order['actual_return_date']));
}

if ($order['cancelled_at']) {
    $order['cancelled_at_formatted'] = date('d/m/Y H:i', strtotime($order['cancelled_at']));
}

if ($order['completed_at']) {
    $order['completed_at_formatted'] = date('d/m/Y H:i', strtotime($order['completed_at']));
}

/* ================== TRẢ VỀ KẾT QUẢ ================== */

echo json_encode([
    'success' => true,
    'order' => $order
]);
