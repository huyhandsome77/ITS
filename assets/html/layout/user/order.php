<!doctype html>
<html lang="vi" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý đơn hàng | Thuexe.com</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="../../../css/style.css">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<?php $baseUrl = '../../../..'; ?>

<body class="min-h-full">
    <div id="app" class="flex min-h-screen">
        <?php include '../../../includes/sidebar.php'; ?>

        <!-- Content Wrapper (Navbar + Main + Footer) -->
        <div id="contentWrapper" class="flex-1 flex flex-col min-h-screen transition-all duration-300">
            <?php include '../../../includes/navbar.php'; ?>

            <!-- Main Section -->
            <main class="flex-1 overflow-auto p-4 md:p-6 lg:p-8" style="margin-top: 76px;">
                <!-- Page Header -->
                <div class="mb-8 animate-fadeInUp">
                    <h2 class="text-3xl md:text-4xl font-bold mb-3" style="color: var(--primary-color);">
                        Quản lý đơn hàng
                    </h2>
                    <p class="text-gray-600 text-base md:text-lg">
                        Theo dõi và quản lý các đơn thuê xe của bạn
                    </p>
                </div>

                <!-- Order Statistics -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8 animate-fadeInUp"
                    style="animation-delay: 0.1s;">
                    <!-- Total Orders -->
                    <div class="bg-white rounded-xl shadow-lg p-6 border-l-4"
                        style="border-color: var(--primary-color);">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-600 text-sm font-medium mb-1">Tổng đơn hàng</p>
                                <p class="text-3xl font-bold" style="color: var(--primary-color);">24</p>
                            </div>
                            <div class="p-3 rounded-full" style="background: var(--bg-primary);">
                                <svg class="w-8 h-8" style="color: var(--primary-color);" fill="currentColor"
                                    viewBox="0 0 20 20">
                                    <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z" />
                                    <path fill-rule="evenodd"
                                        d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Pending Orders -->
                    <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-yellow-500">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-600 text-sm font-medium mb-1">Đang xử lý</p>
                                <p class="text-3xl font-bold text-yellow-600">5</p>
                            </div>
                            <div class="p-3 rounded-full bg-yellow-50">
                                <svg class="w-8 h-8 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Completed Orders -->
                    <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-green-500">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-600 text-sm font-medium mb-1">Hoàn thành</p>
                                <p class="text-3xl font-bold text-green-600">18</p>
                            </div>
                            <div class="p-3 rounded-full bg-green-50">
                                <svg class="w-8 h-8 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Cancelled Orders -->
                    <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-red-500">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-600 text-sm font-medium mb-1">Đã hủy</p>
                                <p class="text-3xl font-bold text-red-600">1</p>
                            </div>
                            <div class="p-3 rounded-full bg-red-50">
                                <svg class="w-8 h-8 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Filter & Search -->
                <div class="bg-white rounded-xl shadow-lg p-6 mb-8 animate-fadeInUp" style="animation-delay: 0.2s;">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-semibold mb-2" style="color: var(--text-primary);">Tìm
                                kiếm</label>
                            <input type="text" placeholder="Mã đơn hàng, tên xe..."
                                class="w-full px-4 py-2 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-primary-color transition-all">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold mb-2" style="color: var(--text-primary);">Trạng
                                thái</label>
                            <select
                                class="w-full px-4 py-2 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-primary-color transition-all">
                                <option value="">Tất cả</option>
                                <option value="pending">Đang xử lý</option>
                                <option value="confirmed">Đã xác nhận</option>
                                <option value="completed">Hoàn thành</option>
                                <option value="cancelled">Đã hủy</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold mb-2" style="color: var(--text-primary);">Sắp
                                xếp</label>
                            <select
                                class="w-full px-4 py-2 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-primary-color transition-all">
                                <option value="newest">Mới nhất</option>
                                <option value="oldest">Cũ nhất</option>
                                <option value="price_high">Giá cao nhất</option>
                                <option value="price_low">Giá thấp nhất</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Orders List -->
                <div class="space-y-6 animate-fadeInUp" style="animation-delay: 0.3s;">
                    <!-- Order Item 1 -->
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition-all">
                        <div class="p-6">
                            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between mb-4">
                                <div class="flex items-center space-x-4 mb-4 lg:mb-0">
                                    <div class="w-20 h-20 rounded-lg flex items-center justify-center"
                                        style="background: var(--accent-gradient);">
                                        <svg class="w-12 h-12 text-white" fill="currentColor" viewBox="0 0 24 24">
                                            <path
                                                d="M18.92 6.01C18.72 5.42 18.16 5 17.5 5h-11c-.66 0-1.21.42-1.42 1.01L3 12v8c0 .55.45 1 1 1h1c.55 0 1-.45 1-1v-1h12v1c0 .55.45 1 1 1h1c.55 0 1-.45 1-1v-8l-2.08-5.99zM6.5 16c-.83 0-1.5-.67-1.5-1.5S5.67 13 6.5 13s1.5.67 1.5 1.5S7.33 16 6.5 16zm11 0c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5zM5 11l1.5-4.5h11L19 11H5z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-xl font-bold text-gray-800">Toyota Camry 2023</h3>
                                        <p class="text-sm text-gray-600">Mã đơn: #ORD-2025-001</p>
                                        <p class="text-sm text-gray-600">Ngày đặt: 15/12/2025</p>
                                    </div>
                                </div>
                                <span
                                    class="px-4 py-2 rounded-full text-sm font-bold bg-green-100 text-green-700 inline-block w-fit">
                                    ✓ Hoàn thành
                                </span>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4 pt-4 border-t">
                                <div>
                                    <p class="text-sm text-gray-600 mb-1">Thời gian thuê</p>
                                    <p class="font-semibold text-gray-800">15/12/2025 - 18/12/2025</p>
                                    <p class="text-sm text-gray-500">3 ngày</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600 mb-1">Địa điểm nhận xe</p>
                                    <p class="font-semibold text-gray-800">123 Nguyễn Huệ, Q1, TP.HCM</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600 mb-1">Tổng tiền</p>
                                    <p class="text-2xl font-bold" style="color: var(--primary-color);">4,500,000₫</p>
                                </div>
                            </div>
                            <div class="flex flex-wrap gap-3 pt-4 border-t">
                                <button
                                    class="px-6 py-2 rounded-lg font-semibold text-sm transition-all border-2 hover:bg-gray-50"
                                    style="border-color: var(--primary-color); color: var(--primary-color);">
                                    Xem chi tiết
                                </button>
                                <button
                                    class="px-6 py-2 rounded-lg font-semibold text-sm text-white transition-all hover:opacity-90"
                                    style="background: var(--accent-gradient);">
                                    Thuê lại
                                </button>
                                <button
                                    class="px-6 py-2 rounded-lg font-semibold text-sm border-2 border-gray-300 text-gray-700 hover:bg-gray-50 transition-all">
                                    Đánh giá
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Order Item 2 -->
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition-all">
                        <div class="p-6">
                            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between mb-4">
                                <div class="flex items-center space-x-4 mb-4 lg:mb-0">
                                    <div class="w-20 h-20 rounded-lg flex items-center justify-center"
                                        style="background: var(--accent-gradient);">
                                        <svg class="w-12 h-12 text-white" fill="currentColor" viewBox="0 0 24 24">
                                            <path
                                                d="M18.92 6.01C18.72 5.42 18.16 5 17.5 5h-11c-.66 0-1.21.42-1.42 1.01L3 12v8c0 .55.45 1 1 1h1c.55 0 1-.45 1-1v-1h12v1c0 .55.45 1 1 1h1c.55 0 1-.45 1-1v-8l-2.08-5.99zM6.5 16c-.83 0-1.5-.67-1.5-1.5S5.67 13 6.5 13s1.5.67 1.5 1.5S7.33 16 6.5 16zm11 0c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5zM5 11l1.5-4.5h11L19 11H5z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-xl font-bold text-gray-800">Honda CR-V 2024</h3>
                                        <p class="text-sm text-gray-600">Mã đơn: #ORD-2025-002</p>
                                        <p class="text-sm text-gray-600">Ngày đặt: 16/12/2025</p>
                                    </div>
                                </div>
                                <span
                                    class="px-4 py-2 rounded-full text-sm font-bold bg-yellow-100 text-yellow-700 inline-block w-fit">
                                    ⏳ Đang xử lý
                                </span>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4 pt-4 border-t">
                                <div>
                                    <p class="text-sm text-gray-600 mb-1">Thời gian thuê</p>
                                    <p class="font-semibold text-gray-800">20/12/2025 - 25/12/2025</p>
                                    <p class="text-sm text-gray-500">5 ngày</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600 mb-1">Địa điểm nhận xe</p>
                                    <p class="font-semibold text-gray-800">456 Lê Lợi, Q1, TP.HCM</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600 mb-1">Tổng tiền</p>
                                    <p class="text-2xl font-bold" style="color: var(--primary-color);">7,500,000₫</p>
                                </div>
                            </div>
                            <div class="flex flex-wrap gap-3 pt-4 border-t">
                                <button
                                    class="px-6 py-2 rounded-lg font-semibold text-sm transition-all border-2 hover:bg-gray-50"
                                    style="border-color: var(--primary-color); color: var(--primary-color);">
                                    Xem chi tiết
                                </button>
                                <button
                                    class="px-6 py-2 rounded-lg font-semibold text-sm border-2 border-red-500 text-red-600 hover:bg-red-50 transition-all">
                                    Hủy đơn
                                </button>
                                <button
                                    class="px-6 py-2 rounded-lg font-semibold text-sm border-2 border-gray-300 text-gray-700 hover:bg-gray-50 transition-all">
                                    Liên hệ hỗ trợ
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Order Item 3 -->
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition-all">
                        <div class="p-6">
                            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between mb-4">
                                <div class="flex items-center space-x-4 mb-4 lg:mb-0">
                                    <div class="w-20 h-20 rounded-lg flex items-center justify-center"
                                        style="background: var(--accent-gradient);">
                                        <svg class="w-12 h-12 text-white" fill="currentColor" viewBox="0 0 24 24">
                                            <path
                                                d="M18.92 6.01C18.72 5.42 18.16 5 17.5 5h-11c-.66 0-1.21.42-1.42 1.01L3 12v8c0 .55.45 1 1 1h1c.55 0 1-.45 1-1v-1h12v1c0 .55.45 1 1 1h1c.55 0 1-.45 1-1v-8l-2.08-5.99zM6.5 16c-.83 0-1.5-.67-1.5-1.5S5.67 13 6.5 13s1.5.67 1.5 1.5S7.33 16 6.5 16zm11 0c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5zM5 11l1.5-4.5h11L19 11H5z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-xl font-bold text-gray-800">Mazda CX-5 2023</h3>
                                        <p class="text-sm text-gray-600">Mã đơn: #ORD-2025-003</p>
                                        <p class="text-sm text-gray-600">Ngày đặt: 10/12/2025</p>
                                    </div>
                                </div>
                                <span
                                    class="px-4 py-2 rounded-full text-sm font-bold bg-blue-100 text-blue-700 inline-block w-fit">
                                    ✓ Đã xác nhận
                                </span>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4 pt-4 border-t">
                                <div>
                                    <p class="text-sm text-gray-600 mb-1">Thời gian thuê</p>
                                    <p class="font-semibold text-gray-800">22/12/2025 - 24/12/2025</p>
                                    <p class="text-sm text-gray-500">2 ngày</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600 mb-1">Địa điểm nhận xe</p>
                                    <p class="font-semibold text-gray-800">789 Trần Hưng Đạo, Q5, TP.HCM</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600 mb-1">Tổng tiền</p>
                                    <p class="text-2xl font-bold" style="color: var(--primary-color);">3,200,000₫</p>
                                </div>
                            </div>
                            <div class="flex flex-wrap gap-3 pt-4 border-t">
                                <button
                                    class="px-6 py-2 rounded-lg font-semibold text-sm transition-all border-2 hover:bg-gray-50"
                                    style="border-color: var(--primary-color); color: var(--primary-color);">
                                    Xem chi tiết
                                </button>
                                <button
                                    class="px-6 py-2 rounded-lg font-semibold text-sm text-white transition-all hover:opacity-90"
                                    style="background: var(--accent-gradient);">
                                    Xem lộ trình
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pagination -->
                <div class="flex justify-center mt-8 animate-fadeInUp" style="animation-delay: 0.4s;">
                    <nav class="flex items-center space-x-2">
                        <button
                            class="px-4 py-2 rounded-lg border-2 border-gray-300 text-gray-700 hover:bg-gray-50 transition-all">
                            Trước
                        </button>
                        <button class="px-4 py-2 rounded-lg font-bold text-white transition-all"
                            style="background: var(--accent-gradient);">
                            1
                        </button>
                        <button
                            class="px-4 py-2 rounded-lg border-2 border-gray-300 text-gray-700 hover:bg-gray-50 transition-all">
                            2
                        </button>
                        <button
                            class="px-4 py-2 rounded-lg border-2 border-gray-300 text-gray-700 hover:bg-gray-50 transition-all">
                            3
                        </button>
                        <button
                            class="px-4 py-2 rounded-lg border-2 border-gray-300 text-gray-700 hover:bg-gray-50 transition-all">
                            Sau
                        </button>
                    </nav>
                </div>
            </main>

            <?php include '../../../includes/footer.php'; ?>
        </div>
    </div>

    <script src="../../../js/main.js"></script>
</body>

</html>