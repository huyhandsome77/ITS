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

    // Filter by Status (Mapping result_code)
    // 0 = Success, != 0 = Fail/Pending? 
    // For simplicity: 0 is Completed. Others Failed. 
    // If pending is needed, we might need to check standard MoMo codes (e.g. 1000, 9000).
    // Assuming 0 is SUCCESS.
    if ($status) {
        if ($status === 'completed') {
            $where[] = "pt.result_code = 0";
        } elseif ($status === 'failed') {
            $where[] = "pt.result_code != 0";
        }
        // Add more logic if we have specific codes for pending
    }

    $whereSql = implode(' AND ', $where);

    // 2. Stats Query
    // Total Revenue (Only success)
    $stmtRevenue = $conn->prepare("SELECT SUM(amount) FROM payment_transactions pt WHERE result_code = 0");
    $stmtRevenue->execute();
    $totalRevenue = $stmtRevenue->fetchColumn() ?: 0;

    // Total Transactions
    $stmtTotal = $conn->prepare("SELECT COUNT(*) FROM payment_transactions pt WHERE 1=1"); // Total count, filtered or unfiltered? Usually stats are overall.
    $stmtTotal->execute();
    $totalTransactions = $stmtTotal->fetchColumn();

    // Today's Transactions
    $stmtToday = $conn->prepare("SELECT COUNT(*) FROM payment_transactions WHERE DATE(created_at) = CURDATE()");
    $stmtToday->execute();
    $todayTransactions = $stmtToday->fetchColumn();

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
            o.order_id
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
            'today_transactions' => $todayTransactions
        ]
    ]);

} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
