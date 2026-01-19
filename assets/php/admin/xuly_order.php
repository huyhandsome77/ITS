<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/QuanTriMang/config/Connect_DB.php';

/* ================== FILTER ================== */

/* ================== FILTER ================== */

$station   = $_GET['station'] ?? '';
$status    = $_GET['status'] ?? '';
$fromDate  = $_GET['from_date'] ?? '';
$toDate    = $_GET['to_date'] ?? '';

$where = [];
$params = [];

if ($station !== '') {
    $where[] = "o.station_id = :station";
    $params[':station'] = $station;
}

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
$statusSql = "
    SELECT 
        COUNT(*) AS total_orders,
        SUM(o.status = 'NEW') AS total_new,
        SUM(o.status = 'WAITING_RETURN') AS total_waiting,
        SUM(o.status = 'COMPLETED') AS total_completed,
        SUM(o.status = 'CANCELLED') AS total_cancelled
    FROM orders o
    JOIN users u ON o.user_id = u.user_id
    $whereSQL
";

$statusStmt = $conn->prepare($statusSql);
$statusStmt->execute($params);
$stats = $statusStmt->fetch();


/* ================== PHÂN TRANG ================== */

$limit = 5; // số đơn / trang
$page  = isset($_GET['page']) && $_GET['page'] > 0 ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

/* ================== ĐẾM TỔNG ĐƠN ================== */

$countSql = "
    SELECT COUNT(*)
    FROM orders o
    JOIN users u ON o.user_id = u.user_id
    $whereSQL
";

$countStmt = $conn->prepare($countSql);
$countStmt->execute($params);
$totalOrders = $countStmt->fetchColumn();
$totalPages = ceil($totalOrders / $limit);

/* ================== LẤY DANH SÁCH ĐƠN ================== */

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

/* bind filter */
foreach ($params as $key => $value) {
    $stmt->bindValue($key, $value);
}

/* bind pagination */
$stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);

$stmt->execute();
$orders = $stmt->fetchAll();

/* ================== HIỂN THỊ X–Y ================== */

$from = $totalOrders > 0 ? $offset + 1 : 0;
$to   = min($offset + $limit, $totalOrders);