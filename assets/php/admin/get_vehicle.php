<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/ITS/config/Connect_DB.php';

header('Content-Type: application/json');

if (!isset($_GET['id'])) {
    echo json_encode(['error' => 'Missing vehicle ID']);
    exit;
}

$vehicleId = (int)$_GET['id'];

$sql = "
    SELECT 
        v.*,
        s.station_name
    FROM vehicles v
    LEFT JOIN stations s ON v.station_id = s.station_id
    WHERE v.vehicle_id = :id
";

$stmt = $conn->prepare($sql);
$stmt->execute([':id' => $vehicleId]);
$vehicle = $stmt->fetch(PDO::FETCH_ASSOC);

if ($vehicle) {
    echo json_encode($vehicle);
} else {
    echo json_encode(['error' => 'Vehicle not found']);
}
