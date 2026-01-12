<!doctype html>
<html lang="vi" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lịch sử thanh toán | Admin</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="../../../css/style.css">
    <script src="https://cdn.tailwindcss.com"></script>
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
                        <h1 class="text-3xl font-bold" style="color: var(--primary-color);">LỊCH SỬ THANH TOÁN</h1>
                        
                    </div>
                    <button  class="btn-primary px-4 py-3 rounded-lg font-bold text-sm lg:text-base shadow-lg text-white" style="background: var(--sidebar-gradient);">
                        <svg class="w-5 h-5 inline-block mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd"/>
                        </svg>
                        Xuất báo cáo
                    </button>
                </div>

                <!-- Statistics Cards -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                    <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-2xl shadow-lg p-6 text-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-green-100 text-sm">Tổng doanh thu</p>
                                <h3 class="text-3xl font-bold mt-1">2.4 tỷ</h3>
                                <p class="text-green-100 text-xs mt-1">+18.3% so với tháng trước</p>
                            </div>
                            <div class="bg-white bg-opacity-20 p-3 rounded-lg">
                                <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"/>
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl shadow-lg p-6 text-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-blue-100 text-sm">Số giao dịch</p>
                                <h3 class="text-3xl font-bold mt-1">3,847</h3>
                                <p class="text-blue-100 text-xs mt-1">154 giao dịch hôm nay</p>
                            </div>
                            <div class="bg-white bg-opacity-20 p-3 rounded-lg">
                                <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z"/>
                                    <path fill-rule="evenodd" d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-2xl shadow-lg p-6 text-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-yellow-100 text-sm">Chờ xác nhận</p>
                                <h3 class="text-3xl font-bold mt-1">28</h3>
                                <p class="text-yellow-100 text-xs mt-1">Cần xử lý trong ngày</p>
                            </div>
                            <div class="bg-white bg-opacity-20 p-3 rounded-lg">
                                <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gradient-to-br from-red-500 to-red-600 rounded-2xl shadow-lg p-6 text-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-red-100 text-sm">Thất bại</p>
                                <h3 class="text-3xl font-bold mt-1">15</h3>
                                <p class="text-red-100 text-xs mt-1">0.4% tỷ lệ lỗi</p>
                            </div>
                            <div class="bg-white bg-opacity-20 p-3 rounded-lg">
                                <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Filter Section -->
                <section class="bg-white rounded-2xl shadow-sm border p-5 mb-6">
                    <h2 class="text-lg font-semibold mb-4">Bộ lọc</h2>
                    <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                        <select id="filterStatus" class="border rounded-lg px-4 py-2">
                            <option value="">Tất cả trạng thái</option>
                            <option value="completed">Thành công</option>
                            <option value="pending">Chờ xác nhận</option>
                            <option value="processing">Đang xử lý</option>
                            <option value="failed">Thất bại</option>
                            <option value="refunded">Đã hoàn tiền</option>
                        </select>

                        <select id="filterMethod" class="border rounded-lg px-4 py-2">
                            <option value="">Tất cả phương thức</option>
                            <option value="cash">Tiền mặt</option>
                            <option value="transfer">Chuyển khoản</option>
                            <option value="credit">Thẻ tín dụng</option>
                            <option value="ewallet">Ví điện tử</option>
                        </select>

                        <input type="date" id="filterFromDate" class="border rounded-lg px-4 py-2" placeholder="Từ ngày">

                        <input type="date" id="filterToDate" class="border rounded-lg px-4 py-2" placeholder="Đến ngày">

                        <button class="px-6 py-2 rounded-lg font-semibold text-white" style="background: var(--primary-color);">
                            <svg class="w-5 h-5 inline-block mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"/>
                            </svg>
                            Lọc
                        </button>
                    </div>
                </section>

                <!-- Payment List -->
                <section class="bg-white rounded-2xl shadow-sm border p-5">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-lg font-semibold">Danh sách giao dịch</h2>
                        <span class="text-gray-600">Tổng số: <strong>3,847</strong> giao dịch</span>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-50 border-b">
                                <tr>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Mã GD</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Khách hàng</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Mã đơn</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Số tiền</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Phương thức</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Thời gian</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Trạng thái</th>
                                    <th class="px-4 py-3 text-center text-sm font-semibold text-gray-700">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y">
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3 text-sm font-mono">#PAY001</td>
                                    <td class="px-4 py-3 text-sm">
                                        <div class="font-semibold">Nguyễn Văn A</div>
                                        <div class="text-xs text-gray-500">0901234567</div>
                                    </td>
                                    <td class="px-4 py-3 text-sm font-mono">#DH001</td>
                                    <td class="px-4 py-3 text-sm">
                                        <span class="font-bold text-green-600">3,600,000đ</span>
                                    </td>
                                    <td class="px-4 py-3 text-sm">
                                        <span class="px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-700">
                                            Chuyển khoản
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-sm">
                                        <div>08/01/2026</div>
                                        <div class="text-xs text-gray-500">14:30</div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">
                                            Thành công
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <button class="text-blue-600 hover:text-blue-800 mx-1" title="Xem chi tiết" onclick="viewPayment(1)">
                                            <svg class="w-5 h-5 inline-block" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/>
                                                <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/>
                                            </svg>
                                        </button>
                                        <button class="text-gray-600 hover:text-gray-800 mx-1" title="In hóa đơn">
                                            <svg class="w-5 h-5 inline-block" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M5 4v3H4a2 2 0 00-2 2v3a2 2 0 002 2h1v2a2 2 0 002 2h6a2 2 0 002-2v-2h1a2 2 0 002-2V9a2 2 0 00-2-2h-1V4a2 2 0 00-2-2H7a2 2 0 00-2 2zm8 0H7v3h6V4zm0 8H7v4h6v-4z" clip-rule="evenodd"/>
                                            </svg>
                                        </button>
                                    </td>
                                </tr>

                                <tr class="hover:bg-gray-50 bg-yellow-50">
                                    <td class="px-4 py-3 text-sm font-mono">#PAY002</td>
                                    <td class="px-4 py-3 text-sm">
                                        <div class="font-semibold">Trần Thị B</div>
                                        <div class="text-xs text-gray-500">0912345678</div>
                                    </td>
                                    <td class="px-4 py-3 text-sm font-mono">#DH002</td>
                                    <td class="px-4 py-3 text-sm">
                                        <span class="font-bold text-green-600">10,500,000đ</span>
                                    </td>
                                    <td class="px-4 py-3 text-sm">
                                        <span class="px-3 py-1 rounded-full text-xs font-semibold bg-purple-100 text-purple-700">
                                            Ví điện tử
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-sm">
                                        <div>10/01/2026</div>
                                        <div class="text-xs text-gray-500">09:15</div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="px-3 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-700">
                                            Chờ xác nhận
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <button class="text-blue-600 hover:text-blue-800 mx-1" title="Xem chi tiết" onclick="viewPayment(2)">
                                            <svg class="w-5 h-5 inline-block" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/>
                                                <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/>
                                            </svg>
                                        </button>
                                        <button class="text-green-600 hover:text-green-800 mx-1" title="Xác nhận" onclick="confirmPayment(2)">
                                            <svg class="w-5 h-5 inline-block" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                            </svg>
                                        </button>
                                    </td>
                                </tr>

                                <tr class="hover:bg-gray-50 bg-red-50">
                                    <td class="px-4 py-3 text-sm font-mono">#PAY003</td>
                                    <td class="px-4 py-3 text-sm">
                                        <div class="font-semibold">Lê Văn C</div>
                                        <div class="text-xs text-gray-500">0923456789</div>
                                    </td>
                                    <td class="px-4 py-3 text-sm font-mono">#DH003</td>
                                    <td class="px-4 py-3 text-sm">
                                        <span class="font-bold text-red-600">2,800,000đ</span>
                                    </td>
                                    <td class="px-4 py-3 text-sm">
                                        <span class="px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">
                                            Thẻ tín dụng
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-sm">
                                        <div>09/01/2026</div>
                                        <div class="text-xs text-gray-500">16:45</div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700">
                                            Thất bại
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <button class="text-blue-600 hover:text-blue-800 mx-1" title="Xem chi tiết" onclick="viewPayment(3)">
                                            <svg class="w-5 h-5 inline-block" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/>
                                                <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/>
                                            </svg>
                                        </button>
                                        <button class="text-yellow-600 hover:text-yellow-800 mx-1" title="Thử lại" onclick="retryPayment(3)">
                                            <svg class="w-5 h-5 inline-block" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" clip-rule="evenodd"/>
                                            </svg>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="flex justify-between items-center mt-4">
                        <span class="text-sm text-gray-600">Hiển thị 1-3 của 3,847 giao dịch</span>
                        <div class="flex space-x-2">
                            <button class="px-4 py-2 border rounded-lg hover:bg-gray-50">Trước</button>
                            <button class="px-4 py-2 border rounded-lg text-white" style="background: var(--primary-color);">1</button>
                            <button class="px-4 py-2 border rounded-lg hover:bg-gray-50">2</button>
                            <button class="px-4 py-2 border rounded-lg hover:bg-gray-50">3</button>
                            <button class="px-4 py-2 border rounded-lg hover:bg-gray-50">Sau</button>
                        </div>
                    </div>
                </section>

            </main>

            <?php include '../../../includes/footer.php'; ?>
        </div>
    </div>

    <script src="../../../js/main.js"></script>
    <script>
        function viewPayment(id) {
            alert('Xem chi tiết giao dịch #PAY00' + id);
        }

        function confirmPayment(id) {
            if (confirm('Xác nhận giao dịch này đã hoàn tất?')) {
                alert('Chức năng sẽ được triển khai ở backend!');
            }
        }

        function retryPayment(id) {
            if (confirm('Thử lại giao dịch này?')) {
                alert('Chức năng sẽ được triển khai ở backend!');
            }
        }
    </script>
</body>

</html>
