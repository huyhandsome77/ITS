<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/ITS/config/Connect_DB.php';
header('Content-Type: application/json');

try {
    // ============================================
    // BƯỚC 1: LẤY DỮ LIỆU TRẠM VÀ XE
    // ============================================
    $stationsStmt = $conn->prepare("
        SELECT station_id, station_name, district, city, 
               latitude, longitude
        FROM stations
    ");
    $stationsStmt->execute();
    $stations = $stationsStmt->fetchAll(PDO::FETCH_ASSOC);

    // Lấy số xe khả dụng
    $vehicleCountStmt = $conn->prepare("
        SELECT station_id, vehicle_type, COUNT(*) as count 
        FROM vehicles 
        WHERE status = 'AVAILABLE' 
        GROUP BY station_id, vehicle_type
    ");
    $vehicleCountStmt->execute();
    $vehicleCounts = $vehicleCountStmt->fetchAll(PDO::FETCH_ASSOC);

    // ============================================
    // BƯỚC 2: TÍNH NHU CẦU DỰ ĐOÁN (PREDICTED DEMAND)
    // ============================================
    // Dựa trên lịch sử đơn hàng 7 ngày qua
    $demandStmt = $conn->prepare("
        SELECT 
            o.station_id,
            v.vehicle_type,
            COUNT(*) as historical_rentals,
            AVG(TIMESTAMPDIFF(HOUR, o.created_at, o.start_date)) as avg_booking_lead_time
        FROM orders o
        JOIN vehicles v ON o.vehicle_id = v.vehicle_id
        WHERE o.created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)
          AND o.status IN ('RENTING', 'COMPLETED')
        GROUP BY o.station_id, v.vehicle_type
    ");
    $demandStmt->execute();
    $demandData = $demandStmt->fetchAll(PDO::FETCH_ASSOC);

    // Tính số đơn đang chờ trong 24h tới (nhu cầu sắp tới)
    $upcomingDemandStmt = $conn->prepare("
        SELECT 
            o.station_id,
            v.vehicle_type,
            COUNT(*) as upcoming_orders
        FROM orders o
        JOIN vehicles v ON o.vehicle_id = v.vehicle_id
        WHERE o.start_date BETWEEN NOW() AND DATE_ADD(NOW(), INTERVAL 24 HOUR)
          AND o.status IN ('NEW', 'RENTING')
        GROUP BY o.station_id, v.vehicle_type
    ");
    $upcomingDemandStmt->execute();
    $upcomingDemand = $upcomingDemandStmt->fetchAll(PDO::FETCH_ASSOC);

    // ============================================
    // BƯỚC 3: XÂY DỰNG DỮ LIỆU TRẠM VỚI LOAD FACTOR
    // ============================================
    $stationData = [];
    
    foreach ($stations as $station) {
        $id = $station['station_id'];
        
        // Đếm xe hiện có
        $carCount = 0;
        $bikeCount = 0;
        foreach ($vehicleCounts as $vc) {
            if ($vc['station_id'] == $id) {
                if ($vc['vehicle_type'] == 'Oto') $carCount = $vc['count'];
                if ($vc['vehicle_type'] == 'Xemay') $bikeCount = $vc['count'];
            }
        }
        
        // Tính nhu cầu dự đoán (trung bình lịch sử / ngày)
        $predictedCarDemand = 2; // Default minimum
        $predictedBikeDemand = 3;
        
        foreach ($demandData as $demand) {
            if ($demand['station_id'] == $id) {
                if ($demand['vehicle_type'] == 'Oto') {
                    $predictedCarDemand = max(2, ceil($demand['historical_rentals'] / 7 * 1.2)); // +20% buffer
                }
                if ($demand['vehicle_type'] == 'Xemay') {
                    $predictedBikeDemand = max(3, ceil($demand['historical_rentals'] / 7 * 1.2));
                }
            }
        }
        
        // Cộng thêm nhu cầu sắp tới trong 24h
        foreach ($upcomingDemand as $upcoming) {
            if ($upcoming['station_id'] == $id) {
                if ($upcoming['vehicle_type'] == 'Oto') {
                    $predictedCarDemand += $upcoming['upcoming_orders'];
                }
                if ($upcoming['vehicle_type'] == 'Xemay') {
                    $predictedBikeDemand += $upcoming['upcoming_orders'];
                }
            }
        }
        
        // TÍNH LOAD FACTOR
        // LF = Số xe hiện có / Nhu cầu dự đoán
        // LF > 1.5: Dư xe (OVER)
        // LF < 0.6: Thiếu xe (LOW)
        // 0.6 <= LF <= 1.5: Cân bằng (BALANCED)
        
        $carLoadFactor = $predictedCarDemand > 0 ? round($carCount / $predictedCarDemand, 2) : 0;
        $bikeLoadFactor = $predictedBikeDemand > 0 ? round($bikeCount / $predictedBikeDemand, 2) : 0;
        $avgLoadFactor = round(($carLoadFactor + $bikeLoadFactor) / 2, 2);
        
        // Xác định trạng thái
        $status = 'BALANCED';
        if ($avgLoadFactor < 0.6) {
            $status = 'LOW';
        } elseif ($avgLoadFactor > 1.5) {
            $status = 'OVER';
        }
        
        $stationData[] = [
            'station_id' => $id,
            'station_name' => $station['station_name'],
            'location' => $station['district'] . ', ' . $station['city'],
            'latitude' => $station['latitude'] ?? 0,
            'longitude' => $station['longitude'] ?? 0,
            'car_count' => $carCount,
            'bike_count' => $bikeCount,
            'total_vehicles' => $carCount + $bikeCount,
            'predicted_car_demand' => $predictedCarDemand,
            'predicted_bike_demand' => $predictedBikeDemand,
            'car_load_factor' => $carLoadFactor,
            'bike_load_factor' => $bikeLoadFactor,
            'avg_load_factor' => $avgLoadFactor,
            'status' => $status
        ];
    }
    
    // ============================================
    // BƯỚC 4: THUẬT TOÁN GỢI Ý ĐIỀU CHUYỂN THÔNG MINH
    // ============================================
    $suggestions = [];
    
    // Tìm trạm LOW và OVER
    $lowStations = array_filter($stationData, fn($s) => $s['status'] === 'LOW');
    $overStations = array_filter($stationData, fn($s) => $s['status'] === 'OVER');
    
    // Hàm tính khoảng cách Haversine (km)
    function calculateDistance($lat1, $lon1, $lat2, $lon2) {
        if ($lat1 == 0 || $lon1 == 0 || $lat2 == 0 || $lon2 == 0) {
            return 999; // Không có tọa độ
        }
        $earthRadius = 6371; // km
        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);
        $a = sin($dLat/2) * sin($dLat/2) +
             cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
             sin($dLon/2) * sin($dLon/2);
        $c = 2 * atan2(sqrt($a), sqrt(1-$a));
        return round($earthRadius * $c, 1);
    }
    
    // Tạo gợi ý cho từng trạm LOW
    foreach ($lowStations as $lowStation) {
        $bestMatch = null;
        $shortestDistance = PHP_INT_MAX;
        
        // Tìm trạm OVER gần nhất
        foreach ($overStations as $overStation) {
            $distance = calculateDistance(
                $lowStation['latitude'], $lowStation['longitude'],
                $overStation['latitude'], $overStation['longitude']
            );
            
            if ($distance < $shortestDistance) {
                $shortestDistance = $distance;
                $bestMatch = $overStation;
            }
        }
        
        if ($bestMatch) {
            // Tính số xe cần chuyển
            $carNeeded = max(0, $lowStation['predicted_car_demand'] - $lowStation['car_count']);
            $bikeNeeded = max(0, $lowStation['predicted_bike_demand'] - $lowStation['bike_count']);
            
            $carAvailable = max(0, $bestMatch['car_count'] - $bestMatch['predicted_car_demand']);
            $bikeAvailable = max(0, $bestMatch['bike_count'] - $bestMatch['predicted_bike_demand']);
            
            $carToMove = min($carNeeded, $carAvailable);
            $bikeToMove = min($bikeNeeded, $bikeAvailable);
            
            if ($carToMove > 0 || $bikeToMove > 0) {
                $suggestions[] = [
                    'priority' => $lowStation['avg_load_factor'] < 0.3 ? 'HIGH' : 'MEDIUM',
                    'from_station_id' => $bestMatch['station_id'],
                    'from_station_name' => $bestMatch['station_name'],
                    'to_station_id' => $lowStation['station_id'],
                    'to_station_name' => $lowStation['station_name'],
                    'car_quantity' => $carToMove,
                    'bike_quantity' => $bikeToMove,
                    'distance' => $shortestDistance,
                    'estimated_cost' => round($shortestDistance * 15000, 0), // 15k/km
                    'reason' => "LF đích: {$lowStation['avg_load_factor']} (Thiếu) ← LF nguồn: {$bestMatch['avg_load_factor']} (Dư)"
                ];
            }
        }
    }
    
    // Sắp xếp theo priority và distance
    usort($suggestions, function($a, $b) {
        if ($a['priority'] === 'HIGH' && $b['priority'] !== 'HIGH') return -1;
        if ($a['priority'] !== 'HIGH' && $b['priority'] === 'HIGH') return 1;
        return $a['distance'] - $b['distance'];
    });
    
    // ============================================
    // BƯỚC 5: THỐNG KÊ
    // ============================================
    $stats = [
        'total_stations' => count($stationData),
        'low_stations' => count($lowStations),
        'over_stations' => count($overStations),
        'balanced_stations' => count($stationData) - count($lowStations) - count($overStations),
        'avg_load_factor' => round(array_sum(array_column($stationData, 'avg_load_factor')) / count($stationData), 2),
        'total_suggestions' => count($suggestions)
    ];
    
    echo json_encode([
        'success' => true,
        'stats' => $stats,
        'stations' => $stationData,
        'suggestions' => $suggestions,
        'algorithm' => 'Load Balancing + Demand Prediction',
        'timestamp' => date('Y-m-d H:i:s')
    ]);

} catch (Exception $e) {
    echo json_encode([
        'success' => false, 
        'message' => 'Error: ' . $e->getMessage()
    ]);
}
