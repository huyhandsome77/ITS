<!doctype html>
<html lang="vi" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý đơn đặt xe | Admin</title>

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
                        <h1 class="text-3xl font-bold" style="color: var(--primary-color);">ĐƠN ĐẶT XE</h1>
                    </div>
                </div>

                <!-- Statistics Cards -->
                <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-6">
                    <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl shadow-lg p-6 text-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-blue-100 text-sm">Đơn mới</p>
                                <h3 class="text-3xl font-bold mt-1">42</h3>
                            </div>
                            <div class="bg-white bg-opacity-20 p-3 rounded-lg">
                                <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/>
                                    <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-2xl shadow-lg p-6 text-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-green-100 text-sm">Đang thuê</p>
                                <h3 class="text-3xl font-bold mt-1">124</h3>
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
                                <p class="text-yellow-100 text-sm">Chờ trả xe</p>
                                <h3 class="text-3xl font-bold mt-1">36</h3>
                            </div>
                            <div class="bg-white bg-opacity-20 p-3 rounded-lg">
                                <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl shadow-lg p-6 text-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-purple-100 text-sm">Hoàn thành</p>
                                <h3 class="text-3xl font-bold mt-1">2,847</h3>
                            </div>
                            <div class="bg-white bg-opacity-20 p-3 rounded-lg">
                                <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gradient-to-br from-red-500 to-red-600 rounded-2xl shadow-lg p-6 text-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-red-100 text-sm">Đã hủy</p>
                                <h3 class="text-3xl font-bold mt-1">58</h3>
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
                        <select id="filterStation" class="border rounded-lg px-4 py-2">
                            <option value="">Tất cả trạm</option>
                            <option value="1">Nguyễn Huệ - Q1</option>
                            <option value="2">Lê Lợi - Q1</option>
                            <option value="3">Võ Văn Tần - Q3</option>
                            <option value="4">Hoàng Văn Thụ - Q Tân Bình</option>
                        </select>

                        <select id="filterStatus" class="border rounded-lg px-4 py-2">
                            <option value="">Tất cả trạng thái</option>
                            <option value="pending">Đơn mới</option>
                            <option value="renting">Đang thuê</option>
                            <option value="returning">Chờ trả xe</option>
                            <option value="completed">Hoàn thành</option>
                            <option value="cancelled">Đã hủy</option>
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

                <!-- Order List -->
                <section class="bg-white rounded-2xl shadow-sm border p-5">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-lg font-semibold">Danh sách đơn đặt xe</h2>
                        <span class="text-gray-600">Tổng số: <strong id="totalOrders">3,107</strong> đơn</span>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-50 border-b">
                                <tr>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Mã đơn</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Trạm</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Khách hàng</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Xe</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Ngày thuê</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Ngày trả</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Tổng tiền</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Trạng thái</th>
                                    <th class="px-4 py-3 text-center text-sm font-semibold text-gray-700">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody id="orderTableBody" class="divide-y">
                                <!-- Sample Data -->
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3 text-sm font-mono">#DH001</td>
                                    <td class="px-4 py-3 text-sm">Nguyễn Huệ - Q1</td>
                                    <td class="px-4 py-3 text-sm">
                                        <div class="font-semibold">Nguyễn Văn A</div>
                                        <div class="text-xs text-gray-500">0901234567</div>
                                    </td>
                                    <td class="px-4 py-3 text-sm">
                                        <div class="font-semibold">Toyota Camry</div>
                                        <div class="text-xs text-gray-500">51G-12345</div>
                                    </td>
                                    <td class="px-4 py-3 text-sm">07/01/2026</td>
                                    <td class="px-4 py-3 text-sm">10/01/2026</td>
                                    <td class="px-4 py-3 text-sm font-bold text-green-600">3,600,000đ</td>
                                    <td class="px-4 py-3">
                                        <span class="px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-700">
                                            Đơn mới
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <button class="text-blue-600 hover:text-blue-800 mx-1" title="Xem chi tiết">
                                            <svg class="w-5 h-5 inline-block" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/>
                                                <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/>
                                            </svg>
                                        </button>
                                        <button class="text-yellow-600 hover:text-yellow-800 mx-1" title="Chỉnh sửa">
                                            <svg class="w-5 h-5 inline-block" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"/>
                                            </svg>
                                        </button>
                                        <button class="text-red-600 hover:text-red-800 mx-1" title="Hủy đơn">
                                            <svg class="w-5 h-5 inline-block" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                            </svg>
                                        </button>
                                    </td>
                                </tr>
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3 text-sm font-mono">#DH002</td>
                                    <td class="px-4 py-3 text-sm">Lê Lợi - Q1</td>
                                    <td class="px-4 py-3 text-sm">
                                        <div class="font-semibold">Trần Thị B</div>
                                        <div class="text-xs text-gray-500">0912345678</div>
                                    </td>
                                    <td class="px-4 py-3 text-sm">
                                        <div class="font-semibold">Honda CR-V</div>
                                        <div class="text-xs text-gray-500">51H-67890</div>
                                    </td>
                                    <td class="px-4 py-3 text-sm">05/01/2026</td>
                                    <td class="px-4 py-3 text-sm">12/01/2026</td>
                                    <td class="px-4 py-3 text-sm font-bold text-green-600">10,500,000đ</td>
                                    <td class="px-4 py-3">
                                        <span class="px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">
                                            Đang thuê
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <button class="text-blue-600 hover:text-blue-800 mx-1" title="Xem chi tiết">
                                            <svg class="w-5 h-5 inline-block" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/>
                                                <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/>
                                            </svg>
                                        </button>
                                    </td>
                                </tr>
                                <tr class="hover:bg-gray-50 bg-yellow-50">
                                    <td class="px-4 py-3 text-sm font-mono">#DH003</td>
                                    <td class="px-4 py-3 text-sm">Võ Văn Tần - Q3</td>
                                    <td class="px-4 py-3 text-sm">
                                        <div class="font-semibold">Lê Văn C</div>
                                        <div class="text-xs text-gray-500">0923456789</div>
                                    </td>
                                    <td class="px-4 py-3 text-sm">
                                        <div class="font-semibold">Ford Tourneo</div>
                                        <div class="text-xs text-gray-500">51F-24680</div>
                                    </td>
                                    <td class="px-4 py-3 text-sm">01/01/2026</td>
                                    <td class="px-4 py-3 text-sm">10/01/2026</td>
                                    <td class="px-4 py-3 text-sm font-bold text-green-600">16,200,000đ</td>
                                    <td class="px-4 py-3">
                                        <span class="px-3 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-700">
                                            Chờ trả xe
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <button class="text-blue-600 hover:text-blue-800 mx-1" title="Xem chi tiết">
                                            <svg class="w-5 h-5 inline-block" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/>
                                                <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/>
                                            </svg>
                                        </button>
                                        <button class="text-green-600 hover:text-green-800 mx-1" title="Xác nhận trả xe">
                                            <svg class="w-5 h-5 inline-block" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                            </svg>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="flex justify-between items-center mt-4">
                        <span class="text-sm text-gray-600">Hiển thị 1-3 của 3,107 đơn</span>
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
</body>

</html>
