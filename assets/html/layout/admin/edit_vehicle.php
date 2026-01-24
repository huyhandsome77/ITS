<!doctype html>
<html lang="vi" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chỉnh sửa phương tiện | Admin</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="../../../css/style.css">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<?php
$baseUrl = '../../../..';
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/ITS/config/Connect_DB.php';

// Lấy ID từ URL
$vehicle_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if (!$vehicle_id) {
    header('Location: manage_vehicles.php');
    exit;
}

// Lấy thông tin xe
$sql = "
    SELECT v.*, s.station_name
    FROM vehicles v
    LEFT JOIN stations s ON v.station_id = s.station_id
    WHERE v.vehicle_id = :id
";
$stmt = $conn->prepare($sql);
$stmt->execute([':id' => $vehicle_id]);
$vehicle = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$vehicle) {
    header('Location: manage_vehicles.php');
    exit;
}

// Lấy danh sách trạm
$stationsSql = "SELECT station_id, station_name FROM stations WHERE status = 'ACTIVE' ORDER BY station_name";
$stationsStmt = $conn->prepare($stationsSql);
$stationsStmt->execute();
$stations = $stationsStmt->fetchAll();
?>

<body class="min-h-full font-[Inter]">
    <div id="app" class="flex min-h-screen">

        <?php include '../../../includes/admin_sidebar.php'; ?>

        <div id="contentWrapper" class="flex-1 flex flex-col min-h-screen transition-all duration-300">

            <?php include '../../../includes/admin_navbar.php'; ?>

            <!-- ================= MAIN ================= -->
            <main class="flex-1 overflow-auto p-4 md:p-6 lg:p-8" style="margin-top:76px">

                <!-- Header Section -->
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h1 class="text-3xl font-bold" style="color: var(--primary-color);">CHỈNH SỬA PHƯƠNG TIỆN</h1>
                        <p class="text-gray-600 mt-2">Cập nhật thông tin xe #<?= $vehicle_id ?></p>
                    </div>
                    <a href="manage_vehicles.php" class="px-6 py-3 border rounded-lg hover:bg-gray-50">
                        <svg class="w-5 h-5 inline-block mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                        </svg>
                        Quay lại
                    </a>
                </div>

                <!-- Form Section -->
                <section class="bg-white rounded-2xl shadow-sm border p-8 max-w-4xl">
                    <form id="editVehicleForm" method="POST" action="/ITS/assets/php/admin/update_vehicle.php" enctype="multipart/form-data">
                        <input type="hidden" name="vehicle_id" value="<?= $vehicle_id ?>">

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Tên xe -->
                            <div class="md:col-span-2">
                                <label class="block text-sm font-semibold mb-2">Tên xe *</label>
                                <input type="text" name="vehicle_name" required 
                                    value="<?= htmlspecialchars($vehicle['vehicle_name']) ?>"
                                    class="w-full border rounded-lg px-4 py-2">
                            </div>

                            <!-- Trạm -->
                            <div>
                                <label class="block text-sm font-semibold mb-2">Trạm *</label>
                                <select name="station_id" required class="w-full border rounded-lg px-4 py-2">
                                    <option value="">Chọn trạm</option>
                                    <?php foreach ($stations as $st): ?>
                                        <option value="<?= $st['station_id'] ?>" 
                                            <?= $vehicle['station_id'] == $st['station_id'] ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($st['station_name']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <!-- Biển số -->
                            <div>
                                <label class="block text-sm font-semibold mb-2">Biển số xe *</label>
                                <input type="text" name="license_plate" required 
                                    value="<?= htmlspecialchars($vehicle['license_plate']) ?>"
                                    class="w-full border rounded-lg px-4 py-2 uppercase">
                            </div>

                            <!-- Loại xe -->
                            <div>
                                <label class="block text-sm font-semibold mb-2">Loại xe *</label>
                                <select name="vehicle_type" required class="w-full border rounded-lg px-4 py-2">
                                    <option value="Oto" <?= $vehicle['vehicle_type'] == 'Oto' ? 'selected' : '' ?>>Ô tô</option>
                                    <option value="Xemay" <?= $vehicle['vehicle_type'] == 'Xemay' ? 'selected' : '' ?>>Xe máy</option>
                                </select>
                            </div>

                            <!-- Hãng -->
                            <div>
                                <label class="block text-sm font-semibold mb-2">Hãng xe *</label>
                                <input type="text" name="brand" required 
                                    value="<?= htmlspecialchars($vehicle['brand']) ?>"
                                    class="w-full border rounded-lg px-4 py-2">
                            </div>

                            <!-- Model -->
                            <div>
                                <label class="block text-sm font-semibold mb-2">Model</label>
                                <input type="text" name="model" 
                                    value="<?= htmlspecialchars($vehicle['model'] ?? '') ?>"
                                    class="w-full border rounded-lg px-4 py-2">
                            </div>

                            <!-- Năm sản xuất -->
                            <div>
                                <label class="block text-sm font-semibold mb-2">Năm sản xuất</label>
                                <input type="number" name="year" min="1990" max="2030"
                                    value="<?= $vehicle['year'] ?? '' ?>"
                                    class="w-full border rounded-lg px-4 py-2">
                            </div>

                            <!-- Số chỗ ngồi -->
                            <div>
                                <label class="block text-sm font-semibold mb-2">Số chỗ ngồi</label>
                                <input type="number" name="seats" min="1" max="50"
                                    value="<?= $vehicle['seats'] ?? '' ?>"
                                    class="w-full border rounded-lg px-4 py-2">
                            </div>

                            <!-- Giá thuê/ngày -->
                            <div>
                                <label class="block text-sm font-semibold mb-2">Giá thuê/ngày (VNĐ) *</label>
                                <input type="number" name="price_per_day" required min="0"
                                    value="<?= $vehicle['price_per_day'] ?>"
                                    class="w-full border rounded-lg px-4 py-2">
                            </div>

                            <!-- Giá thuê/giờ -->
                            <div>
                                <label class="block text-sm font-semibold mb-2">Giá thuê/giờ (VNĐ)</label>
                                <input type="number" name="price_per_hour" min="0"
                                    value="<?= $vehicle['price_per_hour'] ?? '' ?>"
                                    class="w-full border rounded-lg px-4 py-2">
                            </div>

                            <!-- Trạng thái -->
                            <div>
                                <label class="block text-sm font-semibold mb-2">Trạng thái *</label>
                                <select name="status" required class="w-full border rounded-lg px-4 py-2">
                                    <option value="AVAILABLE" <?= $vehicle['status'] == 'AVAILABLE' ? 'selected' : '' ?>>Sẵn sàng</option>
                                    <option value="RENTED" <?= $vehicle['status'] == 'RENTED' ? 'selected' : '' ?>>Đang thuê</option>
                                    <option value="MAINTENANCE" <?= $vehicle['status'] == 'MAINTENANCE' ? 'selected' : '' ?>>Bảo trì</option>
                                </select>
                            </div>

                            <!-- Ảnh hiện tại -->
                            <?php if ($vehicle['image']): ?>
                            <div class="md:col-span-2">
                                <label class="block text-sm font-semibold mb-2">Ảnh hiện tại</label>
                                <img src="/ITS/assets/img/vehicles/<?= htmlspecialchars($vehicle['image']) ?>" 
                                    alt="Vehicle Image" class="w-48 h-32 object-cover rounded-lg border">
                            </div>
                            <?php endif; ?>

                            <!-- Upload ảnh mới -->
                            <div class="md:col-span-2">
                                <label class="block text-sm font-semibold mb-2">Thay đổi ảnh (tùy chọn)</label>
                                <input type="file" name="image" accept="image/*"
                                    class="w-full border rounded-lg px-4 py-2">
                            </div>

                            <!-- Mô tả -->
                            <div class="md:col-span-2">
                                <label class="block text-sm font-semibold mb-2">Mô tả</label>
                                <textarea name="description" rows="4" 
                                    class="w-full border rounded-lg px-4 py-2"><?= htmlspecialchars($vehicle['description'] ?? '') ?></textarea>
                            </div>
                        </div>

                        <!-- Buttons -->
                        <div class="flex justify-end space-x-3 mt-8">
                            <a href="manage_vehicles.php" class="px-6 py-2 border rounded-lg hover:bg-gray-50">
                                Hủy
                            </a>
                            <button type="submit" class="px-6 py-2 rounded-lg text-white font-semibold"
                                style="background: var(--primary-color);">
                                Lưu thay đổi
                            </button>
                        </div>
                    </form>
                </section>

            </main>

            <?php include '../../../includes/footer.php'; ?>
        </div>
    </div>

    <script src="../../../js/main.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
    document.getElementById('editVehicleForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        Swal.fire({
            title: 'Xác nhận',
            text: 'Bạn có chắc muốn lưu thay đổi?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Lưu',
            cancelButtonText: 'Hủy'
        }).then((result) => {
            if (result.isConfirmed) {
                const formData = new FormData(this);
                
                fetch('/ITS/assets/php/admin/update_vehicle.php', {
                    method: 'POST',
                    body: formData
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Thành công',
                            text: data.message,
                            timer: 1500,
                            showConfirmButton: false
                        }).then(() => {
                            window.location.href = 'manage_vehicles.php';
                        });
                    } else {
                        Swal.fire('Lỗi', data.message, 'error');
                    }
                })
                .catch(error => {
                    Swal.fire('Lỗi', 'Đã xảy ra lỗi khi cập nhật', 'error');
                });
            }
        });
    });
    </script>
    
    <?php if (isset($_SESSION['swal'])): ?>
    <script>
    Swal.fire({
        icon: '<?= $_SESSION['swal']['type'] ?>',
        title: '<?= $_SESSION['swal']['title'] ?>',
        text: '<?= $_SESSION['swal']['text'] ?>',
        confirmButtonText: 'OK'
    });
    </script>
    <?php unset($_SESSION['swal']); endif; ?>
</body>

</html>
