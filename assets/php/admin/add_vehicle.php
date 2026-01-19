<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/ITS/config/Connect_DB.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /ITS/assets/html/layout/admin/manage_vehicles.php');
    exit;
}

try {
    // Lấy dữ liệu từ form
    $station_id = trim($_POST['station_id']);
    $vehicle_name = trim($_POST['vehicle_name']);
    $license_plate = strtoupper(trim($_POST['license_plate']));
    $vehicle_type = trim($_POST['vehicle_type']);
    $brand = trim($_POST['brand']);
    $model = trim($_POST['model']);
    $year = (int)$_POST['year'];
    $seats = (int)$_POST['seats'];
    $price_per_day = (float)$_POST['price_per_day'];
    $description = trim($_POST['description'] ?? '');
    $status = trim($_POST['status']);

    // Validate dữ liệu
    if (empty($vehicle_name) || empty($license_plate) || empty($vehicle_type) || empty($brand)) {
        throw new Exception('Vui lòng điền đầy đủ thông tin bắt buộc');
    }

    // Kiểm tra biển số đã tồn tại
    $checkSql = "SELECT COUNT(*) FROM vehicles WHERE license_plate = :license_plate";
    $checkStmt = $conn->prepare($checkSql);
    $checkStmt->execute([':license_plate' => $license_plate]);
    if ($checkStmt->fetchColumn() > 0) {
        throw new Exception('Biển số xe đã tồn tại trong hệ thống');
    }

    // Xử lý upload ảnh
    $imageName = null;
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/ITS/assets/img/vehicles/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $imageName = uniqid('vehicle_') . '.' . $ext;
        $uploadPath = $uploadDir . $imageName;

        if (!move_uploaded_file($_FILES['image']['tmp_name'], $uploadPath)) {
            throw new Exception('Không thể tải lên ảnh xe');
        }
    }

    // Lấy price_per_hour (mặc định = price_per_day / 8)
    $price_per_hour = (float)$_POST['price_per_hour'] ?? ($price_per_day / 8);

    // Thêm xe vào database
    $sql = "
        INSERT INTO vehicles (
            station_id, vehicle_name, license_plate, vehicle_type, 
            brand, model, year, seats, price_per_day, price_per_hour,
            description, status, image
        ) VALUES (
            :station_id, :vehicle_name, :license_plate, :vehicle_type,
            :brand, :model, :year, :seats, :price_per_day, :price_per_hour,
            :description, :status, :image
        )
    ";

    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':station_id' => $station_id,
        ':vehicle_name' => $vehicle_name,
        ':license_plate' => $license_plate,
        ':vehicle_type' => $vehicle_type,
        ':brand' => $brand,
        ':model' => $model,
        ':year' => $year,
        ':seats' => $seats,
        ':price_per_day' => $price_per_day,
        ':price_per_hour' => $price_per_hour,
        ':description' => $description,
        ':status' => $status,
        ':image' => $imageName
    ]);

    $_SESSION['swal'] = [
        'type' => 'success',
        'title' => 'Thành công',
        'text' => 'Thêm phương tiện mới thành công'
    ];

} catch (Exception $e) {
    $_SESSION['swal'] = [
        'type' => 'error',
        'title' => 'Lỗi',
        'text' => $e->getMessage()
    ];
}

header('Location: /ITS/assets/html/layout/admin/manage_vehicles.php');
exit;
