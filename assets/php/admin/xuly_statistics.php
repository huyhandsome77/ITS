<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/ITS/config/Connect_DB.php';

/* ================== HÀM HỖ TRỢ ================== */

// Format doanh thu (tỷ/triệu/nghìn)
function formatRevenue($amount) {
    if ($amount >= 1000000000) {
        return number_format($amount / 1000000000, 1) . ' tỷ';
    } elseif ($amount >= 1000000) {
        return number_format($amount / 1000000, 0) . 'M';
    } elseif ($amount >= 1000) {
        return number_format($amount / 1000, 0) . 'K';
    } else {
        return number_format($amount, 0);
    }
}

/* ================== FILTER THEO THỜI GIAN ================== */

$period = $_GET['period'] ?? 'current_month';

// Xác định khoảng thời gian
switch ($period) {
    case 'last_month':
        $startDate = date('Y-m-01', strtotime('-1 month'));
        $endDate = date('Y-m-t', strtotime('-1 month'));
        break;
    case 'current_quarter':
        $currentQuarter = ceil(date('n') / 3);
        $startMonth = ($currentQuarter - 1) * 3 + 1;
        $startDate = date('Y-' . str_pad($startMonth, 2, '0', STR_PAD_LEFT) . '-01');
        $endDate = date('Y-m-t', strtotime($startDate . ' +2 months'));
        break;
    case 'current_year':
        $startDate = date('Y-01-01');
        $endDate = date('Y-12-31');
        break;
    case 'current_month':
    default:
        $startDate = date('Y-m-01');
        $endDate = date('Y-m-t');
        break;
}

/* ================== 1. THỐNG KÊ DOANH THU ================== */

// Doanh thu kỳ hiện tại
$revenueSql = "
    SELECT COALESCE(SUM(total_amount), 0) as revenue 
    FROM orders 
    WHERE start_date >= :start_date 
    AND start_date <= :end_date
    AND status IN ('COMPLETED', 'RENTING')
";
$revenueStmt = $conn->prepare($revenueSql);
$revenueStmt->execute([':start_date' => $startDate, ':end_date' => $endDate]);
$currentRevenue = $revenueStmt->fetchColumn();

// Doanh thu kỳ trước (để tính tăng trưởng)
if ($period === 'last_month' || $period === 'current_month') {
    $prevStartDate = date('Y-m-01', strtotime($startDate . ' -1 month'));
    $prevEndDate = date('Y-m-t', strtotime($startDate . ' -1 month'));
} else {
    $daysDiff = (strtotime($endDate) - strtotime($startDate)) / 86400;
    $prevStartDate = date('Y-m-d', strtotime($startDate . ' -' . ($daysDiff + 1) . ' days'));
    $prevEndDate = date('Y-m-d', strtotime($startDate . ' -1 day'));
}

$prevRevenueStmt = $conn->prepare($revenueSql);
$prevRevenueStmt->execute([':start_date' => $prevStartDate, ':end_date' => $prevEndDate]);
$prevRevenue = $prevRevenueStmt->fetchColumn();

// Tính % tăng trưởng doanh thu
$revenueGrowth = 0;
if ($prevRevenue > 0) {
    $revenueGrowth = (($currentRevenue - $prevRevenue) / $prevRevenue) * 100;
}
$revenueGrowthText = ($revenueGrowth >= 0 ? '↑ ' : '↓ ') . abs(round($revenueGrowth, 1)) . '%';

/* ================== 2. THỐNG KÊ ĐỌN HÀNG ================== */

// Tổng đơn hàng
$totalOrdersSql = "
    SELECT COUNT(*) FROM orders 
    WHERE start_date >= :start_date AND start_date <= :end_date
";
$totalOrdersStmt = $conn->prepare($totalOrdersSql);
$totalOrdersStmt->execute([':start_date' => $startDate, ':end_date' => $endDate]);
$totalOrders = $totalOrdersStmt->fetchColumn();

// Đơn hàng hôm nay
$todayOrdersSql = "
    SELECT COUNT(*) FROM orders WHERE DATE(created_at) = CURDATE()
";
$todayOrders = $conn->query($todayOrdersSql)->fetchColumn();

/* ================== 3. TỶ LỆ XE HOẠT ĐỘNG ================== */

$totalVehicles = $conn->query("SELECT COUNT(*) FROM vehicles")->fetchColumn();
$activeVehicles = $conn->query(
    "SELECT COUNT(*) FROM vehicles WHERE status IN ('AVAILABLE', 'RENTED')"
)->fetchColumn();
$vehicleUtilization = $totalVehicles > 0 ? round(($activeVehicles / $totalVehicles) * 100, 1) : 0;

/* ================== 4. ĐÁNH GIÁ TRUNG BÌNH ================== */

