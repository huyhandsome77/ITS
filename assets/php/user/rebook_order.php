<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/ITS/config/Connect_DB.php';

header('Content-Type: application/json');

// Kiểm tra đăng nhập
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'Vui lòng đăng nhập']);
    exit;
}

$userId = $_SESSION['user_id'];

// Kiểm tra phương thức POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['error' => 'Phương thức không hợp lệ']);
    exit;
}

// Lấy dữ liệu từ POST
$data = json_decode(file_get_contents('php://input'), true);
$orderCode = $data['order_code'] ?? '';
$startDate = $data['start_date'] ?? '';
$endDate = $data['end_date'] ?? '';
$notes = $data['notes'] ?? '';

if ($orderCode === '') {
    echo json_encode(['error' => 'Thiếu mã đơn hàng']);
    exit;
}

if ($startDate === '' || $endDate === '') {
    echo json_encode(['error' => 'Vui lòng chọn ngày bắt đầu và kết thúc']);
    exit;
}

// Validate ngày
$start = new DateTime($startDate);
$end = new DateTime($endDate);
$now = new DateTime();

if ($start < $now) {
    echo json_encode(['error' => 'Ngày bắt đầu phải từ hôm nay trở đi']);
    exit;
}

if ($end < $start) {
    echo json_encode(['error' => 'Ngày kết thúc phải sau ngày bắt đầu']);
    exit;
}

try {
    $conn->beginTransaction();

    // Lấy thông tin đơn hàng cũ
    $oldOrderSql = "
        SELECT 
            o.station_id,
            o.vehicle_id,
            o.user_id,
            v.price_per_day,
            v.status as vehicle_status,
            s.status as station_status
        FROM orders o
        JOIN vehicles v ON o.vehicle_id = v.vehicle_id
        JOIN stations s ON o.station_id = s.station_id
        WHERE o.order_code = :order_code 
        AND o.user_id = :user_id
    ";
    
    $oldOrderStmt = $conn->prepare($oldOrderSql);
    $oldOrderStmt->execute([
        ':order_code' => $orderCode,
        ':user_id' => $userId
    ]);
    
    $oldOrder = $oldOrderStmt->fetch();
    
    if (!$oldOrder) {
        $conn->rollBack();
        echo json_encode(['error' => 'Không tìm thấy đơn hàng']);
        exit;
    }

    // Kiểm tra xe có sẵn không
    if ($oldOrder['vehicle_status'] !== 'AVAILABLE') {
        $conn->rollBack();
        echo json_encode([
            'error' => 'Xe không khả dụng',
            'message' => 'Xe hiện đang được thuê hoặc đang bảo trì. Vui lòng chọn xe khác.'
        ]);
        exit;
    }

    // Kiểm tra trạm có hoạt động không
    if ($oldOrder['station_status'] !== 'ACTIVE') {
        $conn->rollBack();
        echo json_encode([
            'error' => 'Trạm không hoạt động',
            'message' => 'Trạm hiện không hoạt động. Vui lòng chọn trạm khác.'
        ]);
        exit;
    }

    // Kiểm tra xe có bị trùng lịch không
    $checkConflictSql = "
        SELECT COUNT(*) 
        FROM orders 
        WHERE vehicle_id = :vehicle_id
        AND status IN ('NEW', 'RENTING', 'WAITING_RETURN')
        AND (
            (start_date <= :start_date AND end_date >= :start_date)
            OR (start_date <= :end_date AND end_date >= :end_date)
            OR (start_date >= :start_date AND end_date <= :end_date)
        )
    ";
    
    $checkStmt = $conn->prepare($checkConflictSql);
    $checkStmt->execute([
        ':vehicle_id' => $oldOrder['vehicle_id'],
        ':start_date' => $startDate,
        ':end_date' => $endDate
    ]);
    
    $conflictCount = $checkStmt->fetchColumn();
    
    if ($conflictCount > 0) {
        $conn->rollBack();
        echo json_encode([
            'error' => 'Xe đã có lịch',
            'message' => 'Xe đã được đặt trong khoảng thời gian này. Vui lòng chọn thời gian khác.'
        ]);
        exit;
    }

    // Tính tổng tiền
    $days = $start->diff($end)->days + 1;
    $totalAmount = $days * $oldOrder['price_per_day'];

    // Tạo mã đơn hàng mới
    $newOrderCode = 'DH' . str_pad(rand(1, 99999), 5, '0', STR_PAD_LEFT);
    
    // Kiểm tra trùng mã
    while (true) {
        $checkCodeSql = "SELECT COUNT(*) FROM orders WHERE order_code = :code";
        $checkCodeStmt = $conn->prepare($checkCodeSql);
        $checkCodeStmt->execute([':code' => $newOrderCode]);
        
        if ($checkCodeStmt->fetchColumn() == 0) {
            break;
        }
        
        $newOrderCode = 'DH' . str_pad(rand(1, 99999), 5, '0', STR_PAD_LEFT);
    }

    // Tạo đơn hàng mới
    $createOrderSql = "
        INSERT INTO orders (
            order_code,
            station_id,
            user_id,
            vehicle_id,
            start_date,
            end_date,
            total_amount,
            notes,
            status,
            created_at
        ) VALUES (
            :order_code,
            :station_id,
            :user_id,
            :vehicle_id,
            :start_date,
            :end_date,
            :total_amount,
            :notes,
            'NEW',
            NOW()
        )
    ";
    
    $createStmt = $conn->prepare($createOrderSql);
    $createStmt->execute([
        ':order_code' => $newOrderCode,
        ':station_id' => $oldOrder['station_id'],
        ':user_id' => $userId,
        ':vehicle_id' => $oldOrder['vehicle_id'],
        ':start_date' => $startDate,
        ':end_date' => $endDate,
        ':total_amount' => $totalAmount,
        ':notes' => $notes
    ]);

    // Cập nhật trạng thái xe
    $updateVehicleSql = "
        UPDATE vehicles 
        SET status = 'RENTED'
        WHERE vehicle_id = :vehicle_id
    ";
    
    $updateVehicleStmt = $conn->prepare($updateVehicleSql);
    $updateVehicleStmt->execute([':vehicle_id' => $oldOrder['vehicle_id']]);

    $conn->commit();

    echo json_encode([
        'success' => true,
        'message' => 'Đặt xe thành công',
        'order_code' => $newOrderCode,
        'total_amount' => $totalAmount,
        'total_amount_formatted' => number_format($totalAmount, 0, ',', '.') . '₫',
        'rental_days' => $days
    ]);

} catch (Exception $e) {
    if ($conn->inTransaction()) {
        $conn->rollBack();
    }

    echo json_encode([
        'error' => 'Lỗi hệ thống',
        'message' => 'Không thể tạo đơn hàng mới. Vui lòng thử lại sau.',
        'debug' => $e->getMessage()
    ]);
}
