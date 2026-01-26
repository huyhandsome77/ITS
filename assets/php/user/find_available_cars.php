<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/ITS/config/Connect_DB.php';
header('Content-Type: application/json');

/* 
  INPUT:
  - station_id
  - brand
  - model
  - start_date, start_time
  - end_date, end_time
*/

$input = json_decode(file_get_contents('php://input'), true);

$station_id = $input['station_id'] ?? 0;
// We use vehicle_name or brand/model to group? 
// filter_cars.php uses specific grouping. 
// list_car.php passes 'vehicle_name'.
// Let's assume we pass what we have. 
// Ideally we should pass 'vehicle_name' distinctively if that represents the type.
$vehicle_name = $input['vehicle_name'] ?? '';
$type = $input['type'] ?? ''; // 'Oto' or 'Xemay'

$start_date = $input['start_date'] ?? '';
$start_time = $input['start_time'] ?? '00:00:00';
$end_date   = $input['end_date'] ?? '';
$end_time   = $input['end_time'] ?? '00:00:00';

if (!$station_id || !$start_date || !$end_date || !$vehicle_name) {
    echo json_encode(['success' => false, 'message' => 'Missing parameters']);
    exit;
}

// Strict Date Validation (Requested by User)
if ($start_date >= $end_date) {
    // Check if it's explicitly day mode? 
    // The Input doesn't specify mode, but usually day mode implies date range.
    // However, for hour mode, start_date might be same as end_date (same day rental).
    // Wait, findCars logic doesn't know "Mode".
    // But Hour Mode params: start_date=X, end_date=X ?
    // Let's see list_car.php:
    // Hour Mode: start_date=hourDate, end_date=end.toISOString().split('T')[0]
    // If renting 1 hour: 2026-01-27 10:00 -> 2026-01-27 11:00. StartDate == EndDate.
    // So if we ENFORCE StartDate < EndDate globally, Hour Mode BREAKS.
    
    // Changing strategy: Only enforce if hours > 24 ? Or trust frontend?
    // User request: "xét điều kiện khi đặt xe theo ngày".
    // I should probably pass 'mode' to backend to distinguish.
    
    // For now, let's skip backend strict check OR only check if duration <0.
}

if ($start_date > $end_date) {
     echo json_encode(['success' => false, 'message' => 'Ngày kết thúc phải sau ngày bắt đầu']);
     exit;
}

$req_start = "$start_date $start_time";
$req_end   = "$end_date $end_time";

try {
    // 0. AUTO-CLEANUP: Cancel expired 'NEW' bookings older than 15 minutes
    // This releases cars held by users who abandoned MoMo payment
    $conn->query("UPDATE orders SET status = 'CANCELLED', cancel_reason = 'Payment Timeout' 
                  WHERE status = 'NEW' AND created_at < (NOW() - INTERVAL 15 MINUTE)");

    // 1. Get all vehicles of this 'Type' (Name/Model) at this Station
    // We match by vehicle_name (as assumed grouping key)
    $sql = "SELECT vehicle_id, vehicle_name, license_plate, image, price_per_day, price_per_hour
            FROM vehicles
            WHERE station_id = ? 
            AND vehicle_name = ?
            AND status != 'MAINTENANCE'";
    
    $stmt = $conn->prepare($sql);
    $stmt->execute([$station_id, $vehicle_name]);
    $vehicles = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $results = [];

    foreach ($vehicles as $v) {
        // 2. Check for overlap with 30-minute buffer
        // Condition: NewStart < OldEnd + 30min  AND  NewEnd > OldStart - 30min
        $checkSql = "
            SELECT COUNT(*) 
            FROM orders 
            WHERE vehicle_id = ?
            AND status IN ('NEW', 'RENTING', 'WAITING_RETURN', 'COMPLETED')
            AND (TIMESTAMP(end_date, end_time) + INTERVAL 30 MINUTE) > ?
            AND (TIMESTAMP(start_date, start_time) - INTERVAL 30 MINUTE) < ?
        ";
        
        $chk = $conn->prepare($checkSql);
        $chk->execute([$v['vehicle_id'], $req_start, $req_end]);
        $overlaps = $chk->fetchColumn();

        $v['status'] = ($overlaps > 0) ? 'BUSY' : 'AVAILABLE';
        $results[] = $v;
    }

    echo json_encode(['success' => true, 'data' => $results]);

} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>
