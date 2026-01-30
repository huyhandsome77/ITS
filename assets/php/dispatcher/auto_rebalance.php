<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/ITS/config/Connect_DB.php';
header('Content-Type: application/json');

// Nhận dữ liệu từ request
$data = json_decode(file_get_contents('php://input'), true);

if (!$data || !isset($data['suggestions'])) {
    echo json_encode(['success' => false, 'message' => 'Dữ liệu không hợp lệ']);
    exit;
}

$suggestions = $data['suggestions'];
$results = [];
$successCount = 0;
$failCount = 0;

try {
    // Xử lý từng gợi ý
    foreach ($suggestions as $suggestion) {
        $fromStationId = $suggestion['from_station_id'];
        $toStationId = $suggestion['to_station_id'];
        $carQty = (int)$suggestion['car_quantity'];
        $bikeQty = (int)$suggestion['bike_quantity'];
        
        $conn->beginTransaction();
        
        // Chuyển ô tô
        if ($carQty > 0) {
            $stmtGetCars = $conn->prepare("
                SELECT vehicle_id 
                FROM vehicles 
                WHERE station_id = :from_id 
                  AND vehicle_type = 'Oto' 
                  AND status = 'AVAILABLE' 
                LIMIT :qty
            ");
            $stmtGetCars->bindParam(':from_id', $fromStationId, PDO::PARAM_INT);
            $stmtGetCars->bindParam(':qty', $carQty, PDO::PARAM_INT);
            $stmtGetCars->execute();
            $carIds = $stmtGetCars->fetchAll(PDO::FETCH_COLUMN);
            
            if (count($carIds) >= $carQty) {
                $placeholders = implode(',', array_fill(0, count($carIds), '?'));
                $stmtUpdateCars = $conn->prepare("
                    UPDATE vehicles 
                    SET station_id = ? 
                    WHERE vehicle_id IN ($placeholders)
                ");
                $values = array_merge([$toStationId], $carIds);
                $stmtUpdateCars->execute($values);
            }
        }
        
        // Chuyển xe máy
        if ($bikeQty > 0) {
            $stmtGetBikes = $conn->prepare("
                SELECT vehicle_id 
                FROM vehicles 
                WHERE station_id = :from_id 
                  AND vehicle_type = 'Xemay' 
                  AND status = 'AVAILABLE' 
                LIMIT :qty
            ");
            $stmtGetBikes->bindParam(':from_id', $fromStationId, PDO::PARAM_INT);
            $stmtGetBikes->bindParam(':qty', $bikeQty, PDO::PARAM_INT);
            $stmtGetBikes->execute();
            $bikeIds = $stmtGetBikes->fetchAll(PDO::FETCH_COLUMN);
            
            if (count($bikeIds) >= $bikeQty) {
                $placeholders = implode(',', array_fill(0, count($bikeIds), '?'));
                $stmtUpdateBikes = $conn->prepare("
                    UPDATE vehicles 
                    SET station_id = ? 
                    WHERE vehicle_id IN ($placeholders)
                ");
                $values = array_merge([$toStationId], $bikeIds);
                $stmtUpdateBikes->execute($values);
            }
        }
        
        $conn->commit();
        
        $results[] = [
            'from' => $suggestion['from_station_name'],
            'to' => $suggestion['to_station_name'],
            'cars' => $carQty,
            'bikes' => $bikeQty,
            'status' => 'success'
        ];
        $successCount++;
        
    } // end foreach
    
    echo json_encode([
        'success' => true,
        'message' => "Đã điều chuyển thành công $successCount gợi ý",
        'results' => $results,
        'success_count' => $successCount,
        'fail_count' => $failCount
    ]);

} catch (Exception $e) {
    if ($conn->inTransaction()) {
        $conn->rollBack();
    }
    echo json_encode([
        'success' => false,
        'message' => 'Lỗi: ' . $e->getMessage()
    ]);
}
