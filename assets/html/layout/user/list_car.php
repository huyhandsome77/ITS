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
                <div id="overlay" class="fixed inset-0 bg-black/50 hidden z-[9998]"></div>

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

                            <!-- FIND BUTTON -->
                            <button type="button" onclick="findCars()" 
                                class="w-full py-2 rounded-lg bg-black text-white font-medium hover:opacity-80">
                                🔍 Tìm xe trống
                            </button>

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

            <?php include '../../../includes/footer.php'; ?>

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

    /* ================= OPEN MODAL ================= */
    function openBooking(vehicleId, name, pDay, pHour, image) {
        // Pre-fill
        if(image) m_img.src = image;
        else m_img.src = 'https://placehold.co/100x100?text=No+Image';
        
        m_name.textContent = name;
        m_price.textContent = `${Number(pDay).toLocaleString('vi-VN')}đ/ngày • ${Number(pHour).toLocaleString('vi-VN')}đ/giờ`;

        priceDay = pDay;
        priceHour = pHour;
        currentVehicleName = name;
        
        // Station ID check
        if(!currentStationId) {
            currentStationId = document.getElementById('filterStation').value;
        }
        
        if(!currentStationId) {
            alert("Vui lòng chọn trạm trước!");
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
        
        document.getElementById('totalDisplay').innerText = amount.toLocaleString('vi-VN') + 'đ';
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
    </script>


</body>

</html>