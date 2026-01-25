<!doctype html>
<html lang="vi" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý phương tiện | Admin</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="../../../css/style.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<?php 
$baseUrl = '../../../..'; 
?>
<?php include '../../../php/admin/xuly_vehicle.php'; ?>

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
                        <h1 class="text-3xl font-bold" style="color: var(--primary-color);">QUẢN LÝ PHƯƠNG TIỆN</h1>
                    </div>
                    <button id="btnAddVehicle"
                        class="btn-primary px-6 py-3 rounded-lg font-bold text-sm lg:text-base shadow-lg text-white"
                        style="background: var(--sidebar-gradient);">
                        <svg class="w-6 h-6 inline-block mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"
                                clip-rule="evenodd" />
                        </svg>
                        Thêm xe mới
                    </button>
                </div>

                <!-- Statistics Cards -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                    <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl shadow-lg p-6 text-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-blue-100 text-sm">Tổng số xe</p>
                                <h3 class="text-3xl font-bold mt-1"><?= number_format($totalVehicles) ?></h3>
                            </div>
                            <div class="bg-white bg-opacity-20 p-3 rounded-lg">
                                <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z" />
                                    <path
                                        d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1v-5a1 1 0 00-.293-.707l-2-2A1 1 0 0015 7h-1z" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-2xl shadow-lg p-6 text-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-green-100 text-sm">Sẵn sàng</p>
                                <h3 class="text-3xl font-bold mt-1"><?= number_format($availableVehicles) ?></h3>
                            </div>
                            <div class="bg-white bg-opacity-20 p-3 rounded-lg">
                                <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-2xl shadow-lg p-6 text-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-yellow-100 text-sm">Đang thuê</p>
                                <h3 class="text-3xl font-bold mt-1"><?= number_format($rentedVehicles) ?></h3>
                            </div>
                            <div class="bg-white bg-opacity-20 p-3 rounded-lg">
                                <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-2xl shadow-lg p-6 text-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-orange-100 text-sm">Bảo trì</p>
                                <h3 class="text-3xl font-bold mt-1"><?= number_format($maintenanceVehicles) ?></h3>
                            </div>
                            <div class="bg-white bg-opacity-20 p-3 rounded-lg">
                                <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Filter Section -->
                <form method="GET">
                    <section class="bg-white rounded-2xl shadow-sm border p-5 mb-6">
                        <h2 class="text-lg font-semibold mb-4">Bộ lọc</h2>
                        <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                            <select name="station" class="border rounded-lg px-4 py-2">
                                <option value="">Tất cả trạm</option>
                                <?php foreach ($stations as $st): ?>
                                    <option value="<?= $st['station_id'] ?>" 
                                        <?= ($_GET['station'] ?? '') == $st['station_id'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($st['station_name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>

                            <select name="vehicle_type" class="border rounded-lg px-4 py-2">
                                <option value="">Tất cả loại xe</option>
                                <option value="Oto" <?= ($_GET['vehicle_type'] ?? '') == 'Oto' ? 'selected' : '' ?>>Ô tô</option>
                                <option value="Xemay" <?= ($_GET['vehicle_type'] ?? '') == 'Xemay' ? 'selected' : '' ?>>Xe máy</option>
                            </select>

                            <select name="brand" class="border rounded-lg px-4 py-2">
                                <option value="">Tất cả hãng</option>
                                <option value="Toyota" <?= ($_GET['brand'] ?? '') == 'Toyota' ? 'selected' : '' ?>>Toyota</option>
                                <option value="Honda" <?= ($_GET['brand'] ?? '') == 'Honda' ? 'selected' : '' ?>>Honda</option>
                                <option value="Mazda" <?= ($_GET['brand'] ?? '') == 'Mazda' ? 'selected' : '' ?>>Mazda</option>
                                <option value="Ford" <?= ($_GET['brand'] ?? '') == 'Ford' ? 'selected' : '' ?>>Ford</option>
                                <option value="Yamaha" <?= ($_GET['brand'] ?? '') == 'Yamaha' ? 'selected' : '' ?>>Yamaha</option>
                            </select>

                            <select name="status" class="border rounded-lg px-4 py-2">
                                <option value="">Tất cả trạng thái</option>
                                <option value="AVAILABLE" <?= ($_GET['status'] ?? '') == 'AVAILABLE' ? 'selected' : '' ?>>Sẵn sàng</option>
                                <option value="RENTED" <?= ($_GET['status'] ?? '') == 'RENTED' ? 'selected' : '' ?>>Đang thuê</option>
                                <option value="MAINTENANCE" <?= ($_GET['status'] ?? '') == 'MAINTENANCE' ? 'selected' : '' ?>>Bảo trì</option>
                            </select>

                            <button type="submit" class="px-6 py-2 rounded-lg font-semibold text-white"
                                style="background: var(--primary-color);">
                                <svg class="w-5 h-5 inline-block mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                        clip-rule="evenodd" />
                                </svg>
                                Lọc
                            </button>
                        </div>
                    </section>
                </form>

                <!-- Vehicle List -->
                <section class="bg-white rounded-2xl shadow-sm border p-5">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-lg font-semibold">Danh sách phương tiện</h2>
                        <span class="text-gray-600">Tổng số: <strong id="totalVehicles"><?= number_format($filteredTotal) ?></strong> xe</span>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-50 border-b">
                                <tr>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">ID</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Tên xe</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Biển số</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Loại</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Hãng</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Model</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Năm</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Trạm</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Giá/ngày</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Trạng thái</th>
                                    <th class="px-4 py-3 text-center text-sm font-semibold text-gray-700">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody id="vehicleTableBody" class="divide-y">
                                <?php if (empty($vehicles)): ?>
                                <tr>
                                    <td colspan="11" class="px-4 py-8 text-center text-gray-500">
                                        Không có phương tiện nào
                                    </td>
                                </tr>
                                <?php else: ?>
                                <?php foreach ($vehicles as $vehicle): 
                                    [$typeText, $typeClass] = vehicleTypeLabel($vehicle['vehicle_type']);
                                    [$statusText, $statusClass] = vehicleStatusLabel($vehicle['status']);
                                ?>
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3 text-sm">#<?= $vehicle['vehicle_id'] ?></td>
                                    <td class="px-4 py-3 text-sm font-semibold"><?= htmlspecialchars($vehicle['vehicle_name']) ?></td>
                                    <td class="px-4 py-3 text-sm font-mono"><?= htmlspecialchars($vehicle['license_plate']) ?></td>
                                    <td class="px-4 py-3">
                                        <span class="whitespace-nowrap overflow-hidden px-2 py-1 rounded-full text-xs font-semibold <?= $typeClass ?>">
                                            <?= $typeText ?>
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-sm"><?= htmlspecialchars($vehicle['brand'] ?? '—') ?></td>
                                    <td class="px-4 py-3 text-sm"><?= htmlspecialchars($vehicle['model'] ?? '—') ?></td>
                                    <td class="px-4 py-3 text-sm"><?= $vehicle['year'] ?? '—' ?></td>
                                    <td class="px-4 py-3 text-sm"><?= htmlspecialchars($vehicle['station_name'] ?? 'Chưa có') ?></td>
                                    <td class="px-4 py-3 text-sm font-semibold"><?= number_format($vehicle['price_per_day']) ?>đ</td>
                                    <td class="px-4 py-3">
                                        <span class="whitespace-nowrap overflow-hidden px-3 py-1 rounded-full text-xs font-semibold <?= $statusClass ?>">
                                            <?= $statusText ?>
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <button class="text-blue-600 hover:text-blue-800 mx-1" 
                                            onclick="viewVehicle(<?= $vehicle['vehicle_id'] ?>)" title="Xem chi tiết">
                                            <svg class="w-5 h-5 inline-block" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                                <path fill-rule="evenodd"
                                                    d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                        <button class="text-yellow-600 hover:text-yellow-800 mx-1" 
                                            onclick="editVehicle(<?= $vehicle['vehicle_id'] ?>)" title="Chỉnh sửa">
                                            <svg class="w-5 h-5 inline-block" fill="currentColor" viewBox="0 0 20 20">
                                                <path
                                                    d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                            </svg>
                                        </button>
                                        <button class="text-red-600 hover:text-red-800 mx-1" 
                                            onclick="deleteVehicle(<?= $vehicle['vehicle_id'] ?>)" title="Xóa">
                                            <svg class="w-5 h-5 inline-block" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="flex justify-between items-center mt-4">
                        <span class="text-sm text-gray-600">
                            Hiển thị <?= $from ?>–<?= $to ?> của <?= number_format($filteredTotal) ?> xe
                        </span>
                        <div class="flex space-x-2">
                            <a href="?page=<?= max(1, $page - 1) ?><?= http_build_query(array_filter($_GET, fn($k) => $k != 'page', ARRAY_FILTER_USE_KEY)) ? '&' . http_build_query(array_filter($_GET, fn($k) => $k != 'page', ARRAY_FILTER_USE_KEY)) : '' ?>"
                                class="px-4 py-2 border rounded-lg <?= $page == 1 ? 'opacity-50 pointer-events-none' : 'hover:bg-gray-50' ?>">
                                Trước
                            </a>

                            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                            <a href="?page=<?= $i ?><?= http_build_query(array_filter($_GET, fn($k) => $k != 'page', ARRAY_FILTER_USE_KEY)) ? '&' . http_build_query(array_filter($_GET, fn($k) => $k != 'page', ARRAY_FILTER_USE_KEY)) : '' ?>" 
                                class="px-4 py-2 border rounded-lg <?= $i == $page ? 'text-white' : 'hover:bg-gray-50' ?>"
                                style="<?= $i == $page ? 'background: var(--primary-color);' : '' ?>">
                                <?= $i ?>
                            </a>
                            <?php endfor; ?>

                            <a href="?page=<?= min($totalPages, $page + 1) ?><?= http_build_query(array_filter($_GET, fn($k) => $k != 'page', ARRAY_FILTER_USE_KEY)) ? '&' . http_build_query(array_filter($_GET, fn($k) => $k != 'page', ARRAY_FILTER_USE_KEY)) : '' ?>"
                                class="px-4 py-2 border rounded-lg <?= $page == $totalPages ? 'opacity-50 pointer-events-none' : 'hover:bg-gray-50' ?>">
                                Sau
                            </a>
                        </div>
                    </div>
                </section>

            </main>

            <?php include '../../../includes/footer.php'; ?>
        </div>
    </div>

    <!-- Add/Edit Vehicle Modal -->
    <div id="vehicleModal" class="fixed inset-0 z-50 hidden overflow-y-auto bg-black bg-opacity-50">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div class="bg-white rounded-2xl shadow-xl max-w-2xl w-full p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-2xl font-bold" style="color: var(--primary-color);">Thêm xe mới</h3>
                    <button id="closeModal" class="text-gray-500 hover:text-gray-700">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>

                <form id="vehicleForm" method="POST" action="/ITS/assets/php/admin/add_vehicle.php" enctype="multipart/form-data" class="space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium mb-1">Tên xe *</label>
                            <input type="text" name="vehicle_name" required class="w-full border rounded-lg px-4 py-2" placeholder="Toyota Camry 2024">
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1">Trạm *</label>
                            <select name="station_id" required class="w-full border rounded-lg px-4 py-2">
                                <option value="">Chọn trạm</option>
                                <?php foreach ($stations as $st): ?>
                                    <option value="<?= $st['station_id'] ?>"><?= htmlspecialchars($st['station_name']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1">Biển số xe *</label>
                            <input type="text" name="license_plate" required class="w-full border rounded-lg px-4 py-2 uppercase" placeholder="51G-12345">
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1">Loại xe *</label>
                            <select name="vehicle_type" required class="w-full border rounded-lg px-4 py-2">
                                <option value="">Chọn loại</option>
                                <option value="Oto">Ô tô</option>
                                <option value="Xemay">Xe máy</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1">Hãng xe *</label>
                            <input type="text" name="brand" required class="w-full border rounded-lg px-4 py-2" placeholder="Toyota, Honda...">
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1">Model</label>
                            <input type="text" name="model" class="w-full border rounded-lg px-4 py-2" placeholder="Camry">
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1">Năm sản xuất</label>
                            <input type="number" name="year" min="1990" max="2030" class="w-full border rounded-lg px-4 py-2" placeholder="2024">
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1">Số chỗ ngồi</label>
                            <input type="number" name="seats" min="1" max="50" class="w-full border rounded-lg px-4 py-2" placeholder="5">
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1">Giá thuê/ngày (VNĐ) *</label>
                            <input type="number" name="price_per_day" required min="0" class="w-full border rounded-lg px-4 py-2" placeholder="500000">
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1">Giá thuê/giờ (VNĐ)</label>
                            <input type="number" name="price_per_hour" min="0" class="w-full border rounded-lg px-4 py-2" placeholder="Tự động = giá ngày/8">
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1">Trạng thái *</label>
                            <select name="status" required class="w-full border rounded-lg px-4 py-2">
                                <option value="AVAILABLE">Sẵn sàng</option>
                                <option value="MAINTENANCE">Bảo trì</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1">Ảnh xe</label>
                            <input type="file" name="image" accept="image/*" class="w-full border rounded-lg px-4 py-2">
                        </div>
                        <div class="col-span-2">
                            <label class="block text-sm font-medium mb-1">Mô tả</label>
                            <textarea name="description" rows="2" class="w-full border rounded-lg px-4 py-2" placeholder="Thông tin thêm về xe..."></textarea>
                        </div>
                    </div>

                    <div class="flex justify-end space-x-3 mt-6">
                        <button type="button" id="cancelBtn" class="px-6 py-2 border rounded-lg hover:bg-gray-50">
                            Hủy
                        </button>
                        <button type="submit" class="px-6 py-2 rounded-lg text-white font-semibold"
                            style="background: var(--primary-color);">
                            Lưu
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Vehicle Modal -->
    <div id="editVehicleModal" class="fixed inset-0 z-50 hidden overflow-y-auto bg-black bg-opacity-50">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div class="bg-white rounded-2xl shadow-xl max-w-2xl w-full p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-2xl font-bold" style="color: var(--primary-color);">Chỉnh sửa phương tiện</h3>
                    <button id="closeEditModal" class="text-gray-500 hover:text-gray-700">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>

                <form id="editVehicleForm" method="POST" action="/ITS/assets/php/admin/update_vehicle.php" enctype="multipart/form-data" class="space-y-4">
                    <input type="hidden" name="vehicle_id" id="edit_vehicle_id">
                    <input type="hidden" name="current_image" id="edit_current_image">
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium mb-1">Tên xe *</label>
                            <input type="text" name="vehicle_name" id="edit_vehicle_name" required class="w-full border rounded-lg px-4 py-2" placeholder="Toyota Camry 2024">
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1">Trạm *</label>
                            <select name="station_id" id="edit_station_id" required class="w-full border rounded-lg px-4 py-2">
                                <option value="">Chọn trạm</option>
                                <?php foreach ($stations as $st): ?>
                                    <option value="<?= $st['station_id'] ?>"><?= htmlspecialchars($st['station_name']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1">Biển số xe *</label>
                            <input type="text" name="license_plate" id="edit_license_plate" required class="w-full border rounded-lg px-4 py-2 uppercase" placeholder="51G-12345">
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1">Loại xe *</label>
                            <select name="vehicle_type" id="edit_vehicle_type" required class="w-full border rounded-lg px-4 py-2">
                                <option value="">Chọn loại</option>
                                <option value="Oto">Ô tô</option>
                                <option value="Xemay">Xe máy</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1">Hãng xe *</label>
                            <input type="text" name="brand" id="edit_brand" required class="w-full border rounded-lg px-4 py-2" placeholder="Toyota, Honda...">
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1">Model</label>
                            <input type="text" name="model" id="edit_model" class="w-full border rounded-lg px-4 py-2" placeholder="Camry">
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1">Năm sản xuất</label>
                            <input type="number" name="year" id="edit_year" min="1990" max="2030" class="w-full border rounded-lg px-4 py-2" placeholder="2024">
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1">Số chỗ ngồi</label>
                            <input type="number" name="seats" id="edit_seats" min="1" max="50" class="w-full border rounded-lg px-4 py-2" placeholder="5">
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1">Giá thuê/ngày (VNĐ) *</label>
                            <input type="number" name="price_per_day" id="edit_price_per_day" required min="0" class="w-full border rounded-lg px-4 py-2" placeholder="500000">
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1">Giá thuê/giờ (VNĐ)</label>
                            <input type="number" name="price_per_hour" id="edit_price_per_hour" min="0" class="w-full border rounded-lg px-4 py-2" placeholder="Tự động = giá ngày/8">
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1">Trạng thái *</label>
                            <select name="status" id="edit_status" required class="w-full border rounded-lg px-4 py-2" >
                                <option value="AVAILABLE">Sẵn sàng</option>
                                <option value="RENTED">Đang thuê</option>
                                <option value="MAINTENANCE">Bảo trì</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1">Ảnh xe mới (để trống nếu không đổi)</label>
                            <input type="file" name="image" id="edit_image" accept="image/*" class="w-full border rounded-lg px-4 py-2">
                        </div>
                        <div class="col-span-2">
                            <label class="block text-sm font-medium mb-1">Mô tả</label>
                            <textarea name="description" id="edit_description" rows="2" class="w-full border rounded-lg px-4 py-2" placeholder="Thông tin thêm về xe..."></textarea>
                        </div>
                    </div>

                    <div class="flex justify-end space-x-3 mt-6">
                        <button type="button" id="cancelEditBtn" class="px-6 py-2 border rounded-lg hover:bg-gray-50">
                            Hủy
                        </button>
                        <button type="submit" class="px-6 py-2 rounded-lg text-white font-semibold"
                            style="background: var(--primary-color);">
                            Cập nhật
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="../../../js/main.js"></script>
    <script>
    // Add Vehicle Modal
    const modal = document.getElementById('vehicleModal');
    const btnAddVehicle = document.getElementById('btnAddVehicle');
    const closeModal = document.getElementById('closeModal');
    const cancelBtn = document.getElementById('cancelBtn');

    btnAddVehicle.addEventListener('click', () => {
        modal.classList.remove('hidden');
    });

    closeModal.addEventListener('click', () => {
        modal.classList.add('hidden');
    });

    cancelBtn.addEventListener('click', () => {
        modal.classList.add('hidden');
    });

    document.getElementById('vehicleForm').addEventListener('submit', (e) => {
        e.preventDefault();
        
        Swal.fire({
            title: 'Xác nhận',
            text: 'Bạn có chắc muốn thêm xe mới này?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Thêm',
            cancelButtonText: 'Hủy'
        }).then((result) => {
            if (result.isConfirmed) {
                e.target.submit();
            }
        });
    });

    // Edit Vehicle Modal
    const editModal = document.getElementById('editVehicleModal');
    const closeEditModal = document.getElementById('closeEditModal');
    const cancelEditBtn = document.getElementById('cancelEditBtn');

    closeEditModal.addEventListener('click', () => {
        editModal.classList.add('hidden');
    });

    cancelEditBtn.addEventListener('click', () => {
        editModal.classList.add('hidden');
    });

    document.getElementById('editVehicleForm').addEventListener('submit', (e) => {
        e.preventDefault();
        
        Swal.fire({
            title: 'Xác nhận',
            text: 'Bạn có chắc muốn cập nhật thông tin xe này?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Cập nhật',
            cancelButtonText: 'Hủy'
        }).then((result) => {
            if (result.isConfirmed) {
                e.target.submit();
            }
        });
    });

    function viewVehicle(vehicleId) {
        fetch('/ITS/assets/php/admin/get_vehicle.php?id=' + vehicleId)
            .then(res => res.json())
            .then(vehicle => {
                Swal.fire({
                    title: vehicle.vehicle_name,
                    html: `
                        <div class="text-left space-y-2">
                            <p><strong>Biển số:</strong> ${vehicle.license_plate}</p>
                            <p><strong>Loại xe:</strong> ${vehicle.vehicle_type}</p>
                            <p><strong>Hãng:</strong> ${vehicle.brand}</p>
                            <p><strong>Model:</strong> ${vehicle.model}</p>
                            <p><strong>Năm:</strong> ${vehicle.year}</p>
                            <p><strong>Trạm:</strong> ${vehicle.station_name || 'Chưa có'}</p>
                            <p><strong>Giá thuê/ngày:</strong> ${Number(vehicle.price_per_day).toLocaleString('vi-VN')}đ</p>
                            <p><strong>Giá thuê/giờ:</strong> ${Number(vehicle.price_per_hour).toLocaleString('vi-VN')}đ</p>
                            <p><strong>Trạng thái:</strong> ${vehicle.status}</p>
                        </div>
                    `,
                    imageUrl: vehicle.image ? `/ITS/assets/img/vehicles/${vehicle.image}` : null,
                    imageWidth: 400,
                    imageAlt: vehicle.vehicle_name,
                    confirmButtonText: 'Đóng'
                });
            });
    }

    function editVehicle(vehicleId) {
        fetch('/ITS/assets/php/admin/get_vehicle.php?id=' + vehicleId)
            .then(res => res.json())
            .then(vehicle => {
                // Populate form fields
                document.getElementById('edit_vehicle_id').value = vehicle.vehicle_id;
                document.getElementById('edit_current_image').value = vehicle.image || '';
                document.getElementById('edit_vehicle_name').value = vehicle.vehicle_name;
                document.getElementById('edit_station_id').value = vehicle.station_id;
                document.getElementById('edit_license_plate').value = vehicle.license_plate;
                document.getElementById('edit_vehicle_type').value = vehicle.vehicle_type;
                document.getElementById('edit_brand').value = vehicle.brand;
                document.getElementById('edit_model').value = vehicle.model || '';
                document.getElementById('edit_year').value = vehicle.year || '';
                document.getElementById('edit_seats').value = vehicle.seats || '';
                document.getElementById('edit_price_per_day').value = vehicle.price_per_day;
                document.getElementById('edit_price_per_hour').value = vehicle.price_per_hour || '';
                document.getElementById('edit_status').value = vehicle.status;
                document.getElementById('edit_description').value = vehicle.description || '';
                
                // Show modal
                editModal.classList.remove('hidden');
            })
            .catch(error => {
                Swal.fire('Lỗi', 'Không thể tải thông tin xe', 'error');
            });
    }

    function deleteVehicle(vehicleId) {
        Swal.fire({
            title: 'Xóa phương tiện',
            text: 'Bạn có chắc muốn xóa xe này?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Xóa',
            cancelButtonText: 'Hủy',
            confirmButtonColor: '#dc2626'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch('/ITS/assets/php/admin/delete_vehicle.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ vehicle_id: vehicleId })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Đã xóa',
                            text: data.message,
                            timer: 1500,
                            showConfirmButton: false
                        }).then(() => location.reload());
                    } else {
                        Swal.fire('Lỗi', data.message, 'error');
                    }
                });
            }
        });
    }
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