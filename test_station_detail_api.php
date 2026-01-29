<?php
// Mock DOCUMENT_ROOT for CLI
$_SERVER['DOCUMENT_ROOT'] = 'c:/xampp/htdocs';
require_once 'c:/xampp/htdocs/ITS/config/Connect_DB.php';

$stationId = 1; // Test with ID 1

try {
    echo "Testing Station Details for ID: $stationId\n";

    // 1. Get Station Info
    $stmt = $conn->prepare("SELECT station_name, address, district, city, status FROM stations WHERE station_id = ?");
    $stmt->execute([$stationId]);
    $station = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$station) {
        echo "Station not found.\n";
    } else {
        echo "Station Found: " . $station['station_name'] . "\n";
        print_r($station);
    }

    // 2. Get Vehicles
    $vStmt = $conn->prepare("
        SELECT vehicle_name, vehicle_type, license_plate, status 
        FROM vehicles 
        WHERE station_id = ?
    ");
    $vStmt->execute([$stationId]);
    $vehicles = $vStmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "Vehicles count: " . count($vehicles) . "\n";
    if(count($vehicles) > 0) {
        print_r($vehicles[0]); // Show first vehicle
    }

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
