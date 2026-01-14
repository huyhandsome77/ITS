<!doctype html>
<html lang="vi" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thống kê trạm | Quản lý trạm</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="../../../css/style.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
                        <h1 class="text-3xl font-bold" style="color: var(--primary-color);">THỐNG KÊ</h1>
                        <p class="text-gray-600 mt-1">Trạm: <span class="font-semibold" id="stationName">Nguyễn Huệ - Quận 1</span></p>
                    </div>
                    <div class="flex space-x-3">
                        <select id="filterPeriod" class="border rounded-lg px-4 py-2">
                            <option value="today">Hôm nay</option>
                            <option value="week">7 ngày qua</option>
                            <option value="month" selected>30 ngày qua</option>
                            <option value="year">Năm nay</option>
                        </select>
                        <button class="px-6 py-2 rounded-lg font-semibold text-white" style="background: var(--primary-color);">
                            <svg class="w-5 h-5 inline-block mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd"/>
                            </svg>
                            Xuất báo cáo
                        </button>
                    </div>
                </div>

                <!-- Key Metrics -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                    <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl shadow-lg p-6 text-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-blue-100 text-sm">Tổng doanh thu</p>
                                <h3 class="text-3xl font-bold mt-1">127M</h3>
                                <p class="text-blue-100 text-xs mt-1">+12.5% so với tháng trước</p>
                            </div>
                            <div class="bg-white bg-opacity-20 p-3 rounded-lg">
                                <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"/>
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-2xl shadow-lg p-6 text-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-green-100 text-sm">Tổng đơn hàng</p>
                                <h3 class="text-3xl font-bold mt-1">248</h3>
                                <p class="text-green-100 text-xs mt-1">+8.2% so với tháng trước</p>
                            </div>
                            <div class="bg-white bg-opacity-20 p-3 rounded-lg">
                                <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/>
                                    <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl shadow-lg p-6 text-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-purple-100 text-sm">Tổng phương tiện</p>
                                <h3 class="text-3xl font-bold mt-1">12</h3>
                                <p class="text-purple-100 text-xs mt-1">10 sẵn sàng, 2 đang thuê</p>
                            </div>
                            <div class="bg-white bg-opacity-20 p-3 rounded-lg">
                                <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"/>
                                    <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1v-5a1 1 0 00-.293-.707l-2-2A1 1 0 0015 7h-1z"/>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-2xl shadow-lg p-6 text-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-yellow-100 text-sm">Tỷ lệ sử dụng</p>
                                <h3 class="text-3xl font-bold mt-1">85%</h3>
                                <p class="text-yellow-100 text-xs mt-1">Tốt hơn 73% trạm khác</p>
                            </div>
                            <div class="bg-white bg-opacity-20 p-3 rounded-lg">
                                <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586 14.586 7H12z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Charts Section -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                    <!-- Revenue Chart -->
                    <div class="bg-white rounded-2xl shadow-sm border p-6">
                        <h3 class="text-lg font-semibold mb-4">Doanh thu theo thời gian</h3>
                        <div style="height: 300px;">
                            <canvas id="revenueChart"></canvas>
                        </div>
                    </div>

                    <!-- Order Status Chart -->
                    <div class="bg-white rounded-2xl shadow-sm border p-6">
                        <h3 class="text-lg font-semibold mb-4">Phân bổ trạng thái đơn hàng</h3>
                        <div style="height: 300px;">
                            <canvas id="orderStatusChart"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Vehicle Usage Chart -->
                <div class="bg-white rounded-2xl shadow-sm border p-6 mb-6">
                    <h3 class="text-lg font-semibold mb-4">Tỷ lệ sử dụng phương tiện</h3>
                    <div style="height: 400px;">
                        <canvas id="vehicleUsageChart"></canvas>
                    </div>
                </div>

                <!-- Top Performing Vehicles -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Top Vehicles by Revenue -->
                    <div class="bg-white rounded-2xl shadow-sm border p-6">
                        <h3 class="text-lg font-semibold mb-4">Top 5 xe theo doanh thu</h3>
                        <div class="space-y-4">
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                <div class="flex items-center space-x-3">
                                    <div class="w-8 h-8 bg-blue-600 text-white rounded-full flex items-center justify-center font-bold">1</div>
                                    <div>
                                        <div class="font-semibold">Toyota Camry</div>
                                        <div class="text-xs text-gray-500">51G-12345</div>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="font-bold text-green-600">18.5M</div>
                                    <div class="text-xs text-gray-500">42 đơn</div>
                                </div>
                            </div>

                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                <div class="flex items-center space-x-3">
                                    <div class="w-8 h-8 bg-gray-600 text-white rounded-full flex items-center justify-center font-bold">2</div>
                                    <div>
                                        <div class="font-semibold">Honda CR-V</div>
                                        <div class="text-xs text-gray-500">51H-67890</div>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="font-bold text-green-600">16.2M</div>
                                    <div class="text-xs text-gray-500">38 đơn</div>
                                </div>
                            </div>

                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                <div class="flex items-center space-x-3">
                                    <div class="w-8 h-8 bg-yellow-600 text-white rounded-full flex items-center justify-center font-bold">3</div>
                                    <div>
                                        <div class="font-semibold">Mazda CX-5</div>
                                        <div class="text-xs text-gray-500">51M-13579</div>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="font-bold text-green-600">14.8M</div>
                                    <div class="text-xs text-gray-500">35 đơn</div>
                                </div>
                            </div>

                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                <div class="flex items-center space-x-3">
                                    <div class="w-8 h-8 bg-gray-400 text-white rounded-full flex items-center justify-center font-bold">4</div>
                                    <div>
                                        <div class="font-semibold">Ford Tourneo</div>
                                        <div class="text-xs text-gray-500">51F-24680</div>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="font-bold text-green-600">12.4M</div>
                                    <div class="text-xs text-gray-500">28 đơn</div>
                                </div>
                            </div>

                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                <div class="flex items-center space-x-3">
                                    <div class="w-8 h-8 bg-gray-400 text-white rounded-full flex items-center justify-center font-bold">5</div>
                                    <div>
                                        <div class="font-semibold">VinFast VF8</div>
                                        <div class="text-xs text-gray-500">51V-98765</div>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="font-bold text-green-600">10.9M</div>
                                    <div class="text-xs text-gray-500">25 đơn</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Customer Insights -->
                    <div class="bg-white rounded-2xl shadow-sm border p-6">
                        <h3 class="text-lg font-semibold mb-4">Thống kê khách hàng</h3>
                        <div class="space-y-4">
                            <div class="p-4 bg-blue-50 rounded-lg border-l-4 border-blue-500">
                                <div class="flex justify-between items-center">
                                    <div>
                                        <p class="text-sm text-gray-600">Khách hàng mới</p>
                                        <p class="text-2xl font-bold text-blue-600">87</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-xs text-gray-500">30 ngày qua</p>
                                        <p class="text-sm font-semibold text-green-600">+15%</p>
                                    </div>
                                </div>
                            </div>

                            <div class="p-4 bg-green-50 rounded-lg border-l-4 border-green-500">
                                <div class="flex justify-between items-center">
                                    <div>
                                        <p class="text-sm text-gray-600">Khách quay lại</p>
                                        <p class="text-2xl font-bold text-green-600">161</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-xs text-gray-500">30 ngày qua</p>
                                        <p class="text-sm font-semibold text-green-600">+22%</p>
                                    </div>
                                </div>
                            </div>

                            <div class="p-4 bg-purple-50 rounded-lg border-l-4 border-purple-500">
                                <div class="flex justify-between items-center">
                                    <div>
                                        <p class="text-sm text-gray-600">Đánh giá trung bình</p>
                                        <p class="text-2xl font-bold text-purple-600">4.7 ⭐</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-xs text-gray-500">Từ 142 đánh giá</p>
                                        <p class="text-sm font-semibold text-green-600">Tuyệt vời</p>
                                    </div>
                                </div>
                            </div>

                            <div class="p-4 bg-yellow-50 rounded-lg border-l-4 border-yellow-500">
                                <div class="flex justify-between items-center">
                                    <div>
                                        <p class="text-sm text-gray-600">Thời gian thuê TB</p>
                                        <p class="text-2xl font-bold text-yellow-600">4.2 ngày</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-xs text-gray-500">30 ngày qua</p>
                                        <p class="text-sm font-semibold text-green-600">+0.5 ngày</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </main>

            <?php include '../../../includes/footer.php'; ?>
        </div>
    </div>

    <script src="../../../js/main.js"></script>
    <script>
        // Revenue Chart
        const revenueCtx = document.getElementById('revenueChart').getContext('2d');
        const revenueChart = new Chart(revenueCtx, {
            type: 'line',
            data: {
                labels: ['Tuần 1', 'Tuần 2', 'Tuần 3', 'Tuần 4'],
                datasets: [{
                    label: 'Doanh thu (triệu VNĐ)',
                    data: [28, 32, 35, 32],
                    borderColor: 'rgb(59, 130, 246)',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'bottom'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Order Status Chart
        const orderStatusCtx = document.getElementById('orderStatusChart').getContext('2d');
        const orderStatusChart = new Chart(orderStatusCtx, {
            type: 'doughnut',
            data: {
                labels: ['Đơn mới', 'Đang thuê', 'Chờ trả', 'Hoàn thành', 'Đã hủy'],
                datasets: [{
                    data: [8, 15, 5, 127, 12],
                    backgroundColor: [
                        'rgb(59, 130, 246)',
                        'rgb(34, 197, 94)',
                        'rgb(234, 179, 8)',
                        'rgb(168, 85, 247)',
                        'rgb(239, 68, 68)'
                    ]
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });

        // Vehicle Usage Chart
        const vehicleUsageCtx = document.getElementById('vehicleUsageChart').getContext('2d');
        const vehicleUsageChart = new Chart(vehicleUsageCtx, {
            type: 'bar',
            data: {
                labels: ['Toyota Camry', 'Honda CR-V', 'Mazda CX-5', 'Ford Tourneo', 'VinFast VF8', 'Kia Sorento', 'Hyundai Tucson', 'Toyota Vios', 'Honda City', 'Mazda 3'],
                datasets: [{
                    label: 'Tỷ lệ sử dụng (%)',
                    data: [92, 88, 85, 78, 72, 68, 65, 62, 58, 54],
                    backgroundColor: 'rgba(34, 197, 94, 0.7)',
                    borderColor: 'rgb(34, 197, 94)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'bottom'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 100
                    }
                }
            }
        });
    </script>
</body>

</html>
