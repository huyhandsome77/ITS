<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/ITS/config/Connect_DB.php';

// 1. FETCH ALL STATIONS FOR DROPDOWN
$stations = [];
try {
    $stmt = $conn->query("SELECT station_id, station_name, city, district FROM stations WHERE status = 'ACTIVE' AND is_maintenance = 0");
    $stations = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    echo "<!-- DB Error: " . $e->getMessage() . " -->";
}

// 2. HANDLE SEARCH
$selectedStationId = $_GET['station_id'] ?? null;
$cars = [];
$bikes = [];
$hasSearched = false;

if ($selectedStationId) {
    $hasSearched = true;
    
    // Find Station Name from the already fetched list
    $currentStationName = '';
    foreach($stations as $s) {
        if ($s['station_id'] == $selectedStationId) {
            $currentStationName = $s['station_name'];
            break;
        }
    }

    try {
        // Query grouped by Model to show distinctive cars
        // Using a subquery to get the 'first' available vehicle for each model
        $sql = "
            SELECT v.* 
            FROM vehicles v
            INNER JOIN (
                SELECT MIN(vehicle_id) as min_id
                FROM vehicles
                WHERE station_id = ? AND status = 'AVAILABLE'
                GROUP BY brand, model, vehicle_type
            ) grouped_v ON v.vehicle_id = grouped_v.min_id
            ORDER BY v.vehicle_type, v.price_per_day
        ";
        
        $stmt = $conn->prepare($sql);
        $stmt->execute([$selectedStationId]);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach($results as $v) {
            if($v['vehicle_type'] === 'Oto') $cars[] = $v;
            else $bikes[] = $v;
        }

    } catch(PDOException $e) {
        echo "<!-- Search Error: " . $e->getMessage() . " -->";
    }
}
?>
