<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/ITS/config/Connect_DB.php';

/* ================== HÀM HỖ TRỢ ================== */

function vehicleTypeLabel($type) {
    return match ($type) {
        'Oto' => ['Ô tô', 'bg-blue-100 text-blue-700'],
        'Xemay' => ['Xe máy', 'bg-green-100 text-green-700'],
        default => ['Khác', 'bg-gray-100 text-gray-700'],
    };
}

function vehicleStatusLabel($status) {
    return match ($status) {
        'AVAILABLE' => ['Sẵn sàng', 'bg-green-100 text-green-700'],
        'RENTED' => ['Đang thuê', 'bg-yellow-100 text-yellow-700'],
        'MAINTENANCE' => ['Bảo trì', 'bg-orange-100 text-orange-700'],
        default => ['Không xác định', 'bg-gray-100 text-gray-700'],
    };
}


/* ================== THỐNG KÊ ================== */

$totalVehicles = $conn->query("SELECT COUNT(*) FROM vehicles")->fetchColumn();

$availableVehicles = $conn->query(
    "SELECT COUNT(*) FROM vehicles WHERE status = 'AVAILABLE'"
)->fetchColumn();

$rentedVehicles = $conn->query(
    "SELECT COUNT(*) FROM vehicles WHERE status = 'RENTED'"
)->fetchColumn();

$maintenanceVehicles = $conn->query(
    "SELECT COUNT(*) FROM vehicles WHERE status = 'MAINTENANCE'"
)->fetchColumn();


/* ================== FILTER ================== */

$station      = $_GET['station'] ?? '';
$vehicleType  = $_GET['vehicle_type'] ?? '';
$brand        = $_GET['brand'] ?? '';
$status       = $_GET['status'] ?? '';
$keyword      = trim($_GET['keyword'] ?? '');

$where = [];
$params = [];

if ($station !== '') {
    $where[] = "v.station_id = :station";
    $params[':station'] = $station;
}

if ($vehicleType !== '') {
    $where[] = "v.vehicle_type = :vehicleType";
    $params[':vehicleType'] = $vehicleType;
}

if ($brand !== '') {
    $where[] = "v.brand = :brand";
    $params[':brand'] = $brand;
}

if ($status !== '') {
    $where[] = "v.status = :status";
    $params[':status'] = $status;
}

if ($keyword !== '') {
    $where[] = "(v.vehicle_name LIKE :kw OR v.license_plate LIKE :kw OR v.brand LIKE :kw)";
    $params[':kw'] = "%$keyword%";
}

$whereSQL = $where ? 'WHERE ' . implode(' AND ', $where) : '';


/* ================== PHÂN TRANG ================== */

$limit = 10;
$page = isset($_GET['page']) && $_GET['page'] > 0 ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;


/* ================== ĐẾM VEHICLE (CÓ FILTER) ================== */

$countSql = "
    SELECT COUNT(*) 
    FROM vehicles v
    LEFT JOIN stations s ON v.station_id = s.station_id
    $whereSQL
";
$countStmt = $conn->prepare($countSql);
$countStmt->execute($params);
$filteredTotal = $countStmt->fetchColumn();
$totalPages = ceil($filteredTotal / $limit);


/* ================== LẤY DANH SÁCH VEHICLE ================== */

$sql = "
    SELECT 
        v.vehicle_id,
        v.vehicle_name,
        v.license_plate,
        v.vehicle_type,
        v.brand,
        v.model,
        v.year,
        v.price_per_day,
        v.price_per_hour,
        v.status,
        v.image,
        s.station_name
    FROM vehicles v
    LEFT JOIN stations s ON v.station_id = s.station_id
    $whereSQL
    ORDER BY v.vehicle_id DESC
    LIMIT :limit OFFSET :offset
";

$stmt = $conn->prepare($sql);

// bind filter
foreach ($params as $key => $value) {
    $stmt->bindValue($key, $value);
}

// bind pagination
$stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);

$stmt->execute();
$vehicles = $stmt->fetchAll();


/* ================== LẤY DANH SÁCH TRẠM ================== */

$stationsSql = "SELECT station_id, station_name FROM stations WHERE status = 'ACTIVE' ORDER BY station_name";
$stationsStmt = $conn->prepare($stationsSql);
$stationsStmt->execute();
$stations = $stationsStmt->fetchAll();


/* ================== HIỂN THỊ X–Y ================== */

$from = $filteredTotal > 0 ? $offset + 1 : 0;
$to   = min($offset + $limit, $filteredTotal);
