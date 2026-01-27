<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/ITS/config/Connect_DB.php';

// Kiểm tra session và role
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

header('Content-Type: application/json');

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'STATION') {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

// Lấy station_id của quản lý trạm
$userId = $_SESSION['user_id'];

$stationIdQuery = "SELECT managed_station_id FROM users WHERE user_id = :user_id AND role = 'STATION'";
$stmtStation = $conn->prepare($stationIdQuery);
$stmtStation->execute([':user_id' => $userId]);
$stationData = $stmtStation->fetch();

if (!$stationData || !$stationData['managed_station_id']) {
    echo json_encode(['success' => false, 'message' => 'Không tìm thấy trạm được phân quyền']);
    exit;
}

$stationId = $stationData['managed_station_id'];

// Xử lý GET request
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $vehicleId = $_GET['vehicle_id'] ?? null;

    if (!$vehicleId) {
        echo json_encode(['success' => false, 'message' => 'Thiếu thông tin xe']);
        exit;
    }

    try {
        // Lấy thông tin xe
        $query = "
            SELECT vehicle_id, license_plate, vehicle_name, vehicle_type, brand, model, year, seats, 
                   price_per_day, price_per_hour, description, status
            FROM vehicles 
            WHERE vehicle_id = :vehicle_id AND station_id = :station_id
        ";
        
        $stmt = $conn->prepare($query);
        $stmt->execute([
            ':vehicle_id' => $vehicleId,
            ':station_id' => $stationId
        ]);
        
        $vehicle = $stmt->fetch();

        if ($vehicle) {
            echo json_encode(['success' => true, 'data' => $vehicle]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Không tìm thấy xe hoặc xe không thuộc trạm này']);
        }

    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Lỗi database: ' . $e->getMessage()]);
    }

} else {
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
}
