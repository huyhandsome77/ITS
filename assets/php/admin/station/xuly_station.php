<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/ITS/config/Connect_DB.php';

/* ================== THỐNG KÊ ================== */

// Tổng số trạm
$totalStations = $conn->query("
    SELECT COUNT(*) FROM stations
")->fetchColumn();

// Trạm bảo trì
$stationsMaintenance = $conn->query("
    SELECT COUNT(*) FROM stations
    WHERE is_maintenance = TRUE
")->fetchColumn();

// Trạm có xe (không tính trạm bảo trì)
$stationsHaveVehicles = $conn->query("
    SELECT COUNT(DISTINCT s.station_id)
    FROM stations s
    JOIN vehicles v ON s.station_id = v.station_id
    WHERE s.is_maintenance = FALSE
")->fetchColumn();

// Trạm trống (không bảo trì & không có xe)
$stationsEmpty = $totalStations - $stationsHaveVehicles - $stationsMaintenance;


/* ================== DANH SÁCH TRẠM ================== */

$stations = $conn->query("
    SELECT 
        s.station_id,
        s.station_name,
        s.address,
        s.is_maintenance,

        SUM(CASE WHEN v.vehicle_type = 'Xemay' THEN 1 ELSE 0 END) AS total_bikes,
        SUM(CASE WHEN v.vehicle_type = 'Oto' THEN 1 ELSE 0 END) AS total_cars,
        COUNT(v.vehicle_id) AS total_vehicles

    FROM stations s
    LEFT JOIN vehicles v 
        ON s.station_id = v.station_id

    GROUP BY 
        s.station_id,
        s.station_name,
        s.address,
        s.is_maintenance

    ORDER BY s.created_at DESC
")->fetchAll();