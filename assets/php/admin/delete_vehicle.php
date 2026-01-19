<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/ITS/config/Connect_DB.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit;
}

try {
    $data = json_decode(file_get_contents('php://input'), true);
    $vehicle_id = (int)$data['vehicle_id'];

    // Kiểm tra xe có đơn đang thuê không
    $checkSql = "
        SELECT COUNT(*) FROM orders 
        WHERE vehicle_id = :vehicle_id 
        AND status IN ('NEW', 'RENTING', 'WAITING_RETURN')
    ";
    $checkStmt = $conn->prepare($checkSql);
    $checkStmt->execute([':vehicle_id' => $vehicle_id]);
    
    if ($checkStmt->fetchColumn() > 0) {
        throw new Exception('Không thể xóa xe đang có đơn thuê');
    }

    // Lấy thông tin ảnh để xóa
    $imageSql = "SELECT image FROM vehicles WHERE vehicle_id = :id";
    $imageStmt = $conn->prepare($imageSql);
    $imageStmt->execute([':id' => $vehicle_id]);
    $image = $imageStmt->fetchColumn();

    // Xóa xe
    $sql = "DELETE FROM vehicles WHERE vehicle_id = :vehicle_id";
    $stmt = $conn->prepare($sql);
    $stmt->execute([':vehicle_id' => $vehicle_id]);

    // Xóa ảnh
    if ($image) {
        $imagePath = $_SERVER['DOCUMENT_ROOT'] . '/ITS/assets/img/vehicles/' . $image;
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }
    }

    echo json_encode([
        'success' => true,
        'message' => 'Xóa phương tiện thành công'
    ]);

} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
