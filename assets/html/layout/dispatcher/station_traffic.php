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
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12 animate-fadeInUp">

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
                            <p class="text-xs text-slate-500" id="statBalanced">- trạm cân bằng</p>
                        </div>
                    </div>

                    <!-- ===== AVG LOAD FACTOR ===== -->
                    <div class="group bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 p-1 border border-slate-100">
                        <div class="p-6 h-full flex flex-col justify-between">
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <p class="text-sm font-semibold text-slate-400 uppercase tracking-wilder mb-1">Load Factor TB</p>
                                    <h3 id="statAvgLF" class="text-4xl font-extrabold text-green-600">-</h3>
                                </div>
                                <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-green-500 to-green-600 text-white flex items-center justify-center text-xl shadow-lg shadow-green-200">
                                    ⚖️
                                </div>
                            </div>
                            <p class="text-xs text-slate-500">Mục tiêu: 0.6 - 1.5</p>
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
                            <span class="text-xs font-medium px-2 py-1 bg-red-50 text-red-600 rounded">Cần bổ sung ngay</span>
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
                            <span class="text-xs font-medium px-2 py-1 bg-yellow-50 text-yellow-600 rounded">Sẵn sàng điều chuyển</span>
                        </div>
                    </div>

                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    
                    <!-- ===== TABLE STATIONS (Left - 2 Cols) ===== -->
                    <div class="lg:col-span-2 space-y-6">
                        
                        <!-- SMART SUGGESTIONS -->
                        <section id="suggestionsSection" class="bg-gradient-to-br from-indigo-50 to-purple-50 rounded-2xl shadow-sm border border-indigo-100 overflow-hidden animate-fadeInUp">
                            <div class="p-6 border-b border-indigo-100 bg-white/50 flex items-center justify-between">
                                <div>
                                    <h3 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                                        🤖 Gợi ý thông minh
                                        <span id="suggestionBadge" class="px-2 py-0.5 bg-indigo-600 text-white text-xs rounded-full">0</span>
                                    </h3>
                                    <p class="text-xs text-slate-500 mt-1">Dựa trên Load Factor & dự đoán nhu cầu</p>
                                </div>
                                <button onclick="executeAutoRebalance()" id="autoRebalanceBtn" class="px-4 py-2 bg-gradient-to-r from-green-500 to-emerald-600 text-white text-sm font-bold rounded-xl hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300 flex items-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                    Tự động cân bằng
                                </button>
                            </div>
                            <div id="suggestionsList" class="p-4 max-h-96 overflow-y-auto">
                                <p class="text-center text-slate-400 py-8">Đang tải gợi ý...</p>
                            </div>
                        </section>

                        <!-- STATIONS TABLE -->
                        <section class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden animate-fadeInUp delay-100">
                            <div class="p-6 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                                <div>
                                    <h3 class="text-lg font-bold text-slate-800">📍 Danh sách trạm</h3>
                                    <div class="flex gap-2 text-xs font-medium text-slate-500 mt-1">
                                        <span class="px-2 py-0.5 bg-green-100 text-green-700 rounded">Live Data</span>
                                        <span class="px-2 py-0.5 bg-blue-100 text-blue-700 rounded">Load Factor</span>
                                    </div>
                                </div>
                                <button onclick="loadSmartRebalancing()" class="p-2 hover:bg-white rounded-lg transition text-slate-500 hover:text-blue-600 hover:shadow-sm">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                                </button>
                            </div>
        
                            <div class="overflow-x-auto">
                                <table class="w-full text-sm text-left">
                                    <thead class="bg-slate-50 text-slate-500 font-medium uppercase text-xs tracking-wider">
                                        <tr class="border-b border-slate-200">
                                            <th class="px-6 py-4">Trạm Xe</th>
                                            <th class="px-6 py-4 text-center">🚗 Ô tô</th>
                                            <th class="px-6 py-4 text-center">🛵 Xe máy</th>
                                            <th class="px-6 py-4 text-center">Load Factor</th>
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
        let suggestionsData = [];
        let smartData = null;

        // Load data on page load
        document.addEventListener('DOMContentLoaded', () => {
            loadSmartRebalancing();
        });

        async function loadSmartRebalancing() {
            try {
                const response = await fetch('/ITS/assets/php/dispatcher/get_smart_rebalancing.php');
                const result = await response.json();

                if (result.success) {
                    smartData = result;
                    stationsData = result.stations;
                    suggestionsData = result.suggestions;
                    
                    updateDashboard(result.stats);
                    renderTable(result.stations);
                    renderSuggestions(result.suggestions);
                    populateSelects(result.stations);
                } else {
                    console.error(result.message);
                    Swal.fire('Lỗi', result.message, 'error');
                }
            } catch (error) {
                console.error('Error fetching smart data:', error);
                Swal.fire('Lỗi', 'Không thể tải dữ liệu', 'error');
            }
        }

        function updateDashboard(stats) {
            document.getElementById('statTotal').innerText = stats.total_stations;
            document.getElementById('statBalanced').innerText = stats.balanced_stations + ' trạm cân bằng';
            document.getElementById('statAvgLF').innerText = stats.avg_load_factor;
            document.getElementById('statLow').innerText = stats.low_stations;
            document.getElementById('statOver').innerText = stats.over_stations;
            document.getElementById('suggestionBadge').innerText = stats.total_suggestions;
            
            // Enable/disable auto-rebalance button
            const autoBtn = document.getElementById('autoRebalanceBtn');
            if (stats.total_suggestions > 0) {
                autoBtn.disabled = false;
            } else {
                autoBtn.disabled = true;
            }
        }

        function renderSuggestions(suggestions) {
            const container = document.getElementById('suggestionsList');
            
            if (suggestions.length === 0) {
                container.innerHTML = '<p class="text-center text-green-600 py-8 font-semibold">✅ Hệ thống đã cân bằng! Không cần điều chuyển.</p>';
                return;
            }
            
            let html = '';
            suggestions.forEach((sug, index) => {
                const priorityColor = sug.priority === 'HIGH' ? 'red' : 'orange';
                const priorityText = sug.priority === 'HIGH' ? 'Khẩn cấp' : 'Ưu tiên';
                
                html += `
                    <div class="bg-white rounded-xl p-4 mb-3 border border-slate-200 hover:shadow-md transition-all">
                        <div class="flex items-start justify-between mb-2">
                            <div class="flex-1">
                                <div class="flex items-center gap-2 mb-1">
                                    <span class="px-2 py-0.5 bg-${priorityColor}-100 text-${priorityColor}-700 text-xs font-bold rounded">${priorityText}</span>
                                    <span class="text-xs text-slate-500">${sug.distance} km • ~${(sug.estimated_cost/1000).toFixed(0)}k VND</span>
                                </div>
                                <div class="flex items-center gap-2 text-sm font-semibold text-slate-800">
                                    <span>${sug.from_station_name}</span>
                                    <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                                    <span>${sug.to_station_name}</span>
                                </div>
                            </div>
                            <button onclick="executeSingleSuggestion(${index})" class="ml-2 px-3 py-1.5 bg-indigo-600 text-white text-xs font-semibold rounded-lg hover:bg-indigo-700 transition">
                                Thực hiện
                            </button>
                        </div>
                        <div class="flex gap-4 text-xs text-slate-600">
                            ${sug.car_quantity > 0 ? `<span>🚗 ${sug.car_quantity} ô tô</span>` : ''}
                            ${sug.bike_quantity > 0 ? `<span>🛵 ${sug.bike_quantity} xe máy</span>` : ''}
                        </div>
                        <p class="text-xs text-slate-500 mt-2">${sug.reason}</p>
                    </div>
                `;
            });
            
            container.innerHTML = html;
        }

        function renderTable(stations) {
            const tbody = document.getElementById('stationTableBody');
            tbody.innerHTML = '';

            stations.forEach(s => {
                let statusBadge = '';
                let lfColor = 'green';
                
                if(s.status === 'LOW') {
                    statusBadge = `<span class="px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700">⚠️ Thiếu xe</span>`;
                    lfColor = 'red';
                } else if(s.status === 'OVER') {
                    statusBadge = `<span class="px-3 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-700">📦 Dư xe</span>`;
                    lfColor = 'yellow';
                } else {
                    statusBadge = `<span class="px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">✅ Cân bằng</span>`;
                }

                const row = `
                    <tr class="border-b border-slate-100 hover:bg-slate-50 transition text-black bg-white">
                        <td class="p-4">
                            <div class="font-semibold text-blue-700">${s.station_name}</div>
                            <div class="text-xs text-slate-500">${s.location}</div>
                        </td>
                        <td class="p-4 text-center">
                            <div class="font-bold text-black">${s.car_count}</div>
                            <div class="text-xs text-slate-500">Dự đoán: ${s.predicted_car_demand}</div>
                        </td>
                        <td class="p-4 text-center">
                            <div class="font-bold text-black">${s.bike_count}</div>
                            <div class="text-xs text-slate-500">Dự đoán: ${s.predicted_bike_demand}</div>
                        </td>
                        <td class="p-4 text-center">
                            <div class="font-bold text-${lfColor}-700">${s.avg_load_factor}</div>
                            <div class="text-xs text-slate-500">LF: ${s.car_load_factor} / ${s.bike_load_factor}</div>
                        </td>
                        <td class="p-4 text-center">${statusBadge}</td>
                    </tr>
                `;
                tbody.innerHTML += row;
            });
        }

        function populateSelects(stations) {
            const fromSelect = document.getElementById('fromStation');
            const toSelect = document.getElementById('toStation');
            
            const currentFrom = fromSelect.value;
            const currentTo = toSelect.value;

            fromSelect.innerHTML = '<option value="">-- Chọn trạm nguồn --</option>';
            toSelect.innerHTML = '<option value="">-- Chọn trạm nhận --</option>';

            stations.forEach(s => {
                fromSelect.innerHTML += `<option value="${s.station_id}">${s.station_name} (LF: ${s.avg_load_factor})</option>`;
                toSelect.innerHTML += `<option value="${s.station_id}">${s.station_name}</option>`;
            });

            fromSelect.value = currentFrom;
            toSelect.value = currentTo;
        }

        async function executeSingleSuggestion(index) {
            const suggestion = suggestionsData[index];
            
            const result = await Swal.fire({
                title: 'Xác nhận điều chuyển',
                html: `
                    <div class="text-left space-y-2">
                        <p><b>Từ:</b> ${suggestion.from_station_name}</p>
                        <p><b>Đến:</b> ${suggestion.to_station_name}</p>
                        <p><b>Số xe:</b> ${suggestion.car_quantity} ô tô, ${suggestion.bike_quantity} xe máy</p>
                        <p><b>Chi phí dự kiến:</b> ${(suggestion.estimated_cost/1000).toFixed(0)}k VND</p>
                    </div>
                `,
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Xác nhận',
                cancelButtonText: 'Hủy',
                confirmButtonColor: '#059669'
            });

            if (result.isConfirmed) {
                Swal.fire({ title: 'Đang xử lý...', didOpen: () => Swal.showLoading() });
                
                try {
                    const response = await fetch('/ITS/assets/php/dispatcher/auto_rebalance.php', {
                        method: 'POST',
                        headers: {'Content-Type': 'application/json'},
                        body: JSON.stringify({ suggestions: [suggestion] })
                    });
                    
                    const res = await response.json();
                    
                    if (res.success) {
                        Swal.fire('Thành công!', res.message, 'success');
                        loadSmartRebalancing(); // Reload
                    } else {
                        Swal.fire('Thất bại', res.message, 'error');
                    }
                } catch (err) {
                    Swal.fire('Lỗi', 'Không thể kết nối server', 'error');
                }
            }
        }

        async function executeAutoRebalance() {
            if (suggestionsData.length === 0) {
                Swal.fire('Thông báo', 'Không có gợi ý nào để thực hiện', 'info');
                return;
            }
            
            const result = await Swal.fire({
                title: '🤖 Tự động cân bằng',
                html: `
                    <div class="text-left">
                        <p class="mb-2">Hệ thống sẽ tự động thực hiện <b>${suggestionsData.length} gợi ý</b>:</p>
                        <ul class="list-disc pl-6 text-sm space-y-1">
                            ${suggestionsData.slice(0, 3).map(s => 
                                `<li>${s.from_station_name} → ${s.to_station_name} (${s.car_quantity + s.bike_quantity} xe)</li>`
                            ).join('')}
                            ${suggestionsData.length > 3 ? `<li class="text-slate-500">... và ${suggestionsData.length - 3} gợi ý khác</li>` : ''}
                        </ul>
                    </div>
                `,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Thực hiện tất cả',
                cancelButtonText: 'Hủy',
                confirmButtonColor: '#059669'
            });

            if (result.isConfirmed) {
                Swal.fire({ 
                    title: 'Đang cân bằng hệ thống...', 
                    html: 'Vui lòng đợi trong giây lát',
                    didOpen: () => Swal.showLoading() 
                });
                
                try {
                    const response = await fetch('/ITS/assets/php/dispatcher/auto_rebalance.php', {
                        method: 'POST',
                        headers: {'Content-Type': 'application/json'},
                        body: JSON.stringify({ suggestions: suggestionsData })
                    });
                    
                    const res = await response.json();
                    
                    if (res.success) {
                        Swal.fire({
                            title: 'Hoàn thành!',
                            html: `Đã điều chuyển thành công <b>${res.success_count}</b> gợi ý`,
                            icon: 'success',
                            confirmButtonText: 'OK'
                        });
                        loadSmartRebalancing(); // Reload
                    } else {
                        Swal.fire('Thất bại', res.message, 'error');
                    }
                } catch (err) {
                    Swal.fire('Lỗi', 'Không thể kết nối server', 'error');
                }
            }
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
            const toName = document.getElementById('toStation').options[document.getElementById('toStation').selectedIndex].text.split('(')[0].trim();

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
                confirmButtonColor: '#059669'
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
                        loadSmartRebalancing(); // Reload
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