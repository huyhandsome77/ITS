<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/ITS/config/Connect_DB.php';

// Lấy danh sách trạm kèm số lượng xe
$stmt = $conn->prepare("
    SELECT 
        s.station_id,
        s.station_name,
        s.address,
        s.city,
        s.district,
        COUNT(CASE WHEN v.vehicle_type = 'Oto' AND v.status = 'AVAILABLE' THEN 1 END) as car_count,
        COUNT(CASE WHEN v.vehicle_type = 'Xemay' AND v.status = 'AVAILABLE' THEN 1 END) as bike_count
    FROM stations s
    LEFT JOIN vehicles v ON s.station_id = v.station_id
    WHERE s.is_maintenance = 0
    GROUP BY s.station_id, s.station_name, s.address, s.city, s.district
    ORDER BY s.city, s.district, s.station_name
");
$stmt->execute();
$stations = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!-- Hidden data cards cho JavaScript đọc -->
<div id="stationDataSource" class="hidden">
    <?php foreach ($stations as $s): ?>
    <div class="station-card" data-id="<?= htmlspecialchars($s['station_id']) ?>"
        data-name="<?= htmlspecialchars($s['station_name']) ?>" data-city="<?= htmlspecialchars($s['city']) ?>"
        data-district="<?= htmlspecialchars($s['district']) ?>" data-address="<?= htmlspecialchars($s['address']) ?>"
        data-cars="<?= htmlspecialchars($s['car_count']) ?>" data-bikes="<?= htmlspecialchars($s['bike_count']) ?>">
    </div>
    <?php endforeach; ?>
</div>