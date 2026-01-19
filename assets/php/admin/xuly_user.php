<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/QuanTriMang/config/Connect_DB.php';

/* ================== HÀM HỖ TRỢ ================== */

function getInitials($name) {
    $words = explode(' ', trim($name));
    $initials = '';
    foreach ($words as $w) {
        $initials .= mb_substr($w, 0, 1);
    }
    return mb_strtoupper($initials);
}

function roleLabel($role) {
    return match ($role) {
        'ADMIN' => ['Admin', 'bg-red-100 text-red-700'],
        'STATION' => ['Quản lý trạm', 'bg-purple-100 text-purple-700'],
        default => ['Người dùng', 'bg-blue-100 text-blue-700'],
    };
}

function statusLabel($status) {
    return $status === 'ACTIVE'
        ? ['Hoạt động', 'bg-green-100 text-green-700']
        : ['Bị khóa', 'bg-red-100 text-red-700'];
}


/* ================== THỐNG KÊ ================== */

$totalUsersAll = $conn->query("SELECT COUNT(*) FROM users")->fetchColumn();

$activeUsers = $conn->query(
    "SELECT COUNT(*) FROM users WHERE status = 'ACTIVE'"
)->fetchColumn();

$blockedUsers = $conn->query(
    "SELECT COUNT(*) FROM users WHERE status = 'BLOCKED'"
)->fetchColumn();

$managementUsers = $conn->query(
    "SELECT COUNT(*) FROM users WHERE role = 'STATION'"
)->fetchColumn();


/* ================== FILTER ================== */

$role    = $_GET['role'] ?? '';
$status  = $_GET['status'] ?? '';
$keyword = trim($_GET['keyword'] ?? '');

$where = [];
$params = [];

if ($role !== '') {
    $where[] = "role = :role";
    $params[':role'] = $role;
}

if ($status !== '') {
    $where[] = "status = :status";
    $params[':status'] = $status;
}

if ($keyword !== '') {
    $where[] = "(full_name LIKE :kw OR email LIKE :kw OR phone LIKE :kw)";
    $params[':kw'] = "%$keyword%";
}

$whereSQL = $where ? 'WHERE ' . implode(' AND ', $where) : '';


/* ================== PHÂN TRANG ================== */

$limit = 5;
$page = isset($_GET['page']) && $_GET['page'] > 0 ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;


/* ================== ĐẾM USER (CÓ FILTER) ================== */

$countSql = "SELECT COUNT(*) FROM users $whereSQL";
$countStmt = $conn->prepare($countSql);
$countStmt->execute($params);
$totalUsers = $countStmt->fetchColumn();
$totalPages = ceil($totalUsers / $limit);


/* ================== LẤY DANH SÁCH USER ================== */

$sql = "SELECT user_id, full_name, email, phone, role, status, created_at
        FROM users
        $whereSQL
        ORDER BY created_at DESC
        LIMIT :limit OFFSET :offset";

$stmt = $conn->prepare($sql);

// bind filter
foreach ($params as $key => $value) {
    $stmt->bindValue($key, $value);
}

// bind pagination
$stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);

$stmt->execute();
$users = $stmt->fetchAll();


/* ================== HIỂN THỊ X–Y ================== */

$from = $totalUsers > 0 ? $offset + 1 : 0;
$to   = min($offset + $limit, $totalUsers);