<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/ITS/config/Connect_DB.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/ITS/helpers/flash.php';

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

// Xử lý POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $vehicleId = $_POST['vehicle_id'] ?? null;
    $newStatus = $_POST['status'] ?? null;

    // Validate input
    if (!$vehicleId || !$newStatus) {
        echo json_encode(['success' => false, 'message' => 'Thiếu thông tin xe hoặc trạng thái']);
        exit;
    }

    // Validate status
    $validStatuses = ['AVAILABLE', 'RENTED', 'MAINTENANCE'];
    if (!in_array($newStatus, $validStatuses)) {
        echo json_encode(['success' => false, 'message' => 'Trạng thái không hợp lệ']);
        exit;
    }

    try {
        // Kiểm tra xe có thuộc trạm này không
        $checkQuery = "SELECT vehicle_id, status FROM vehicles WHERE vehicle_id = :vehicle_id AND station_id = :station_id";
        $checkStmt = $conn->prepare($checkQuery);
        $checkStmt->execute([
            ':vehicle_id' => $vehicleId,
            ':station_id' => $stationId
        ]);
        $vehicle = $checkStmt->fetch();

        if (!$vehicle) {
            echo json_encode(['success' => false, 'message' => 'Không tìm thấy xe hoặc xe không thuộc trạm này']);
            exit;
        }

        // Không cho phép thay đổi trạng thái nếu xe đang được thuê
        if ($vehicle['status'] === 'RENTED' && $newStatus !== 'RENTED') {
            echo json_encode(['success' => false, 'message' => 'Không thể thay đổi trạng thái xe đang được thuê']);
            exit;
        }

        // Cập nhật trạng thái
        $updateQuery = "UPDATE vehicles SET status = :status WHERE vehicle_id = :vehicle_id";
        $updateStmt = $conn->prepare($updateQuery);
        $updateStmt->execute([
            ':status' => $newStatus,
            ':vehicle_id' => $vehicleId
        ]);

        $message = match($newStatus) {
            'MAINTENANCE' => 'Đã chuyển xe sang trạng thái bảo trì',
            'AVAILABLE' => 'Đã chuyển xe sang trạng thái sẵn sàng',
            default => 'Đã cập nhật trạng thái xe'
        };

        echo json_encode(['success' => true, 'message' => $message]);

    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Lỗi database: ' . $e->getMessage()]);
    }

} else {
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
}
