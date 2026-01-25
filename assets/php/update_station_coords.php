<?php
require_once '../../config/Connect_DB.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? null;
    $lat = $_POST['lat'] ?? null;
    $lng = $_POST['lng'] ?? null;

    if ($id && $lat && $lng) {
        try {
            $stmt = $conn->prepare("UPDATE stations SET latitude = ?, longitude = ? WHERE station_id = ?");
            $success = $stmt->execute([$lat, $lng, $id]);
            
            if ($success) {
                echo json_encode(['status' => 'success', 'message' => 'Updated successfully']);
            } else {
                http_response_code(500);
                echo json_encode(['status' => 'error', 'message' => 'Database update failed']);
            }
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
    } else {
        http_response_code(400);
        echo json_encode(['status' => 'error', 'message' => 'Missing parameters']);
    }
} else {
    http_response_code(405);
    echo json_encode(['status' => 'error', 'message' => 'Method not allowed']);
}
?>
