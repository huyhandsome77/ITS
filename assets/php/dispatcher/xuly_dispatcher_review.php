<?php
require_once dirname(__DIR__, 3) . '/config/Connect_DB.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/* ================== HELPER FUNCTIONS ================== */

function getInitials($name) {
    if (!$name) return '?';
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
    if ($diff < 60) return $diff . ' giây trước';
    elseif ($diff < 3600) return floor($diff / 60) . ' phút trước';
    elseif ($diff < 86400) return floor($diff / 3600) . ' giờ trước';
    elseif ($diff < 604800) return floor($diff / 86400) . ' ngày trước';
    else return date('d/m/Y', $time);
}

// Dispatcher can manage ALL reviews, no station filter needed
$dispatcherStationId = null; 
// We generally don't need to fetch the station ID if we are showing all reviews.
// However, if we wanted to show "My Station's Reviews" vs "All", we would keep it.
// User requested "manage all reviews", so we remove the filter constraint.

// Station Filter String for Queries - Empty implies ALL
$stationFilter = "";
 

/* ================== THỐNG KÊ TỔNG QUAN ================== */
// Note: We need joins to filter by station IF needed, but now we get all.

// Tổng số đánh giá
$sqlTotal = "SELECT COUNT(*) FROM reviews r JOIN orders o ON r.order_id = o.order_id WHERE 1=1 $stationFilter";
$totalReviews = $conn->query($sqlTotal)->fetchColumn();

// Điểm trung bình
$sqlAvg = "SELECT AVG(rating) FROM reviews r JOIN orders o ON r.order_id = o.order_id WHERE r.status = 'APPROVED' $stationFilter";
$avgRatingResult = $conn->query($sqlAvg)->fetchColumn();
$avgRating = $avgRatingResult ? round($avgRatingResult, 1) : 0;

// Số đánh giá chờ duyệt
$sqlPending = "SELECT COUNT(*) FROM reviews r JOIN orders o ON r.order_id = o.order_id WHERE r.status = 'PENDING' $stationFilter";
$pendingReviews = $conn->query($sqlPending)->fetchColumn();

// Số đánh giá bị báo cáo
$sqlReported = "SELECT COUNT(*) FROM reviews r JOIN orders o ON r.order_id = o.order_id WHERE r.is_reported = 1 $stationFilter";
$reportedReviews = $conn->query($sqlReported)->fetchColumn();


/* ================== FILTER PARAMS ================== */
$rating = $_GET['rating'] ?? '';
$status = $_GET['status'] ?? '';
$type = $_GET['type'] ?? '';
$date = $_GET['date'] ?? '';

$where = ["1=1"];
$params = [];

// Apply Station Filter to Main Query - REMOVED
/*
if ($dispatcherStationId) {
    $where[] = "o.station_id = :station_id";
    $params[':station_id'] = $dispatcherStationId;
}
*/

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

$whereSQL = implode(' AND ', $where);


/* ================== PHÂN TRANG ================== */
$limit = 10;
$page = isset($_GET['page']) && $_GET['page'] > 0 ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;


/* ================== COUNT & FETCH ================== */
$countSql = "
    SELECT COUNT(*) 
    FROM reviews r
    JOIN orders o ON r.order_id = o.order_id
    WHERE $whereSQL
";
$countStmt = $conn->prepare($countSql);
foreach ($params as $k => $v) $countStmt->bindValue($k, $v);
$countStmt->execute();
$filteredTotal = $countStmt->fetchColumn();
$totalPages = ceil($filteredTotal / $limit);

$reviewsSql = "
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
        r.reply,
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
    WHERE $whereSQL
    ORDER BY r.created_at DESC
    LIMIT :limit OFFSET :offset
";

$stmt = $conn->prepare($reviewsSql);
foreach ($params as $key => $value) {
    $stmt->bindValue($key, $value);
}
$stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$reviews = $stmt->fetchAll();
