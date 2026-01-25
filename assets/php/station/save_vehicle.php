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

$stationIdQuery = "SELECT station_id FROM users WHERE user_id = :user_id AND role = 'STATION'";
$stmtStation = $conn->prepare($stationIdQuery);
$stmtStation->execute([':user_id' => $userId]);
$stationData = $stmtStation->fetch();

if (!$stationData || !$stationData['station_id']) {
    echo json_encode(['success' => false, 'message' => 'Không tìm thấy trạm được phân quyền']);
    exit;
}

$stationId = $stationData['station_id'];

// Xử lý POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $vehicleId = $_POST['vehicle_id'] ?? null;
    $licensePlate = trim($_POST['license_plate'] ?? '');
    $vehicleName = trim($_POST['vehicle_name'] ?? '');
    $vehicleType = $_POST['vehicle_type'] ?? '';
    $brand = trim($_POST['brand'] ?? '');
    $model = trim($_POST['model'] ?? '');
    $year = $_POST['year'] ?? null;
    $seats = $_POST['seats'] ?? null;
    $pricePerDay = $_POST['price_per_day'] ?? 0;
    $pricePerHour = $_POST['price_per_hour'] ?? 0;
    $description = trim($_POST['description'] ?? '');
    $status = $_POST['status'] ?? 'AVAILABLE';

    // Validate input
    if (empty($licensePlate) || empty($vehicleName) || empty($vehicleType) || empty($brand) || empty($model)) {
        echo json_encode(['success' => false, 'message' => 'Vui lòng điền đầy đủ thông tin bắt buộc']);
        exit;
    }

    // Validate vehicle type
    if (!in_array($vehicleType, ['Oto', 'Xemay'])) {
        echo json_encode(['success' => false, 'message' => 'Loại xe không hợp lệ']);
        exit;
    }

    // Validate status
    if (!in_array($status, ['AVAILABLE', 'RENTED', 'MAINTENANCE'])) {
        echo json_encode(['success' => false, 'message' => 'Trạng thái không hợp lệ']);
        exit;
    }

    // Validate prices
    if ($pricePerDay <= 0 || $pricePerHour <= 0) {
        echo json_encode(['success' => false, 'message' => 'Giá thuê phải lớn hơn 0']);
        exit;
    }

    // Validate year and seats
    if (!$year || $year < 2000 || $year > 2030) {
        echo json_encode(['success' => false, 'message' => 'Năm sản xuất không hợp lệ']);
        exit;
    }

    if (!$seats || $seats < 2 || $seats > 16) {
        echo json_encode(['success' => false, 'message' => 'Số chỗ ngồi không hợp lệ']);
        exit;
    }

    try {
        if ($vehicleId) {
            // UPDATE - Chỉnh sửa xe
            // Kiểm tra xe có thuộc trạm này không
            $checkQuery = "SELECT vehicle_id FROM vehicles WHERE vehicle_id = :vehicle_id AND station_id = :station_id";
            $checkStmt = $conn->prepare($checkQuery);
            $checkStmt->execute([
                ':vehicle_id' => $vehicleId,
                ':station_id' => $stationId
            ]);
            
            if (!$checkStmt->fetch()) {
                echo json_encode(['success' => false, 'message' => 'Không tìm thấy xe hoặc xe không thuộc trạm này']);
                exit;
            }

            // Kiểm tra biển số trùng (ngoại trừ xe hiện tại)
            $duplicateQuery = "SELECT vehicle_id FROM vehicles WHERE license_plate = :license_plate AND vehicle_id != :vehicle_id";
            $duplicateStmt = $conn->prepare($duplicateQuery);
            $duplicateStmt->execute([
                ':license_plate' => $licensePlate,
                ':vehicle_id' => $vehicleId
            ]);
            
            if ($duplicateStmt->fetch()) {
                echo json_encode(['success' => false, 'message' => 'Biển số xe đã tồn tại']);
                exit;
            }

            $updateQuery = "
                UPDATE vehicles 
                SET license_plate = :license_plate,
                    vehicle_name = :vehicle_name,
                    vehicle_type = :vehicle_type,
                    brand = :brand,
                    model = :model,
                    year = :year,
                    seats = :seats,
                    price_per_day = :price_per_day,
                    price_per_hour = :price_per_hour,
                    description = :description,
                    status = :status
                WHERE vehicle_id = :vehicle_id
            ";
            
            $updateStmt = $conn->prepare($updateQuery);
            $updateStmt->execute([
                ':license_plate' => $licensePlate,
                ':vehicle_name' => $vehicleName,
                ':vehicle_type' => $vehicleType,
                ':brand' => $brand,
                ':model' => $model,
                ':year' => $year,
                ':seats' => $seats,
                ':price_per_day' => $pricePerDay,
                ':price_per_hour' => $pricePerHour,
                ':description' => $description,
                ':status' => $status,
                ':vehicle_id' => $vehicleId
            ]);

            echo json_encode(['success' => true, 'message' => 'Cập nhật thông tin xe thành công']);

        } else {
            // INSERT - Thêm xe mới
            // Kiểm tra biển số trùng
            $duplicateQuery = "SELECT vehicle_id FROM vehicles WHERE license_plate = :license_plate";
            $duplicateStmt = $conn->prepare($duplicateQuery);
            $duplicateStmt->execute([':license_plate' => $licensePlate]);
            
            if ($duplicateStmt->fetch()) {
                echo json_encode(['success' => false, 'message' => 'Biển số xe đã tồn tại']);
                exit;
            }

            $insertQuery = "
                INSERT INTO vehicles (license_plate, vehicle_name, vehicle_type, brand, model, year, seats, price_per_day, price_per_hour, description, status, station_id)
                VALUES (:license_plate, :vehicle_name, :vehicle_type, :brand, :model, :year, :seats, :price_per_day, :price_per_hour, :description, :status, :station_id)
            ";
            
            $insertStmt = $conn->prepare($insertQuery);
            $insertStmt->execute([
                ':license_plate' => $licensePlate,
                ':vehicle_name' => $vehicleName,
                ':vehicle_type' => $vehicleType,
                ':brand' => $brand,
                ':model' => $model,
                ':year' => $year,
                ':seats' => $seats,
                ':price_per_day' => $pricePerDay,
                ':price_per_hour' => $pricePerHour,
                ':description' => $description,
                ':status' => $status,
                ':station_id' => $stationId
            ]);

            echo json_encode(['success' => true, 'message' => 'Thêm xe mới thành công']);
        }

    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Lỗi database: ' . $e->getMessage()]);
    }

} else {
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
}
