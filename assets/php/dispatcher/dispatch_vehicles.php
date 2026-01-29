<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/ITS/config/Connect_DB.php';
header('Content-Type: application/json');

// Check authentication
// if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'DISPATCHER') {
//     echo json_encode(['success' => false, 'message' => 'Unauthorized']);
//     exit;
// }

// Receive JSON data
$data = json_decode(file_get_contents('php://input'), true);

if (!$data) {
    echo json_encode(['success' => false, 'message' => 'Invalid data']);
    exit;
}

$fromStationId = $data['from_station_id'] ?? null;
$toStationId = $data['to_station_id'] ?? null;
$vehicleType = $data['vehicle_type'] ?? null; // 'Ô tô' or 'Xe máy'
$quantity = (int)($data['quantity'] ?? 0);

// Map frontend type to DB type
$typeMap = [
    'Ô tô' => 'Oto',
    'Xe máy' => 'Xemay'
];
$dbVehicleType = $typeMap[$vehicleType] ?? null;

if (!$fromStationId || !$toStationId || !$dbVehicleType || $quantity <= 0) {
    echo json_encode(['success' => false, 'message' => 'Missing required fields or invalid quantity/type']);
    exit;
}

if ($fromStationId == $toStationId) {
    echo json_encode(['success' => false, 'message' => 'Trạm nguồn và trạm đích không được trùng nhau']);
    exit;
}

try {
    $conn->beginTransaction();

    // 1. Get IDs of vehicles to move
    // Priority: Available vehicles
    $sqlGet = "
        SELECT vehicle_id 
        FROM vehicles 
        WHERE station_id = :from_id 
          AND vehicle_type = :type 
          AND status = 'AVAILABLE' 
        LIMIT :qty
    ";
    
    // PDO doesn't like LIMIT binding with strings directly in some versions, so we cast to int
    // Usually bindParam with PDO::PARAM_INT is safest
    $stmtGet = $conn->prepare($sqlGet);
    $stmtGet->bindParam(':from_id', $fromStationId, PDO::PARAM_INT);
    $stmtGet->bindParam(':type', $dbVehicleType, PDO::PARAM_STR);
    $stmtGet->bindParam(':qty', $quantity, PDO::PARAM_INT);
    $stmtGet->execute();
    
    $vehiclesToMove = $stmtGet->fetchAll(PDO::FETCH_COLUMN);

    if (count($vehiclesToMove) < $quantity) {
        $conn->rollBack();
        echo json_encode([
            'success' => false, 
            'message' => 'Không đủ số lượng xe khả dụng (Hiện có: ' . count($vehiclesToMove) . ' xe)'
        ]);
        exit;
    }

    // 2. Update their station
    $placeholders = implode(',', array_fill(0, count($vehiclesToMove), '?'));
    $sqlUpdate = "
        UPDATE vehicles 
        SET station_id = ? 
        WHERE vehicle_id IN ($placeholders)
    ";
    
    $values = array_merge([$toStationId], $vehiclesToMove);
    $stmtUpdate = $conn->prepare($sqlUpdate);
    $stmtUpdate->execute($values);

    $conn->commit();

    echo json_encode([
        'success' => true, 
        'message' => "Đã điều chuyển $quantity $vehicleType thành công"
    ]);

} catch (Exception $e) {
    if ($conn->inTransaction()) {
        $conn->rollBack();
    }
    echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
}
