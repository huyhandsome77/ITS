<!doctype html>
<html lang="vi" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thống kê hệ thống | Admin</title>

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
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h1 class="text-3xl font-bold" style="color: var(--primary-color);">THỐNG KÊ</h1>
                    </div>
                    <div class="flex space-x-3">
                        <select class="border rounded-lg px-4 py-2 text-sm">
                            <option>Tháng này</option>
                            <option>Tháng trước</option>
                            <option>Quý này</option>
                            <option>Năm nay</option>
                        </select>
                        <button class="px-4 py-2 rounded-lg text-white font-semibold text-sm" style="background: var(--primary-color);">
                            <svg class="w-4 h-4 inline-block mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd"/>
                            </svg>
                            Xuất báo cáo
                        </button>
                    </div>
                </div>

                <!-- KPI Cards -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                    <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl shadow-lg p-6 text-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-blue-100 text-sm">Doanh thu tháng</p>
                                <h3 class="text-3xl font-bold mt-1">2.4 tỷ</h3>
                                <p class="text-blue-100 text-xs mt-1">↑ 18.3% so với T12</p>
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
                                <h3 class="text-3xl font-bold mt-1">3,107</h3>
                                <p class="text-green-100 text-xs mt-1">154 đơn hôm nay</p>
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
                                <p class="text-purple-100 text-sm">Tỷ lệ xe hoạt động</p>
                                <h3 class="text-3xl font-bold mt-1">90.2%</h3>
                                <p class="text-purple-100 text-xs mt-1">313/347 xe</p>
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
                                <p class="text-yellow-100 text-sm">Đánh giá TB</p>
                                <h3 class="text-3xl font-bold mt-1">4.6 ⭐</h3>
                                <p class="text-yellow-100 text-xs mt-1">Từ 2,847 đánh giá</p>
                            </div>
                            <div class="bg-white bg-opacity-20 p-3 rounded-lg">
                                <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- New Charts Row 1 -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                    <!-- User Growth Chart -->
                    <section class="bg-white rounded-2xl shadow-sm border p-5">
                        <div class="flex justify-between items-center mb-4">
                            <h2 class="text-lg font-semibold">Tăng trưởng người dùng</h2>
                            <span class="text-xs text-gray-500">12 tháng qua</span>
                        </div>
                        <div style="height: 300px;">
                            <canvas id="userGrowthChart"></canvas>
                        </div>
                    </section>

                    <!-- Booking by Day of Week -->
                    <section class="bg-white rounded-2xl shadow-sm border p-5">
                        <h2 class="text-lg font-semibold mb-4">Đặt xe theo ngày trong tuần</h2>
                        <div style="height: 300px;">
                            <canvas id="bookingByDayChart"></canvas>
                        </div>
                    </section>
                </div>

                <!-- New Charts Row 2 -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                    <!-- Vehicle Type Distribution -->
                    <section class="bg-white rounded-2xl shadow-sm border p-5">
                        <h2 class="text-lg font-semibold mb-4">Phân bố loại xe được thuê</h2>
                        <div style="height: 300px;">
                            <canvas id="vehicleTypeChart"></canvas>
                        </div>
                    </section>

                    <!-- Payment Method Distribution -->
                    <section class="bg-white rounded-2xl shadow-sm border p-5">
                        <h2 class="text-lg font-semibold mb-4">Phương thức thanh toán</h2>
                        <div style="height: 300px;">
                            <canvas id="paymentMethodChart"></canvas>
                        </div>
                    </section>
                </div>

                <!-- Station Comparison Chart -->
                <div class="grid grid-cols-1 gap-6 mb-6">
                    <section class="bg-white rounded-2xl shadow-sm border p-5">
                        <h2 class="text-lg font-semibold mb-4">So sánh hiệu suất các trạm</h2>
                        <div style="height: 350px;">
                            <canvas id="stationComparisonChart"></canvas>
                        </div>
                    </section>
                </div>

                <!-- Top Vehicles & Customer Insights -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                    <!-- Top 5 Vehicles -->
                    <section class="bg-white rounded-2xl shadow-sm border p-5">
                        <h2 class="text-lg font-semibold mb-4">Top 5 xe được thuê nhiều nhất</h2>
                        <div class="space-y-3">
                            <div class="flex items-center justify-between p-3 bg-gradient-to-r from-yellow-50 to-yellow-100 rounded-lg border-l-4 border-yellow-500">
                                <div class="flex items-center space-x-3">
                                    <span class="w-8 h-8 rounded-full bg-yellow-500 text-white flex items-center justify-center font-bold text-sm">1</span>
                                    <div>
                                        <div class="font-semibold text-sm">Toyota Camry 2023</div>
                                        <div class="text-xs text-gray-600">51G-12345 • Nguyễn Huệ - Q1</div>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="font-bold text-sm">87 lượt</div>
                                    <div class="text-xs text-gray-500">94% thời gian</div>
                                </div>
                            </div>

                            <div class="flex items-center justify-between p-3 bg-gradient-to-r from-gray-50 to-gray-100 rounded-lg border-l-4 border-gray-400">
                                <div class="flex items-center space-x-3">
                                    <span class="w-8 h-8 rounded-full bg-gray-400 text-white flex items-center justify-center font-bold text-sm">2</span>
                                    <div>
                                        <div class="font-semibold text-sm">Honda CR-V 2023</div>
                                        <div class="text-xs text-gray-600">51H-67890 • Lê Lợi - Q1</div>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="font-bold text-sm">76 lượt</div>
                                    <div class="text-xs text-gray-500">89% thời gian</div>
                                </div>
                            </div>

                            <div class="flex items-center justify-between p-3 bg-gradient-to-r from-orange-50 to-orange-100 rounded-lg border-l-4 border-orange-500">
                                <div class="flex items-center space-x-3">
                                    <span class="w-8 h-8 rounded-full bg-orange-500 text-white flex items-center justify-center font-bold text-sm">3</span>
                                    <div>
                                        <div class="font-semibold text-sm">Mazda CX-5 2022</div>
                                        <div class="text-xs text-gray-600">51M-24680 • Võ Văn Tần - Q3</div>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="font-bold text-sm">68 lượt</div>
                                    <div class="text-xs text-gray-500">85% thời gian</div>
                                </div>
                            </div>

                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <div class="flex items-center space-x-3">
                                    <span class="w-8 h-8 rounded-full bg-gray-300 text-gray-700 flex items-center justify-center font-bold text-sm">4</span>
                                    <div>
                                        <div class="font-semibold text-sm">Ford Tourneo 2021</div>
                                        <div class="text-xs text-gray-600">51F-13579 • Nguyễn Huệ - Q1</div>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="font-bold text-sm">62 lượt</div>
                                    <div class="text-xs text-gray-500">81% thời gian</div>
                                </div>
                            </div>

                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <div class="flex items-center space-x-3">
                                    <span class="w-8 h-8 rounded-full bg-gray-300 text-gray-700 flex items-center justify-center font-bold text-sm">5</span>
                                    <div>
                                        <div class="font-semibold text-sm">VinFast VF8 2024</div>
                                        <div class="text-xs text-gray-600">51V-98765 • Hoàng Văn Thụ - TB</div>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="font-bold text-sm">58 lượt</div>
                                    <div class="text-xs text-gray-500">78% thời gian</div>
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- Customer Insights -->
                    <section class="bg-white rounded-2xl shadow-sm border p-5">
                        <h2 class="text-lg font-semibold mb-4">Phân tích khách hàng</h2>
                        
                        <div class="mb-6">
                            <h3 class="text-sm font-semibold text-gray-700 mb-3">Thời gian thuê trung bình</h3>
                            <div class="space-y-2">
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-gray-600">1-3 ngày</span>
                                    <div class="flex items-center space-x-2 flex-1 max-w-xs">
                                        <div class="flex-1 bg-gray-200 rounded-full h-2">
                                            <div class="bg-blue-500 h-2 rounded-full" style="width: 65%"></div>
                                        </div>
                                        <span class="text-sm font-semibold text-gray-700">65%</span>
                                    </div>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-gray-600">4-7 ngày</span>
                                    <div class="flex items-center space-x-2 flex-1 max-w-xs">
                                        <div class="flex-1 bg-gray-200 rounded-full h-2">
                                            <div class="bg-green-500 h-2 rounded-full" style="width: 25%"></div>
                                        </div>
                                        <span class="text-sm font-semibold text-gray-700">25%</span>
                                    </div>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-gray-600">Trên 7 ngày</span>
                                    <div class="flex items-center space-x-2 flex-1 max-w-xs">
                                        <div class="flex-1 bg-gray-200 rounded-full h-2">
                                            <div class="bg-purple-500 h-2 rounded-full" style="width: 10%"></div>
                                        </div>
                                        <span class="text-sm font-semibold text-gray-700">10%</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-6">
                            <h3 class="text-sm font-semibold text-gray-700 mb-3">Khung giờ đặt xe phổ biến</h3>
                            <div class="space-y-2">
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-gray-600">Sáng (6h-12h)</span>
                                    <div class="flex items-center space-x-2 flex-1 max-w-xs">
                                        <div class="flex-1 bg-gray-200 rounded-full h-2">
                                            <div class="bg-yellow-500 h-2 rounded-full" style="width: 45%"></div>
                                        </div>
                                        <span class="text-sm font-semibold text-gray-700">45%</span>
                                    </div>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-gray-600">Chiều (12h-18h)</span>
                                    <div class="flex items-center space-x-2 flex-1 max-w-xs">
                                        <div class="flex-1 bg-gray-200 rounded-full h-2">
                                            <div class="bg-orange-500 h-2 rounded-full" style="width: 35%"></div>
                                        </div>
                                        <span class="text-sm font-semibold text-gray-700">35%</span>
                                    </div>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-gray-600">Tối (18h-24h)</span>
                                    <div class="flex items-center space-x-2 flex-1 max-w-xs">
                                        <div class="flex-1 bg-gray-200 rounded-full h-2">
                                            <div class="bg-indigo-500 h-2 rounded-full" style="width: 20%"></div>
                                        </div>
                                        <span class="text-sm font-semibold text-gray-700">20%</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div>
                            <h3 class="text-sm font-semibold text-gray-700 mb-3">Khách hàng trung thành</h3>
                            <div class="flex items-center justify-between p-3 bg-gradient-to-r from-teal-50 to-teal-100 rounded-lg border border-teal-200">
                                <div>
                                    <div class="text-2xl font-bold text-teal-700">342</div>
                                    <div class="text-xs text-teal-600">Khách hàng thuê trên 5 lần</div>
                                </div>
                                <svg class="w-10 h-10 text-teal-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/>
                                </svg>
                            </div>
                        </div>
                    </section>
                </div>

                <!-- Station Performance Table -->
                <section class="bg-white rounded-2xl shadow-sm border p-5">
                    <h2 class="text-lg font-semibold mb-4">Hiệu suất các trạm</h2>
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-50 border-b">
                                <tr>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Trạm</th>
                                    <th class="px-4 py-3 text-center text-sm font-semibold text-gray-700">Số xe</th>
                                    <th class="px-4 py-3 text-center text-sm font-semibold text-gray-700">Đơn hàng</th>
                                    <th class="px-4 py-3 text-center text-sm font-semibold text-gray-700">Doanh thu</th>
                                    <th class="px-4 py-3 text-center text-sm font-semibold text-gray-700">Tỷ lệ sử dụng</th>
                                    <th class="px-4 py-3 text-center text-sm font-semibold text-gray-700">Đánh giá</th>
                                    <th class="px-4 py-3 text-center text-sm font-semibold text-gray-700">Hiệu suất</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y">
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3 text-sm font-semibold">Nguyễn Huệ - Q1</td>
                                    <td class="px-4 py-3 text-center text-sm">95</td>
                                    <td class="px-4 py-3 text-center text-sm font-semibold">847</td>
                                    <td class="px-4 py-3 text-center text-sm font-bold text-green-600">780M</td>
                                    <td class="px-4 py-3 text-center">
                                        <span class="px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">92%</span>
                                    </td>
                                    <td class="px-4 py-3 text-center text-sm">4.8 ⭐</td>
                                    <td class="px-4 py-3 text-center">
                                        <span class="px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">Xuất sắc</span>
                                    </td>
                                </tr>
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3 text-sm font-semibold">Lê Lợi - Q1</td>
                                    <td class="px-4 py-3 text-center text-sm">82</td>
                                    <td class="px-4 py-3 text-center text-sm font-semibold">723</td>
                                    <td class="px-4 py-3 text-center text-sm font-bold text-green-600">650M</td>
                                    <td class="px-4 py-3 text-center">
                                        <span class="px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">89%</span>
                                    </td>
                                    <td class="px-4 py-3 text-center text-sm">4.7 ⭐</td>
                                    <td class="px-4 py-3 text-center">
                                        <span class="px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">Tốt</span>
                                    </td>
                                </tr>
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3 text-sm font-semibold">Võ Văn Tần - Q3</td>
                                    <td class="px-4 py-3 text-center text-sm">76</td>
                                    <td class="px-4 py-3 text-center text-sm font-semibold">654</td>
                                    <td class="px-4 py-3 text-center text-sm font-bold text-green-600">580M</td>
                                    <td class="px-4 py-3 text-center">
                                        <span class="px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-700">86%</span>
                                    </td>
                                    <td class="px-4 py-3 text-center text-sm">4.5 ⭐</td>
                                    <td class="px-4 py-3 text-center">
                                        <span class="px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-700">Khá</span>
                                    </td>
                                </tr>
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3 text-sm font-semibold">Hoàng Văn Thụ - TB</td>
                                    <td class="px-4 py-3 text-center text-sm">94</td>
                                    <td class="px-4 py-3 text-center text-sm font-semibold">883</td>
                                    <td class="px-4 py-3 text-center text-sm font-bold text-green-600">390M</td>
                                    <td class="px-4 py-3 text-center">
                                        <span class="px-3 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-700">75%</span>
                                    </td>
                                    <td class="px-4 py-3 text-center text-sm">4.3 ⭐</td>
                                    <td class="px-4 py-3 text-center">
                                        <span class="px-3 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-700">Trung bình</span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </section>

            </main>

            <?php include '../../../includes/footer.php'; ?>
        </div>
    </div>

    <script src="../../../js/main.js"></script>
    <script>
        // User Growth Chart - Line chart showing user growth over time
        const userGrowthCtx = document.getElementById('userGrowthChart').getContext('2d');
        new Chart(userGrowthCtx, {
            type: 'line',
            data: {
                labels: ['T1', 'T2', 'T3', 'T4', 'T5', 'T6', 'T7', 'T8', 'T9', 'T10', 'T11', 'T12'],
                datasets: [{
                    label: 'Tổng người dùng',
                    data: [850, 892, 924, 968, 1010, 1056, 1098, 1142, 1180, 1205, 1223, 1247],
                    borderColor: '#8b5cf6',
                    backgroundColor: 'rgba(139, 92, 246, 0.1)',
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
                        beginAtZero: false
                    }
                }
            }
        });

        // Booking by Day of Week - Bar chart
        const bookingByDayCtx = document.getElementById('bookingByDayChart').getContext('2d');
        new Chart(bookingByDayCtx, {
            type: 'bar',
            data: {
                labels: ['Thứ 2', 'Thứ 3', 'Thứ 4', 'Thứ 5', 'Thứ 6', 'Thứ 7', 'CN'],
                datasets: [{
                    label: 'Số đơn đặt',
                    data: [387, 412, 398, 425, 568, 647, 534],
                    backgroundColor: [
                        '#3b82f6',
                        '#3b82f6',
                        '#3b82f6',
                        '#3b82f6',
                        '#10b981',
                        '#f59e0b',
                        '#f59e0b'
                    ]
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
                        beginAtZero: true
                    }
                }
            }
        });

        // Vehicle Type Distribution - Pie chart
        const vehicleTypeCtx = document.getElementById('vehicleTypeChart').getContext('2d');
        new Chart(vehicleTypeCtx, {
            type: 'pie',
            data: {
                labels: ['Sedan', 'SUV', 'MPV', 'Hatchback', 'Pickup'],
                datasets: [{
                    data: [1247, 982, 678, 534, 289],
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
                        position: 'right'
                    }
                }
            }
        });

        // Payment Method Distribution - Doughnut chart
        const paymentMethodCtx = document.getElementById('paymentMethodChart').getContext('2d');
        new Chart(paymentMethodCtx, {
            type: 'doughnut',
            data: {
                labels: ['Chuyển khoản', 'Ví điện tử', 'Thẻ tín dụng', 'Tiền mặt'],
                datasets: [{
                    data: [45, 30, 18, 7],
                    backgroundColor: [
                        '#3b82f6',
                        '#8b5cf6',
                        '#10b981',
                        '#f59e0b'
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

        // Station Comparison Chart - Horizontal Bar
        const stationComparisonCtx = document.getElementById('stationComparisonChart').getContext('2d');
        new Chart(stationComparisonCtx, {
            type: 'bar',
            data: {
                labels: ['Nguyễn Huệ - Q1', 'Lê Lợi - Q1', 'Võ Văn Tần - Q3', 'Hoàng Văn Thụ - TB'],
                datasets: [
                    {
                        label: 'Doanh thu (triệu)',
                        data: [780, 650, 580, 390],
                        backgroundColor: '#006666'
                    },
                    {
                        label: 'Số đơn',
                        data: [847, 723, 654, 883],
                        backgroundColor: '#8b5cf6'
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                indexAxis: 'y',
                plugins: {
                    legend: {
                        position: 'top'
                    }
                },
                scales: {
                    x: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</body>

</html>
