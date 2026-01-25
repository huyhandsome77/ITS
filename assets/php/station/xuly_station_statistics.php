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

/* ================== HÀM HỖ TRỢ ================== */

function formatRevenue($amount) {
    if ($amount >= 1000000000) {
        return number_format($amount / 1000000000, 1) . ' tỷ';
    } elseif ($amount >= 1000000) {
        return number_format($amount / 1000000, 1) . 'M';
    }
    return number_format($amount, 0, ',', '.') . 'đ';
}

/* ================== FILTER PERIOD ================== */

$period = $_GET['period'] ?? 'month';

$dateCondition = match ($period) {
    'today' => "DATE(o.created_at) = CURDATE()",
    'week' => "o.created_at >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)",
    'month' => "o.created_at >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)",
    'year' => "YEAR(o.created_at) = YEAR(CURDATE())",
    default => "o.created_at >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)",
};

/* ================== DOANH THU ================== */

$revenueQuery = "
    SELECT 
        COALESCE(SUM(o.total_amount), 0) AS current_revenue,
        COUNT(o.order_id) AS total_orders
    FROM orders o
    WHERE o.station_id = :station_id
        AND o.status IN ('COMPLETED', 'RENTING')
        AND $dateCondition
";

$revenueStmt = $conn->prepare($revenueQuery);
$revenueStmt->execute([':station_id' => $stationId]);
$revenueData = $revenueStmt->fetch();

$currentRevenue = $revenueData['current_revenue'] ?? 0;
$totalOrders = $revenueData['total_orders'] ?? 0;

// Tính revenue growth (so với period trước)
$previousDateCondition = match ($period) {
    'today' => "DATE(o.created_at) = DATE_SUB(CURDATE(), INTERVAL 1 DAY)",
    'week' => "o.created_at >= DATE_SUB(CURDATE(), INTERVAL 14 DAY) AND o.created_at < DATE_SUB(CURDATE(), INTERVAL 7 DAY)",
    'month' => "o.created_at >= DATE_SUB(CURDATE(), INTERVAL 60 DAY) AND o.created_at < DATE_SUB(CURDATE(), INTERVAL 30 DAY)",
    'year' => "YEAR(o.created_at) = YEAR(CURDATE()) - 1",
    default => "o.created_at >= DATE_SUB(CURDATE(), INTERVAL 60 DAY) AND o.created_at < DATE_SUB(CURDATE(), INTERVAL 30 DAY)",
};

$previousRevenueQuery = "
    SELECT COALESCE(SUM(o.total_amount), 0) AS previous_revenue
    FROM orders o
    WHERE o.station_id = :station_id
        AND o.status IN ('COMPLETED', 'RENTING')
        AND $previousDateCondition
";

$previousRevenueStmt = $conn->prepare($previousRevenueQuery);
$previousRevenueStmt->execute([':station_id' => $stationId]);
$previousRevenue = $previousRevenueStmt->fetchColumn();

$revenueGrowth = 0;
$revenueGrowthText = '';
if ($previousRevenue > 0) {
    $revenueGrowth = (($currentRevenue - $previousRevenue) / $previousRevenue) * 100;
    $revenueGrowthText = ($revenueGrowth >= 0 ? '+' : '') . number_format($revenueGrowth, 1) . '% so với ' . match($period) {
        'today' => 'hôm qua',
        'week' => 'tuần trước',
        'month' => 'tháng trước',
        'year' => 'năm trước',
        default => 'kỳ trước',
    };
} else {
    $revenueGrowthText = 'Chưa có dữ liệu kỳ trước';
}

/* ================== TỔNG XE VÀ TỶ LỆ SỬ DỤNG ================== */

$vehicleStatsQuery = "
    SELECT 
        COUNT(*) AS total_vehicles,
        SUM(CASE WHEN status = 'AVAILABLE' THEN 1 ELSE 0 END) AS available_vehicles,
        SUM(CASE WHEN status = 'RENTED' THEN 1 ELSE 0 END) AS rented_vehicles
    FROM vehicles
    WHERE station_id = :station_id
";

$vehicleStatsStmt = $conn->prepare($vehicleStatsQuery);
$vehicleStatsStmt->execute([':station_id' => $stationId]);
$vehicleStats = $vehicleStatsStmt->fetch();

