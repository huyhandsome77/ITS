<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/ITS/config/Connect_DB.php';

// Tổng số trạm
$stationsSql = "SELECT COUNT(*) as total FROM stations";
$stationsActiveSQL = "SELECT COUNT(*) as active FROM stations WHERE status = 'ACTIVE'";
$totalStations = $conn->query($stationsSql)->fetchColumn();
$activeStations = $conn->query($stationsActiveSQL)->fetchColumn();

// Tổng phương tiện
$vehiclesSql = "SELECT COUNT(*) as total FROM vehicles";
$vehiclesAvailableSql = "SELECT COUNT(*) as available FROM vehicles WHERE status = 'AVAILABLE'";
$totalVehicles = $conn->query($vehiclesSql)->fetchColumn();
$availableVehicles = $conn->query($vehiclesAvailableSql)->fetchColumn();

// Tổng người dùng
$usersSql = "SELECT COUNT(*) as total FROM users WHERE role = 'USER'";
$usersThisMonthSql = "SELECT COUNT(*) as new_users FROM users WHERE role = 'USER' AND DATE(created_at) >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)";
$totalUsers = $conn->query($usersSql)->fetchColumn();
$newUsersThisMonth = $conn->query($usersThisMonthSql)->fetchColumn();

// Doanh thu tháng hiện tại
$currentMonth = date('Y-m');
$revenueSql = "
    SELECT COALESCE(SUM(total_amount), 0) as revenue 
    FROM orders 
    WHERE DATE_FORMAT(start_date, '%Y-%m') = :month 
    AND status IN ('COMPLETED', 'RENTING')
";
$revenueStmt = $conn->prepare($revenueSql);
$revenueStmt->execute([':month' => $currentMonth]);
$monthlyRevenue = $revenueStmt->fetchColumn();

// Doanh thu tháng trước
$lastMonth = date('Y-m', strtotime('-1 month'));
$lastMonthSql = "
    SELECT COALESCE(SUM(total_amount), 0) as revenue 
    FROM orders 
    WHERE DATE_FORMAT(start_date, '%Y-%m') = :month 
    AND status IN ('COMPLETED', 'RENTING')
";
$lastMonthStmt = $conn->prepare($lastMonthSql);
$lastMonthStmt->execute([':month' => $lastMonth]);
$lastMonthRevenue = $lastMonthStmt->fetchColumn();

// Tính % tăng trưởng
$revenueGrowth = 0;
if ($lastMonthRevenue > 0) {
    $revenueGrowth = (($monthlyRevenue - $lastMonthRevenue) / $lastMonthRevenue) * 100;
}

// Format doanh thu (tỷ/triệu)
function formatRevenue($amount) {
    if ($amount >= 1000000000) {
        return number_format($amount / 1000000000, 1) . ' tỷ';
    } elseif ($amount >= 1000000) {
        return number_format($amount / 1000000, 0) . ' triệu';
    } else {
        return number_format($amount, 0);
    }
}

$revenueFormatted = formatRevenue($monthlyRevenue);

// Doanh thu theo tháng (12 tháng gần nhất)
$revenueByMonthSql = "
    SELECT 
        DATE_FORMAT(start_date, '%Y-%m') as month,
        COALESCE(SUM(total_amount), 0) / 1000000 as revenue_millions
    FROM orders
    WHERE start_date >= DATE_SUB(CURDATE(), INTERVAL 12 MONTH)
    AND status IN ('COMPLETED', 'RENTING')
    GROUP BY DATE_FORMAT(start_date, '%Y-%m')
    ORDER BY month ASC
";
$revenueByMonth = $conn->query($revenueByMonthSql)->fetchAll(PDO::FETCH_ASSOC);

// Tạo array 12 tháng
$months = [];
$revenues = [];
for ($i = 11; $i >= 0; $i--) {
    $monthKey = date('Y-m', strtotime("-$i months"));
    $monthLabel = 'T' . date('n', strtotime("-$i months"));
    $months[] = $monthLabel;
    
    // Tìm doanh thu tháng đó
    $found = false;
    foreach ($revenueByMonth as $data) {
        if ($data['month'] == $monthKey) {
            $revenues[] = round($data['revenue_millions'], 0);
            $found = true;
            break;
        }
    }
    if (!$found) {
        $revenues[] = 0;
    }
}

