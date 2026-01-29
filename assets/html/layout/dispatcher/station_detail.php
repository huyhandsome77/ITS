<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/ITS/assets/php/auth/check_permission.php';
requireDispatcher();
?>
<!doctype html>
<html lang="vi" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết trạm xe | Dispatcher</title>

    <!-- FONT -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- CSS -->
    <link rel="stylesheet" href="../../../css/style.css">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<?php
$baseUrl = '../../../..';
?>

<body class="min-h-full font-[Inter]">
    <div id="app" class="flex min-h-screen">

        <!-- SIDEBAR -->
        <?php include '../../../includes/dispatcher/dispatcher_sidebar.php'; ?>

        <!-- CONTENT -->
        <div id="contentWrapper" class="flex-1 flex flex-col min-h-screen
                ml-64 lg:ml-72 transition-all duration-300">

            <!-- NAVBAR -->
            <?php include '../../../includes/navbar.php'; ?>

            <!-- MAIN -->
            <main class="flex-1 overflow-auto p-4 md:p-6 lg:p-8" style="margin-top:76px">

                <!-- HEADER -->
                <div class="mb-8">
                    <h2 id="stationName" class="text-3xl font-bold text-green-600 mb-2">
                        Loading...
                    </h2>
                    <p id="stationAddress" class="text-gray-600">
                        ...
                    </p>
                </div>

                <!-- OVERVIEW -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">

                    <!-- Ô tô -->
                    <div class="bg-white rounded-2xl shadow p-6 border-l-4 border-blue-500">
                        <p class="text-sm text-gray-500 mb-1">🚗 Ô tô</p>
                        <p id="carCount" class="text-3xl font-bold text-blue-600">-</p>
                    </div>

                    <!-- Xe máy -->
                    <div class="bg-white rounded-2xl shadow p-6 border-l-4 border-green-500">
                        <p class="text-sm text-gray-500 mb-1">🛵 Xe máy</p>
                        <p id="bikeCount" class="text-3xl font-bold text-green-600">-</p>
                    </div>

                    <!-- Tình trạng -->
                    <div class="bg-white rounded-2xl shadow p-6 border-l-4 border-green-500">
                        <p class="text-sm text-gray-500 mb-1">Tình trạng</p>
                        <span id="stationStatus" class="inline-block mt-2 px-4 py-1 rounded-full
                                 bg-green-100 text-green-700 font-semibold text-sm">
                            ...
                        </span>
                    </div>

                </div>

                <!-- TABLE VEHICLES -->
                <section class="bg-white rounded-2xl shadow-lg border overflow-hidden mb-10">

                    <div class="p-6 border-b">
                        <h3 class="text-lg font-semibold">
                            🚘 Danh sách xe tại trạm
                        </h3>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead class="bg-slate-100 text-slate-600">
                                <tr>
                                    <th class="px-4 py-3 text-left">#</th>
                                    <th class="px-4 py-3 text-left">Tên xe</th>
                                    <th class="px-4 py-3 text-left">Loại</th>
                                    <th class="px-4 py-3 text-left">Biển số</th>
                                    <th class="px-4 py-3 text-left">Trạng thái</th>
                                </tr>
                            </thead>
                            <tbody id="vehicleTableBody" class="divide-y">
                                <!-- Dynamic Content -->
                            </tbody>
                        </table>
                    </div>
                </section>

                <!-- ACTIONS -->
                <div class="flex gap-4">

                    <a href="station_traffic.php" class="px-6 py-3 rounded-lg font-semibold text-white
                          hover:opacity-90 transition" style="background:var(--accent-gradient)">
                        🔁 Điều tiết xe
                    </a>

                    <a href="dispatcher_orders.php" class="px-6 py-3 rounded-lg font-semibold border
                          text-gray-700 hover:bg-gray-50 transition">
                        ← Quay lại
                    </a>

                </div>

            </main>

            <!-- FOOTER -->
            <?php include '../../../includes/footer.php'; ?>

        </div>
    </div>
    
    <!-- Script -->
    <script src="../../../js/main.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const urlParams = new URLSearchParams(window.location.search);
            const stationId = urlParams.get('id');

            if (!stationId) {
                console.warn('No station ID provided');
                return;
            }

            fetchStationDetails(stationId);
        });

        async function fetchStationDetails(id) {
            try {
                const response = await fetch(`/ITS/assets/php/dispatcher/get_station_detail.php?station_id=${id}`);
                const data = await response.json();

                if (data.success) {
                    renderStationInfo(data);
                } else {
                    alert('Lỗi: ' + data.message);
                }
            } catch (error) {
                console.error('Error:', error);
            }
        }

        function renderStationInfo(data) {
            // Header
            document.getElementById('stationName').innerText = '🏢 ' + data.station.name;
            document.getElementById('stationAddress').innerText = data.station.address;

            // Stats
            document.getElementById('carCount').innerText = data.stats.car_count + ' xe';
            document.getElementById('bikeCount').innerText = data.stats.bike_count + ' xe';
            
            // Status
            const statusBadge = document.getElementById('stationStatus');
            if(data.station.status === 'ACTIVE') {
                statusBadge.className = 'inline-block mt-2 px-4 py-1 rounded-full bg-green-100 text-green-700 font-semibold text-sm';
                statusBadge.innerText = 'Hoạt động tốt';
            } else {
                statusBadge.className = 'inline-block mt-2 px-4 py-1 rounded-full bg-red-100 text-red-700 font-semibold text-sm';
                statusBadge.innerText = 'Đang bảo trì';
            }

            // Table
            const tbody = document.getElementById('vehicleTableBody');
            tbody.innerHTML = '';
            
            if (data.vehicles.length === 0) {
                tbody.innerHTML = '<tr><td colspan="5" class="p-4 text-center text-gray-500">Chưa có xe nào tại trạm</td></tr>';
                return;
            }

            data.vehicles.forEach((v, index) => {
                let statusClass = 'bg-gray-100 text-gray-600';
                let statusText = 'Không rõ';

                if (v.status === 'AVAILABLE') {
                    statusClass = 'bg-green-100 text-green-700';
                    statusText = 'Sẵn sàng';
                } else if (v.status === 'RENTED') {
                    statusClass = 'bg-yellow-100 text-yellow-700';
                    statusText = 'Đang thuê';
                } else if (v.status === 'MAINTENANCE') {
                    statusClass = 'bg-red-100 text-red-700';
                    statusText = 'Bảo trì';
                }

                const row = `
                    <tr class="hover:bg-slate-50">
                        <td class="px-4 py-3">${index + 1}</td>
                        <td class="px-4 py-3 font-medium">${v.vehicle_name}</td>
                        <td class="px-4 py-3">${v.vehicle_type === 'Oto' ? '🚗 Ô tô' : '🛵 Xe máy'}</td>
                        <td class="px-4 py-3">${v.license_plate}</td>
                        <td class="px-4 py-3">
                            <span class="px-3 py-1 rounded-full text-xs font-semibold ${statusClass}">
                                ${statusText}
                            </span>
                        </td>
                    </tr>
                `;
                tbody.innerHTML += row;
            });
        }
    </script>
</body>

</html>