try {
    $avgRatingSql = "SELECT AVG(rating) FROM reviews WHERE status = 'APPROVED'";
    $avgRating = $conn->query($avgRatingSql)->fetchColumn();
    $avgRating = $avgRating ? round($avgRating, 1) : 0;
    
    $totalReviews = $conn->query("SELECT COUNT(*) FROM reviews")->fetchColumn();
} catch (PDOException $e) {
    $avgRating = 0;
    $totalReviews = 0;
}

/* ================== 5. BIỂU ĐỒ TĂNG TRƯỞNG NGƯỜI DÙNG (12 THÁNG) ================== */

$userGrowthSql = "
    SELECT 
        DATE_FORMAT(created_at, '%Y-%m') as month,
        COUNT(*) as total
    FROM users
    WHERE created_at >= DATE_SUB(CURDATE(), INTERVAL 12 MONTH)
    AND role = 'USER'
    GROUP BY DATE_FORMAT(created_at, '%Y-%m')
    ORDER BY month ASC
";
$userGrowthData = $conn->query($userGrowthSql)->fetchAll(PDO::FETCH_ASSOC);

// Tạo array 12 tháng cho user growth
$userMonths = [];
$userCounts = [];
$cumulativeUsers = $conn->query(
    "SELECT COUNT(*) FROM users WHERE role = 'USER' AND created_at < DATE_SUB(CURDATE(), INTERVAL 12 MONTH)"
)->fetchColumn();

for ($i = 11; $i >= 0; $i--) {
    $monthKey = date('Y-m', strtotime("-$i months"));
    $monthLabel = 'T' . date('n', strtotime("-$i months"));
    $userMonths[] = $monthLabel;
    
    $newUsers = 0;
    foreach ($userGrowthData as $data) {
        if ($data['month'] == $monthKey) {
            $newUsers = $data['total'];
            break;
        }
    }
    $cumulativeUsers += $newUsers;
    $userCounts[] = $cumulativeUsers;
}

/* ================== 6. ĐẶT XE THEO NGÀY TRONG TUẦN ================== */

$bookingByDaySql = "
    SELECT 
        DAYOFWEEK(created_at) as day_num,
        COUNT(*) as count
    FROM orders
    WHERE created_at >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)
    GROUP BY DAYOFWEEK(created_at)
    ORDER BY day_num
";
$bookingByDayData = $conn->query($bookingByDaySql)->fetchAll(PDO::FETCH_KEY_PAIR);

$dayLabels = ['CN', 'Thứ 2', 'Thứ 3', 'Thứ 4', 'Thứ 5', 'Thứ 6', 'Thứ 7'];
$bookingCounts = [];
for ($i = 1; $i <= 7; $i++) {
    $bookingCounts[] = $bookingByDayData[$i] ?? 0;
}

/* ================== 7. PHÂN BỐ LOẠI XE ĐƯỢC THUÊ ================== */

$vehicleTypeSql = "
    SELECT 
        v.vehicle_type,
        COUNT(o.order_id) as count
    FROM orders o
    JOIN vehicles v ON o.vehicle_id = v.vehicle_id
    WHERE o.start_date >= :start_date AND o.start_date <= :end_date
    GROUP BY v.vehicle_type
";
$vehicleTypeStmt = $conn->prepare($vehicleTypeSql);
$vehicleTypeStmt->execute([':start_date' => $startDate, ':end_date' => $endDate]);
$vehicleTypeData = $vehicleTypeStmt->fetchAll(PDO::FETCH_KEY_PAIR);

$vehicleTypeLabels = array_keys($vehicleTypeData);
$vehicleTypeCounts = array_values($vehicleTypeData);

/* ================== 8. SO SÁNH HIỆU SUẤT CÁC TRẠM ================== */

$stationComparisonSql = "
    SELECT 
        s.station_name,
        COUNT(o.order_id) as total_orders,
        COALESCE(SUM(o.total_amount), 0) / 1000000 as revenue_millions
    FROM stations s
    LEFT JOIN orders o ON s.station_id = o.station_id
        AND o.start_date >= :start_date 
        AND o.start_date <= :end_date
        AND o.status IN ('COMPLETED', 'RENTING')
    GROUP BY s.station_id, s.station_name
    ORDER BY revenue_millions DESC
    LIMIT 10
";
$stationCompStmt = $conn->prepare($stationComparisonSql);
$stationCompStmt->execute([':start_date' => $startDate, ':end_date' => $endDate]);
$stationComparison = $stationCompStmt->fetchAll(PDO::FETCH_ASSOC);

$stationNames = array_column($stationComparison, 'station_name');
$stationRevenues = array_map('round', array_column($stationComparison, 'revenue_millions'));
$stationOrders = array_column($stationComparison, 'total_orders');

/* ================== 9. TOP 5 XE ĐƯỢC THUÊ NHIỀU NHẤT ================== */

