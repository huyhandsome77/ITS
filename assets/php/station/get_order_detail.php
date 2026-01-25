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

if (!isset($_GET['order_code'])) {
    echo json_encode(['success' => false, 'message' => 'Order code required']);
    exit;
}

$orderCode = $_GET['order_code'];
$userId = $_SESSION['user_id'];

// Lấy station_id
$stationQuery = "SELECT station_id FROM users WHERE user_id = :user_id AND role = 'STATION'";
$stmtStation = $conn->prepare($stationQuery);
$stmtStation->execute([':user_id' => $userId]);
$stationData = $stmtStation->fetch();

if (!$stationData || !$stationData['station_id']) {
    echo json_encode(['success' => false, 'message' => 'Station not found']);
    exit;
}

$stationId = $stationData['station_id'];

// Lấy thông tin đơn hàng
$query = "
    SELECT 
        o.order_id,
        o.order_code,
        o.start_date,
        o.end_date,
        o.actual_return_date,
        o.total_amount,
        o.status,
        o.notes,
        o.cancel_reason,
        o.cancelled_at,
        o.completed_at,
        o.created_at,
        DATEDIFF(o.end_date, o.start_date) AS rental_days,
        u.full_name AS customer_name,
        u.email AS customer_email,
        u.phone AS customer_phone,
        v.vehicle_name,
        v.license_plate,
        v.vehicle_type,
        v.brand,
        v.model,
        v.year,
        v.seats,
        s.station_name,
        s.address AS station_address
    FROM orders o
    INNER JOIN users u ON o.user_id = u.user_id
    INNER JOIN vehicles v ON o.vehicle_id = v.vehicle_id
    LEFT JOIN stations s ON o.station_id = s.station_id
    WHERE o.order_code = :order_code AND o.station_id = :station_id
";

$stmt = $conn->prepare($query);
$stmt->execute([
    ':order_code' => $orderCode,
    ':station_id' => $stationId
]);

$order = $stmt->fetch();

if (!$order) {
    echo json_encode(['success' => false, 'message' => 'Order not found or access denied']);
    exit;
}

echo json_encode([
    'success' => true,
    'data' => $order
]);
