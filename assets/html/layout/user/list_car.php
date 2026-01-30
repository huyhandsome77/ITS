<!doctype html>
<html lang="vi" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý đơn hàng | Thuexe.com</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="../../../css/style.css">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<?php $baseUrl = '../../../..'; ?>

    <div id="app" class="flex min-h-screen">
        <?php require_once '../../../php/user/filter_cars.php'; ?>

        <?php include '../../../includes/sidebar.php'; ?>

        <div id="contentWrapper" class="flex-1 flex flex-col min-h-screen transition-all duration-300">

            <?php include '../../../includes/navbar.php'; ?>

            <!-- ================= MAIN ================= -->
            <main class="flex-1 overflow-auto p-4 md:p-6 lg:p-8" style="margin-top:76px">

                <!-- CHỌN TRẠM -->
                <section class="bg-white rounded-2xl shadow-sm border p-5 mb-6">
                    <h2 class="text-lg font-semibold mb-4">Chọn trạm xe</h2>

                    <form method="GET" action="" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                        <select id="filterCity" class="border rounded-lg px-4 py-2 text-black cursor-pointer">
                            <option value="">-- Thành phố --</option>
                        </select>

                        <select id="filterDistrict" class="border rounded-lg px-4 py-2 text-black cursor-pointer" disabled>
                            <option value="">-- Quận / Huyện --</option>
                        </select>

                        <select id="filterStation" name="station_id" class="border rounded-lg px-4 py-2 text-black cursor-pointer bg-white" disabled required>
                            <option value="">-- Trạm xe --</option>
                        </select>

                        <button type="submit" class="h-[42px] rounded-lg text-white font-semibold bg-black hover:opacity-80 transition"> 
                            Tìm xe
                        </button>
                    </form>
                </section>

                <script>
                    const allStations = <?= json_encode($stations) ?>;
                    // Group data for filters
                    const cities = [...new Set(allStations.map(s => s.city))];
                    const filterCity = document.getElementById('filterCity');
                    const filterDistrict = document.getElementById('filterDistrict');
                    const filterStation = document.getElementById('filterStation');

                    // Init City
                    cities.forEach(c => {
                        const opt = document.createElement('option');
                        opt.value = c;
                        opt.textContent = c;
                        filterCity.appendChild(opt);
                    });

                    // Event City -> District
                    filterCity.addEventListener('change', () => {
                        filterDistrict.innerHTML = '<option value="">-- Quận / Huyện --</option>';
                        filterStation.innerHTML = '<option value="">-- Trạm xe --</option>';
                        filterDistrict.disabled = !filterCity.value;
                        filterStation.disabled = true;

                        if(filterCity.value) {
                            const districts = [...new Set(allStations.filter(s => s.city === filterCity.value).map(s => s.district))];
                            districts.forEach(d => {
                                const opt = document.createElement('option');
                                opt.value = d;
                                opt.textContent = d;
                                filterDistrict.appendChild(opt);
                            });
                        }
                    });

                    // Event District -> Station
                    filterDistrict.addEventListener('change', () => {
                        filterStation.innerHTML = '<option value="">-- Trạm xe --</option>';
                        filterStation.disabled = !filterDistrict.value;

                        if(filterDistrict.value) {
                            const stations = allStations.filter(s => s.city === filterCity.value && s.district === filterDistrict.value);
                            stations.forEach(s => {
                                const opt = document.createElement('option');
                                opt.value = s.station_id;
                                opt.textContent = s.station_name;
                                filterStation.appendChild(opt);
                            });
                        }
                    });
                </script>

                <?php if ($hasSearched): ?>
                    <div class="mb-6 p-4 bg-gray-50 border border-gray-200 rounded-lg flex items-center gap-3">
                        <span class="text-2xl">📍</span>
                        <div>
                            <p class="text-sm text-gray-600 font-medium">Đang xem danh sách xe tại trạm:</p>
                            <h2 class="text-xl font-bold text-black"><?= htmlspecialchars($currentStationName) ?></h2>
                        </div>
                    </div>
                    <!-- OTO LIST -->
                    <?php if (count($cars) > 0): ?>
                    <div class="flex items-center justify-between bg-slate-50 p-4 rounded-xl border-l-4 border-blue-600 mb-6 mt-10 shadow-sm">
                        <div class="flex items-center gap-3">
                            <div class="p-2 bg-blue-100 rounded-lg"><span class="text-xl">🚗</span></div>
                            <div>
                                <h2 class="text-xl font-bold text-slate-800">Ô tô cho thuê</h2>
                                <p class="text-xs text-slate-500">Đa dạng dòng xe từ 4-7 chỗ</p>
                            </div>
                        </div>
                        <button onclick="toggleSection('oto-list', this)" class="group p-2 hover:bg-white rounded-full transition-all duration-300 shadow-sm border border-transparent hover:border-slate-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-slate-600 transition-transform duration-300 transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                    </div>
                    <section id="oto-list" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-12 transition-all duration-500 ease-in-out">
                        <?php foreach($cars as $c): ?>
                        <div class="bg-white rounded-xl shadow border overflow-hidden">
                            <img src="<?= $c['image'] ? '/ITS/assets/img/vehicles/'.$c['image'] : 'https://placehold.co/600x400?text=No+Image' ?>"
                                class="h-48 w-full object-cover">
                            <div class="p-4">
                                <div class="flex justify-between items-start">
                                    <h3 class="font-semibold text-lg"><?= $c['vehicle_name'] ?></h3>
                                    <button onclick="openDetails(
                                        '<?= addslashes($c['vehicle_name']) ?>',
                                        '<?= $c['brand'] ?>',
                                        '<?= $c['model'] ?>',
                                        <?= $c['seats'] ?>,
                                        '<?= $c['year'] ?>',
                                        '<?= addslashes($c['description'] ?? '') ?>',
                                        '<?= $c['image'] ? '/ITS/assets/img/vehicles/'.$c['image'] : '' ?>',
                                        <?= $c['price_per_day'] ?>
                                    )" class="group p-2 rounded-full bg-slate-50 hover:bg-blue-600 text-slate-500 hover:text-white transition-all duration-300 shadow-sm hover:shadow-md hover:-translate-y-0.5" title="Xem chi tiết">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </button>
                                </div>
                                <p class="text-sm text-slate-500 mb-2"><?= $c['seats'] ?> chỗ • <?= $c['brand'] ?></p>
                                <p class="font-bold mb-4">
                                    <?= number_format($c['price_per_day'], 0, ',', '.') ?>đ / ngày • 
                                    <?= number_format($c['price_per_hour'], 0, ',', '.') ?>đ / giờ
                                </p>
                                <div class="grid grid-cols-2 gap-2">
                                    <button onclick="viewReviews(<?= $c['vehicle_id'] ?>)" 
                                        class="w-full py-2 rounded-lg border border-gray-300 text-gray-700 font-semibold hover:bg-gray-50">
                                        Xem đánh giá
                                    </button>
                                    <button onclick="openBooking(
                                        <?= $c['vehicle_id'] ?>, 
                                        '<?= addslashes($c['vehicle_name']) ?>',
                                        <?= $c['price_per_day'] ?>,
                                        <?= $c['price_per_hour'] ?>,
                                        '<?= $c['image'] ? '/ITS/assets/img/vehicles/'.$c['image'] : '' ?>',
                                        'OTO'
                                    )" class="w-full py-2 rounded-lg text-white font-semibold"
                                        style="background:var(--primary-color)">Đặt lịch</button>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </section>
                    <?php endif; ?>

                    <!-- XEMAY LIST -->
                    <?php if (count($bikes) > 0): ?>
                    <div class="flex items-center justify-between bg-slate-50 p-4 rounded-xl border-l-4 border-orange-500 mb-6 mt-10 shadow-sm">
                        <div class="flex items-center gap-3">
                            <div class="p-2 bg-orange-100 rounded-lg"><span class="text-xl">🛵</span></div>
                            <div>
                                <h2 class="text-xl font-bold text-slate-800">Xe máy cho thuê</h2>
                                <p class="text-xs text-slate-500">Xe số, tay ga & xe côn đời mới</p>
                            </div>
                        </div>
                        <button onclick="toggleSection('xemay-list', this)" class="group p-2 hover:bg-white rounded-full transition-all duration-300 shadow-sm border border-transparent hover:border-slate-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-slate-600 transition-transform duration-300 transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                    </div>
                    <section id="xemay-list" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-12 transition-all duration-500">
                        <?php foreach($bikes as $b): ?>
                        <div class="bg-white rounded-xl shadow border overflow-hidden">
                            <img src="<?= $b['image'] ? '/ITS/assets/img/vehicles/'.$b['image'] : 'https://placehold.co/600x400?text=No+Image' ?>"
                                class="h-48 w-full object-cover">
                            <div class="p-4">
                                <div class="flex justify-between items-start">
                                    <h3 class="font-semibold text-lg"><?= $b['vehicle_name'] ?></h3>
                                    <button onclick="openDetails(
                                        '<?= addslashes($b['vehicle_name']) ?>',
                                        '<?= $b['brand'] ?>',
                                        '<?= $b['model'] ?>',
                                        2,
                                        '<?= $b['year'] ?>',
                                        '<?= addslashes($b['description'] ?? '') ?>',
                                        '<?= $b['image'] ? '/ITS/assets/img/vehicles/'.$b['image'] : '' ?>',
                                        <?= $b['price_per_day'] ?>
                                    )" class="group p-2 rounded-full bg-slate-50 hover:bg-orange-500 text-slate-500 hover:text-white transition-all duration-300 shadow-sm hover:shadow-md hover:-translate-y-0.5" title="Xem chi tiết">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </button>
                                </div>
                                <p class="text-sm text-slate-500 mb-2">Xe máy • <?= $b['brand'] ?></p>
                                <p class="font-bold mb-4">
                                    <?= number_format($b['price_per_day'], 0, ',', '.') ?>đ / ngày • 
                                    <?= number_format($b['price_per_hour'], 0, ',', '.') ?>đ / giờ
                                </p>
                                <div class="grid grid-cols-2 gap-2">
                                    <button onclick="viewReviews(<?= $b['vehicle_id'] ?>)" 
                                        class="w-full py-2 rounded-lg border border-gray-300 text-gray-700 font-semibold hover:bg-gray-50">
                                        Xem đánh giá
                                    </button>
                                    <button onclick="openBooking(
                                        <?= $b['vehicle_id'] ?>, 
                                        '<?= addslashes($b['vehicle_name']) ?>',
                                        <?= $b['price_per_day'] ?>,
                                        <?= $b['price_per_hour'] ?>,
                                        '<?= $b['image'] ? '/ITS/assets/img/vehicles/'.$b['image'] : '' ?>',
                                        'XEMAY'
                                    )" class="w-full py-2 rounded-lg text-white font-semibold"
                                        style="background:var(--primary-color)">Đặt lịch</button>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </section>
                    <?php endif; ?>

                    <?php if(count($cars) === 0 && count($bikes) === 0): ?>
                        <div class="text-center py-10 bg-gray-50 rounded-xl">
                            <p class="text-xl text-gray-500">❌ Không tìm thấy xe nào tại trạm này.</p>
                        </div>
                    <?php endif; ?>

                <?php else: ?>
                    <div class="text-center py-20 bg-gray-50 rounded-xl">
                        <p class="text-xl text-gray-500">Vui lòng chọn trạm và nhấn <b>"Tìm xe"</b> để xem danh sách.</p>
                    </div>
                <?php endif; ?>

                <!-- ===== MODAL ===== -->
                <div id="overlay" class="fixed inset-0 bg-black/50 hidden z-[9998]"></div>

                <!-- Vehicle Detail Modal -->
    <div id="detailModal" class="fixed inset-0 hidden z-[9999] flex items-center justify-center px-4 pointer-events-none">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-4xl max-h-[90vh] overflow-y-auto pointer-events-auto transform scale-95 opacity-0 transition-all duration-300 flex flex-col" id="detailModalContent">
            
            <!-- Header -->
            <div class="flex justify-between items-center p-5 border-b sticky top-0 z-20 shadow-sm shrink-0" style="background:var(--primary-color); color:white;">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-white/20 rounded-lg backdrop-blur-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold" id="detailTitle">Thông tin phương tiện</h3>
                </div>
                <button onclick="closeDetails()" class="p-2 hover:bg-white/20 rounded-full transition text-white/90 hover:text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="p-6 overflow-y-auto custom-scrollbar">
                <!-- Vehicle Info -->
                <div class="flex flex-col md:flex-row gap-8 mb-10">
                    <div class="w-full md:w-5/12">
                        <div class="relative group rounded-2xl overflow-hidden shadow-lg border border-slate-100">
                            <img id="detailImage" src="" alt="Vehicle Image" class="w-full h-64 object-cover transform group-hover:scale-105 transition duration-500">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition duration-300 flex items-end p-4">
                                <span class="text-white text-sm font-medium">Hình ảnh thực tế</span>
                            </div>
                        </div>
                    </div>
                    <div class="w-full md:w-7/12 space-y-5">
                        <h2 id="detailName" class="text-3xl font-bold text-slate-800 tracking-tight"></h2>
                        
                        <div class="grid grid-cols-2 gap-4">
                            <div class="bg-indigo-50 p-3 rounded-xl border border-indigo-100">
                                <span class="block text-xs text-indigo-500 font-bold uppercase tracking-wider mb-1">Hãng xe</span>
                                <span id="detailBrand" class="font-semibold text-slate-700 text-lg"></span>
                            </div>
                            <div class="bg-indigo-50 p-3 rounded-xl border border-indigo-100">
                                <span class="block text-xs text-indigo-500 font-bold uppercase tracking-wider mb-1">Đời xe</span>
                                <span id="detailYear" class="font-semibold text-slate-700 text-lg"></span>
                            </div>
                            <div class="bg-indigo-50 p-3 rounded-xl border border-indigo-100">
                                <span class="block text-xs text-indigo-500 font-bold uppercase tracking-wider mb-1">Số chỗ</span>
                                <span id="detailSeats" class="font-semibold text-slate-700 text-lg"></span>
                            </div>
                            <div class="bg-indigo-50 p-3 rounded-xl border border-indigo-100">
                                <span class="block text-xs text-indigo-500 font-bold uppercase tracking-wider mb-1">Kiểu xe</span>
                                <span id="detailModel" class="font-semibold text-slate-700 text-lg"></span>
                            </div>
                        </div>

                        <div class="bg-slate-50 p-4 rounded-xl border border-slate-100">
                            <span class="flex items-center gap-2 text-xs text-slate-500 font-bold uppercase tracking-wider mb-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" /></svg>
                                Mô tả
                            </span>
                            <p id="detailDesc" class="text-slate-600 leading-relaxed text-sm"></p>
                        </div>
                    </div>
                </div>

                <!-- Policies Section -->
                <div class="mb-10">
                    <h4 class="text-xl font-bold text-slate-800 mb-6 flex items-center gap-3">
                        <span class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        </span>
                        Chính sách & Điều khoản
                    </h4>
                    
                    <div class="grid md:grid-cols-2 gap-6">
                        <div class="space-y-4">
                            <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm hover:shadow-md transition">
                                <h5 class="font-bold text-slate-700 mb-2 flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                    Thời gian nhận/trả
                                </h5>
                                <p class="text-sm text-slate-600">Nhận xe <b>24/7</b>. Trả xe trễ quá 30 phút tính thêm phí.</p>
                            </div>
                            <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm hover:shadow-md transition">
                                <h5 class="font-bold text-slate-700 mb-2 flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                    Thủ tục nhận xe
                                </h5>
                                <p class="text-sm text-slate-600">Yêu cầu <b>CCCD/CMND</b> & <b>Bằng lái</b> phù hợp. Xe máy có thể yêu cầu cọc.</p>
                            </div>
                        </div>
                        
                        <div class="bg-amber-50 rounded-xl p-5 border border-amber-100 shadow-sm">
                            <h5 class="font-bold text-amber-800 mb-4 flex items-center gap-2 border-b border-amber-200 pb-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                                Quy định quan trọng
                            </h5>
                            <ul class="space-y-3 text-sm text-amber-900">
                                <li class="flex items-start gap-2">
                                    <span class="mt-1 w-1.5 h-1.5 rounded-full bg-amber-600 shrink-0"></span>
                                    <span><b>Pháp lý:</b> Chỉ sử dụng hợp pháp. Nghiêm cấm cầm cố, thế chấp, cho thuê lại.</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <span class="mt-1 w-1.5 h-1.5 rounded-full bg-amber-600 shrink-0"></span>
                                    <span><b>Vệ sinh:</b> Cấm hút thuốc, chở hàng cấm/nặng mùi. Giữ xe sạch sẽ (vi phạm thu phí vệ sinh).</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <span class="mt-1 w-1.5 h-1.5 rounded-full bg-amber-600 shrink-0"></span>
                                    <div class="w-full">
                                        <b>Giới hạn Km/Chuyến:</b>
                                        <div class="grid grid-cols-2 gap-x-2 gap-y-1 mt-1 text-amber-800 opacity-90 text-xs">
                                            <span>• 4h: 250km</span>
                                            <span>• 8h: 300km</span>
                                            <span>• 12h: 350km</span>
                                            <span>• 24h: 400km</span>
                                        </div>
                                        <span class="block mt-1 italic text-xs text-red-600 font-medium">→ Vượt mức: 3.000đ/km</span>
                                    </div>
                                </li>
                                <li class="text-center pt-2 font-bold text-red-500 scale-95 border-t border-amber-200 mt-2">
                                    Vi phạm có thể bị từ chối phục vụ!
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Surcharges Section -->
                <div>
                    <h4 class="text-xl font-bold text-slate-800 mb-6 flex items-center gap-3">
                        <span class="w-10 h-10 rounded-full bg-red-100 flex items-center justify-center text-red-600 shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </span>
                        Biểu phí phụ thu
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Late Fee -->
                        <div class="bg-red-50 p-5 rounded-2xl border border-red-100 flex flex-col justify-between">
                            <div>
                                <div class="flex justify-between items-start mb-2">
                                    <span class="font-bold text-slate-700 text-lg">Phí trả trễ</span>
                                    <span class="font-extrabold text-red-600 text-xl" id="detailLateFee">-- đ/giờ</span>
                                </div>
                                <p class="text-sm text-slate-600 mb-3">
                                    (Tính bằng 20% giá thuê ngày). Nên mua thêm gói giờ để tiết kiệm chi phí.
                                </p>
                            </div>
                            <div class="text-xs font-semibold text-red-500 bg-white p-2 rounded-lg text-center border border-red-100">
                                ⚠️ Vui lòng gia hạn trước 1 tiếng
                            </div>
                        </div>

                        <!-- Fuel -->
                        <div class="bg-slate-50 p-5 rounded-2xl border border-slate-200">
                            <div class="flex justify-between items-center mb-2">
                                <span class="font-bold text-slate-700">Nhiên liệu</span>
                                <span class="font-bold text-slate-900 text-lg">27.000 đ/lít</span>
                            </div>
                            <p class="text-xs text-slate-500">
                                Thu khi trả xe không đúng vạch xăng cũ.
                            </p>
                            <hr class="my-3 border-slate-200">
                            <div class="flex justify-between items-center mb-2">
                                <span class="font-bold text-slate-700">Vệ sinh</span>
                                <span class="font-bold text-slate-900 text-lg">150.000 đ</span>
                            </div>
                            <p class="text-xs text-slate-500">
                                Thu nếu xe bẩn, có mùi hôi, rác thải.
                            </p>
                        </div>

                        <!-- Mileage & Tolls -->
                        <div class="bg-slate-50 p-5 rounded-2xl border border-slate-200 md:col-span-2 flex flex-col md:flex-row gap-6">
                            <div class="flex-1">
                                <div class="flex justify-between items-center mb-2">
                                    <span class="font-bold text-slate-700">Phí vượt Km</span>
                                    <span class="font-bold text-slate-900 text-lg">3.000 đ/km</span>
                                </div>
                                <p class="text-xs text-slate-500">
                                    Áp dụng cho mỗi km vượt định mức quy định.
                                </p>
                            </div>
                            <div class="hidden md:block w-px bg-slate-200"></div>
                            <div class="flex-1">
                                <div class="flex justify-between items-center mb-2">
                                    <span class="font-bold text-slate-700">Phí cầu đường</span>
                                    <span class="font-bold text-slate-900 text-lg">Thực tế</span>
                                </div>
                                <p class="text-xs text-slate-500">
                                    Thanh toán theo phát sinh trên tài khoản VETC.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Footer -->
            <div class="p-5 border-t bg-slate-50 flex justify-end shrink-0 z-20">
                <button onclick="closeDetails()" class="px-8 py-3 bg-slate-200 hover:bg-slate-300 text-slate-700 font-bold rounded-xl transition shadow-sm hover:shadow">Đóng lại</button>
            </div>
        </div>
    </div>

    <div id="modal" class="fixed inset-0 hidden z-[9999] flex items-center justify-center px-4">
                    <form id="bookingForm" method="POST" action="/ITS/assets/php/user/submit_booking.php" 
                          class="bg-white w-full max-w-2xl rounded-2xl shadow-xl flex flex-col max-h-[90vh]">
                        
                        <input type="hidden" name="station_id" id="formStationId">
                        <input type="hidden" name="vehicle_name" id="formVehicleName">
                        <input type="hidden" name="vehicle_id" id="formVehicleId">
                        <input type="hidden" name="total_amount" id="formTotal">
                        
                        <!-- Hidden inputs for submission -->
                        <input type="hidden" name="start_date" id="sub_startDate">
                        <input type="hidden" name="start_time" id="sub_startTime">
                        <input type="hidden" name="end_date" id="sub_endDate">
                        <input type="hidden" name="end_time" id="sub_endTime">


                        <div class="flex justify-between items-center p-5 border-b shrink-0 rounded-t-2xl" style="background:var(--primary-color); color:white;">
                            <h3 class="text-lg font-semibold">Đặt lịch thuê xe</h3>
                            <button type="button" onclick="closeBooking()" class="text-xl opacity-80 hover:opacity-100">&times;</button>
                        </div>

                        <div class="p-5 overflow-y-auto space-y-5">
                            
                            <!-- DEPOSIT POLICY ALERT -->
                            <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded-r shadow-sm">
                                <div class="flex items-center mb-2">
                                    <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    <h4 class="font-bold text-blue-800">Chính sách Cọc & Hoàn tiền</h4>
                                </div>
                                <ul class="text-sm text-blue-900 space-y-1 ml-1 list-disc list-inside">
                                    <li><b>Cọc bắt buộc:</b> Xe máy 300k, Ô tô 500k (Hoàn 100% trong 1-3 ngày sau khi trả xe đúng hạn).</li>
                                    <li><b>Trả muộn:</b> Tự động trừ vào tiền cọc.</li>
                                    <li><b>Nợ xấu:</b> Khóa tài khoản vĩnh viễn và chuyển thu hồi nợ nếu không thanh toán đủ.</li>
                                </ul>
                            </div>

                            <!-- XE TYPE INFO -->
                            <div class="flex gap-4 bg-slate-50 p-4 rounded-xl">
                                <img id="m_img" src="" class="w-20 h-16 rounded object-cover">
                                <div>
                                    <h4 id="m_name" class="font-semibold"></h4>
                                    <p id="m_price" class="text-sm text-slate-500"></p>
                                </div>
                            </div>

                            <!-- TABS -->
                            <div class="grid grid-cols-2 gap-2">
                                <button type="button" id="tabDay" onclick="setMode('day')"
                                    class="py-2 rounded-lg bg-blue-50 text-blue-600 font-medium">
                                    Theo ngày
                                </button>
                                <button type="button" id="tabHour" onclick="setMode('hour')"
                                    class="py-2 rounded-lg border font-medium">
                                    Theo giờ
                                </button>
                            </div>

                            <!-- INPUTS -->
                            <div id="dayForm" class="space-y-4">
                                <div class="grid grid-cols-2 gap-3">
                                    <div>
                                        <label class="text-sm text-slate-600">Ngày nhận</label>
                                        <input type="date" id="dayStart" class="w-full border rounded-lg px-4 py-2">
                                    </div>
                                    <div>
                                        <label class="text-sm text-slate-600">Giờ nhận</label>
                                        <select id="dayStartTime" class="w-full border rounded-lg px-4 py-2"></select>
                                    </div>
                                </div>
                                <div class="grid grid-cols-2 gap-3">
                                    <div>
                                        <label class="text-sm text-slate-600">Ngày trả</label>
                                        <input type="date" id="dayEnd" class="w-full border rounded-lg px-4 py-2">
                                    </div>
                                    <div>
                                        <label class="text-sm text-slate-600">Giờ trả</label>
                                        <select id="dayEndTime" class="w-full border rounded-lg px-4 py-2"></select>
                                    </div>
                                </div>
                            </div>

                            <div id="hourForm" class="space-y-4 hidden">
                                <div class="grid grid-cols-2 gap-3">
                                    <div>
                                        <label class="text-sm text-slate-600">Ngày thuê</label>
                                        <input type="date" id="hourDate" class="w-full border rounded-lg px-4 py-2">
                                    </div>
                                    <div>
                                        <label class="text-sm text-slate-600">Giờ nhận</label>
                                        <select id="hourStartTime" class="w-full border rounded-lg px-4 py-2"></select>
                                    </div>
                                </div>
                                <div>
                                    <label class="text-sm text-slate-600">Số giờ thuê</label>
                                    <input type="number" id="hourCount" min="1" value="1"
                                        class="w-full border rounded-lg px-4 py-2">
                                </div>
                                <div class="bg-slate-50 rounded-lg p-3 text-center">
                                    <p class="text-sm text-slate-500">Giờ trả xe</p>
                                    <p id="hourReturn" class="text-lg font-semibold text-slate-800">--</p>
                                </div>
                            </div>

                            

                            <!-- RESULTS TABLE -->
                            <div id="resultSection" class="hidden">
                                <h4 class="font-semibold mb-2">Danh sách xe</h4>
                                <div class="border rounded-lg overflow-hidden max-h-48 overflow-y-auto">
                                    <table class="w-full text-sm text-left">
                                        <thead class="bg-gray-100 text-gray-600">
                                            <tr>
                                                <th class="px-4 py-2">Biển số</th>
                                                <th class="px-4 py-2">Trạng thái</th>
                                                <th class="px-4 py-2 text-center">Chọn</th>
                                            </tr>
                                        </thead>
                                        <tbody id="resultBody" class="divide-y"></tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- TOTAL -->
                            <div class="bg-slate-50 p-4 rounded-xl text-center">
                                <p class="text-sm text-slate-500">Tạm tính</p>
                                <p id="totalDisplay" class="text-2xl font-bold">0đ</p>
                            </div>
                            <!-- FIND BUTTON -->
                            <button type="button" onclick="findCars()" 
                                class="w-full py-2 rounded-lg bg-green-600 text-white font-medium hover:opacity-80">
                                🔍 Tìm xe trống
                            </button>
                            <!-- PAYMENT METHOD -->
                            <div class="space-y-3">
                                <p class="font-semibold text-gray-700">Phương thức thanh toán</p>
                                
                                <label class="flex items-center justify-between p-3 border rounded-lg cursor-pointer hover:bg-slate-50 transition">
                                    <div class="flex items-center gap-3">
                                        <div class="w-5 h-5 rounded-full border border-gray-300 flex items-center justify-center">
                                            <input type="radio" name="payment_method" value="CASH" checked class="accent-blue-600">
                                        </div>
                                        <span>💵 Tiền mặt (Thanh toán tại trạm)</span>
                                    </div>
                                </label>

                                <label class="flex items-center justify-between p-3 border rounded-lg cursor-pointer hover:bg-slate-50 transition">
                                    <div class="flex items-center gap-3">
                                        <div class="w-5 h-5 rounded-full border border-gray-300 flex items-center justify-center">
                                            <input type="radio" name="payment_method" value="MOMO" class="accent-pink-600">
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <img src="/ITS/assets/img/momo_logo.png" class="h-6 w-6">
                                            <span class="text-pink-600 font-medium">Ví MoMo / ATM</span>
                                        </div>
                                    </div>
                                </label>
                            </div>

                            <button type="submit" id="btnPayment" disabled
                                class="w-full py-3 rounded-lg text-white font-semibold flex justify-center gap-2 items-center disabled:opacity-50 disabled:cursor-not-allowed"
                                style="background:var(--primary-color)">
                                <span>Xác nhận & Thanh toán</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>

                        </div>
                    </form>
                </div>

            </main>

      <!-- Footer -->
    <?php include '../../../includes/footer.php'; ?>

    <!-- Review Modal -->
    <div id="reviewModal" class="fixed inset-0 hidden z-[9999] flex items-center justify-center px-4">
        <div class="absolute inset-0 bg-black/50" onclick="closeReviews()"></div>
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-2xl max-h-[80vh] flex flex-col relative z-10 animate-fade-in-up">
            
            <!-- Header -->
            <div class="p-5 border-b flex justify-between items-center bg-white rounded-t-2xl sticky top-0 z-10">
                <div>
                    <h3 class="text-xl font-bold text-gray-800" id="reviewVehicleName">Đánh giá xe</h3>
                    <div class="flex items-center gap-2 text-yellow-500 mt-1">
                        <span class="text-2xl font-bold" id="reviewAvgRating">0.0</span>
                        <div class="flex" id="reviewStars"></div>
                        <span class="text-gray-500 text-sm ml-2">(<span id="reviewCount">0</span> đánh giá)</span>
                    </div>
                </div>
                <button onclick="closeReviews()" class="p-2 hover:bg-gray-100 rounded-full text-gray-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Body -->
            <div class="p-0 overflow-y-auto bg-gray-50" id="reviewList"></div>

            <!-- Footer -->
            <div class="p-4 border-t bg-white rounded-b-2xl text-center text-sm text-gray-500">
                Chỉ khách hàng đã thuê xe mới có thể viết đánh giá.
            </div>
        </div>
    </div>
    <script src="../../../js/main.js"></script>
    <!-- ================= JS ================= -->
    <script>
    let priceDay = 0;
    let priceHour = 0;
    let mode = 'day';
    // Init from PHP to handle direct URL access
    let currentStationId = <?= json_encode($selectedStationId ?? 0) ?>;
    let currentVehicleName = '';

    /* ================= DOM ================= */
    const overlay = document.getElementById('overlay');
    const modal = document.getElementById('modal');
    
    const m_img = document.getElementById('m_img');
    const m_name = document.getElementById('m_name');
    const m_price = document.getElementById('m_price');

    const formStationId = document.getElementById('formStationId');
    const formVehicleName = document.getElementById('formVehicleName');
    const formVehicleId = document.getElementById('formVehicleId');
    const formTotal = document.getElementById('formTotal');
    const sub_startDate = document.getElementById('sub_startDate');
    const sub_startTime = document.getElementById('sub_startTime');
    const sub_endDate = document.getElementById('sub_endDate');
    const sub_endTime = document.getElementById('sub_endTime');

    const dayForm = document.getElementById('dayForm');
    const dayStart = document.getElementById('dayStart');
    const dayStartTime = document.getElementById('dayStartTime');
    const dayEnd = document.getElementById('dayEnd');
    const dayEndTime = document.getElementById('dayEndTime');

    const hourForm = document.getElementById('hourForm');
    const hourDate = document.getElementById('hourDate');
    const hourStartTime = document.getElementById('hourStartTime');
    const hourCount = document.getElementById('hourCount');
    const hourReturn = document.getElementById('hourReturn');

    const resultSection = document.getElementById('resultSection');
    const resultBody = document.getElementById('resultBody');
    const btnPayment = document.getElementById('btnPayment');

    /* ================= OPEN DETAIL MODAL ================= */
    function openDetails(name, brand, model, seats, year, desc, image, priceDay) {
        document.getElementById('detailName').innerText = name;
        document.getElementById('detailBrand').innerText = brand;
        document.getElementById('detailModel').innerText = model;
        document.getElementById('detailSeats').innerText = seats;
        document.getElementById('detailYear').innerText = year;
        document.getElementById('detailDesc').innerText = desc || 'Không có mô tả chi tiết.';
        document.getElementById('detailImage').src = image || 'https://placehold.co/600x400?text=No+Image';

        // Calculate Late Fee (20% of Day Price)
        const lateFee = Math.round(priceDay * 0.2);
        document.getElementById('detailLateFee').innerText = lateFee.toLocaleString('vi-VN') + ' đ/giờ';

        const modal = document.getElementById('detailModal');
        const content = document.getElementById('detailModalContent');
        const overlay = document.getElementById('overlay');

        overlay.classList.remove('hidden');
        modal.classList.remove('hidden');
        
        setTimeout(() => {
            content.classList.remove('scale-95', 'opacity-0');
            content.classList.add('scale-100', 'opacity-100');
        }, 10);
    }

    function closeDetails() {
        const modal = document.getElementById('detailModal');
        const content = document.getElementById('detailModalContent');
        const overlay = document.getElementById('overlay');

        content.classList.remove('scale-100', 'opacity-100');
        content.classList.add('scale-95', 'opacity-0');

        setTimeout(() => {
            modal.classList.add('hidden');
            if(document.getElementById('modal').classList.contains('hidden')) {
                overlay.classList.add('hidden');
            }
        }, 300);
    }

    let currentVehicleType = 'XEMAY'; // Default
    let depositVal = 300000;

    /* ================= OPEN MODAL ================= */
    function openBooking(vehicleId, name, pDay, pHour, image, type = 'XEMAY') {
        // Pre-fill
        if(image) m_img.src = image;
        else m_img.src = 'https://placehold.co/100x100?text=No+Image';
        
        m_name.textContent = name;
        m_price.textContent = `${Number(pDay).toLocaleString('vi-VN')}đ/ngày • ${Number(pHour).toLocaleString('vi-VN')}đ/giờ`;

        priceDay = pDay;
        priceHour = pHour;
        currentVehicleName = name;
        currentVehicleType = type;
        
        // Set Deposit
        depositVal = (type === 'OTO' || type === 'CAR') ? 500000 : 300000;
        
        // Station ID check
        if(!currentStationId) {
            currentStationId = document.getElementById('filterStation').value;
        }
        
        if(!currentStationId) {
            Swal.fire({
                icon: 'warning',
                title: 'Chưa chọn trạm!',
                text: 'Vui lòng chọn trạm xe trước khi đặt lịch.',
                confirmButtonColor: '#3085d6'
            });
            return;
        }

        formStationId.value = currentStationId;
        formVehicleName.value = name;

        // Reset
        formVehicleId.value = '';
        btnPayment.disabled = true;
        resultSection.classList.add('hidden');
        resultBody.innerHTML = '';
        calc();

        overlay.classList.remove('hidden');
        modal.classList.remove('hidden');
    }

    function closeBooking() {
        overlay.classList.add('hidden');
        modal.classList.add('hidden');
    }



    function viewReviews(vehicleId) {
        const modal = document.getElementById('reviewModal');
        const reviewList = document.getElementById('reviewList');
        const vehicleNameEl = document.getElementById('reviewVehicleName');
        const avgRatingEl = document.getElementById('reviewAvgRating');
        const countEl = document.getElementById('reviewCount');
        const starsEl = document.getElementById('reviewStars');

        modal.classList.remove('hidden');
        
        // Loading State
        reviewList.innerHTML = `
            <div class="p-10 text-center text-gray-500">
                <svg class="animate-spin h-8 w-8 mx-auto mb-3 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Đang tải đánh giá...
            </div>
        `;

        fetch(`/ITS/assets/php/user/get_vehicle_reviews.php?vehicle_id=${vehicleId}`)
            .then(res => res.json())
            .then(res => {
                if(!res.success) {
                    reviewList.innerHTML = `<div class="p-10 text-center text-red-500">${res.message}</div>`;
                    return;
                }

                const { reviews, vehicle_name, avg_rating, total_reviews } = res.data;
                
                vehicleNameEl.textContent = vehicle_name;
                avgRatingEl.textContent = avg_rating;
                countEl.textContent = total_reviews;
                starsEl.innerHTML = renderStars(avg_rating);

                if(reviews.length === 0) {
                    reviewList.innerHTML = `
                        <div class="flex flex-col items-center justify-center p-12 text-gray-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mb-4 opacity-50" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                            </svg>
                            <p class="text-lg">Chưa có đánh giá nào</p>
                        </div>
                    `;
                } else {
                    let html = '';
                    reviews.forEach(r => {
                        html += `
                            <div class="p-5 border-b bg-white last:border-0 hover:bg-gray-50 transition">
                                <div class="flex items-start gap-4">
                                    <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold shrink-0 overflow-hidden">
                                        ${r.avatar ? `<img src="/ITS/assets/img/avatars/${r.avatar}" class="w-full h-full object-cover">` : r.full_name.charAt(0)}
                                    </div>
                                    <div class="flex-1">
                                        <div class="flex justify-between items-start mb-1">
                                            <div>
                                                <h4 class="font-bold text-gray-800">${r.full_name}</h4>
                                                <p class="text-xs text-gray-500">${new Date(r.created_at).toLocaleDateString('vi-VN')}</p>
                                            </div>
                                            <div class="flex text-yellow-500 text-sm">
                                                ${renderStars(r.rating)}
                                            </div>
                                        </div>
                                        <p class="text-gray-700 leading-relaxed">${r.comment || '<span class="italic text-gray-400">Không có nhận xét</span>'}</p>
                                    </div>
                                </div>
                            </div>
                        `;
                    });
                    reviewList.innerHTML = html;
                }
            })
            .catch(err => {
                console.error(err);
                reviewList.innerHTML = `<div class="p-10 text-center text-red-500">Không thể tải đánh giá. Vui lòng thử lại sau.</div>`;
            });
    }

    function closeReviews() {
        document.getElementById('reviewModal').classList.add('hidden');
    }

    function renderStars(rating) {
        let stars = '';
        for (let i = 1; i <= 5; i++) {
            if (i <= Math.round(rating)) {
                stars += `<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" /></svg>`;
            } else {
                stars += `<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-300 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" /></svg>`;
            }
        }
        return stars;
    }


    /* ================= MODE & TIME ================= */
    function setMode(m) {
        mode = m;
        dayForm.classList.toggle('hidden', m !== 'day');
        hourForm.classList.toggle('hidden', m !== 'hour');
        
        document.getElementById('tabDay').className = m === 'day' ? 'py-2 rounded-lg bg-blue-50 text-blue-600 font-medium' : 'py-2 rounded-lg border font-medium';
        document.getElementById('tabHour').className = m === 'hour' ? 'py-2 rounded-lg bg-blue-50 text-blue-600 font-medium' : 'py-2 rounded-lg border font-medium';
        calc();
    }

    function genTimes(select) {
        select.innerHTML = '';
        for (let h = 0; h < 24; h++) {
            for (let m of [0, 30]) {
                const t = `${String(h).padStart(2,'0')}:${String(m).padStart(2,'0')}`;
                const opt = document.createElement('option');
                opt.value = t + ':00';
                opt.textContent = t;
                select.appendChild(opt);
            }
        }
    }
    genTimes(dayStartTime);
    genTimes(dayEndTime);
    genTimes(hourStartTime);

    /* ================= CALC & FIND ================= */
    function getTimes() {
        if (mode === 'day') {
            if (!dayStart.value || !dayEnd.value) return null;
            return {
                start_date: dayStart.value,
                start_time: dayStartTime.value,
                end_date: dayEnd.value,
                end_time: dayEndTime.value
            };
        } else {
            if (!hourDate.value || hourCount.value <= 0) return null;
            const start = new Date(`${hourDate.value}T${hourStartTime.value}`);
            const end = new Date(start);
            end.setHours(end.getHours() + parseInt(hourCount.value));
            
            // Fix Timezone Issue: use Local YYYY-MM-DD
            const y = end.getFullYear();
            const m = String(end.getMonth() + 1).padStart(2, '0');
            const d = String(end.getDate()).padStart(2, '0');
            const localEndDate = `${y}-${m}-${d}`;

            return {
                start_date: hourDate.value,
                start_time: hourStartTime.value,
                end_date: localEndDate,
                end_time: end.toTimeString().split(' ')[0]
            };
        }
    }

    function calc() {
        const t = getTimes();
        let amount = 0;

        if (t) {
            if (mode === 'day') {
                const s = new Date(`${t.start_date}T${t.start_time}`);
                const e = new Date(`${t.end_date}T${t.end_time}`);
                
                // Validate Strict Date Comparison if requested
                if (t.start_date >= t.end_date) {
                    totalPriceEl.innerText = 'Ngày trả phải sau ngày nhận';
                    return;
                }

                if (e > s) {
                    const days = Math.ceil((e - s) / 86400000);
                    amount = days * priceDay;
                }
            } else {
                amount = parseInt(hourCount.value) * priceHour;
                hourReturn.innerText = t.end_time.slice(0, 5);
            }
        }
        
        // Add Deposit
        if(amount > 0) {
            amount += depositVal;
            document.getElementById('totalDisplay').innerHTML = `
                <span class="block">${(amount - depositVal).toLocaleString('vi-VN')}đ (Thuê xe)</span>
                <span class="block text-sm font-normal text-blue-600">+ ${depositVal.toLocaleString('vi-VN')}đ (Cọc)</span>
                <span class="block border-t mt-1 pt-1 text-3xl text-red-600">= ${amount.toLocaleString('vi-VN')}đ</span>
            `;
        } else {
            document.getElementById('totalDisplay').innerText = '0đ';
        }

        formTotal.value = amount;
        
        if(t && document.getElementById('totalDisplay').innerText !== '0đ' && document.getElementById('totalDisplay').innerText !== 'Ngày trả phải sau ngày nhận'){
            sub_startDate.value = t.start_date;
            sub_startTime.value = t.start_time;
            sub_endDate.value = t.end_date;
            sub_endTime.value = t.end_time;
        }
    }

    function findCars() {
        const times = getTimes();
        if(!times) {
            alert("Vui lòng chọn thời gian hợp lệ");
            return;
        }

        if(mode === 'day' && times.start_date >= times.end_date) {
            alert("Vui lòng chọn ngày trả xe LỚN HƠN ngày nhận xe (ít nhất 1 ngày)");
            return;
        }

        // Call API
        fetch('/ITS/assets/php/user/find_available_cars.php', {
            method: 'POST',
            body: JSON.stringify({
                station_id: currentStationId,
                vehicle_name: currentVehicleName,
                ...times
            })
        })
        .then(res => res.json())
        .then(res => {
            if(!res.success) {
                alert(res.message);
                return;
            }
            renderResults(res.data);
        });
    }

    function renderResults(cars) {
        resultBody.innerHTML = '';
        if(cars.length === 0) {
            resultBody.innerHTML = '<tr><td colspan="3" class="text-center py-4">Không tìm thấy xe nào</td></tr>';
        } else {
            cars.forEach(c => {
                const tr = document.createElement('tr');
                const isBusy = c.status === 'BUSY';
                tr.className = isBusy ? 'bg-gray-50 opacity-50' : 'hover:bg-blue-50 cursor-pointer';
                
                tr.innerHTML = `
                    <td class="px-4 py-2 font-mono">${c.license_plate}</td>
                    <td class="px-4 py-2">
                        <span class="px-2 py-1 rounded text-xs font-bold ${isBusy ? 'bg-red-100 text-red-600' : 'bg-green-100 text-green-600'}">
                            ${isBusy ? 'Đã đặt' : 'Sẵn sàng'}
                        </span>
                    </td>
                    <td class="px-4 py-2 text-center">
                        <input type="radio" name="select_vehicle" 
                               ${isBusy ? 'disabled' : ''} 
                               onchange="selectCar(${c.vehicle_id})"
                               class="w-5 h-5 accent-blue-600">
                    </td>
                `;
                resultBody.appendChild(tr);
            });
        }
        resultSection.classList.remove('hidden');
    }

    function selectCar(id) {
        formVehicleId.value = id;
        btnPayment.disabled = false;
    }

    // Listeners
    [dayStart, dayStartTime, dayEnd, dayEndTime, hourDate, hourStartTime, hourCount].forEach(el => {
        el.addEventListener('change', () => {
             calc();
             // Reset Selection when time changes
             formVehicleId.value = '';
             btnPayment.disabled = true;
             resultSection.classList.add('hidden');
        });
    });

    // Toggle Section
    function toggleSection(sectionId, btn) {
        const section = document.getElementById(sectionId);
        const icon = btn.querySelector('svg');
        if (section.classList.contains('hidden')) {
            section.classList.remove('hidden');
            icon.style.transform = 'rotate(0deg)';
        } else {
            section.classList.add('hidden');
            icon.style.transform = 'rotate(180deg)';
        }
    }

    // Overlay Clicker to Close Modals
    overlay.addEventListener('click', function() {
        if(!modal.classList.contains('hidden')) closeBooking();
        if(!document.getElementById('detailModal').classList.contains('hidden')) closeDetails();
    });

    /* ================= REVIEW FUNCTIONS ================= */
    function viewReviews(vehicleId) {
        const modal = document.getElementById('reviewModal');
        const reviewList = document.getElementById('reviewList');
        const vehicleNameEl = document.getElementById('reviewVehicleName');
        const avgRatingEl = document.getElementById('reviewAvgRating');
        const countEl = document.getElementById('reviewCount');
        const starsEl = document.getElementById('reviewStars');

        if(!modal) {
             console.error('Review Modal element not found');
             alert('Có lỗi xảy ra, vui lòng tải lại trang');
             return;
        }

        modal.classList.remove('hidden');
        
        // Loading State
        reviewList.innerHTML = `
            <div class="p-10 text-center text-gray-500">
                <svg class="animate-spin h-8 w-8 mx-auto mb-3 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Đang tải đánh giá...
            </div>
        `;

        fetch(`/ITS/assets/php/user/get_vehicle_reviews.php?vehicle_id=${vehicleId}`)
            .then(res => res.json())
            .then(res => {
                if(!res.success) {
                    reviewList.innerHTML = `<div class="p-10 text-center text-red-500">${res.message}</div>`;
                    return;
                }

                const { reviews, vehicle_name, avg_rating, total_reviews } = res.data;
                
                vehicleNameEl.textContent = vehicle_name;
                avgRatingEl.textContent = avg_rating;
                countEl.textContent = total_reviews;
                starsEl.innerHTML = renderStars(avg_rating);

                if(reviews.length === 0) {
                    reviewList.innerHTML = `
                        <div class="flex flex-col items-center justify-center p-12 text-gray-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mb-4 opacity-50" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                            </svg>
                            <p class="text-lg">Chưa có đánh giá nào</p>
                        </div>
                    `;
                } else {
                    let html = '';
                    reviews.forEach(r => {
                        html += `
                            <div class="p-5 border-b bg-white last:border-0 hover:bg-gray-50 transition">
                                <div class="flex items-start gap-4">
                                    <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold shrink-0 overflow-hidden">
                                        ${r.avatar ? `<img src="/ITS/assets/img/avatars/${r.avatar}" class="w-full h-full object-cover">` : r.full_name.charAt(0)}
                                    </div>
                                    <div class="flex-1">
                                        <div class="flex justify-between items-start mb-1">
                                            <div>
                                                <h4 class="font-bold text-gray-800">${r.full_name}</h4>
                                                <p class="text-xs text-gray-500">${new Date(r.created_at).toLocaleDateString('vi-VN')}</p>
                                            </div>
                                            <div class="flex text-yellow-500 text-sm">
                                                ${renderStars(r.rating)}
                                            </div>
                                        </div>
                                        <p class="text-gray-700 leading-relaxed">${r.comment || '<span class="italic text-gray-400">Không có nhận xét</span>'}</p>
                                        
                                        ${r.reply ? `
                                            <div class="mt-3 bg-blue-50 p-3 rounded-lg border border-blue-100">
                                                <p class="text-xs font-bold text-blue-800 mb-1">💬 Admin phản hồi:</p>
                                                <p class="text-sm text-gray-700">${r.reply}</p>
                                                <p class="text-xs text-gray-400 mt-1 text-right">${new Date(r.replied_at).toLocaleDateString('vi-VN')}</p>
                                            </div>
                                        ` : ''}
                                    </div>
                                </div>
                            </div>
                        `;
                    });
                    reviewList.innerHTML = html;
                }
            })
            .catch(err => {
                console.error(err);
                reviewList.innerHTML = `<div class="p-10 text-center text-red-500">Không thể tải đánh giá. Vui lòng thử lại sau.</div>`;
            });
    }

    function closeReviews() {
        const modal = document.getElementById('reviewModal');
        if(modal) modal.classList.add('hidden');
    }

    function renderStars(rating) {
        let stars = '';
        for (let i = 1; i <= 5; i++) {
            if (i <= Math.round(rating)) {
                stars += `<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" /></svg>`;
            } else {
                stars += `<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-300 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" /></svg>`;
            }
        }
        return stars;
    }
    </script>


</body>

</html>