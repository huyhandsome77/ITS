<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/ITS/assets/php/auth/check_permission.php';
requireDispatcher();
?>
<!doctype html>
<html lang="vi" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Điều tiết lưu lượng xe | Thuexe.com</title>

    <!-- FONT -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- STYLE -->

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../../../css/style.css">
</head>

<?php
$baseUrl = '../../../..';
?>

<body class="min-h-full font-[Inter]">
    <div id="app" class="flex min-h-screen">

        <!-- SIDEBAR DISPATCHER -->
        <?php include '../../../includes/dispatcher/dispatcher_sidebar.php'; ?>

        <!-- CONTENT -->
        <div id="contentWrapper" class="flex-1 flex flex-col min-h-screen
                ml-64 lg:ml-72 transition-all duration-300">

            <!-- NAVBAR -->
            <?php include '../../../includes/navbar.php'; ?>

            <!-- MAIN -->
            <main class="flex-1 overflow-auto p-4 md:p-6 lg:p-8" style="margin-top:76px">

                <!-- ===== HEADER ===== -->
                <div class="mb-10 animate-fadeInUp">
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="text-3xl font-extrabold text-slate-800 tracking-tight">
                                🚦 Điều tiết lưu lượng
                            </h1>
                            <p class="text-slate-500 mt-2 text-base">
                                Giám sát và phân phối xe giữa các trạm theo thời gian thực
                            </p>
                        </div>
                        <div class="hidden md:block">
                            <span class="px-4 py-2 bg-blue-50 text-blue-600 rounded-lg font-semibold text-sm border border-blue-100">
                                📅 Hôm nay: <?php echo date('d/m/Y'); ?>
                            </span>
                        </div>
                    </div>
                </div>

                <!-- ===== DASHBOARD OVERVIEW ===== -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12 animate-fadeInUp">

                    <!-- ===== TOTAL STATIONS ===== -->
                    <div class="group bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 p-1 border border-slate-100">
                        <div class="p-6 h-full flex flex-col justify-between">
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <p class="text-sm font-semibold text-slate-400 uppercase tracking-wilder mb-1">Tổng trạm</p>
                                    <h3 id="statTotal" class="text-4xl font-extrabold text-slate-800">-</h3>
                                </div>
                                <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-blue-500 to-blue-600 text-white flex items-center justify-center text-xl shadow-lg shadow-blue-200">
                                    🏢
                                </div>
                            </div>
                            <div>
                                <a href="#stationTableBody" class="inline-flex items-center text-sm font-semibold text-blue-600 group-hover:text-blue-700 transition-colors">
                                    Xem chi tiết
                                    <svg class="w-4 h-4 ml-1 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- ===== LOW VEHICLE ===== -->
                    <div class="group bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 p-1 border border-slate-100">
                        <div class="p-6 h-full flex flex-col justify-between">
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <p class="text-sm font-semibold text-slate-400 uppercase tracking-wilder mb-1">Thiếu xe</p>
                                    <h3 id="statLow" class="text-4xl font-extrabold text-red-600">-</h3>
                                </div>
                                <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-red-500 to-red-600 text-white flex items-center justify-center text-xl shadow-lg shadow-red-200">
                                    📉
                                </div>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-medium px-2 py-1 bg-red-50 text-red-600 rounded">Cần bổ sung ngay</span>
                                <a href="#stationTableBody" class="inline-flex items-center text-sm font-semibold text-red-600 group-hover:text-red-700 transition-colors">
                                    Xem danh sách
                                    <svg class="w-4 h-4 ml-1 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- ===== OVER VEHICLE ===== -->
                    <div class="group bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 p-1 border border-slate-100">
                        <div class="p-6 h-full flex flex-col justify-between">
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <p class="text-sm font-semibold text-slate-400 uppercase tracking-wilder mb-1">Dư xe</p>
                                    <h3 id="statOver" class="text-4xl font-extrabold text-yellow-600">-</h3>
                                </div>
                                <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-yellow-400 to-yellow-600 text-white flex items-center justify-center text-xl shadow-lg shadow-yellow-200">
                                    📦
                                </div>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-medium px-2 py-1 bg-yellow-50 text-yellow-600 rounded">Sẵn sàng điều chuyển</span>
                                <a href="#stationTableBody" class="inline-flex items-center text-sm font-semibold text-yellow-600 group-hover:text-yellow-700 transition-colors">
                                    Xem danh sách
                                    <svg class="w-4 h-4 ml-1 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </a>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    
                    <!-- ===== TABLE STATIONS (Left - 2 Cols) ===== -->
                    <div class="lg:col-span-2 animate-fadeInUp delay-100">
                        <section class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden h-full flex flex-col">
                            <div class="p-6 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                                <div>
                                    <h3 class="text-lg font-bold text-slate-800">📍 Danh sách trạm</h3>
                                    <div class="flex gap-2 text-xs font-medium text-slate-500 mt-1">
                                        <span class="px-2 py-0.5 bg-green-100 text-green-700 rounded">Live Data</span>
                                    </div>
                                </div>
                                <button onclick="loadStationTraffic()" class="p-2 hover:bg-white rounded-lg transition text-slate-500 hover:text-blue-600 hover:shadow-sm">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                                </button>
                            </div>
        
                            <div class="overflow-x-auto flex-1">
                                <table class="w-full text-sm text-left">
                                    <thead class="bg-slate-50 text-slate-500 font-medium uppercase text-xs tracking-wider">
                                        <tr class="border-b border-slate-200">
                                            <th class="px-6 py-4">Trạm Xe</th>
                                            <th class="px-6 py-4">Khu vực</th>
                                            <th class="px-6 py-4 text-center">🚗 Ô tô</th>
                                            <th class="px-6 py-4 text-center">🛵 Xe máy</th>
                                            <th class="px-6 py-4 text-center">Trạng thái</th>
                                        </tr>
                                    </thead>
                                    <tbody id="stationTableBody" class="bg-white text-black divide-y divide-slate-200">
                                        <!-- Dynamic Content -->
                                    </tbody>
                                </table>
                            </div>
                        </section>
                    </div>
    
                    <!-- ===== TRAFFIC CONTROL FORM (Right - 1 Col) ===== -->
                    <div class="lg:col-span-1 animate-fadeInUp delay-200">
                        <section class="bg-white rounded-2xl shadow-lg border border-indigo-100 p-0 overflow-hidden sticky top-24">
                            <div class="p-6 bg-gradient-to-r from-indigo-600 to-violet-600 text-white">
                                <h3 class="text-lg font-bold flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg>
                                    Điều phối xe nhanh
                                </h3>
                                <p class="text-indigo-100 text-sm mt-1">Chuyển xe giữa các trạm để cân bằng</p>
                            </div>
    
                            <div class="p-6">
                                <form id="dispatchForm" onsubmit="handleDispatch(event)" class="space-y-5">
                                    
                                    <!-- Source -->
                                    <div class="relative group">
                                        <label class="block text-xs font-semibold text-slate-500 uppercase mb-1.5 pl-1">Trạm nguồn</label>
                                        <div class="relative">
                                            <select id="fromStation" class="w-full pl-10 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all appearance-none text-slate-700 font-medium cursor-pointer hover:bg-slate-100" required onchange="updateMaxQuantity()">
                                                <option value="">-- Chọn trạm đi --</option>
                                            </select>
                                            <div class="absolute left-3 top-3.5 text-slate-400 pointer-events-none">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                            </div>
                                        </div>
                                    </div>
    
                                    <!-- Destination -->
                                    <div class="relative group">
                                        <label class="block text-xs font-semibold text-slate-500 uppercase mb-1.5 pl-1">Trạm nhận</label>
                                        <div class="relative">
                                            <select id="toStation" class="w-full pl-10 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all appearance-none text-slate-700 font-medium cursor-pointer hover:bg-slate-100" required>
                                                <option value="">-- Chọn trạm đến --</option>
                                            </select>
                                            <div class="absolute left-3 top-3.5 text-slate-400 pointer-events-none">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21v-8a2 2 0 012-2h14a2 2 0 012 2v8"></path></svg>
                                            </div>
                                        </div>
                                    </div>
    
                                    <!-- Type & Qty -->
                                    <div class="grid grid-cols-2 gap-4">
                                        <div class="relative">
                                            <label class="block text-xs font-semibold text-slate-500 uppercase mb-1.5 pl-1">Loại xe</label>
                                            <select id="vehicleType" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all font-medium text-slate-700" required onchange="updateMaxQuantity()">
                                                <option value="Ô tô">🚗 Ô tô</option>
                                                <option value="Xe máy">🛵 Xe máy</option>
                                            </select>
                                        </div>
                                        <div class="relative">
                                            <label class="block text-xs font-semibold text-slate-500 uppercase mb-1.5 pl-1">Số lượng</label>
                                            <input id="quantity" type="number" min="1" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all font-bold text-slate-800 text-center" required>
                                            <p id="maxQtyHint" class="text-xs text-right mt-1 text-slate-400 font-medium h-4"></p>
                                        </div>
                                    </div>
    
                                    <button type="submit" class="w-full py-3.5 rounded-xl text-white font-bold text-base shadow-lg shadow-indigo-200 hover:shadow-xl hover:-translate-y-0.5 transition-all duration-300 flex items-center justify-center gap-2 group" style="background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);">
                                        <span>Xác nhận điều chuyển</span>
                                        <svg class="w-5 h-5 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                    </button>
                                </form>
                            </div>
                        </section>
                    </div>

                </div>

            </main>

            <!-- FOOTER -->
            <?php include '../../../includes/footer.php'; ?>

        </div>
    </div>
    
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../../../js/main.js"></script>

    <script>
        let stationsData = [];

        // Load data on page load
        document.addEventListener('DOMContentLoaded', () => {
            loadStationTraffic();
        });

        async function loadStationTraffic() {
            try {
                const response = await fetch('/ITS/assets/php/dispatcher/get_station_traffic.php');
                const result = await response.json();

                if (result.success) {
                    stationsData = result.stations;
                    updateDashboard(result.stats);
                    renderTable(result.stations);
                    populateSelects(result.stations);
                } else {
                    console.error(result.message);
                }
            } catch (error) {
                console.error('Error fetching traffic data:', error);
            }
        }

        function updateDashboard(stats) {
            document.getElementById('statTotal').innerText = stats.total_stations;
            document.getElementById('statLow').innerText = stats.low_stock;
            document.getElementById('statOver').innerText = stats.over_stock;
        }

        function renderTable(stations) {
            const tbody = document.getElementById('stationTableBody');
            tbody.innerHTML = '';

            stations.forEach(s => {
                let statusBadge = '';
                if(s.status === 'LOW') {
                    statusBadge = `<span class="px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700">Thiếu xe</span>`;
                } else if(s.status === 'OVER') {
                    statusBadge = `<span class="px-3 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-700">Dư xe</span>`;
                } else {
                    statusBadge = `<span class="px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">Bình thường</span>`;
                }

                const row = `
                    <tr class="border-b border-slate-100 hover:bg-slate-50 transition text-black bg-white">
                        <td class="p-4 font-semibold">
                            <a href="station_detail.php?id=${s.station_id}" class="text-blue-700 hover:underline">
                                ${s.station_name}
                            </a>
                        </td>
                        <td class="p-4 text-gray-800">${s.municipality}</td>
                        <td class="p-4 text-center font-bold text-black">${s.car_count}</td>
                        <td class="p-4 text-center font-bold text-black">${s.bike_count}</td>
                        <td class="p-4 text-center">${statusBadge}</td>
                    </tr>
                `;
                tbody.innerHTML += row;
            });
        }

        function populateSelects(stations) {
            const fromSelect = document.getElementById('fromStation');
            const toSelect = document.getElementById('toStation');
            
            // Save current selection if re-populating
            const currentFrom = fromSelect.value;
            const currentTo = toSelect.value;

            fromSelect.innerHTML = '<option value="">-- Chọn trạm nguồn --</option>';
            toSelect.innerHTML = '<option value="">-- Chọn trạm nhận --</option>';

            stations.forEach(s => {
                fromSelect.innerHTML += `<option value="${s.station_id}">${s.station_name} (Hiện có: ${s.total_vehicles})</option>`;
                toSelect.innerHTML += `<option value="${s.station_id}">${s.station_name}</option>`;
            });

            fromSelect.value = currentFrom;
            toSelect.value = currentTo;
        }

        function updateMaxQuantity() {
            const fromId = document.getElementById('fromStation').value;
            const type = document.getElementById('vehicleType').value;
            const hint = document.getElementById('maxQtyHint');
            const input = document.getElementById('quantity');

            if (!fromId) {
                hint.innerText = '';
                return;
            }

            const station = stationsData.find(s => s.station_id == fromId);
            if (!station) return;

            let max = 0;
            if (type === 'Ô tô') max = station.car_count;
            if (type === 'Xe máy') max = station.bike_count;

            hint.innerText = `(Tối đa: ${max})`;
            input.setAttribute('max', max);
            
            if (parseInt(input.value) > max) {
                input.value = max;
            }
        }

        async function handleDispatch(e) {
            e.preventDefault();
            
            const fromId = document.getElementById('fromStation').value;
            const toId = document.getElementById('toStation').value;
            const type = document.getElementById('vehicleType').value;
            const qty = document.getElementById('quantity').value;
            
            const fromName = document.getElementById('fromStation').options[document.getElementById('fromStation').selectedIndex].text.split('(')[0].trim();
            const toName = document.getElementById('toStation').options[document.getElementById('toStation').selectedIndex].text;

            if (fromId === toId) {
                Swal.fire('Lỗi', 'Trạm nguồn và đích không được trùng nhau', 'error');
                return;
            }

            const result = await Swal.fire({
                title: 'Xác nhận điều tiết',
                html: `Chuyển <b>${qty} ${type}</b> <br> từ <b>${fromName}</b> <br> sang <b>${toName}</b>?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Đồng ý',
                cancelButtonText: 'Hủy',
                confirmButtonColor: '#059669' // Green-600
            });

            if (result.isConfirmed) {
                Swal.fire({ title: 'Đang xử lý...', didOpen: () => Swal.showLoading() });
                
                try {
                    const response = await fetch('/ITS/assets/php/dispatcher/dispatch_vehicles.php', {
                        method: 'POST',
                        headers: {'Content-Type': 'application/json'},
                        body: JSON.stringify({
                            from_station_id: fromId,
                            to_station_id: toId,
                            vehicle_type: type,
                            quantity: qty
                        })
                    });
                    
                    const res = await response.json();
                    
                    if (res.success) {
                        Swal.fire('Thành công', res.message, 'success');
                        loadStationTraffic(); // Reload data
                        document.getElementById('dispatchForm').reset();
                        document.getElementById('maxQtyHint').innerText = '';
                    } else {
                        Swal.fire('Thất bại', res.message, 'error');
                    }

                } catch (err) {
                    Swal.fire('Lỗi hệ thống', 'Không thể kết nối server', 'error');
                }
            }
        }
    </script>
</body>
</html>