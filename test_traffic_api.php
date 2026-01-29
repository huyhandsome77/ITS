<?php
// Mock DOCUMENT_ROOT for CLI
$_SERVER['DOCUMENT_ROOT'] = 'c:/xampp/htdocs';
require_once 'c:/xampp/htdocs/ITS/config/Connect_DB.php';

try {
    echo "Connected to DB.\n";
    
    // 1. Get all stations
    $stationsStmt = $conn->prepare("SELECT station_id, station_name, municipality FROM stations");
    $stationsStmt->execute();
    $stations = $stationsStmt->fetchAll(PDO::FETCH_ASSOC);
    echo "Stations found: " . count($stations) . "\n";

    // 2. Get vehicle counts (available only)
    $sql = "
        SELECT 
            current_station_id, 
            type, 
            COUNT(*) as count 
        FROM vehicles 
        WHERE status = 'available' 
        GROUP BY current_station_id, type
    ";
    $countStmt = $conn->prepare($sql);
    $countStmt->execute();
    $counts = $countStmt->fetchAll(PDO::FETCH_ASSOC);
    echo "Counts found: " . count($counts) . "\n";
    print_r($counts);

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
