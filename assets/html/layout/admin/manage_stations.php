!doctype html>
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
</head>

<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/ITS/assets/php/auth/check_permission.php';
requireAdmin();
?>
<?php $baseUrl = '../../../..'; ?>

<body class="min-h-full font-[Inter]">
    <div id="app" class="flex min-h-screen">

        <?php include '../../../includes/admin_sidebar.php'; ?>

        <div id="contentWrapper" class="flex-1 flex flex-col min-h-screen transition-all duration-300">

            <?php include '../../../includes/admin_navbar.php'; ?>
            <?php include '../../../php/admin/station/xuly_station.php'; ?>

            <!-- ================= MAIN ================= -->
            <main class="flex-1 overflow-auto p-4 md:p-6 lg:p-8" style="margin-top:76px">

                <!-- Header Section -->
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h1 class="text-3xl font-bold" style="color: var(--primary-color);">QUẢN LÝ TRẠM</h1>
                    </div>
                    <button id="btnAddStation"
                        class="btn-primary px-6 py-3 rounded-lg font-bold text-sm lg:text-base shadow-lg text-white"
                        style="background: var(--sidebar-gradient);">
                        <svg class="w-6 h-6 inline-block mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"
                                clip-rule="evenodd" />
                        </svg>
                        Thêm trạm mới
                    </button>

                </div>

                <div class="flex flex-wrap gap-4 mb-6">
                    <a href="/ITS/public/fix_location.php" target="_blank" 
                       class="px-6 py-3 bg-white border border-gray-300 rounded-lg font-bold text-gray-700 hover:bg-gray-50 shadow-sm flex items-center gap-2">
                        <span>🗺️</span> Mở bản đồ chỉnh sửa
                    </a>
                </div>

                <!-- STATISTICS -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">

                    <!-- TỔNG SỐ TRẠM -->
                    <div class="bg-blue-600 text-white p-6 rounded-xl flex items-center justify-between">
                        <div>
                            <p class="text-sm opacity-90">Tổng số trạm</p>
                            <h3 class="text-3xl font-bold"><?= $totalStations ?></h3>
                        </div>
                        <!-- ICON: Station -->
                        <svg class="w-10 h-10 opacity-90" viewBox="0 0 24 24" fill="currentColor">
                            <path
                                d="M3 22h18v-2H3v2zm2-4h4v-4H5v4zm0-6h4V8H5v4zm6 6h4v-4h-4v4zm0-6h4V8h-4v4zm6 6h4v-4h-4v4zm0-6h4V8h-4v4z" />
                        </svg>
                    </div>

                    <!-- TRẠM CÓ XE -->
                    <div class="bg-green-600 text-white p-6 rounded-xl flex items-center justify-between">
                        <div>
                            <p class="text-sm opacity-90">Trạm có xe</p>
                            <h3 class="text-3xl font-bold"><?= $stationsHaveVehicles ?></h3>
                        </div>
                        <!-- ICON: Car -->
                        <svg class="w-10 h-10 opacity-90" viewBox="0 0 24 24" fill="currentColor">
                            <path
                                d="M5 11l1.5-4.5h11L19 11v6a1 1 0 01-1 1h-1a1 1 0 01-1-1v-1H8v1a1 1 0 01-1 1H6a1 1 0 01-1-1v-6zm3.5 2a1.5 1.5 0 100 3 1.5 1.5 0 000-3zm7 0a1.5 1.5 0 100 3 1.5 1.5 0 000-3z" />
                        </svg>
                    </div>

                    <!-- TRẠM TRỐNG -->
                    <div class="bg-gray-600 text-white p-6 rounded-xl flex items-center justify-between">
                        <div>
                            <p class="text-sm opacity-90">Trạm trống</p>
                            <h3 class="text-3xl font-bold"><?= $stationsEmpty ?></h3>
                        </div>
                        <!-- ICON: Empty -->
                        <svg class="w-10 h-10 opacity-90" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M4 4h16v16H4z" />
                        </svg>
                    </div>

                    <!-- TRẠM BẢO TRÌ -->
                    <div class="bg-orange-600 text-white p-6 rounded-xl flex items-center justify-between">
                        <div>
                            <p class="text-sm opacity-90">Trạm bảo trì</p>
                            <h3 class="text-3xl font-bold"><?= $stationsMaintenance ?></h3>
                        </div>
                        <!-- ICON: Maintenance -->
                        <svg class="w-10 h-10 opacity-90" viewBox="0 0 24 24" fill="currentColor">
                            <path
                                d="M22.7 19.3l-6.2-6.2a6 6 0 01-7.8-7.8l3.3 3.3 2.8-2.8-3.3-3.3a6 6 0 017.8 7.8l6.2 6.2-2.8 2.8z" />
                        </svg>
                    </div>

                </div>


                <!-- TABLE -->
                <div class="bg-white rounded-xl shadow p-6">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left">ID</th>
                                <th class="px-4 py-3 text-left">Tên trạm</th>
                                <th class="px-4 py-3 text-left">Địa chỉ</th>
                                <th class="px-4 py-3 text-center">Xe máy</th>
                                <th class="px-4 py-3 text-center">Oto</th>
                                <th class="px-4 py-3 text-center">Tổng xe</th>
                                <th class="px-4 py-3 text-center">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y">
                            <?php foreach ($stations as $s): ?>
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3"><?= $s['station_id'] ?></td>
                                <td class="px-4 py-3 font-semibold">
                                    <?= $s['station_name'] ?>
                                    <?php if ($s['is_maintenance']): ?>
                                    <span class="ml-2 text-xs px-2 py-0.5 rounded bg-orange-100 text-orange-700">
                                        Bảo trì
                                    </span>
                                    <?php endif; ?>
                                </td>

                                <td class="px-4 py-3"><?= $s['address'] ?></td>

                                <!-- XE MÁY -->
                                <td class="px-4 py-3 text-center">
                                    <?= $s['total_bikes'] ?>
                                </td>

                                <!-- Ô TÔ -->
                                <td class="px-4 py-3 text-center">
                                    <?= $s['total_cars'] ?>
                                </td>

                                <!-- TỔNG XE -->
                                <td class="px-4 py-3 text-center font-semibold">
                                    <?= $s['total_vehicles'] ?>
                                </td>
                                <td class="px-4 py-3 text-center whitespace-nowrap">

                                    <div class="flex justify-center items-center gap-2">
                                        <!-- SỬA (KHÔNG CHO SỬA KHI BẢO TRÌ) -->
                                        <?php if (!$s['is_maintenance']): ?>
                                        <button onclick="openEditStationModal(
                                            <?= $s['station_id'] ?>,
                                            '<?= addslashes($s['station_name']) ?>',
                                            '<?= addslashes($s['address']) ?>',
                                            '<?= $s['latitude'] ?? '' ?>',
                                            '<?= $s['longitude'] ?? '' ?>'
                                        )" class="text-yellow-600 hover:text-yellow-800 transition-colors tooltip-btn" title="Sửa trạm">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                        </button>
                                        <?php endif; ?>

                                        <!-- BẢO TRÌ / KẾT THÚC BẢO TRÌ -->
                                        <?php if (!$s['is_maintenance']): ?>
                                        <button type="button"
                                            onclick="confirmSetMaintenance(<?= $s['station_id'] ?>)"
                                            class="text-orange-600 hover:text-orange-800 transition-colors tooltip-btn" title="Chuyển sang bảo trì">
                                            <!-- wrench (outline) -->
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                        </button>
                                        <?php else: ?>
                                        <button type="button"
                                            onclick="confirmUnsetMaintenance(<?= $s['station_id'] ?>)"
                                            class="text-green-600 hover:text-green-800 transition-colors tooltip-btn" title="Kết thúc bảo trì">
                                            <!-- check (outline) -->
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </button>
                                        <?php endif; ?>


                                        <!-- XÓA (CHỈ KHI: KHÔNG XE + KHÔNG BẢO TRÌ) -->
                                        <?php if ($s['total_vehicles'] == 0 && !$s['is_maintenance']): ?>
                                        <button type="button" onclick="confirmDelete(<?= $s['station_id'] ?>)"
                                            class="text-red-600 hover:text-red-800 transition-colors tooltip-btn" title="Xóa trạm">
                                            <!-- trash (outline) -->
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                        <?php endif; ?>
                                    </div>

                                </td>

                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

            </main>

            <?php include '../../../includes/footer.php'; ?>
        </div>
    </div>

    <!-- ADD STATION MODAL -->
    <div id="addStationModal"
        class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">

        <div class="bg-white rounded-2xl shadow-2xl max-w-xl w-full">

            <!-- HEADER -->
            <div class="p-6 border-b flex justify-between items-center">
                <h2 class="text-2xl font-bold">Thêm trạm mới</h2>
                <button onclick="closeAddStationModal()" class="text-xl">✖</button>
            </div>

            <!-- FORM -->
            <!-- FORM -->
            <form action="/ITS/assets/php/admin/station/add_station.php" method="POST" class="p-6">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                    <!-- TÊN TRẠM -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold mb-2">Tên trạm</label>
                        <input type="text" name="station_name" required class="w-full border rounded-lg px-4 py-2"
                            placeholder="VD: Trạm Nguyễn Huệ - Q1">
                    </div>

                    <!-- THÀNH PHỐ / TỈNH -->
                    <div>
                        <label class="block text-sm font-semibold mb-2">Thành phố / Tỉnh</label>
                        <select id="citySelect" name="city" class="w-full border rounded-lg px-4 py-2" required>
                            <option value="">-- Chọn Thành phố --</option>
                            <option value="TP. Hồ Chí Minh">TP. Hồ Chí Minh</option>
                            <option value="Hà Nội">Hà Nội</option>
                            <option value="Đà Nẵng">Đà Nẵng</option>
                        </select>
                    </div>

                    <!-- QUẬN / HUYỆN -->
                    <div>
                        <label class="block text-sm font-semibold mb-2">Quận / Huyện</label>
                        <select id="districtSelect" name="district" class="w-full border rounded-lg px-4 py-2" required>
                            <option value="">-- Chọn Quận / Huyện --</option>
                        </select>
                    </div>

                    <!-- ĐỊA CHỈ CHI TIẾT -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold mb-2">Địa chỉ chi tiết</label>
                        <input type="text" name="address" class="w-full border rounded-lg px-4 py-2"
                            placeholder="VD: 12 Nguyễn Huệ">
                    </div>

                    <!-- TRẠNG THÁI -->
                    <div>
                        <label class="block text-sm font-semibold mb-2">Trạng thái trạm</label>
                        <select name="is_maintenance" class="w-full border rounded-lg px-4 py-2">
                            <option value="0">Hoạt động</option>
                            <option value="1">Bảo trì</option>
                        </select>
                    </div>

                    <!-- Coordinates -->
                    <div class="grid grid-cols-2 gap-4 col-span-2 md:col-span-2">
                        <div>
                            <label class="block text-sm font-semibold mb-2">Vĩ độ (Lat)</label>
                            <input type="number" step="any" name="latitude" class="w-full border rounded-lg px-4 py-2" placeholder="VD: 10.1234">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold mb-2">Kinh độ (Lng)</label>
                            <input type="number" step="any" name="longitude" class="w-full border rounded-lg px-4 py-2" placeholder="VD: 106.1234">
                        </div>
                    </div>

                </div>

                <!-- ACTION -->
                <div class="flex justify-end mt-6 gap-3">
                    <button type="button" onclick="closeAddStationModal()" class="px-5 py-2 rounded-lg border">
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

    <!-- EDIT STATION MODAL -->
    <div id="editStationModal"
        class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">

        <div class="bg-white rounded-2xl shadow-2xl max-w-xl w-full">

            <!-- HEADER -->
            <div class="p-6 border-b flex justify-between items-center">
                <h2 class="text-2xl font-bold">Chỉnh sửa trạm</h2>
                <button onclick="closeEditStationModal()" class="text-xl">✖</button>
            </div>

            <!-- FORM -->
            <form action="/ITS/assets/php/admin/station/edit_station.php" method="POST" class="p-6">

                <input type="hidden" name="station_id" id="edit_station_id">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                    <!-- TÊN TRẠM -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold mb-2">Tên trạm</label>
                        <input type="text" name="station_name" id="edit_station_name" required
                            class="w-full border rounded-lg px-4 py-2">
                    </div>

                    <!-- ĐỊA CHỈ -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold mb-2">Địa chỉ</label>
                        <input type="text" name="address" id="edit_station_address"
                            class="w-full border rounded-lg px-4 py-2">
                    </div>

                    <!-- Coordinates -->
                    <div>
                        <label class="block text-sm font-semibold mb-2">Vĩ độ (Lat)</label>
                        <input type="number" step="any" name="latitude" id="edit_station_lat" class="w-full border rounded-lg px-4 py-2">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold mb-2">Kinh độ (Lng)</label>
                        <input type="number" step="any" name="longitude" id="edit_station_lng" class="w-full border rounded-lg px-4 py-2">
                    </div>

                </div>

                <!-- ACTION -->
                <div class="flex justify-end mt-6 gap-3">
                    <button type="button" onclick="closeEditStationModal()" class="px-5 py-2 rounded-lg border">
                        Hủy
                    </button>
                    <button type="submit" class="px-6 py-2 rounded-lg text-white font-semibold"
                        style="background: var(--primary-color);">
                        Lưu thay đổi
                    </button>
                </div>

            </form>

        </div>
    </div>


    <script>
    const editStationModal = document.getElementById('editStationModal');

    function openEditStationModal(id, name, address) {
        document.getElementById('edit_station_id').value = id;
        document.getElementById('edit_station_name').value = name;
        document.getElementById('edit_station_address').value = address ?? '';
        document.getElementById('edit_station_lat').value = arguments[3] ?? '';
        document.getElementById('edit_station_lng').value = arguments[4] ?? '';

        editStationModal.classList.remove('hidden');
    }

    function closeEditStationModal() {
        editStationModal.classList.add('hidden');
    }

    // click nền đen để đóng
    editStationModal.addEventListener('click', (e) => {
        if (e.target === editStationModal) closeEditStationModal();
    });
    </script>


    <script src="../../../js/main.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <?php if (!empty($_SESSION['flash_alert'])): ?>
    <script>
    Swal.fire({
        icon: '<?= $_SESSION['flash_alert']['icon'] ?>',
        title: '<?= $_SESSION['flash_alert']['title'] ?>',
        text: '<?= $_SESSION['flash_alert']['text'] ?>',
        timer: 2500,
        showConfirmButton: false
    });
    </script>
    <?php unset($_SESSION['flash_alert']); endif; ?>

    <script>
    function confirmDelete(id) {
        Swal.fire({
            title: 'Xóa trạm?',
            text: 'Hành động này không thể hoàn tác!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Xóa',
            cancelButtonText: 'Hủy'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href =
                    '/ITS/assets/php/admin/station/delete_station.php?id=' + id;
            }
        });
    }
    </script>
    <script>
    function confirmSetMaintenance(id) {
        Swal.fire({
            title: 'Chuyển sang bảo trì?',
            text: 'Trạm sẽ bị khóa và không thể cho thuê.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Chuyển bảo trì',
            cancelButtonText: 'Hủy'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href =
                    '/ITS/assets/php/admin/station/set_maintenance.php?id=' + id;
            }
        });
    }

    function confirmUnsetMaintenance(id) {
        Swal.fire({
            title: 'Kết thúc bảo trì?',
            text: 'Trạm sẽ hoạt động trở lại.',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Hoàn tất',
            cancelButtonText: 'Hủy'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href =
                    '/ITS/assets/php/admin/station/unset_maintenance.php?id=' + id;
            }
        });
    }
    </script>


    <script>
    const modal = document.getElementById('addStationModal');
    const btnAdd = document.getElementById('btnAddStation');

    btnAdd.addEventListener('click', () => {
        modal.classList.remove('hidden');
    });

    function closeAddStationModal() {
        modal.classList.add('hidden');
    }

    modal.addEventListener('click', (e) => {
        if (e.target === modal) closeAddStationModal();
    });
    </script>

</body>

</html>