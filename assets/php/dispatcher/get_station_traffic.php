<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/ITS/config/Connect_DB.php';
header('Content-Type: application/json');

try {
    // 1. Get all stations
    $stationsStmt = $conn->prepare("SELECT station_id, station_name, district, city FROM stations");
    $stationsStmt->execute();
    $stations = $stationsStmt->fetchAll(PDO::FETCH_ASSOC);

    // 2. Get vehicle counts (available only)
    $sql = "
        SELECT 
            station_id, 
            vehicle_type, 
            COUNT(*) as count 
        FROM vehicles 
        WHERE status = 'AVAILABLE' 
        GROUP BY station_id, vehicle_type
    ";
    $countStmt = $conn->prepare($sql);
    $countStmt->execute();
    $counts = $countStmt->fetchAll(PDO::FETCH_ASSOC);

    // Map counts to stations
    $stationData = [];
    $totalStations = count($stations);
    $lowStockStations = 0;
    $overStockStations = 0;

    foreach ($stations as $station) {
        $id = $station['station_id'];
        
        $carCount = 0;
        $bikeCount = 0;

        foreach ($counts as $c) {
            if ($c['station_id'] == $id) {
                if ($c['vehicle_type'] == 'Oto') $carCount = $c['count'];
                if ($c['vehicle_type'] == 'Xemay') $bikeCount = $c['count'];
            }
        }

        $totalVehicles = $carCount + $bikeCount;
        
        // Define status
        // Thresholds: < 3 (Low), > 10 (Over), Else (Normal)
        $status = 'NORMAL';
        if ($totalVehicles < 3) {
            $status = 'LOW';
            $lowStockStations++;
        } elseif ($totalVehicles > 15) {
            $status = 'OVER';
            $overStockStations++;
        }

        $stationData[] = [
            'station_id' => $id,
            'station_name' => $station['station_name'],
            'municipality' => $station['district'] . ', ' . $station['city'], // Construct readable location
            'car_count' => $carCount,
            'bike_count' => $bikeCount,
            'total_vehicles' => $totalVehicles,
            'status' => $status
        ];
    }

    echo json_encode([
        'success' => true,
        'stats' => [
            'total_stations' => $totalStations,
            'low_stock' => $lowStockStations,
            'over_stock' => $overStockStations
        ],
        'stations' => $stationData
    ]);

} catch (PDOException $e) {
    echo json_encode([
        'success' => false, 
        'message' => 'Database error: ' . $e->getMessage()
    ]);
}
