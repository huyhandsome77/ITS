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
                <div class="mb-8 animate-fadeInUp">
                    <h1 class="text-2xl font-bold text-slate-800">
                        🚦 Điều tiết lưu lượng xe
                    </h1>

                    <p class="text-sm text-slate-500 mt-1">
                        Theo dõi số lượng xe tại các trạm và điều phối hợp lý
                    </p>
                </div>

                <!-- ===== DASHBOARD OVERVIEW ===== -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10 animate-fadeInUp">

                    <!-- ===== TOTAL STATIONS ===== -->
                    <div
                        class="group bg-white rounded-2xl shadow-md hover:shadow-xl transition p-6 relative overflow-hidden">

                        <!-- Accent line -->
                        <div class="absolute inset-x-0 top-0 h-1 bg-green-500"></div>

                        <div class="flex items-center justify-between mb-6">
                            <div>
                                <p class="text-sm font-medium text-gray-500 mb-1">
                                    Tổng số trạm
                                </p>
                                <p class="text-4xl font-extrabold text-green-600">
                                    3
                                </p>
                            </div>

                            <div class="w-12 h-12 rounded-xl flex items-center justify-center
                    bg-green-50 text-green-600 text-xl shadow-sm">
                                🏢
                            </div>
                        </div>

                        <a href="station_detail.php" class="inline-flex items-center gap-2 text-sm font-semibold
               text-green-600 group-hover:underline transition">
                            Xem chi tiết
                            <span class="group-hover:translate-x-1 transition">→</span>
                        </a>
                    </div>


                    <!-- ===== LOW VEHICLE ===== -->
                    <div
                        class="group bg-white rounded-2xl shadow-md hover:shadow-xl transition p-6 relative overflow-hidden">

                        <div class="absolute inset-x-0 top-0 h-1 bg-red-500"></div>

                        <div class="flex items-center justify-between mb-6">
                            <div>
                                <p class="text-sm font-medium text-gray-500 mb-1">
                                    Trạm thiếu xe
                                </p>
                                <p class="text-4xl font-extrabold text-red-600">
                                    1
                                </p>
                            </div>

                            <div class="w-12 h-12 rounded-xl flex items-center justify-center
                        bg-red-50 text-red-600 text-xl shadow-sm">
                                ⚠️
                            </div>
                        </div>

                        <a href="station_detail.php" class="inline-flex items-center gap-2 text-sm font-semibold
                   text-red-600 group-hover:underline transition">
                            Xem chi tiết
                            <span class="group-hover:translate-x-1 transition">→</span>
                        </a>
                    </div>

                    <!-- ===== OVER VEHICLE ===== -->
                    <div
                        class="group bg-white rounded-2xl shadow-md hover:shadow-xl transition p-6 relative overflow-hidden">

                        <div class="absolute inset-x-0 top-0 h-1 bg-yellow-500"></div>

                        <div class="flex items-center justify-between mb-6">
                            <div>
                                <p class="text-sm font-medium text-gray-500 mb-1">
                                    Trạm dư xe
                                </p>
                                <p class="text-4xl font-extrabold text-yellow-600">
                                    1
                                </p>
                            </div>

                            <div class="w-12 h-12 rounded-xl flex items-center justify-center
                        bg-yellow-50 text-yellow-600 text-xl shadow-sm">
                                📦
                            </div>
                        </div>

                        <a href="station_detail.php" class="inline-flex items-center gap-2 text-sm font-semibold
                   text-yellow-600 group-hover:underline transition">
                            Xem chi tiết
                            <span class="group-hover:translate-x-1 transition">→</span>
                        </a>
                    </div>

                </div>



                <!-- ===== TABLE STATIONS ===== -->
                <section class="rounded-2xl shadow-lg border p-6 mb-10 animate-fadeInUp" style="
                    background: var(--accent-gradient);
                    color: #ffffff;
                    border-color: var(--primary-dark);
                ">
                    <h3 class="text-lg font-semibold mb-4">📍 Danh sách trạm</h3>

                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead>
                                <tr style="background-color: #ffffff; color: black;">
                                    <th class="p-4 text-left">Trạm</th>
                                    <th class="p-4 text-left">Khu vực</th>
                                    <th class="p-4 text-center">🚗 Ô tô</th>
                                    <th class="p-4 text-center">🛵 Xe máy</th>
                                    <th class="p-4 text-center">Tình trạng</th>
                                </tr>
                            </thead>
                            <tbody>

                                <tr class="border-t">
                                    <td class="p-4 font-semibold">Nguyễn Huệ</td>
                                    <td class="p-4 text-gray-600">Quận 1</td>
                                    <td class="p-4 text-center font-bold">8</td>
                                    <td class="p-4 text-center font-bold">12</td>
                                    <td class="p-4 text-center">
                                        <span class="px-3 py-1 rounded-full text-xs font-semibold
                                               bg-green-100 text-green-700">
                                            Bình thường
                                        </span>
                                    </td>
                                </tr>

                                <tr class="border-t ">
                                    <td class="p-4 font-semibold">Bến Thành</td>
                                    <td class="p-4 text-gray-600">Quận 1</td>
                                    <td class="p-4 text-center font-bold text-red-600">2</td>
                                    <td class="p-4 text-center font-bold text-red-600">3</td>
                                    <td class="p-4 text-center">
                                        <span class="px-3 py-1 rounded-full text-xs font-semibold
                                               bg-red-100 text-red-700">
                                            Thiếu xe
                                        </span>
                                    </td>
                                </tr>

                                <tr class="border-t">
                                    <td class="p-4 font-semibold">Quận 7</td>
                                    <td class="p-4 text-gray-600">TP.HCM</td>
                                    <td class="p-4 text-center font-bold text-yellow-600">12</td>
                                    <td class="p-4 text-center font-bold text-yellow-600">20</td>
                                    <td class="p-4 text-center">
                                        <span class="px-3 py-1 rounded-full text-xs font-semibold
                                               bg-yellow-100 text-yellow-700">
                                            Dư xe
                                        </span>
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </section>

                <!-- ===== TRAFFIC CONTROL FORM ===== -->
                <section class="bg-white rounded-2xl shadow-lg border p-6 w-full animate-fadeInUp">

                    <h3 class="text-lg font-semibold mb-6">
                        🔁 Điều tiết xe giữa các trạm
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                        <div>
                            <label class="text-sm font-medium">Trạm nguồn</label>
                            <select class="w-full mt-1 border-2 border-gray-300 rounded-lg
                                   px-4 py-2 focus:outline-none
                                   focus:border-primary-color">
                                <option>Quận 7</option>
                                <option>Nguyễn Huệ</option>
                            </select>
                        </div>

                        <div>
                            <label class="text-sm font-medium">Trạm nhận</label>
                            <select class="w-full mt-1 border-2 border-gray-300 rounded-lg
                                   px-4 py-2 focus:outline-none
                                   focus:border-primary-color">
                                <option>Bến Thành</option>
                                <option>Nguyễn Huệ</option>
                            </select>
                        </div>

                        <div>
                            <label class="text-sm font-medium">Loại xe</label>
                            <select class="w-full mt-1 border-2 border-gray-300 rounded-lg
                                   px-4 py-2 focus:outline-none
                                   focus:border-primary-color">
                                <option>🚗 Ô tô</option>
                                <option>🛵 Xe máy</option>
                            </select>
                        </div>

                        <div>
                            <label class="text-sm font-medium">Số lượng</label>
                            <input type="number" min="1" class="w-full mt-1 border-2 border-gray-300 rounded-lg
                                   px-4 py-2 focus:outline-none
                                   focus:border-primary-color">
                        </div>

                        <div class="md:col-span-2 mt-2">
                            <button class="w-full py-3 rounded-lg text-white font-bold text-lg
                                   hover:opacity-90 transition" style="background:var(--accent-gradient)">
                                Xác nhận điều tiết
                            </button>
                        </div>

                    </div>
                </section>

            </main>

            <!-- FOOTER -->
            <?php include '../../../includes/footer.php'; ?>

        </div>
    </div>

    <script src="../../../js/main.js"></script>
</body>

</html>