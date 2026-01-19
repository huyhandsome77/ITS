<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/ITS/config/Connect_DB.php';

header('Content-Type: application/json');

if (!isset($_GET['order_code'])) {
    echo json_encode(['error' => 'Missing order code']);
    exit;
}

$orderCode = trim($_GET['order_code']);

$sql = "
    SELECT 
        o.*,
        s.station_name,
        s.address as station_address,
        u.full_name as customer_name,
        u.email as customer_email,
        u.phone as customer_phone,
        v.vehicle_name,
        v.license_plate,
        v.brand,
        v.model,
        v.vehicle_type,
        v.price_per_day
    FROM orders o
    JOIN stations s ON o.station_id = s.station_id
    JOIN users u ON o.user_id = u.user_id
    JOIN vehicles v ON o.vehicle_id = v.vehicle_id
    WHERE o.order_code = :order_code
";

$stmt = $conn->prepare($sql);
$stmt->execute([':order_code' => $orderCode]);
$order = $stmt->fetch(PDO::FETCH_ASSOC);

if ($order) {
    // Tính số ngày thuê
    $startDate = new DateTime($order['start_date']);
    $endDate = new DateTime($order['end_date']);
    $days = $startDate->diff($endDate)->days + 1;
    $order['rental_days'] = $days;
    
    echo json_encode($order);
} else {
    echo json_encode(['error' => 'Order not found']);
}
