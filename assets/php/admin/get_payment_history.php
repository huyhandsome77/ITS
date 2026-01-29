<?php
require_once dirname(__DIR__, 3) . '/config/Connect_DB.php';

header('Content-Type: application/json');

try {
    // 1. Filter Parameters
    $status = $_GET['status'] ?? ''; // completed, failed, pending
    $method = $_GET['method'] ?? ''; // MOMO, CASH, etc.
    $fromDate = $_GET['from_date'] ?? '';
    $toDate = $_GET['to_date'] ?? '';
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $limit = 10;
    $offset = ($page - 1) * $limit;

    $where = ["1=1"];
    $params = [];

    // Filter by Method
    if ($method) {
        $where[] = "pt.payment_type = :method";
        $params[':method'] = $method;
    }

    // Filter by Date
    if ($fromDate) {
        $where[] = "DATE(pt.created_at) >= :from_date";
        $params[':from_date'] = $fromDate;
    }
    if ($toDate) {
        $where[] = "DATE(pt.created_at) <= :to_date";
        $params[':to_date'] = $toDate;
    }

    // Filter by Status (payment_status from orders table)
    // Filter by Status (based on transaction result_code)
    if ($status === 'success') {
        $where[] = "pt.result_code = 0";
    } elseif ($status === 'pending') {
        // Only show pending for CASH or where result_code is -1
        $where[] = "pt.result_code = -1";
    } elseif ($status === 'failed') {
        // Anything not 0 or -1 is considered failed
        $where[] = "pt.result_code NOT IN (0, -1)";
    }

    $whereSql = implode(' AND ', $where);

    // 2. Stats Query
    // Total Revenue (Only PAID orders)
    $stmtRevenue = $conn->prepare("
        SELECT SUM(o.total_amount) 
        FROM orders o 
        WHERE o.payment_status = 'PAID'
    ");
    $stmtRevenue->execute();
    $totalRevenue = $stmtRevenue->fetchColumn() ?: 0;

    // Total Orders
    $stmtTotal = $conn->prepare("SELECT COUNT(*) FROM orders");
    $stmtTotal->execute();
    $totalTransactions = $stmtTotal->fetchColumn();

    // Today's Orders
    $stmtToday = $conn->prepare("SELECT COUNT(*) FROM orders WHERE DATE(created_at) = CURDATE()");
    $stmtToday->execute();
    $todayTransactions = $stmtToday->fetchColumn();

    // UNPAID Orders
    $stmtUnpaid = $conn->prepare("SELECT COUNT(*) FROM orders WHERE payment_status = 'UNPAID'");
    $stmtUnpaid->execute();
    $unpaidOrders = $stmtUnpaid->fetchColumn();

    // REFUNDED Orders
    $stmtRefunded = $conn->prepare("SELECT COUNT(*) FROM orders WHERE payment_status = 'REFUNDED'");
    $stmtRefunded->execute();
    $refundedOrders = $stmtRefunded->fetchColumn();


    // 3. Data Query
    $sql = "
        SELECT 
            pt.transaction_id,
            pt.order_code,
            pt.payment_type,
            pt.amount,
            pt.trans_id,
            pt.result_code,
            pt.message,
            pt.created_at,
            u.full_name,
            u.phone,
            o.order_id,
            o.payment_status,
            o.payment_method
        FROM payment_transactions pt
        LEFT JOIN orders o ON pt.order_code COLLATE utf8mb4_unicode_ci = o.order_code
        LEFT JOIN users u ON o.user_id = u.user_id
        WHERE $whereSql
        ORDER BY pt.created_at DESC
        LIMIT :limit OFFSET :offset
    ";

    $stmt = $conn->prepare($sql);
    foreach ($params as $key => $value) {
        $stmt->bindValue($key, $value);
    }
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    $transactions = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // 4. Pagination Count
    $sqlCount = "SELECT COUNT(*) FROM payment_transactions pt WHERE $whereSql";
    $stmtCount = $conn->prepare($sqlCount);
    foreach ($params as $key => $value) {
        $stmtCount->bindValue($key, $value);
    }
    $stmtCount->execute();
    $filteredTotal = $stmtCount->fetchColumn();
    $totalPages = ceil($filteredTotal / $limit);

    // 5. Response
    echo json_encode([
        'success' => true,
        'data' => $transactions,
        'pagination' => [
            'page' => $page,
            'limit' => $limit,
            'total_pages' => $totalPages,
            'total_records' => $filteredTotal
        ],
        'stats' => [
            'total_revenue' => $totalRevenue,
            'total_transactions' => $totalTransactions,
            'today_transactions' => $todayTransactions,
            'unpaid_orders' => $unpaidOrders,
            'refunded_orders' => $refundedOrders
        ]
    ]);

} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
