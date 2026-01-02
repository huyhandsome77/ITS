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

<body class="min-h-full font-[Inter]">
    <div id="app" class="flex min-h-screen">

        <?php include '../../../includes/sidebar.php'; ?>

        <div id="contentWrapper" class="flex-1 flex flex-col min-h-screen transition-all duration-300">

            <?php include '../../../includes/navbar.php'; ?>

            <!-- ================= MAIN ================= -->
            <main class="flex-1 overflow-auto p-4 md:p-6 lg:p-8" style="margin-top:76px">

                <!-- CHỌN TRẠM -->
                <section class="bg-white rounded-2xl shadow-sm border p-5 mb-6">
                    <h2 class="text-lg font-semibold mb-4">Chọn trạm xe</h2>

                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                        <select class="border rounded-lg px-4 py-2">
                            <option>Thành phố</option>
                            <option>TP.HCM</option>
                        </select>

                        <select class="border rounded-lg px-4 py-2">
                            <option>Quận / Huyện</option>
                            <option>Quận 1</option>
                        </select>

                        <select class="border rounded-lg px-4 py-2">
                            <option>Trạm xe</option>
                            <option>Nguyễn Huệ</option>
                        </select>

                        <button class="h-[42px] rounded-lg text-white font-semibold"
                            style="background:var(--primary-color)">
                            Tìm xe
                        </button>
                    </div>
                </section>

                <!-- DANH SÁCH XE -->
                <section class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div class="bg-white rounded-xl shadow border overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1549924231-f129b911e442"
                            class="h-48 w-full object-cover">

                        <div class="p-4">
                            <h3 class="font-semibold text-lg">Toyota Vios</h3>
                            <p class="text-sm text-slate-500 mb-2">5 chỗ • Tự động</p>
                            <p class="font-bold mb-4">600.000đ / ngày • 80.000đ / giờ</p>

                            <button onclick="openBooking()" class="w-full py-2 rounded-lg text-white font-semibold"
                                style="background:var(--primary-color)">
                                Đặt lịch
                            </button>
                        </div>
                    </div>
                </section>

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

    <!-- ================= JS ================= -->
    <script>
    /* ================= CONFIG ================= */
    const priceDay = 600000;
    const priceHour = 80000;
    let mode = 'day';

    /* ================= DOM ================= */
    const overlay = document.getElementById('overlay');
    const modal = document.getElementById('modal');

    const dayForm = document.getElementById('dayForm');
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
    </script>


</body>

</html>