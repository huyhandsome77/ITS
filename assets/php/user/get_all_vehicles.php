<?php
require_once '../../../config/Connect_DB.php';

header('Content-Type: application/json');

try {
    // Fetch all available vehicles from the database
    $sql = "SELECT 
                MAX(v.vehicle_id) as vehicle_id,
                MAX(v.vehicle_name) as vehicle_name,
                -- license_plate removed as requested (generic display)
                MAX(v.vehicle_type) as vehicle_type,
                MAX(v.brand) as brand,
                v.model,
                MAX(v.year) as year,
                MAX(v.seats) as seats,
                MIN(v.price_per_day) as price_per_day,
                MIN(v.price_per_hour) as price_per_hour,
                MAX(v.description) as description,
                MAX(v.image) as image,
                MAX(v.status) as status,
                MAX(s.station_name) as station_name,
                MAX(s.city) as city,
                MAX(s.district) as district
            FROM vehicles v
            LEFT JOIN stations s ON v.station_id = s.station_id
            WHERE v.status != 'MAINTENANCE'
            GROUP BY v.model
            ORDER BY vehicle_type DESC, price_per_day ASC";
    
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
