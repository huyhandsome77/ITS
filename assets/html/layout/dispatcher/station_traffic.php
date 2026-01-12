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
    <link rel="stylesheet" href="../../../css/style.css">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<?php
$baseUrl = '../../../..';
?>

<body class="min-h-full font-[Inter]">
    <div id="app" class="flex min-h-screen">

        <!-- SIDEBAR DISPATCHER -->
        <?php include '../../../includes/dispatcher/dispatcher_sidebar.php'; ?>

        <!-- CONTENT -->
        <div id="contentWrapper" class="flex-1 flex flex-col min-h-screen transition-all duration-300">

            <!-- NAVBAR -->
            <?php include '../../../includes/navbar.php'; ?>

            <!-- MAIN -->
            <main class="flex-1 overflow-auto p-4 md:p-6 lg:p-8" style="margin-top:76px">

                <!-- ===== HEADER ===== -->
                <div class="mb-8 animate-fadeInUp">
                    <h2 class="text-3xl md:text-4xl font-bold mb-2" style="color:var(--primary-color)">
                        🚦 Điều tiết lưu lượng xe
                    </h2>
                    <p class="text-gray-600 text-base md:text-lg">
                        Theo dõi số lượng xe tại các trạm và điều phối hợp lý
                    </p>
                </div>

                <!-- ===== DASHBOARD OVERVIEW ===== -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8 animate-fadeInUp">

                    <div class="bg-white rounded-xl shadow-lg p-6 border-l-4" style="border-color:var(--primary-color)">
                        <p class="text-gray-500 text-sm mb-1">Tổng số trạm</p>
                        <p class="text-3xl font-bold" style="color:var(--primary-color)">3</p>
                    </div>

                    <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-red-500">
                        <p class="text-gray-500 text-sm mb-1">Trạm thiếu xe</p>
                        <p class="text-3xl font-bold text-red-600">1</p>
                    </div>

                    <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-yellow-500">
                        <p class="text-gray-500 text-sm mb-1">Trạm dư xe</p>
                        <p class="text-3xl font-bold text-yellow-600">1</p>
                    </div>

                </div>

                <!-- ===== TABLE STATIONS ===== -->
                <section class="bg-white rounded-2xl shadow-lg border p-6 mb-10 animate-fadeInUp">
                    <h3 class="text-lg font-semibold mb-4">📍 Danh sách trạm</h3>

                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="bg-slate-100">
                                    <th class="p-4 text-left">Trạm</th>
                                    <th class="p-4 text-left">Khu vực</th>
                                    <th class="p-4 text-center">🚗 Ô tô</th>
                                    <th class="p-4 text-center">🛵 Xe máy</th>
                                    <th class="p-4 text-center">Tình trạng</th>
                                </tr>
                            </thead>
                            <tbody>

                                <tr class="border-t hover:bg-slate-50 transition">
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

                                <tr class="border-t hover:bg-slate-50 transition">
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

                                <tr class="border-t hover:bg-slate-50 transition">
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
                <section class="bg-white rounded-2xl shadow-lg border p-6 max-w-4xl animate-fadeInUp">

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