// Thống kê trạng thái đơn
$orderStatusSql = "
    SELECT 
        status,
        COUNT(*) as count
    FROM orders
    GROUP BY status
";
$orderStatus = $conn->query($orderStatusSql)->fetchAll(PDO::FETCH_KEY_PAIR);

$orderStatusData = [
    'NEW' => $orderStatus['NEW'] ?? 0,
    'RENTING' => $orderStatus['RENTING'] ?? 0,
    'WAITING_RETURN' => $orderStatus['WAITING_RETURN'] ?? 0,
    'COMPLETED' => $orderStatus['COMPLETED'] ?? 0,
    'CANCELLED' => $orderStatus['CANCELLED'] ?? 0
];

// Đơn đặt xe gần đây (top 3)
$recentOrdersSql = "
    SELECT 
        o.order_id,
        u.full_name as customer_name,
        v.vehicle_name,
        v.brand,
        v.model,
        o.status,
        DATEDIFF(o.end_date, o.start_date) as rental_days
    FROM orders o
    JOIN users u ON o.user_id = u.user_id
    JOIN vehicles v ON o.vehicle_id = v.vehicle_id
    ORDER BY o.created_at DESC
    LIMIT 3
";
$recentOrders = $conn->query($recentOrdersSql)->fetchAll(PDO::FETCH_ASSOC);

// Trạm hiệu suất cao (top 3)
$topStationsSql = "
    SELECT 
        s.station_name,
        s.address,
        COUNT(o.order_id) as total_orders,
        COALESCE(SUM(o.total_amount), 0) as total_revenue
    FROM stations s
    LEFT JOIN vehicles v ON s.station_id = v.station_id
    LEFT JOIN orders o ON v.vehicle_id = o.vehicle_id 
        AND DATE_FORMAT(o.start_date, '%Y-%m') = :month
        AND o.status IN ('COMPLETED', 'RENTING')
    GROUP BY s.station_id, s.station_name, s.address
    HAVING total_orders > 0
    ORDER BY total_revenue DESC
    LIMIT 3
";
$topStationsStmt = $conn->prepare($topStationsSql);
$topStationsStmt->execute([':month' => $currentMonth]);
$topStations = $topStationsStmt->fetchAll(PDO::FETCH_ASSOC);

// Cảnh báo hệ thống
$maintenanceVehiclesSql = "SELECT COUNT(*) FROM vehicles WHERE status = 'MAINTENANCE'";
$maintenanceVehicles = $conn->query($maintenanceVehiclesSql)->fetchColumn();

$pendingPaymentsSql = "SELECT COUNT(*) FROM orders WHERE status = 'NEW'";
$pendingPayments = $conn->query($pendingPaymentsSql)->fetchColumn();

// Kiểm tra xem bảng reviews có tồn tại không
try {
    $pendingReviewsSql = "SELECT COUNT(*) FROM reviews WHERE status = 'PENDING'";
    $pendingReviews = $conn->query($pendingReviewsSql)->fetchColumn();
} catch (PDOException $e) {
    // Bảng reviews chưa tồn tại, set về 0
    $pendingReviews = 0;
}

// Helper functions cho status label
function getOrderStatusLabel($status) {
    $labels = [
        'NEW' => ['text' => 'Đơn mới', 'class' => 'bg-blue-100 text-blue-700'],
        'RENTING' => ['text' => 'Đang thuê', 'class' => 'bg-green-100 text-green-700'],
        'WAITING_RETURN' => ['text' => 'Chờ trả', 'class' => 'bg-yellow-100 text-yellow-700'],
        'COMPLETED' => ['text' => 'Hoàn thành', 'class' => 'bg-gray-100 text-gray-700'],
        'CANCELLED' => ['text' => 'Đã hủy', 'class' => 'bg-red-100 text-red-700']
    ];
    return $labels[$status] ?? ['text' => $status, 'class' => 'bg-gray-100 text-gray-700'];
}
