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

// Lấy station_id của quản lý trạm
$userId = $_SESSION['user_id'];

$stationIdQuery = "SELECT managed_station_id FROM users WHERE user_id = :user_id AND role = 'STATION'";
$stmtStation = $conn->prepare($stationIdQuery);
$stmtStation->execute([':user_id' => $userId]);
$stationData = $stmtStation->fetch();

if (!$stationData || !$stationData['managed_station_id']) {
    die("Không tìm thấy trạm được phân quyền cho tài khoản này.");
}

$stationId = $stationData['managed_station_id'];

// Lấy thông tin trạm
$stationInfoQuery = "SELECT station_name FROM stations WHERE station_id = :station_id";
$stmtStationInfo = $conn->prepare($stationInfoQuery);
$stmtStationInfo->execute([':station_id' => $stationId]);
$stationInfo = $stmtStationInfo->fetch();
$stationName = $stationInfo['station_name'] ?? 'Trạm không xác định';

/* ================== HÀM HỖ TRỢ ================== */

function vehicleStatusLabel($status) {
    return match ($status) {
        'AVAILABLE' => ['label' => 'Sẵn sàng', 'class' => 'bg-green-100 text-green-700'],
        'RENTED' => ['label' => 'Đang thuê', 'class' => 'bg-red-100 text-red-700'],
        'MAINTENANCE' => ['label' => 'Bảo trì', 'class' => 'bg-yellow-100 text-yellow-700'],
        default => ['label' => 'Không xác định', 'class' => 'bg-gray-100 text-gray-700'],
    };
}

function formatCurrency($amount) {
    return number_format($amount, 0, ',', '.') . 'đ';
}

/* ================== THỐNG KÊ XE CỦA TRẠM ================== */

$statsQuery = "
    SELECT 
        COUNT(*) AS total_vehicles,
        SUM(CASE WHEN status = 'AVAILABLE' THEN 1 ELSE 0 END) AS available_vehicles,
        SUM(CASE WHEN status = 'RENTED' THEN 1 ELSE 0 END) AS rented_vehicles,
        SUM(CASE WHEN status = 'MAINTENANCE' THEN 1 ELSE 0 END) AS maintenance_vehicles
    FROM vehicles
    WHERE station_id = :station_id
";

$statsStmt = $conn->prepare($statsQuery);
$statsStmt->execute([':station_id' => $stationId]);
$stats = $statsStmt->fetch();

$totalVehicles = $stats['total_vehicles'] ?? 0;
$availableVehicles = $stats['available_vehicles'] ?? 0;
$rentedVehicles = $stats['rented_vehicles'] ?? 0;
$maintenanceVehicles = $stats['maintenance_vehicles'] ?? 0;

/* ================== FILTER ================== */

$vehicleType = $_GET['vehicle_type'] ?? '';
$status = $_GET['status'] ?? '';

$where = ["v.station_id = :station_id"];
$params = [':station_id' => $stationId];

if ($vehicleType !== '') {
    $where[] = "v.vehicle_type = :vehicle_type";
    $params[':vehicle_type'] = $vehicleType;
}

if ($status !== '') {
    $where[] = "v.status = :status";
    $params[':status'] = $status;
}

$whereSQL = 'WHERE ' . implode(' AND ', $where);

/* ================== PHÂN TRANG ================== */

$limit = 10;
$page = isset($_GET['page']) && $_GET['page'] > 0 ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

/* ================== ĐẾM TỔNG XE ================== */

$countSql = "SELECT COUNT(*) FROM vehicles v $whereSQL";
$countStmt = $conn->prepare($countSql);
$countStmt->execute($params);
$filteredTotal = $countStmt->fetchColumn();
$totalPages = ceil($filteredTotal / $limit);

/* ================== LẤY DANH SÁCH XE ================== */

$sql = "
    SELECT 
        v.vehicle_id,
        v.license_plate,
        v.vehicle_type,
        v.vehicle_name,
        v.price_per_day,
        v.price_per_hour,
        v.status,
        COUNT(DISTINCT o.order_id) AS total_rentals,
        COALESCE(AVG(r.rating), 0) AS avg_rating
    FROM vehicles v
    LEFT JOIN orders o ON v.vehicle_id = o.vehicle_id AND o.status = 'COMPLETED'
    LEFT JOIN reviews r ON o.order_id = r.order_id AND r.review_type = 'VEHICLE' AND r.status = 'APPROVED'
    $whereSQL
    GROUP BY v.vehicle_id
    ORDER BY v.vehicle_id DESC
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
$vehicles = $stmt->fetchAll();

/* ================== LẤY DANH SÁCH LOẠI XE (UNIQUE) ================== */

$typesQuery = "
    SELECT DISTINCT vehicle_type 
    FROM vehicles 
    WHERE station_id = :station_id AND vehicle_type IS NOT NULL AND vehicle_type != ''
    ORDER BY vehicle_type
";
$typesStmt = $conn->prepare($typesQuery);
$typesStmt->execute([':station_id' => $stationId]);
$vehicleTypes = $typesStmt->fetchAll(PDO::FETCH_COLUMN);
