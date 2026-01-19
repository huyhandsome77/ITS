<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/ITS/config/Connect_DB.php';

$code = $_GET['code'] ?? '';

$sql = "
    SELECT 
        o.order_code,
        o.start_date,
        o.end_date,
        o.total_amount,
        o.status,
        o.created_at,

        s.station_name,

        v.vehicle_name,
        v.license_plate,
        v.vehicle_type,

        u.full_name,
        u.phone
    FROM orders o
    JOIN stations s ON o.station_id = s.station_id
    JOIN vehicles v ON o.vehicle_id = v.vehicle_id
    JOIN users u ON o.user_id = u.user_id
    WHERE o.order_code = :code
";

$stmt = $conn->prepare($sql);
$stmt->bindValue(':code', $code);
$stmt->execute();

echo json_encode($stmt->fetch());