<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/ITS/config/Connect_DB.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $_SESSION['swal'] = [
        'type' => 'error',
        'title' => 'Lỗi',
        'text' => 'Invalid request method'
    ];
    header('Location: /ITS/assets/html/layout/admin/manage_vehicles.php');
    exit;
}

try {
    $vehicle_id = (int)$_POST['vehicle_id'];
    $station_id = trim($_POST['station_id']);
    $vehicle_name = trim($_POST['vehicle_name']);
    $license_plate = strtoupper(trim($_POST['license_plate']));
    $vehicle_type = trim($_POST['vehicle_type']);
    $brand = trim($_POST['brand']);
    $model = trim($_POST['model']);
    $year = (int)$_POST['year'];
    $seats = (int)$_POST['seats'];
    $price_per_day = (float)$_POST['price_per_day'];
    $price_per_hour = (float)$_POST['price_per_hour'] ?? ($price_per_day / 8);
    $description = trim($_POST['description'] ?? '');
    $status = trim($_POST['status']);

    // Kiểm tra biển số trùng (trừ xe hiện tại)
    $checkSql = "SELECT COUNT(*) FROM vehicles WHERE license_plate = :license_plate AND vehicle_id != :vehicle_id";
    $checkStmt = $conn->prepare($checkSql);
    $checkStmt->execute([
        ':license_plate' => $license_plate,
        ':vehicle_id' => $vehicle_id
    ]);
    if ($checkStmt->fetchColumn() > 0) {
        throw new Exception('Biển số xe đã tồn tại');
    }

    // Xử lý upload ảnh mới (nếu có)
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
            throw new Exception('Không thể tải lên ảnh mới');
        }

        // Xóa ảnh cũ
        $oldImageSql = "SELECT image FROM vehicles WHERE vehicle_id = :id";
        $oldImageStmt = $conn->prepare($oldImageSql);
        $oldImageStmt->execute([':id' => $vehicle_id]);
        $oldImage = $oldImageStmt->fetchColumn();
        if ($oldImage && file_exists($uploadDir . $oldImage)) {
            unlink($uploadDir . $oldImage);
        }
    }

    // Update vehicle
    if ($imageName) {
        $sql = "
            UPDATE vehicles SET
                station_id = :station_id,
                vehicle_name = :vehicle_name,
                license_plate = :license_plate,
                vehicle_type = :vehicle_type,
                brand = :brand,
                model = :model,
                year = :year,
                seats = :seats,
                price_per_day = :price_per_day,
                price_per_hour = :price_per_hour,
                description = :description,
                status = :status,
                image = :image
            WHERE vehicle_id = :vehicle_id
        ";
        $params = [
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
            ':image' => $imageName,
            ':vehicle_id' => $vehicle_id
        ];
    } else {
        $sql = "
            UPDATE vehicles SET
                station_id = :station_id,
                vehicle_name = :vehicle_name,
                license_plate = :license_plate,
                vehicle_type = :vehicle_type,
                brand = :brand,
                model = :model,
                year = :year,
                seats = :seats,
                price_per_day = :price_per_day,
                price_per_hour = :price_per_hour,
                description = :description,
                status = :status
            WHERE vehicle_id = :vehicle_id
        ";
        $params = [
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
            ':vehicle_id' => $vehicle_id
        ];
    }

    $stmt = $conn->prepare($sql);
    $stmt->execute($params);

    $_SESSION['swal'] = [
        'type' => 'success',
        'title' => 'Thành công',
        'text' => 'Cập nhật phương tiện thành công'
    ];
    header('Location: /ITS/assets/html/layout/admin/manage_vehicles.php');
    exit;

} catch (Exception $e) {
    $_SESSION['swal'] = [
        'type' => 'error',
        'title' => 'Lỗi',
        'text' => $e->getMessage()
    ];
    header('Location: /ITS/assets/html/layout/admin/manage_vehicles.php');
    exit;
}
