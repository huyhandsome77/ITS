<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/ITS/config/Connect_DB.php';
header('Content-Type: application/json');

$stationId = $_GET['station_id'] ?? null;

if (!$stationId) {
    echo json_encode(['success' => false, 'message' => 'Station ID required']);
    exit;
}

try {
    // 1. Get Station Info
    $stmt = $conn->prepare("SELECT station_name, address, district, city, status FROM stations WHERE station_id = ?");
    $stmt->execute([$stationId]);
    $station = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$station) {
        echo json_encode(['success' => false, 'message' => 'Station not found']);
        exit;
    }

    // 2. Get Vehicles at this station
    $vStmt = $conn->prepare("
        SELECT 
            vehicle_name, 
            vehicle_type, 
            license_plate, 
            status 
        FROM vehicles 
        WHERE station_id = ?
        ORDER BY vehicle_type ASC, status ASC
    ");
    $vStmt->execute([$stationId]);
    $vehicles = $vStmt->fetchAll(PDO::FETCH_ASSOC);

    // 3. Calc stats
    $carCount = 0;
    $bikeCount = 0;
    foreach ($vehicles as $v) {
        if ($v['vehicle_type'] === 'Oto') $carCount++;
        elseif ($v['vehicle_type'] === 'Xemay') $bikeCount++;
    }

    echo json_encode([
        'success' => true,
        'station' => [
            'name' => $station['station_name'],
            'address' => $station['address'] . ', ' . $station['district'] . ', ' . $station['city'],
            'status' => $station['status']
        ],
        'stats' => [
            'car_count' => $carCount,
            'bike_count' => $bikeCount
        ],
        'vehicles' => $vehicles
    ]);

} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
