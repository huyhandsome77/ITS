<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once $_SERVER['DOCUMENT_ROOT'] . '/ITS/assets/php/auth/check_permission.php';
requireStation();

require_once $_SERVER['DOCUMENT_ROOT'] . '/ITS/assets/php/station/xuly_station_vehicle.php';
?>
<!doctype html>
<html lang="vi" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý phương tiện | Quản lý trạm</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="../../../css/style.css">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<?php $baseUrl = '../../../..'; ?>

<body class="min-h-full font-[Inter]">
    <div id="app" class="flex min-h-screen">

        <?php include '../../../includes/station_sidebar.php'; ?>

        <div id="contentWrapper" class="flex-1 flex flex-col min-h-screen transition-all duration-300">

            <?php include '../../../includes/station_navbar.php'; ?>

            <!-- ================= MAIN ================= -->
            <main class="flex-1 overflow-auto p-4 md:p-6 lg:p-8" style="margin-top:76px">

                <!-- Header Section -->
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h1 class="text-3xl font-bold" style="color: var(--primary-color);">Quản lý phương tiện</h1>
                        <p class="text-gray-600 mt-1">Trạm: <span class="font-semibold" id="stationName"><?= htmlspecialchars($stationName) ?></span></p>
                    </div>
                    <button id="btnAddVehicle"class="btn-primary px-6 py-3 rounded-lg font-bold text-sm lg:text-base shadow-lg text-white" style="background: var(--sidebar-gradient);">
                        <svg class="w-5 h-5 inline-block mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"/>
                        </svg>
                        Thêm xe mới
                    </button>
                </div>

                <!-- Filter Section -->
                <section class="bg-white rounded-2xl shadow-sm border p-5 mb-6">
                    <h2 class="text-lg font-semibold mb-4">Bộ lọc</h2>
                    <form method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <select name="vehicle_type" id="filterVehicleType" class="border rounded-lg px-4 py-2">
                            <option value="">Tất cả loại xe</option>
                            <?php foreach ($vehicleTypes as $type): ?>
                                <option value="<?= htmlspecialchars($type) ?>" <?= $vehicleType === $type ? 'selected' : '' ?>>
                                    <?= $type === 'Oto' ? 'Ô tô' : ($type === 'Xemay' ? 'Xe máy' : htmlspecialchars($type)) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>

                        <select name="status" id="filterStatus" class="border rounded-lg px-4 py-2">
                            <option value="">Tất cả trạng thái</option>
                            <option value="AVAILABLE" <?= $status === 'AVAILABLE' ? 'selected' : '' ?>>Sẵn sàng</option>
                            <option value="RENTED" <?= $status === 'RENTED' ? 'selected' : '' ?>>Đang thuê</option>
                            <option value="MAINTENANCE" <?= $status === 'MAINTENANCE' ? 'selected' : '' ?>>Bảo trì</option>
                        </select>

                        <button type="submit" class="px-6 py-2 rounded-lg font-semibold text-white" style="background: var(--primary-color);">
                            <svg class="w-5 h-5 inline-block mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"/>
                            </svg>
                            Lọc
                        </button>
                    </form>
                </section>

                <!-- Vehicle List -->
                <section class="bg-white rounded-2xl shadow-sm border p-5">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-lg font-semibold">Danh sách phương tiện</h2>
                        <span class="text-gray-600">Tổng số: <strong id="totalVehicles"><?= $filteredTotal ?></strong> xe</span>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-50 border-b">
                                <tr>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Biển số</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Tên xe</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Loại xe</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Giá/ngày</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Giá/giờ</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Lượt thuê</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Đánh giá</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Trạng thái</th>
                                    <th class="px-4 py-3 text-center text-sm font-semibold text-gray-700">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody id="vehicleTableBody" class="divide-y">
                                <?php if (empty($vehicles)): ?>
                                    <tr>
                                        <td colspan="9" class="px-4 py-8 text-center text-gray-500">Không có phương tiện nào</td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($vehicles as $vehicle): 
                                        $statusBadge = vehicleStatusLabel($vehicle['status']);
                                    ?>
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-4 py-3 text-sm font-mono"><?= htmlspecialchars($vehicle['license_plate']) ?></td>
                                        <td class="px-4 py-3 text-sm font-semibold"><?= htmlspecialchars($vehicle['vehicle_name']) ?></td>
                                        <td class="px-4 py-3 text-sm"><?= $vehicle['vehicle_type'] === 'Oto' ? 'Ô tô' : 'Xe máy' ?></td>
                                        <td class="px-4 py-3 text-sm font-semibold"><?= formatCurrency($vehicle['price_per_day']) ?></td>
                                        <td class="px-4 py-3 text-sm"><?= formatCurrency($vehicle['price_per_hour']) ?></td>
                                        <td class="px-4 py-3 text-sm text-center"><?= $vehicle['total_rentals'] ?> lượt</td>
                                        <td class="px-4 py-3 text-sm text-center"><?= number_format($vehicle['avg_rating'], 1) ?> ⭐</td>
                                        <td class="px-4 py-3">
                                            <span class="px-3 py-1 rounded-full text-xs font-semibold <?= $statusBadge['class'] ?>">
                                                <?= $statusBadge['label'] ?>
                                            </span>
                                        </td>
                                        <td class="px-4 py-3 text-center">
                                            <button onclick="viewVehicleDetail(<?= $vehicle['vehicle_id'] ?>)" class="text-blue-600 hover:text-blue-800 mx-1" title="Xem chi tiết">
                                                <svg class="w-5 h-5 inline-block" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/>
                                                    <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/>
                                                </svg>
                                            </button>
                                            <button onclick="editVehicle(<?= $vehicle['vehicle_id'] ?>)" class="text-yellow-600 hover:text-yellow-800 mx-1" title="Chỉnh sửa">
                                                <svg class="w-5 h-5 inline-block" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"/>
                                                </svg>
                                            </button>
                                            <?php if ($vehicle['status'] === 'AVAILABLE'): ?>
                                                <button onclick="toggleMaintenance(<?= $vehicle['vehicle_id'] ?>, 'MAINTENANCE')" class="text-orange-600 hover:text-orange-800 mx-1" title="Chuyển bảo trì">
                                                    <svg class="w-5 h-5 inline-block" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"/>
                                                    </svg>
                                                </button>
                                            <?php elseif ($vehicle['status'] === 'MAINTENANCE'): ?>
                                                <button onclick="toggleMaintenance(<?= $vehicle['vehicle_id'] ?>, 'AVAILABLE')" class="text-green-600 hover:text-green-800 mx-1" title="Kết thúc bảo trì">
                                                    <svg class="w-5 h-5 inline-block" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                                    </svg>
                                                </button>
                                            <?php endif; ?>
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
                            Hiển thị <span class="font-semibold"><?= min($offset + 1, $filteredTotal) ?>-<?= min($offset + $limit, $filteredTotal) ?></span> 
                            của <span class="font-semibold"><?= $filteredTotal ?></span> xe
                        </span>
                        <div class="flex space-x-2">
                            <!-- Previous Button -->
                            <a href="?page=<?= max(1, $page - 1) ?><?= !empty($vehicleType) ? '&vehicle_type=' . urlencode($vehicleType) : '' ?><?= !empty($status) ? '&status=' . urlencode($status) : '' ?>" 
                               class="px-4 py-2 border rounded-lg hover:bg-gray-50 <?= $page <= 1 ? 'opacity-50 cursor-not-allowed pointer-events-none' : '' ?>">
                                Trước
                            </a>
                            
                            <!-- Page Numbers -->
                            <?php for ($i = max(1, $page - 2); $i <= min($totalPages, $page + 2); $i++): ?>
                                <a href="?page=<?= $i ?><?= !empty($vehicleType) ? '&vehicle_type=' . urlencode($vehicleType) : '' ?><?= !empty($status) ? '&status=' . urlencode($status) : '' ?>" 
                                   class="px-4 py-2 <?= $i == $page ? 'bg-teal-600 text-white' : 'border hover:bg-gray-50' ?> rounded-lg">
                                    <?= $i ?>
                                </a>
                            <?php endfor; ?>
                            
                            <!-- Next Button -->
                            <a href="?page=<?= min($totalPages, $page + 1) ?><?= !empty($vehicleType) ? '&vehicle_type=' . urlencode($vehicleType) : '' ?><?= !empty($status) ? '&status=' . urlencode($status) : '' ?>" 
                               class="px-4 py-2 border rounded-lg hover:bg-gray-50 <?= $page >= $totalPages ? 'opacity-50 cursor-not-allowed pointer-events-none' : '' ?>">
                                Sau
                            </a>
                        </div>
                    </div>
                </section>

            </main>

            <?php include '../../../includes/footer.php'; ?>
        </div>
    </div>

    <!-- Modal: View Vehicle Detail -->
    <div id="viewModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
            <div class="p-6 border-b flex justify-between items-center">
                <h2 class="text-2xl font-bold" style="color: var(--primary-color);">Chi tiết phương tiện</h2>
                <button id="closeViewModal" class="text-gray-500 hover:text-gray-700">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                    </svg>
                </button>
            </div>
            <div id="viewModalContent" class="p-6">
                <div class="grid grid-cols-2 gap-4">
                    <div class="col-span-2 md:col-span-1">
                        <label class="block text-sm font-semibold text-gray-600 mb-1">Biển số xe</label>
                        <p id="view_license_plate" class="text-lg font-mono font-bold"></p>
                    </div>
                    <div class="col-span-2 md:col-span-1">
                        <label class="block text-sm font-semibold text-gray-600 mb-1">Tên xe</label>
                        <p id="view_vehicle_name" class="text-lg font-semibold"></p>
                    </div>
                    <div class="col-span-2 md:col-span-1">
                        <label class="block text-sm font-semibold text-gray-600 mb-1">Loại xe</label>
                        <p id="view_vehicle_type" class="text-lg"></p>
                    </div>
                    <div class="col-span-2 md:col-span-1">
                        <label class="block text-sm font-semibold text-gray-600 mb-1">Trạng thái</label>
                        <p id="view_status"></p>
                    </div>
                    <div class="col-span-2 md:col-span-1">
                        <label class="block text-sm font-semibold text-gray-600 mb-1">Giá thuê / ngày</label>
                        <p id="view_price_day" class="text-lg font-bold text-green-600"></p>
                    </div>
                    <div class="col-span-2 md:col-span-1">
                        <label class="block text-sm font-semibold text-gray-600 mb-1">Giá thuê / giờ</label>
                        <p id="view_price_hour" class="text-lg font-bold text-green-600"></p>
                    </div>
                    <div class="col-span-2 md:col-span-1">
                        <label class="block text-sm font-semibold text-gray-600 mb-1">Số lượt thuê</label>
                        <p id="view_rentals" class="text-lg"></p>
                    </div>
                    <div class="col-span-2 md:col-span-1">
                        <label class="block text-sm font-semibold text-gray-600 mb-1">Đánh giá trung bình</label>
                        <p id="view_rating" class="text-lg"></p>
                    </div>
                </div>
            </div>
            <div class="p-6 border-t flex justify-end">
                <button id="closeViewModalBtn" class="px-6 py-2 border rounded-lg hover:bg-gray-50">Đóng</button>
            </div>
        </div>
    </div>

    <!-- Modal: Add/Edit Vehicle -->
    <div id="vehicleModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
            <div class="p-6 border-b flex justify-between items-center">
                <h2 class="text-2xl font-bold" style="color: var(--primary-color);">Thêm xe mới</h2>
                <button id="closeModal" class="text-gray-500 hover:text-gray-700">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                    </svg>
                </button>
            </div>
            <form id="vehicleForm" class="p-6">
                <input type="hidden" id="vehicle_id" name="vehicle_id">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold mb-2">Biển số xe *</label>
                        <input type="text" id="license_plate" name="license_plate" placeholder="VD: 51G-12345" class="w-full border rounded-lg px-4 py-2" required>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold mb-2">Tên xe *</label>
                        <input type="text" id="vehicle_name" name="vehicle_name" placeholder="VD: Toyota Camry" class="w-full border rounded-lg px-4 py-2" required>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold mb-2">Loại xe *</label>
                        <select id="vehicle_type" name="vehicle_type" class="w-full border rounded-lg px-4 py-2" required>
                            <option value="">-- Chọn loại --</option>
                            <option value="Oto">Ô tô</option>
                            <option value="Xemay">Xe máy</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold mb-2">Hãng xe *</label>
                        <input type="text" id="brand" name="brand" placeholder="VD: Toyota, Honda" class="w-full border rounded-lg px-4 py-2" required>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold mb-2">Dòng xe *</label>
                        <input type="text" id="model" name="model" placeholder="VD: Camry, CR-V" class="w-full border rounded-lg px-4 py-2" required>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold mb-2">Năm sản xuất *</label>
                        <input type="number" id="year" name="year" placeholder="2023" min="2000" max="2030" class="w-full border rounded-lg px-4 py-2" required>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold mb-2">Số chỗ ngồi *</label>
                        <input type="number" id="seats" name="seats" placeholder="5" min="2" max="16" class="w-full border rounded-lg px-4 py-2" required>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold mb-2">Giá thuê / ngày (VNĐ) *</label>
                        <input type="number" id="price_per_day" name="price_per_day" placeholder="1000000" min="0" class="w-full border rounded-lg px-4 py-2" required>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold mb-2">Giá thuê / giờ (VNĐ) *</label>
                        <input type="number" id="price_per_hour" name="price_per_hour" placeholder="100000" min="0" class="w-full border rounded-lg px-4 py-2" required>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold mb-2">Trạng thái *</label>
                        <select id="status" name="status" class="w-full border rounded-lg px-4 py-2" required>
                            <option value="AVAILABLE">Sẵn sàng</option>
                            <option value="RENTED">Đang thuê</option>
                            <option value="MAINTENANCE">Bảo trì</option>
                        </select>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold mb-2">Mô tả</label>
                        <textarea id="description" name="description" rows="3" placeholder="Thông tin thêm về xe..." class="w-full border rounded-lg px-4 py-2"></textarea>
                    </div>
                </div>
                <div class="flex justify-end space-x-3 mt-6">
                    <button type="button" id="cancelBtn" class="px-6 py-2 border rounded-lg hover:bg-gray-50">Hủy</button>
                    <button type="submit" class="btn-primary px-6 py-2 rounded-lg font-bold text-sm lg:text-base shadow-lg text-white" style="background: var(--sidebar-gradient);">Lưu xe</button>
                </div>
            </form>
        </div>
    </div>

    <script src="../../../js/main.js"></script>
    <script>
        // Notification using SweetAlert2 Toast
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })

        function showNotification(message, type = 'success') {
            Toast.fire({
                icon: type,
                title: message
            });
        }

        // Add/Edit Modal handling
        const modal = document.getElementById('vehicleModal');
        const btnAddVehicle = document.getElementById('btnAddVehicle');
        const closeModal = document.getElementById('closeModal');
        const cancelBtn = document.getElementById('cancelBtn');
        const modalTitle = modal.querySelector('h2');
        let isEditMode = false;
        let currentVehicleId = null;

        btnAddVehicle.addEventListener('click', () => {
            isEditMode = false;
            currentVehicleId = null;
            modalTitle.textContent = 'Thêm xe mới';
            document.getElementById('vehicleForm').reset();
            document.getElementById('vehicle_id').value = '';
            modal.classList.remove('hidden');
        });

        closeModal.addEventListener('click', () => {
            modal.classList.add('hidden');
        });

        cancelBtn.addEventListener('click', () => {
            modal.classList.add('hidden');
        });

        modal.addEventListener('click', (e) => {
            if (e.target === modal) {
                modal.classList.add('hidden');
            }
        });

        // View Modal handling
        const viewModal = document.getElementById('viewModal');
        const closeViewModal = document.getElementById('closeViewModal');
        const closeViewModalBtn = document.getElementById('closeViewModalBtn');

        closeViewModal.addEventListener('click', () => {
            viewModal.classList.add('hidden');
        });

        closeViewModalBtn.addEventListener('click', () => {
            viewModal.classList.add('hidden');
        });

        viewModal.addEventListener('click', (e) => {
            if (e.target === viewModal) {
                viewModal.classList.add('hidden');
            }
        });

        // Form submit handling
        document.getElementById('vehicleForm').addEventListener('submit', (e) => {
            e.preventDefault();
            
            const formData = new FormData(e.target);
            
            // Send AJAX request
            fetch('../../../php/station/save_vehicle.php', {
                method: 'POST',
                body: new URLSearchParams(formData)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification(data.message, 'success');
                    modal.classList.add('hidden');
                    setTimeout(() => location.reload(), 1500);
                } else {
                    showNotification(data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('Không thể kết nối đến server!', 'error');
            });
        });

        // View vehicle detail
        function viewVehicleDetail(vehicleId) {
            // Get vehicle data from table row
            const row = event.target.closest('tr');
            const cells = row.querySelectorAll('td');
            
            document.getElementById('view_license_plate').textContent = cells[0].textContent.trim();
            document.getElementById('view_vehicle_name').textContent = cells[1].textContent.trim();
            document.getElementById('view_vehicle_type').textContent = cells[2].textContent.trim();
            document.getElementById('view_price_day').textContent = cells[3].textContent.trim();
            document.getElementById('view_price_hour').textContent = cells[4].textContent.trim();
            document.getElementById('view_rentals').textContent = cells[5].textContent.trim();
            document.getElementById('view_rating').textContent = cells[6].textContent.trim();
            
            const statusHtml = cells[7].querySelector('span').outerHTML;
            document.getElementById('view_status').innerHTML = statusHtml;
            
            viewModal.classList.remove('hidden');
        }

        // Edit vehicle
        function editVehicle(vehicleId) {
            isEditMode = true;
            currentVehicleId = vehicleId;
            modalTitle.textContent = 'Chỉnh sửa thông tin xe';
            
            // Fetch vehicle data from server
            fetch(`../../../php/station/get_vehicle.php?vehicle_id=${vehicleId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const vehicle = data.data;
                        
                        // Populate form
                        document.getElementById('vehicle_id').value = vehicle.vehicle_id;
                        document.getElementById('license_plate').value = vehicle.license_plate;
                        document.getElementById('vehicle_name').value = vehicle.vehicle_name;
                        document.getElementById('vehicle_type').value = vehicle.vehicle_type;
                        document.getElementById('brand').value = vehicle.brand || '';
                        document.getElementById('model').value = vehicle.model || '';
                        document.getElementById('year').value = vehicle.year || '';
                        document.getElementById('seats').value = vehicle.seats || '';
                        document.getElementById('price_per_day').value = vehicle.price_per_day;
                        document.getElementById('price_per_hour').value = vehicle.price_per_hour;
                        document.getElementById('description').value = vehicle.description || '';
                        document.getElementById('status').value = vehicle.status;
                        
                        modal.classList.remove('hidden');
                    } else {
                        showNotification(data.message, 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showNotification('Không thể tải thông tin xe!', 'error');
                });
        }

        // Toggle maintenance status
        function toggleMaintenance(vehicleId, newStatus) {
            const statusText = newStatus === 'MAINTENANCE' ? 'chuyển sang bảo trì' : 'kết thúc bảo trì';

            Swal.fire({
                title: 'Xác nhận',
                text: `Bạn có chắc chắn muốn ${statusText} xe này?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#f97316',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Đồng ý',
                cancelButtonText: 'Hủy'
            }).then((result) => {
                if (result.isConfirmed) {
                     // Send AJAX request to update status
                    fetch('../../../php/station/update_vehicle_status.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: `vehicle_id=${vehicleId}&status=${newStatus}`
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            showNotification(data.message || 'Cập nhật trạng thái thành công!', 'success');
                            setTimeout(() => location.reload(), 1500);
                        } else {
                            showNotification(data.message || 'Có lỗi xảy ra!', 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showNotification('Không thể kết nối đến server!', 'error');
                    });
                }
            });
        }
    </script>
</body>

</html>
