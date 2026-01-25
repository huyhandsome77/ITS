<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/ITS/config/Connect_DB.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/ITS/helpers/flash.php';

// Kiểm tra session và role
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'STATION') {
    header('Location: /ITS/assets/html/auth/login.php');
    exit;
}

// Lấy station_id của quản lý trạm từ session hoặc database
$userId = $_SESSION['user_id'];

// Lấy station_id từ bảng users (giả sử có cột station_id cho STATION role)
// Hoặc từ bảng mapping riêng nếu có
// Tạm thời lấy từ GET nếu chưa có structure rõ ràng
$stationIdQuery = "SELECT station_id FROM users WHERE user_id = :user_id AND role = 'STATION'";
$stmtStation = $conn->prepare($stationIdQuery);
$stmtStation->execute([':user_id' => $userId]);
$stationData = $stmtStation->fetch();

if (!$stationData || !$stationData['station_id']) {
    die("Không tìm thấy trạm được phân quyền cho tài khoản này.");
}

$stationId = $stationData['station_id'];

// Lấy thông tin trạm
$stationInfoQuery = "SELECT station_name FROM stations WHERE station_id = :station_id";
$stmtStationInfo = $conn->prepare($stationInfoQuery);
$stmtStationInfo->execute([':station_id' => $stationId]);
$stationInfo = $stmtStationInfo->fetch();
$stationName = $stationInfo['station_name'] ?? 'Trạm không xác định';

/* ================== THỐNG KÊ ĐƠN HÀNG CỦA TRẠM ================== */

$statsQuery = "
    SELECT 
        COUNT(*) AS total_orders,
        SUM(CASE WHEN o.status = 'NEW' THEN 1 ELSE 0 END) AS new_orders,
        SUM(CASE WHEN o.status = 'RENTING' THEN 1 ELSE 0 END) AS renting_orders,
        SUM(CASE WHEN o.status = 'WAITING_RETURN' THEN 1 ELSE 0 END) AS waiting_return,
        SUM(CASE WHEN o.status = 'COMPLETED' THEN 1 ELSE 0 END) AS completed_orders,
        SUM(CASE WHEN o.status = 'CANCELLED' THEN 1 ELSE 0 END) AS cancelled_orders
    FROM orders o
    WHERE o.station_id = :station_id
";

$statsStmt = $conn->prepare($statsQuery);
$statsStmt->execute([':station_id' => $stationId]);
$stats = $statsStmt->fetch();

$totalOrders = $stats['total_orders'] ?? 0;
$newOrders = $stats['new_orders'] ?? 0;
$rentingOrders = $stats['renting_orders'] ?? 0;
$waitingReturn = $stats['waiting_return'] ?? 0;
$completedOrders = $stats['completed_orders'] ?? 0;
$cancelledOrders = $stats['cancelled_orders'] ?? 0;

/* ================== FILTER ================== */

$status = $_GET['status'] ?? '';
$filterDate = $_GET['filter_date'] ?? '';

$where = ["o.station_id = :station_id"];
$params = [':station_id' => $stationId];

if ($status !== '') {
    $where[] = "o.status = :status";
    $params[':status'] = $status;
}

if ($filterDate !== '') {
    $where[] = "(DATE(o.start_date) = :filter_date OR DATE(o.end_date) = :filter_date)";
    $params[':filter_date'] = $filterDate;
}

$whereSQL = 'WHERE ' . implode(' AND ', $where);

/* ================== PHÂN TRANG ================== */

$limit = 10;
$page = isset($_GET['page']) && $_GET['page'] > 0 ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

/* ================== ĐẾM TỔNG ĐƠN ================== */

$countSql = "SELECT COUNT(*) FROM orders o $whereSQL";
$countStmt = $conn->prepare($countSql);
$countStmt->execute($params);
$filteredTotal = $countStmt->fetchColumn();
$totalPages = ceil($filteredTotal / $limit);

/* ================== LẤY DANH SÁCH ĐƠN HÀNG ================== */

$sql = "
    SELECT 
        o.order_id,
        o.order_code,
        u.full_name AS customer_name,
        u.phone AS customer_phone,
        v.vehicle_name,
        v.license_plate,
        o.start_date,
        o.end_date,
        DATEDIFF(o.end_date, o.start_date) AS rental_days,
        s.station_name,
        o.total_amount,
        o.status,
        o.created_at
    FROM orders o
    JOIN users u ON o.user_id = u.user_id
    JOIN vehicles v ON o.vehicle_id = v.vehicle_id
    LEFT JOIN stations s ON o.station_id = s.station_id
    $whereSQL
    ORDER BY o.created_at DESC
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

/* ================== HÀM HỖ TRỢ ================== */

function getStatusBadge($status) {
    return match ($status) {
        'NEW' => ['label' => 'Đơn mới', 'class' => 'bg-blue-100 text-blue-700'],
        'RENTING' => ['label' => 'Đang thuê', 'class' => 'bg-green-100 text-green-700'],
        'WAITING_RETURN' => ['label' => 'Chờ trả xe', 'class' => 'bg-yellow-100 text-yellow-700'],
        'COMPLETED' => ['label' => 'Hoàn thành', 'class' => 'bg-purple-100 text-purple-700'],
        'CANCELLED' => ['label' => 'Đã hủy', 'class' => 'bg-red-100 text-red-700'],
        default => ['label' => 'Không xác định', 'class' => 'bg-gray-100 text-gray-700'],
    };
}

function formatCurrency($amount) {
    return number_format($amount, 0, ',', '.') . 'đ';
}

function formatDate($date) {
    return date('d/m/Y', strtotime($date));
}