$totalVehicles = $vehicleStats['total_vehicles'] ?? 0;
$availableVehicles = $vehicleStats['available_vehicles'] ?? 0;
$rentedVehicles = $vehicleStats['rented_vehicles'] ?? 0;

$vehicleUtilization = $totalVehicles > 0 ? round(($rentedVehicles / $totalVehicles) * 100) : 0;

/* ================== DOANH THU THEO THỜI GIAN (12 THÁNG GẦN NHẤT) ================== */

$revenueChartQuery = "
    SELECT 
        DATE_FORMAT(o.created_at, '%Y-%m') AS month,
        COALESCE(SUM(o.total_amount), 0) AS revenue
    FROM orders o
    WHERE o.station_id = :station_id
        AND o.status IN ('COMPLETED', 'RENTING')
        AND o.created_at >= DATE_SUB(CURDATE(), INTERVAL 12 MONTH)
    GROUP BY DATE_FORMAT(o.created_at, '%Y-%m')
    ORDER BY month ASC
";

$revenueChartStmt = $conn->prepare($revenueChartQuery);
$revenueChartStmt->execute([':station_id' => $stationId]);
$revenueChartData = $revenueChartStmt->fetchAll();

$revenueMonths = [];
$revenueAmounts = [];

foreach ($revenueChartData as $row) {
    $revenueMonths[] = date('m/Y', strtotime($row['month'] . '-01'));
    $revenueAmounts[] = $row['revenue'];
}

/* ================== PHÂN BỔ TRẠNG THÁI ĐƠN HÀNG ================== */

$orderStatusQuery = "
    SELECT 
        o.status,
        COUNT(*) AS count
    FROM orders o
    WHERE o.station_id = :station_id
        AND $dateCondition
    GROUP BY o.status
";

$orderStatusStmt = $conn->prepare($orderStatusQuery);
$orderStatusStmt->execute([':station_id' => $stationId]);
$orderStatusData = $orderStatusStmt->fetchAll();

$orderStatusLabels = [];
$orderStatusCounts = [];
$orderStatusColors = [
    'NEW' => '#3b82f6',
    'RENTING' => '#10b981',
    'WAITING_RETURN' => '#f59e0b',
    'COMPLETED' => '#8b5cf6',
    'CANCELLED' => '#ef4444',
];

foreach ($orderStatusData as $row) {
    $label = match($row['status']) {
        'NEW' => 'Đơn mới',
        'RENTING' => 'Đang thuê',
        'WAITING_RETURN' => 'Chờ trả xe',
        'COMPLETED' => 'Hoàn thành',
        'CANCELLED' => 'Đã hủy',
        default => $row['status'],
    };
    $orderStatusLabels[] = $label;
    $orderStatusCounts[] = $row['count'];
}

/* ================== TỶ LỆ SỬ DỤNG TỪNG XE ================== */

$vehicleUsageQuery = "
    SELECT 
        v.vehicle_name,
        v.license_plate,
        COUNT(DISTINCT o.order_id) AS rental_count
    FROM vehicles v
    LEFT JOIN orders o ON v.vehicle_id = o.vehicle_id 
        AND o.status IN ('COMPLETED', 'RENTING')
        AND o.station_id = :station_id
        AND $dateCondition
    WHERE v.station_id = :station_id
    GROUP BY v.vehicle_id, v.vehicle_name, v.license_plate
    ORDER BY rental_count DESC
    LIMIT 10
";

$vehicleUsageStmt = $conn->prepare($vehicleUsageQuery);
$vehicleUsageStmt->execute([':station_id' => $stationId]);
$vehicleUsageData = $vehicleUsageStmt->fetchAll();

$vehicleNames = [];
$vehicleUsageCounts = [];

foreach ($vehicleUsageData as $row) {
    $vehicleNames[] = $row['vehicle_name'] . ' (' . $row['license_plate'] . ')';
    $vehicleUsageCounts[] = $row['rental_count'];
}

/* ================== TOP 5 XE THEO DOANH THU ================== */

