<?php
require_once '../../../config/Connect_DB.php';

header('Content-Type: application/json');

try {
    // Fetch all available vehicles from the database
    $sql = "SELECT 
                v.vehicle_id,
                v.vehicle_name,
                v.license_plate,
                v.vehicle_type,
                v.brand,
                v.model,
                v.year,
                v.seats,
                v.price_per_day,
                v.price_per_hour,
                v.description,
                v.image,
                v.status,
                s.station_name,
                s.city,
                s.district
            FROM vehicles v
            LEFT JOIN stations s ON v.station_id = s.station_id
            WHERE v.status = 'AVAILABLE'
            ORDER BY v.vehicle_type, v.price_per_day DESC";
    
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $vehicles = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode([
        'success' => true,
        'data' => $vehicles,
        'total' => count($vehicles)
    ]);
    
} catch (PDOException $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Lỗi khi lấy dữ liệu xe: ' . $e->getMessage()
    ]);
}
