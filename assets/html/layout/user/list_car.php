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
                                <h3 class="font-semibold text-lg"><?= $c['vehicle_name'] ?></h3>
                                <p class="text-sm text-slate-500 mb-2"><?= $c['seats'] ?> chỗ • <?= $c['brand'] ?></p>
                                <p class="font-bold mb-4">
                                    <?= number_format($c['price_per_day'], 0, ',', '.') ?>đ / ngày • 
                                    <?= number_format($c['price_per_hour'], 0, ',', '.') ?>đ / giờ
                                </p>
                                <button onclick="openBooking(
                                    <?= $c['vehicle_id'] ?>, 
                                    '<?= addslashes($c['vehicle_name']) ?>',
                                    <?= $c['price_per_day'] ?>,
                                    <?= $c['price_per_hour'] ?>,
                                    '<?= $c['image'] ? '/ITS/assets/img/vehicles/'.$c['image'] : '' ?>'
                                )" class="w-full py-2 rounded-lg text-white font-semibold"
                                    style="background:var(--primary-color)">Đặt lịch</button>
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
                                <h3 class="font-semibold text-lg"><?= $b['vehicle_name'] ?></h3>
                                <p class="text-sm text-slate-500 mb-2">Xe máy • <?= $b['brand'] ?></p>
                                <p class="font-bold mb-4">
                                    <?= number_format($b['price_per_day'], 0, ',', '.') ?>đ / ngày • 
                                    <?= number_format($b['price_per_hour'], 0, ',', '.') ?>đ / giờ
                                </p>
                                <button onclick="openBooking(
                                    <?= $b['vehicle_id'] ?>, 
                                    '<?= addslashes($b['vehicle_name']) ?>',
                                    <?= $b['price_per_day'] ?>,
                                    <?= $b['price_per_hour'] ?>,
                                    '<?= $b['image'] ? '/ITS/assets/img/vehicles/'.$b['image'] : '' ?>'
                                )" class="w-full py-2 rounded-lg text-white font-semibold"
                                    style="background:var(--primary-color)">Đặt lịch</button>
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
                <div id="overlay" class="fixed inset-0 bg-black/50 hidden z-40"></div>

                <div id="modal" class="fixed inset-0 hidden z-50 flex items-center justify-center px-4">

                    <div class="bg-white w-full max-w-lg rounded-2xl shadow-xl">

                        <div class="flex justify-between items-center p-5 border-b">
                            <h3 class="text-lg font-semibold">Đặt lịch thuê xe</h3>
                            <button onclick="closeBooking()" class="text-xl">&times;</button>
                        </div>

                        <div class="p-5 space-y-5">

                            <!-- XE -->
                            <div class="flex gap-4 bg-slate-50 p-4 rounded-xl">
                                <img src="https://images.unsplash.com/photo-1549924231-f129b911e442"
                                    class="w-20 h-16 rounded object-cover">
                                <div>
                                    <h4 class="font-semibold">Toyota Vios</h4>
                                    <p class="text-sm text-slate-500">
                                        600.000đ/ngày • 80.000đ/giờ
                                    </p>
                                </div>
                            </div>

                            <!-- TABS -->
                            <div class="grid grid-cols-2 gap-2">
                                <button id="tabDay" onclick="setMode('day')"
                                    class="py-2 rounded-lg bg-blue-50 text-blue-600 font-medium">
                                    Theo ngày
                                </button>
                                <button id="tabHour" onclick="setMode('hour')"
                                    class="py-2 rounded-lg border font-medium">
                                    Theo giờ
                                </button>
                            </div>

                            <!-- THEO NGÀY -->
                            <div id="dayForm" class="space-y-4">

                                <!-- Nhận xe -->
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

                                <!-- Trả xe -->
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


                            <!-- THEO GIỜ -->
                            <div id="hourForm" class="space-y-4 hidden">

                                <!-- Ngày + Giờ nhận -->
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

                                <!-- Số giờ thuê -->
                                <div>
                                    <label class="text-sm text-slate-600">Số giờ thuê</label>
                                    <input type="number" id="hourCount" min="1" value="1"
                                        class="w-full border rounded-lg px-4 py-2">
                                </div>

                                <!-- Giờ trả -->
                                <div class="bg-slate-50 rounded-lg p-3 text-center">
                                    <p class="text-sm text-slate-500">Giờ trả xe</p>
                                    <p id="hourReturn" class="text-lg font-semibold text-slate-800">--</p>
                                </div>

                            </div>


                            <!-- TOTAL -->
                            <div class="bg-slate-50 p-4 rounded-xl text-center">
                                <p class="text-sm text-slate-500">Tổng tiền</p>
                                <p id="total" class="text-2xl font-bold">0đ</p>
                            </div>

                            <button class="w-full py-3 rounded-lg text-white font-semibold"
                                style="background:var(--primary-color)">
                                Thanh toán
                            </button>

                        </div>
                    </div>
                </div>

            </main>

            <?php include '../../../includes/footer.php'; ?>

        </div>
    </div>
    <script src="../../../js/main.js"></script>
    <!-- ================= JS ================= -->
    <script>
    /* ================= CONFIG ================= */
    let priceDay = 0;
    let priceHour = 0;
    let mode = 'day';

    /* ================= DOM ================= */
    const overlay = document.getElementById('overlay');
    const modal = document.getElementById('modal');
    
    // Modal Elements for Dynamic Data
    const modalImg = modal.querySelector('img');
    const modalName = modal.querySelector('h4');
    const modalPrice = modal.querySelector('p.text-sm.text-slate-500');

    /* ... IDs ... */
    const dayForm = document.getElementById('dayForm');
    /* ... */

    /* ================= MODAL ================= */
    function openBooking(id, name, pDay, pHour, image) {
        // Update Modal Data
        if(image) modalImg.src = image;
        else modalImg.src = 'https://placehold.co/100x100?text=No+Image';
        
        modalName.textContent = name;
        modalPrice.textContent = `${pDay.toLocaleString('vi-VN')}đ/ngày • ${pHour.toLocaleString('vi-VN')}đ/giờ`;

        // Update Global Params for Calc
        priceDay = pDay;
        priceHour = pHour;
        
        // Reset Inputs or Calc
        calc();

        overlay.classList.remove('hidden');
        modal.classList.remove('hidden');
    }
    const hourForm = document.getElementById('hourForm');

    const tabDay = document.getElementById('tabDay');
    const tabHour = document.getElementById('tabHour');

    const dayStart = document.getElementById('dayStart');
    const dayStartTime = document.getElementById('dayStartTime');
    const dayEnd = document.getElementById('dayEnd');
    const dayEndTime = document.getElementById('dayEndTime');

    const hourDate = document.getElementById('hourDate');
    const hourStartTime = document.getElementById('hourStartTime');
    const hourCount = document.getElementById('hourCount');
    const hourReturn = document.getElementById('hourReturn');

    const totalPriceEl = document.getElementById('total');

    /* ================= MODAL ================= */
    function openBooking() {
        overlay.classList.remove('hidden');
        modal.classList.remove('hidden');
    }

    function closeBooking() {
        overlay.classList.add('hidden');
        modal.classList.add('hidden');
    }

    /* ================= MODE ================= */
    function setMode(m) {
        mode = m;

        dayForm.classList.toggle('hidden', m !== 'day');
        hourForm.classList.toggle('hidden', m !== 'hour');

        tabDay.className = m === 'day' ?
            'py-2 rounded-lg bg-blue-50 text-blue-600 font-medium' :
            'py-2 rounded-lg border font-medium';

        tabHour.className = m === 'hour' ?
            'py-2 rounded-lg bg-blue-50 text-blue-600 font-medium' :
            'py-2 rounded-lg border font-medium';

        calc();
    }

    /* ================= TIME OPTIONS ================= */
    function genTimes(select) {
        select.innerHTML = '';
        for (let h = 0; h < 24; h++) {
            for (let m of [0, 30]) {
                const t = `${String(h).padStart(2,'0')}:${String(m).padStart(2,'0')}`;
                const opt = document.createElement('option');
                opt.value = t;
                opt.textContent = t;
                select.appendChild(opt);
            }
        }
    }

    genTimes(dayStartTime);
    genTimes(dayEndTime);
    genTimes(hourStartTime);

    /* ================= CALC ================= */
    function calc() {
        let amount = 0;

        if (mode === 'day') {
            if (!dayStart.value || !dayEnd.value) {
                totalPriceEl.innerText = '0đ';
                return;
            }

            const start = new Date(`${dayStart.value}T${dayStartTime.value}`);
            const end = new Date(`${dayEnd.value}T${dayEndTime.value}`);

            if (end <= start) {
                totalPriceEl.innerText = '0đ';
                return;
            }

            const days = Math.ceil((end - start) / 86400000);
            amount = days * priceDay;
        }

        if (mode === 'hour') {
            if (!hourDate.value || hourCount.value <= 0) {
                totalPriceEl.innerText = '0đ';
                return;
            }

            const start = new Date(`${hourDate.value}T${hourStartTime.value}`);
            const hours = parseInt(hourCount.value, 10);

            const end = new Date(start);
            end.setHours(end.getHours() + hours);

            hourReturn.innerText = end.toTimeString().slice(0, 5);
            amount = hours * priceHour;
        }

        totalPriceEl.innerText = amount.toLocaleString('vi-VN') + 'đ';
    }

    /* ================= EVENTS ================= */
    [
        dayStart, dayStartTime, dayEnd, dayEndTime,
        hourDate, hourStartTime, hourCount
    ].forEach(el => {
        if (el) el.addEventListener('change', calc);
    });


    // toggle danh mục xe 
    function toggleSection(sectionId, btn) {
        const section = document.getElementById(sectionId);
        const icon = btn.querySelector('svg');

        // Toggle class để ẩn hiện
        if (section.classList.contains('hidden')) {
            section.classList.remove('hidden');
            icon.style.transform = 'rotate(0deg)';
        } else {
            section.classList.add('hidden');
            icon.style.transform = 'rotate(180deg)';
        }
    }
    </script>


</body>

</html>