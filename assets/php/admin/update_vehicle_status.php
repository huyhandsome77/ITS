<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/ITS/config/Connect_DB.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit;
}

try {
    $data = json_decode(file_get_contents('php://input'), true);
    $vehicle_id = (int)$data['vehicle_id'];
    $status = trim($data['status']);

    // Validate status
    $validStatuses = ['AVAILABLE', 'RENTED', 'MAINTENANCE'];
    if (!in_array($status, $validStatuses)) {
        throw new Exception('Trạng thái không hợp lệ');
    }

    // Kiểm tra nếu chuyển sang AVAILABLE nhưng xe đang có đơn thuê
    if ($status === 'AVAILABLE') {
        $checkSql = "
            SELECT COUNT(*) FROM orders 
            WHERE vehicle_id = :vehicle_id 
            AND status IN ('RENTING', 'WAITING_RETURN')
        ";
        $checkStmt = $conn->prepare($checkSql);
        $checkStmt->execute([':vehicle_id' => $vehicle_id]);
        
        if ($checkStmt->fetchColumn() > 0) {
            throw new Exception('Xe đang có đơn thuê, không thể chuyển sang sẵn sàng');
        }
    }

    $sql = "UPDATE vehicles SET status = :status WHERE vehicle_id = :vehicle_id";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':status' => $status,
        ':vehicle_id' => $vehicle_id
    ]);

    $statusText = match($status) {
        'AVAILABLE' => 'sẵn sàng',
        'RENTED' => 'đang thuê',
        'MAINTENANCE' => 'bảo trì',
        default => ''
    };

    echo json_encode([
        'success' => true,
        'message' => "Đã chuyển xe sang trạng thái {$statusText}"
    ]);

} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
