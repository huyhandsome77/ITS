<!doctype html>
<html lang="vi" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>

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

        <?php include '../../../includes/admin_sidebar.php'; ?>

        <div id="contentWrapper" class="flex-1 flex flex-col min-h-screen transition-all duration-300">

            <?php include '../../../includes/admin_navbar.php'; ?>

            <!-- ================= MAIN ================= -->
            <main class="flex-1 overflow-auto p-4 md:p-6 lg:p-8" style="margin-top:76px">

                <!-- Header Section -->
                <div class="mb-6">
                    <h1 class="text-3xl font-bold" style="color: var(--primary-color);">DASHBOARD ADMIN</h1>
                </div>
                <!-- Main Statistics Cards -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                    <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl shadow-lg p-6 text-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-blue-100 text-sm">Tổng số trạm</p>
                                <h3 class="text-3xl font-bold mt-1">24</h3>
                                <p class="text-blue-100 text-xs mt-1">4 trạm hoạt động</p>
                            </div>
                            <div class="bg-white bg-opacity-20 p-3 rounded-lg">
                                <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl shadow-lg p-6 text-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-purple-100 text-sm">Tổng phương tiện</p>
                                <h3 class="text-3xl font-bold mt-1">347</h3>
                                <p class="text-purple-100 text-xs mt-1">189 xe sẵn sàng</p>
                            </div>
                            <div class="bg-white bg-opacity-20 p-3 rounded-lg">
                                <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"/>
                                    <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1v-5a1 1 0 00-.293-.707l-2-2A1 1 0 0015 7h-1z"/>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-2xl shadow-lg p-6 text-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-green-100 text-sm">Người dùng</p>
                                <h3 class="text-3xl font-bold mt-1">1,247</h3>
                                <p class="text-green-100 text-xs mt-1">+24 hôm nay</p>
                            </div>
                            <div class="bg-white bg-opacity-20 p-3 rounded-lg">
                                <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-2xl shadow-lg p-6 text-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-yellow-100 text-sm">Doanh thu tháng</p>
                                <h3 class="text-3xl font-bold mt-1">2.4 tỷ</h3>
                                <p class="text-yellow-100 text-xs mt-1">+18.3% so với T12</p>
                            </div>
                            <div class="bg-white bg-opacity-20 p-3 rounded-lg">
                                <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"/>
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Charts Row -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                    <!-- Revenue Chart -->
                    <section class="bg-white rounded-2xl shadow-sm border p-5">
                        <div class="flex justify-between items-center mb-4">
                            <h2 class="text-lg font-semibold">Doanh thu theo tháng</h2>
                            <select class="border rounded-lg px-3 py-1 text-sm">
                                <option>2026</option>
                                <option>2025</option>
                            </select>
                        </div>
                        <div style="height: 300px;">
                            <canvas id="revenueChart"></canvas>
                        </div>
                    </section>

                    <!-- Order Status Chart -->
                    <section class="bg-white rounded-2xl shadow-sm border p-5">
                        <h2 class="text-lg font-semibold mb-4">Tình trạng đơn đặt xe</h2>
                        <div style="height: 300px;">
                            <canvas id="orderStatusChart"></canvas>
                        </div>
                    </section>
                </div>

                <!-- Activity Tables Row -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                    <!-- Recent Orders -->
                    <section class="bg-white rounded-2xl shadow-sm border p-5">
                        <div class="flex justify-between items-center mb-4">
                            <h2 class="text-lg font-semibold">Đơn đặt xe gần đây</h2>
                            <a href="manage_orders.php" class="text-sm text-red-900 hover:underline">Xem tất cả →</a>
                        </div>
                        <div class="space-y-3">
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center">
                                        <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/>
                                            <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <div class="font-semibold text-sm">#DH001 - Nguyễn Văn A</div>
                                        <div class="text-xs text-gray-500">Toyota Camry • 3 ngày</div>
                                    </div>
                                </div>
                                <span class="px-2 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-700">Đơn mới</span>
                            </div>

                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center">
                                        <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"/>
                                            <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1v-5a1 1 0 00-.293-.707l-2-2A1 1 0 0015 7h-1z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <div class="font-semibold text-sm">#DH002 - Trần Thị B</div>
                                        <div class="text-xs text-gray-500">Honda CR-V • 7 ngày</div>
                                    </div>
                                </div>
                                <span class="px-2 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">Đang thuê</span>
                            </div>

                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 rounded-full bg-yellow-100 flex items-center justify-center">
                                        <svg class="w-5 h-5 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <div class="font-semibold text-sm">#DH003 - Lê Văn C</div>
                                        <div class="text-xs text-gray-500">Ford Tourneo • 9 ngày</div>
                                    </div>
                                </div>
                                <span class="px-2 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-700">Chờ trả</span>
                            </div>
                        </div>
                    </section>

                    <!-- Top Performing Stations -->
                    <section class="bg-white rounded-2xl shadow-sm border p-5">
                        <div class="flex justify-between items-center mb-4">
                            <h2 class="text-lg font-semibold">Trạm hiệu suất cao</h2>
                            <select class="border rounded-lg px-3 py-1 text-sm">
                                <option>Tháng này</option>
                                <option>Tháng trước</option>
                            </select>
                        </div>
                        <div class="space-y-3">
                            <div class="flex items-center justify-between p-3 bg-gradient-to-r from-yellow-50 to-yellow-100 rounded-lg border-l-4 border-yellow-500">
                                <div class="flex items-center space-x-3">
                                    <div class="w-8 h-8 rounded-full bg-yellow-500 text-white flex items-center justify-center font-bold">1</div>
                                    <div>
                                        <div class="font-semibold text-sm">Nguyễn Huệ - Q1</div>
                                        <div class="text-xs text-gray-600">124 đơn • 780M doanh thu</div>
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center justify-between p-3 bg-gradient-to-r from-gray-50 to-gray-100 rounded-lg border-l-4 border-gray-400">
                                <div class="flex items-center space-x-3">
                                    <div class="w-8 h-8 rounded-full bg-gray-400 text-white flex items-center justify-center font-bold">2</div>
                                    <div>
                                        <div class="font-semibold text-sm">Lê Lợi - Q1</div>
                                        <div class="text-xs text-gray-600">98 đơn • 650M doanh thu</div>
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center justify-between p-3 bg-gradient-to-r from-orange-50 to-orange-100 rounded-lg border-l-4 border-orange-500">
                                <div class="flex items-center space-x-3">
                                    <div class="w-8 h-8 rounded-full bg-orange-500 text-white flex items-center justify-center font-bold">3</div>
                                    <div>
                                        <div class="font-semibold text-sm">Võ Văn Tần - Q3</div>
                                        <div class="text-xs text-gray-600">87 đơn • 580M doanh thu</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>

                <!-- System Alerts -->
                <section class="bg-white rounded-2xl shadow-sm border p-5">
                    <h2 class="text-lg font-semibold mb-4">Cảnh báo hệ thống</h2>
                    <div class="space-y-3">
                        <div class="flex items-start space-x-3 p-3 bg-red-50 border border-red-200 rounded-lg">
                            <svg class="w-5 h-5 text-red-600 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                            </svg>
                            <div class="flex-1">
                                <div class="font-semibold text-sm text-red-900">34 xe đang trong tình trạng bảo trì</div>
                                <div class="text-xs text-red-700 mt-1">Cần kiểm tra và cập nhật trạng thái</div>
                            </div>
                        </div>

                        <div class="flex items-start space-x-3 p-3 bg-yellow-50 border border-yellow-200 rounded-lg">
                            <svg class="w-5 h-5 text-yellow-600 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            <div class="flex-1">
                                <div class="font-semibold text-sm text-yellow-900">28 giao dịch chờ xác nhận</div>
                                <div class="text-xs text-yellow-700 mt-1">Cần xác nhận thanh toán trong hôm nay</div>
                            </div>
                        </div>

                        <div class="flex items-start space-x-3 p-3 bg-blue-50 border border-blue-200 rounded-lg">
                            <svg class="w-5 h-5 text-blue-600 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                            </svg>
                            <div class="flex-1">
                                <div class="font-semibold text-sm text-blue-900">47 đánh giá đang chờ duyệt</div>
                                <div class="text-xs text-blue-700 mt-1">Kiểm tra và phê duyệt nội dung</div>
                            </div>
                        </div>
                    </div>
                </section>

            </main>

            <?php include '../../../includes/footer.php'; ?>
        </div>
    </div>

    <script src="../../../js/main.js"></script>
    <script>
        // Revenue Chart
        const revenueCtx = document.getElementById('revenueChart').getContext('2d');
        new Chart(revenueCtx, {
            type: 'line',
            data: {
                labels: ['T1', 'T2', 'T3', 'T4', 'T5', 'T6', 'T7', 'T8', 'T9', 'T10', 'T11', 'T12'],
                datasets: [{
                    label: 'Doanh thu (triệu VNĐ)',
                    data: [1800, 1900, 2100, 2000, 2200, 2300, 2400, 2500, 2300, 2400, 2000, 2400],
                    borderColor: '#08ea4fff',
                    backgroundColor: 'rgba(0, 102, 102, 0.1)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return value + 'M';
                            }
                        }
                    }
                }
            }
        });

        // Order Status Chart
        const orderStatusCtx = document.getElementById('orderStatusChart').getContext('2d');
        new Chart(orderStatusCtx, {
            type: 'doughnut',
            data: {
                labels: ['Đơn mới', 'Đang thuê', 'Chờ trả', 'Hoàn thành', 'Đã hủy'],
                datasets: [{
                    data: [42, 124, 36, 2847, 58],
                    backgroundColor: [
                        '#3b82f6',
                        '#10b981',
                        '#f59e0b',
                        '#8b5cf6',
                        '#ef4444'
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
    </script>
</body>

</html>
