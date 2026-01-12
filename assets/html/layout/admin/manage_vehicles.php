<!doctype html>
<html lang="vi" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý phương tiện | Admin</title>

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
                        <h1 class="text-3xl font-bold" style="color: var(--primary-color);">QUẢN LÝ PHƯƠNG TIỆN</h1>    
                    </div>
                    <button id="btnAddVehicle" class="btn-primary px-6 py-3 rounded-lg font-bold text-sm lg:text-base shadow-lg text-white" style="background: var(--sidebar-gradient);">
                        <svg class="w-6 h-6 inline-block mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"/>
                        </svg>
                        Thêm xe mới
                    </button>
                </div>

                <!-- Statistics Cards -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                    <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl shadow-lg p-6 text-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-blue-100 text-sm">Tổng số xe</p>
                                <h3 class="text-3xl font-bold mt-1">347</h3>
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
                                <p class="text-green-100 text-sm">Sẵn sàng</p>
                                <h3 class="text-3xl font-bold mt-1">189</h3>
                            </div>
                            <div class="bg-white bg-opacity-20 p-3 rounded-lg">
                                <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-2xl shadow-lg p-6 text-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-yellow-100 text-sm">Đang thuê</p>
                                <h3 class="text-3xl font-bold mt-1">124</h3>
                            </div>
                            <div class="bg-white bg-opacity-20 p-3 rounded-lg">
                                <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-2xl shadow-lg p-6 text-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-orange-100 text-sm">Bảo trì</p>
                                <h3 class="text-3xl font-bold mt-1">34</h3>
                            </div>
                            <div class="bg-white bg-opacity-20 p-3 rounded-lg">
                                <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"/>
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

                        <select id="filterVehicleType" class="border rounded-lg px-4 py-2">
                            <option value="">Tất cả loại xe</option>
                            <option value="sedan">Sedan</option>
                            <option value="suv">SUV</option>
                            <option value="mpv">MPV</option>
                            <option value="hatchback">Hatchback</option>
                        </select>

                        <select id="filterBrand" class="border rounded-lg px-4 py-2">
                            <option value="">Tất cả hãng</option>
                            <option value="toyota">Toyota</option>
                            <option value="honda">Honda</option>
                            <option value="mazda">Mazda</option>
                            <option value="ford">Ford</option>
                            <option value="vinfast">VinFast</option>
                        </select>

                        <select id="filterStatus" class="border rounded-lg px-4 py-2">
                            <option value="">Tất cả trạng thái</option>
                            <option value="available">Sẵn sàng</option>
                            <option value="rented">Đang thuê</option>
                            <option value="maintenance">Bảo trì</option>
                        </select>

                        <button class="px-6 py-2 rounded-lg font-semibold text-white" style="background: var(--primary-color);">
                            <svg class="w-5 h-5 inline-block mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"/>
                            </svg>
                            Lọc
                        </button>
                    </div>
                </section>

                <!-- Vehicle List -->
                <section class="bg-white rounded-2xl shadow-sm border p-5">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-lg font-semibold">Danh sách phương tiện</h2>
                        <span class="text-gray-600">Tổng số: <strong id="totalVehicles">347</strong> xe</span>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-50 border-b">
                                <tr>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Mã xe</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Trạm</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Biển số</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Loại xe</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Hãng</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Dòng xe</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Năm SX</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Giá/ngày</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Trạng thái</th>
                                    <th class="px-4 py-3 text-center text-sm font-semibold text-gray-700">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody id="vehicleTableBody" class="divide-y">
                                <!-- Sample Data -->
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3 text-sm">VH001</td>
                                    <td class="px-4 py-3 text-sm">Nguyễn Huệ - Q1</td>
                                    <td class="px-4 py-3 text-sm font-mono">51G-12345</td>
                                    <td class="px-4 py-3 text-sm">Sedan</td>
                                    <td class="px-4 py-3 text-sm">Toyota</td>
                                    <td class="px-4 py-3 text-sm">Camry</td>
                                    <td class="px-4 py-3 text-sm">2022</td>
                                    <td class="px-4 py-3 text-sm font-semibold">1,200,000đ</td>
                                    <td class="px-4 py-3">
                                        <span class="px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">
                                            Sẵn sàng
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
                                        <button class="text-red-600 hover:text-red-800 mx-1" title="Xóa">
                                            <svg class="w-5 h-5 inline-block" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                            </svg>
                                        </button>
                                    </td>
                                </tr>
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3 text-sm">VH002</td>
                                    <td class="px-4 py-3 text-sm">Lê Lợi - Q1</td>
                                    <td class="px-4 py-3 text-sm font-mono">51H-67890</td>
                                    <td class="px-4 py-3 text-sm">SUV</td>
                                    <td class="px-4 py-3 text-sm">Honda</td>
                                    <td class="px-4 py-3 text-sm">CR-V</td>
                                    <td class="px-4 py-3 text-sm">2023</td>
                                    <td class="px-4 py-3 text-sm font-semibold">1,500,000đ</td>
                                    <td class="px-4 py-3">
                                        <span class="px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700">
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
                                        <button class="text-yellow-600 hover:text-yellow-800 mx-1" title="Chỉnh sửa">
                                            <svg class="w-5 h-5 inline-block" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"/>
                                            </svg>
                                        </button>
                                        <button class="text-red-600 hover:text-red-800 mx-1" title="Xóa">
                                            <svg class="w-5 h-5 inline-block" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                            </svg>
                                        </button>
                                    </td>
                                </tr>
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3 text-sm">VH003</td>
                                    <td class="px-4 py-3 text-sm">Võ Văn Tần - Q3</td>
                                    <td class="px-4 py-3 text-sm font-mono">51F-24680</td>
                                    <td class="px-4 py-3 text-sm">MPV</td>
                                    <td class="px-4 py-3 text-sm">Ford</td>
                                    <td class="px-4 py-3 text-sm">Tourneo</td>
                                    <td class="px-4 py-3 text-sm">2021</td>
                                    <td class="px-4 py-3 text-sm font-semibold">1,800,000đ</td>
                                    <td class="px-4 py-3">
                                        <span class="px-3 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-700">
                                            Bảo trì
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
                                        <button class="text-red-600 hover:text-red-800 mx-1" title="Xóa">
                                            <svg class="w-5 h-5 inline-block" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                            </svg>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="flex justify-between items-center mt-4">
                        <span class="text-sm text-gray-600">Hiển thị 1-3 của 347 xe</span>
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

    <!-- Add/Edit Vehicle Modal -->
    <div id="vehicleModal" class="fixed inset-0 z-50 hidden overflow-y-auto bg-black bg-opacity-50">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div class="bg-white rounded-2xl shadow-xl max-w-2xl w-full p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-2xl font-bold" style="color: var(--primary-color);">Thêm xe mới</h3>
                    <button id="closeModal" class="text-gray-500 hover:text-gray-700">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                        </svg>
                    </button>
                </div>

                <form id="vehicleForm" class="space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium mb-1">Trạm</label>
                            <select class="w-full border rounded-lg px-4 py-2">
                                <option value="">Chọn trạm</option>
                                <option value="1">Nguyễn Huệ - Q1</option>
                                <option value="2">Lê Lợi - Q1</option>
                                <option value="3">Võ Văn Tần - Q3</option>
                                <option value="4">Hoàng Văn Thụ - Q Tân Bình</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1">Biển số xe</label>
                            <input type="text" class="w-full border rounded-lg px-4 py-2" placeholder="51G-12345">
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1">Loại xe</label>
                            <select class="w-full border rounded-lg px-4 py-2">
                                <option value="sedan">Sedan</option>
                                <option value="suv">SUV</option>
                                <option value="mpv">MPV</option>
                                <option value="hatchback">Hatchback</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1">Hãng xe</label>
                            <select class="w-full border rounded-lg px-4 py-2">
                                <option value="toyota">Toyota</option>
                                <option value="honda">Honda</option>
                                <option value="mazda">Mazda</option>
                                <option value="ford">Ford</option>
                                <option value="vinfast">VinFast</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1">Dòng xe</label>
                            <input type="text" class="w-full border rounded-lg px-4 py-2" placeholder="Camry">
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1">Năm sản xuất</label>
                            <input type="number" class="w-full border rounded-lg px-4 py-2" placeholder="2022">
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1">Giá thuê/ngày</label>
                            <input type="number" class="w-full border rounded-lg px-4 py-2" placeholder="1200000">
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1">Trạng thái</label>
                            <select class="w-full border rounded-lg px-4 py-2">
                                <option value="available">Sẵn sàng</option>
                                <option value="maintenance">Bảo trì</option>
                            </select>
                        </div>
                    </div>

                    <div class="flex justify-end space-x-3 mt-6">
                        <button type="button" id="cancelBtn" class="px-6 py-2 border rounded-lg hover:bg-gray-50">
                            Hủy
                        </button>
                        <button type="submit" class="px-6 py-2 rounded-lg text-white font-semibold" style="background: var(--primary-color);">
                            Lưu
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="../../../js/main.js"></script>
    <script>
        const modal = document.getElementById('vehicleModal');
        const btnAddVehicle = document.getElementById('btnAddVehicle');
        const closeModal = document.getElementById('closeModal');
        const cancelBtn = document.getElementById('cancelBtn');

        btnAddVehicle.addEventListener('click', () => {
            modal.classList.remove('hidden');
        });

        closeModal.addEventListener('click', () => {
            modal.classList.add('hidden');
        });

        cancelBtn.addEventListener('click', () => {
            modal.classList.add('hidden');
        });

        document.getElementById('vehicleForm').addEventListener('submit', (e) => {
            e.preventDefault();
            alert('Chức năng sẽ được triển khai ở backend!');
            modal.classList.add('hidden');
        });
    </script>
</body>

</html>