$topVehiclesQuery = "
    SELECT 
        v.vehicle_name,
        v.license_plate,
        COUNT(DISTINCT o.order_id) AS total_orders,
        COALESCE(SUM(o.total_amount), 0) AS total_revenue
    FROM vehicles v
    LEFT JOIN orders o ON v.vehicle_id = o.vehicle_id 
        AND o.status IN ('COMPLETED', 'RENTING')
        AND o.station_id = :station_id
        AND $dateCondition
    WHERE v.station_id = :station_id
    GROUP BY v.vehicle_id, v.vehicle_name, v.license_plate
    ORDER BY total_revenue DESC
    LIMIT 5
";

$topVehiclesStmt = $conn->prepare($topVehiclesQuery);
$topVehiclesStmt->execute([':station_id' => $stationId]);
$topVehicles = $topVehiclesStmt->fetchAll();

/* ================== THỐNG KÊ KHÁCH HÀNG ================== */

$customerStatsQuery = "
    SELECT 
        COUNT(DISTINCT CASE 
            WHEN o.created_at >= DATE_SUB(CURDATE(), INTERVAL 30 DAY) 
            THEN o.user_id 
        END) AS new_customers,
        COUNT(DISTINCT CASE 
            WHEN (SELECT COUNT(*) FROM orders o2 WHERE o2.user_id = o.user_id) > 1 
            THEN o.user_id 
        END) AS returning_customers,
        ROUND(AVG(DATEDIFF(o.end_date, o.start_date)), 1) AS avg_rental_days,
        ROUND(AVG(o.total_amount), 0) AS avg_order_value
    FROM orders o
    WHERE o.station_id = :station_id
        AND o.status IN ('COMPLETED', 'RENTING')
        AND $dateCondition
";

$customerStatsStmt = $conn->prepare($customerStatsQuery);
$customerStatsStmt->execute([':station_id' => $stationId]);
$customerStats = $customerStatsStmt->fetch();

$newCustomers = $customerStats['new_customers'] ?? 0;
$returningCustomers = $customerStats['returning_customers'] ?? 0;
$avgRentalDays = $customerStats['avg_rental_days'] ?? 0;
$avgOrderValue = $customerStats['avg_order_value'] ?? 0;

// Tính growth cho khách hàng
$previousCustomerQuery = "
    SELECT 
        COUNT(DISTINCT o.user_id) AS previous_customers
    FROM orders o
    WHERE o.station_id = :station_id
        AND o.status IN ('COMPLETED', 'RENTING')
        AND $previousDateCondition
";

$previousCustomerStmt = $conn->prepare($previousCustomerQuery);
$previousCustomerStmt->execute([':station_id' => $stationId]);
$previousCustomers = $previousCustomerStmt->fetchColumn();

$customerGrowth = 0;
if ($previousCustomers > 0) {
    $customerGrowth = ((($newCustomers + $returningCustomers) - $previousCustomers) / $previousCustomers) * 100;
}

$newCustomerGrowth = ($customerGrowth >= 0 ? '+' : '') . number_format($customerGrowth, 1) . '%';
$returningCustomerGrowth = ($returningCustomers > 0 && $previousCustomers > 0) 
    ? (($returningCustomers - $previousCustomers) / $previousCustomers) * 100 
    : 0;
$returningCustomerGrowthText = ($returningCustomerGrowth >= 0 ? '+' : '') . number_format($returningCustomerGrowth, 1) . '%';

/* ================== TỶ LỆ HOÀN THÀNH ĐƠN HÀNG ================== */

$completionRateQuery = "
    SELECT 
        COUNT(CASE WHEN o.status = 'COMPLETED' THEN 1 END) AS completed_count,
        COUNT(*) AS total_count
    FROM orders o
    WHERE o.station_id = :station_id
        AND $dateCondition
        AND o.status IN ('COMPLETED', 'CANCELLED', 'RENTING', 'WAITING_RETURN')
";

$completionRateStmt = $conn->prepare($completionRateQuery);
$completionRateStmt->execute([':station_id' => $stationId]);
$completionRateData = $completionRateStmt->fetch();

$completedOrders = $completionRateData['completed_count'] ?? 0;
$totalFilteredOrders = $completionRateData['total_count'] ?? 0;

$completionRate = $totalFilteredOrders > 0 
    ? round(($completedOrders / $totalFilteredOrders) * 100) 
    : 0;

/* ================== ĐÁNH GIÁ TRUNG BÌNH ================== */

// Bảng reviews chưa tồn tại trong database
$avgRating = 0;
$reviewCount = 0;

