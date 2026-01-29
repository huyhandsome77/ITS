<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/ITS/config/Connect_DB.php';

// Kiểm tra đăng nhập
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'Vui lòng đăng nhập']);
    exit;
}

$userId = $_SESSION['user_id'];

/* ================== FILTER & SEARCH ================== */

$search = $_GET['search'] ?? '';
$status = $_GET['status'] ?? '';
$sortBy = $_GET['sort'] ?? 'newest';

$where = ["o.user_id = :user_id"];
$params = [':user_id' => $userId];

// Tìm kiếm theo mã đơn hoặc tên xe
if ($search !== '') {
    $where[] = "(o.order_code LIKE :search OR v.vehicle_name LIKE :search)";
    $params[':search'] = "%$search%";
}

// Lọc theo trạng thái
if ($status !== '') {
    switch ($status) {
        case 'pending':
            $where[] = "o.status = 'NEW'";
            break;
        case 'confirmed':
            $where[] = "o.status IN ('RENTING', 'WAITING_RETURN')";
            break;
        case 'completed':
            $where[] = "o.status = 'COMPLETED'";
            break;
        case 'cancelled':
            $where[] = "o.status = 'CANCELLED'";
            break;
    }
}

$whereSQL = 'WHERE ' . implode(' AND ', $where);

/* ================== THỐNG KÊ ĐƠN HÀNG ================== */

$statsSql = "
    SELECT 
        COUNT(*) AS total_orders,
        SUM(o.status = 'NEW') AS total_pending,
        SUM(o.status IN ('RENTING', 'WAITING_RETURN')) AS total_confirmed,
        SUM(o.status = 'COMPLETED') AS total_completed,
        SUM(o.status = 'CANCELLED') AS total_cancelled
    FROM orders o
    WHERE o.user_id = :user_id
";

$statsStmt = $conn->prepare($statsSql);
$statsStmt->execute([':user_id' => $userId]);
$stats = $statsStmt->fetch();

/* ================== PHÂN TRANG ================== */

$limit = 10; // số đơn / trang
$page = isset($_GET['page']) && $_GET['page'] > 0 ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

/* ================== ĐẾM TỔNG ĐƠN ================== */

$countSql = "
    SELECT COUNT(*)
    FROM orders o
    JOIN vehicles v ON o.vehicle_id = v.vehicle_id
    $whereSQL
";

$countStmt = $conn->prepare($countSql);
$countStmt->execute($params);
$totalOrders = $countStmt->fetchColumn();
$totalPages = ceil($totalOrders / $limit);

/* ================== SẮP XẾP ================== */

$orderBySQL = "o.created_at DESC"; // Mặc định

switch ($sortBy) {
    case 'newest':
        $orderBySQL = "o.created_at DESC";
        break;
    case 'oldest':
        $orderBySQL = "o.created_at ASC";
        break;
    case 'price_high':
        $orderBySQL = "o.total_amount DESC";
        break;
    case 'price_low':
        $orderBySQL = "o.total_amount ASC";
        break;
}

/* ================== LẤY DANH SÁCH ĐƠN ================== */

$sql = "
    SELECT 
        o.order_id,
        o.order_code,
        o.start_date,
        o.end_date,
        o.total_amount,
        o.status,
        o.created_at,
        s.station_name,
        s.address as station_address,
        v.vehicle_name,
        v.vehicle_id,
        v.brand,
        v.model,
        v.license_plate,
        DATEDIFF(o.end_date, o.start_date) + 1 as rental_days,
        (SELECT COUNT(*) FROM reviews r WHERE r.order_id = o.order_id) > 0 as is_reviewed
    FROM orders o
    JOIN stations s ON o.station_id = s.station_id
    JOIN vehicles v ON o.vehicle_id = v.vehicle_id
    $whereSQL
    ORDER BY $orderBySQL
    LIMIT :limit OFFSET :offset
";

$stmt = $conn->prepare($sql);

// Bind filter parameters
foreach ($params as $key => $value) {
    $stmt->bindValue($key, $value);
}

// Bind pagination
$stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);

$stmt->execute();
$orders = $stmt->fetchAll();

// Map trạng thái sang tiếng Việt và frontend status
foreach ($orders as &$order) {
    switch ($order['status']) {
        case 'NEW':
            $order['status_text'] = 'Đang xử lý';
            $order['status_class'] = 'pending';
            $order['can_cancel'] = true;
            break;
        case 'RENTING':
            $order['status_text'] = 'Đã xác nhận';
            $order['status_class'] = 'confirmed';
            $order['can_cancel'] = false;
            break;
        case 'WAITING_RETURN':
            $order['status_text'] = 'Đã xác nhận';
            $order['status_class'] = 'confirmed';
            $order['can_cancel'] = false;
            break;
        case 'COMPLETED':
            $order['status_text'] = 'Hoàn thành';
            $order['status_class'] = 'completed';
            $order['can_cancel'] = false;
            break;
        case 'CANCELLED':
            $order['status_text'] = 'Đã hủy';
            $order['status_class'] = 'cancelled';
            $order['can_cancel'] = false;
            break;
    }
    
    // Format số tiền
    $order['total_amount_formatted'] = number_format($order['total_amount'], 0, ',', '.') . '₫';
    
    // Format ngày
    $order['start_date_formatted'] = date('d/m/Y', strtotime($order['start_date']));
    $order['end_date_formatted'] = date('d/m/Y', strtotime($order['end_date']));
    $order['created_at_formatted'] = date('d/m/Y', strtotime($order['created_at']));
}

/* ================== TRẢ VỀ JSON ================== */

header('Content-Type: application/json');
echo json_encode([
    'success' => true,
    'stats' => [
        'total_orders' => (int)$stats['total_orders'],
        'total_pending' => (int)$stats['total_pending'],
        'total_confirmed' => (int)$stats['total_confirmed'],
        'total_completed' => (int)$stats['total_completed'],
        'total_cancelled' => (int)$stats['total_cancelled']
    ],
    'orders' => $orders,
    'pagination' => [
        'current_page' => $page,
        'total_pages' => $totalPages,
        'total_orders' => $totalOrders,
        'per_page' => $limit
    ]
]);
