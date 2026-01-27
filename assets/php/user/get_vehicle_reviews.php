<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/ITS/config/Connect_DB.php';

header('Content-Type: application/json');

$vehicleId = $_GET['vehicle_id'] ?? null;

if (!$vehicleId) {
    echo json_encode(['success' => false, 'message' => 'Vehicle ID is required']);
    exit;
}

try {
    // Check if vehicle exists
    $stmtCheck = $conn->prepare("SELECT vehicle_name FROM vehicles WHERE vehicle_id = :vehicle_id");
    $stmtCheck->execute([':vehicle_id' => $vehicleId]);
    $vehicle = $stmtCheck->fetch();

    if (!$vehicle) {
        echo json_encode(['success' => false, 'message' => 'Vehicle not found']);
        exit;
    }

    // Get reviews
    $sql = "
        SELECT 
            r.rating,
            r.comment,
            r.created_at,
            u.full_name,
            u.avatar
        FROM reviews r
        JOIN orders o ON r.order_id = o.order_id
        JOIN users u ON r.user_id = u.user_id
        WHERE o.vehicle_id = :vehicle_id 
          AND r.review_type = 'VEHICLE' 
          AND r.status = 'APPROVED'
        ORDER BY r.created_at DESC
        LIMIT 20
    ";

    $stmt = $conn->prepare($sql);
    $stmt->execute([':vehicle_id' => $vehicleId]);
    $reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Calculate average rating
    $sqlAvg = "
        SELECT AVG(rating) as avg_rating, COUNT(*) as total_reviews
        FROM reviews r
        JOIN orders o ON r.order_id = o.order_id
        WHERE o.vehicle_id = :vehicle_id 
          AND r.review_type = 'VEHICLE' 
          AND r.status = 'APPROVED'
    ";
    $stmtAvg = $conn->prepare($sqlAvg);
    $stmtAvg->execute([':vehicle_id' => $vehicleId]);
    $stats = $stmtAvg->fetch(PDO::FETCH_ASSOC);

    echo json_encode([
        'success' => true,
        'data' => [
            'reviews' => $reviews,
            'vehicle_name' => $vehicle['vehicle_name'],
            'avg_rating' => round($stats['avg_rating'], 1),
            'total_reviews' => $stats['total_reviews']
        ]
    ]);

} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
}
