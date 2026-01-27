<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/ITS/config/Connect_DB.php';

// Ensure Session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$current_user_id = $_SESSION['user_id'] ?? 0;

// Fetch Managed Station for this Dispatcher
$stStmt = $conn->prepare("SELECT managed_station_id FROM users WHERE user_id = ?");
$stStmt->execute([$current_user_id]);
$managed_station_id = $stStmt->fetchColumn();


/* ================== FILTER PARAMS ================== */
$status    = $_GET['status'] ?? '';
$fromDate  = $_GET['from_date'] ?? '';
$toDate    = $_GET['to_date'] ?? '';
// Note: Dispatcher cannot "select" a station, they are bound to their managed station (if any).
// If they don't have a managed station, what? Maybe they see nothing, or everything?
// Let's assume they see everything if NULL (like an Admin-Dispatcher), 
// OR simpler: strictly enforce filter if $managed_station_id is set.
// User said "station role manage station", so they likely have one.

$where = [];
$params = [];

// Allow filtering by station if selected
if (!empty($_GET['station'])) {
    $where[] = "o.station_id = :station_get";
    $params[':station_get'] = $_GET['station'];
}

// Fetch all stations for the dropdown
$placeStmt = $conn->query("SELECT station_id, station_name FROM stations ORDER BY station_name ASC");
$all_stations = $placeStmt->fetchAll();

if ($status !== '') {
    $where[] = "o.status = :status";
    $params[':status'] = $status;
}

if ($fromDate !== '') {
    $where[] = "o.start_date >= :fromDate";
    $params[':fromDate'] = $fromDate;
}

if ($toDate !== '') {
    $where[] = "o.end_date <= :toDate";
    $params[':toDate'] = $toDate;
}

$whereSQL = $where ? 'WHERE ' . implode(' AND ', $where) : '';


/* ================== STATISTICS ================== */
$statusSql = "
    SELECT 
        COUNT(*) AS total_orders,
        SUM(o.status = 'NEW') AS total_new,
        SUM(o.status = 'WAITING_RETURN') AS total_waiting,
        SUM(o.status = 'COMPLETED') AS total_completed,
        SUM(o.status = 'CANCELLED') AS total_cancelled
    FROM orders o
    $whereSQL
";

$statusStmt = $conn->prepare($statusSql);
$statusStmt->execute($params);
$stats = $statusStmt->fetch();


/* ================== PAGINATION ================== */
$limit = 5; 
$page  = isset($_GET['page']) && $_GET['page'] > 0 ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;


/* ================== COUNT TOTAL ================== */
$countSql = "SELECT COUNT(*) FROM orders o $whereSQL";
$countStmt = $conn->prepare($countSql);
$countStmt->execute($params);
$totalOrders = $countStmt->fetchColumn();
$totalPages = ceil($totalOrders / $limit);


/* ================== LIST ORDERS ================== */
$sql = "
    SELECT 
        o.order_code,
        s.station_name,
        u.full_name,
        u.phone,
        v.vehicle_name,
        v.license_plate,
        o.start_date,
        o.end_date,
        o.total_amount,
        o.status
    FROM orders o
    JOIN stations s ON o.station_id = s.station_id
    JOIN users u ON o.user_id = u.user_id
    JOIN vehicles v ON o.vehicle_id = v.vehicle_id
    $whereSQL
    ORDER BY o.created_at DESC
    LIMIT :limit OFFSET :offset
";

$stmt = $conn->prepare($sql);

foreach ($params as $key => $value) {
    $stmt->bindValue($key, $value);
}

$stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);

$stmt->execute();
$orders = $stmt->fetchAll();


/* ================== DISPLAY RANGE ================== */
$from = $totalOrders > 0 ? $offset + 1 : 0;
$to   = min($offset + $limit, $totalOrders);
?>