$topVehiclesSql = "
    SELECT 
        v.vehicle_name,
        v.license_plate,
        s.station_name,
        COUNT(o.order_id) as rental_count,
        ROUND((COUNT(o.order_id) * 100.0 / 
            (SELECT COUNT(*) FROM orders WHERE created_at >= DATE_SUB(CURDATE(), INTERVAL 30 DAY))
        ), 0) as usage_percent
    FROM vehicles v
    LEFT JOIN orders o ON v.vehicle_id = o.vehicle_id 
        AND o.created_at >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)
    LEFT JOIN stations s ON v.station_id = s.station_id
    GROUP BY v.vehicle_id, v.vehicle_name, v.license_plate, s.station_name
    HAVING rental_count > 0
    ORDER BY rental_count DESC
    LIMIT 5
";
$topVehicles = $conn->query($topVehiclesSql)->fetchAll(PDO::FETCH_ASSOC);

/* ================== 10. BẢNG HIỆU SUẤT CÁC TRẠM CHI TIẾT ================== */

$stationPerformanceSql = "
    SELECT 
        s.station_id,
        s.station_name,
        COUNT(DISTINCT v.vehicle_id) as total_vehicles,
        COUNT(o.order_id) as total_orders,
        COALESCE(SUM(o.total_amount), 0) as revenue,
        ROUND(AVG(CASE WHEN v.status IN ('AVAILABLE', 'RENTED') THEN 100 ELSE 0 END), 0) as utilization_rate
    FROM stations s
    LEFT JOIN vehicles v ON s.station_id = v.station_id
    LEFT JOIN orders o ON v.vehicle_id = o.vehicle_id
        AND o.start_date >= :start_date 
        AND o.start_date <= :end_date
        AND o.status IN ('COMPLETED', 'RENTING')
    GROUP BY s.station_id, s.station_name
    HAVING total_orders > 0
    ORDER BY revenue DESC
";
$stationPerfStmt = $conn->prepare($stationPerformanceSql);
$stationPerfStmt->execute([':start_date' => $startDate, ':end_date' => $endDate]);
$stationPerformance = $stationPerfStmt->fetchAll(PDO::FETCH_ASSOC);

// Thêm đánh giá trung bình cho mỗi trạm
foreach ($stationPerformance as &$station) {
    try {
        $stationRatingSql = "
            SELECT AVG(r.rating) 
            FROM reviews r
            JOIN orders o ON r.order_id = o.order_id
            WHERE o.station_id = :station_id AND r.status = 'APPROVED'
        ";
        $stationRatingStmt = $conn->prepare($stationRatingSql);
        $stationRatingStmt->execute([':station_id' => $station['station_id']]);
        $station['avg_rating'] = round($stationRatingStmt->fetchColumn() ?: 0, 1);
    } catch (PDOException $e) {
        $station['avg_rating'] = 0;
    }
    
    // Xác định hiệu suất
    if ($station['utilization_rate'] >= 85) {
        $station['performance'] = ['label' => 'Xuất sắc', 'class' => 'bg-green-100 text-green-700'];
    } elseif ($station['utilization_rate'] >= 70) {
        $station['performance'] = ['label' => 'Tốt', 'class' => 'bg-blue-100 text-blue-700'];
    } elseif ($station['utilization_rate'] >= 50) {
        $station['performance'] = ['label' => 'Khá', 'class' => 'bg-yellow-100 text-yellow-700'];
    } else {
        $station['performance'] = ['label' => 'Trung bình', 'class' => 'bg-gray-100 text-gray-700'];
    }
}

/* ================== 11. PHÂN TÍCH KHÁCH HÀNG ================== */

// Thời gian thuê trung bình
$rentalDurationSql = "
    SELECT 
        SUM(CASE WHEN DATEDIFF(end_date, start_date) <= 3 THEN 1 ELSE 0 END) as short_term,
        SUM(CASE WHEN DATEDIFF(end_date, start_date) BETWEEN 4 AND 7 THEN 1 ELSE 0 END) as medium_term,
        SUM(CASE WHEN DATEDIFF(end_date, start_date) > 7 THEN 1 ELSE 0 END) as long_term,
        COUNT(*) as total
    FROM orders
    WHERE start_date >= :start_date AND start_date <= :end_date
";
$rentalDurationStmt = $conn->prepare($rentalDurationSql);
$rentalDurationStmt->execute([':start_date' => $startDate, ':end_date' => $endDate]);
$rentalDuration = $rentalDurationStmt->fetch(PDO::FETCH_ASSOC);

$totalRentals = $rentalDuration['total'] ?: 1;
$shortTermPercent = round(($rentalDuration['short_term'] / $totalRentals) * 100);
$mediumTermPercent = round(($rentalDuration['medium_term'] / $totalRentals) * 100);
$longTermPercent = round(($rentalDuration['long_term'] / $totalRentals) * 100);

// Khách hàng trung thành
$loyalCustomersSql = "
    SELECT COUNT(DISTINCT user_id) as loyal_count
    FROM (
        SELECT user_id, COUNT(*) as order_count
        FROM orders
        GROUP BY user_id
        HAVING order_count >= 5
    ) as loyal_users
";
$loyalCustomers = $conn->query($loyalCustomersSql)->fetchColumn();
