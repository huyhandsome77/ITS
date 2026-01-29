<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/ITS/config/Connect_DB.php';

/* ================== HÀM HỖ TRỢ ================== */

function getInitials($name) {
    $words = explode(' ', trim($name));
    $initials = '';
    foreach ($words as $w) {
        $initials .= mb_substr($w, 0, 1);
    }
    return mb_strtoupper($initials);
}

function getStarDisplay($rating) {
    $stars = '';
    for ($i = 0; $i < $rating; $i++) {
        $stars .= '⭐';
    }
    return $stars;
}

function getStatusBadge($status) {
    return match($status) {
        'APPROVED' => ['Đã duyệt', 'bg-green-100 text-green-700'],
        'PENDING' => ['Chờ duyệt', 'bg-blue-100 text-blue-700'],
        'REJECTED' => ['Từ chối', 'bg-red-100 text-red-700'],
        'HIDDEN' => ['Đã ẩn', 'bg-gray-100 text-gray-700'],
        default => ['Không xác định', 'bg-gray-100 text-gray-500']
    };
}

function getReviewTypeName($type) {
    return match($type) {
        'VEHICLE' => 'Đánh giá xe',
        'STATION' => 'Đánh giá trạm',
        'SERVICE' => 'Đánh giá dịch vụ',
        default => 'Không xác định'
    };
}

function timeAgo($datetime) {
    $time = strtotime($datetime);
    $diff = time() - $time;
    
    if ($diff < 60) {
        return $diff . ' giây trước';
    } elseif ($diff < 3600) {
        return floor($diff / 60) . ' phút trước';
    } elseif ($diff < 86400) {
        return floor($diff / 3600) . ' giờ trước';
    } elseif ($diff < 604800) {
        return floor($diff / 86400) . ' ngày trước';
    } else {
        return date('d/m/Y', $time);
    }
}

/* ================== THỐNG KÊ TỔNG QUAN ================== */

// Tổng số đánh giá
$totalReviews = $conn->query("SELECT COUNT(*) FROM reviews")->fetchColumn();

// Điểm trung bình
$avgRatingResult = $conn->query("SELECT AVG(rating) FROM reviews WHERE status = 'APPROVED'")->fetchColumn();
$avgRating = $avgRatingResult ? round($avgRatingResult, 1) : 0;

// Số đánh giá chờ duyệt
$pendingReviews = $conn->query(
    "SELECT COUNT(*) FROM reviews WHERE status = 'PENDING'"
)->fetchColumn();

// Số đánh giá bị báo cáo
$reportedReviews = $conn->query(
    "SELECT COUNT(*) FROM reviews WHERE is_reported = 1"
)->fetchColumn();


/* ================== FILTER ================== */

$rating = $_GET['rating'] ?? '';
$status = $_GET['status'] ?? '';
$type = $_GET['type'] ?? '';
$date = $_GET['date'] ?? '';

$where = [];
$params = [];

if ($rating !== '') {
    $where[] = "r.rating = :rating";
    $params[':rating'] = $rating;
}

if ($status !== '') {
    $where[] = "r.status = :status";
    $params[':status'] = strtoupper($status);
}

if ($type !== '') {
    $where[] = "r.review_type = :type";
    $params[':type'] = strtoupper($type);
}

if ($date !== '') {
    $where[] = "DATE(r.created_at) = :date";
    $params[':date'] = $date;
}

$whereSQL = $where ? 'WHERE ' . implode(' AND ', $where) : '';


/* ================== PHÂN TRANG ================== */

$limit = 10;
$page = isset($_GET['page']) && $_GET['page'] > 0 ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;


/* ================== ĐẾM SỐ ĐÁNH GIÁ (CÓ FILTER) ================== */

$countSql = "SELECT COUNT(*) FROM reviews r $whereSQL";
$countStmt = $conn->prepare($countSql);
$countStmt->execute($params);
$filteredTotal = $countStmt->fetchColumn();
$totalPages = ceil($filteredTotal / $limit);


/* ================== LẤY DANH SÁCH ĐÁNH GIÁ ================== */

$sql = "
    SELECT 
        r.review_id,
        r.user_id,
        r.rating,
        r.comment,
        r.status,
        r.review_type,
        r.is_reported,
        r.report_reason,
        r.created_at,
        u.full_name,
        o.order_code,
        v.vehicle_name,
        v.license_plate,
        s.station_name
    FROM reviews r
    JOIN users u ON r.user_id = u.user_id
    JOIN orders o ON r.order_id = o.order_id
    LEFT JOIN vehicles v ON o.vehicle_id = v.vehicle_id
    LEFT JOIN stations s ON o.station_id = s.station_id
    $whereSQL
    ORDER BY r.created_at DESC
    LIMIT :limit OFFSET :offset
";

$stmt = $conn->prepare($sql);

// bind filter params
foreach ($params as $key => $value) {
    $stmt->bindValue($key, $value);
}

// bind pagination params
$stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);

$stmt->execute();
$reviews = $stmt->fetchAll();
