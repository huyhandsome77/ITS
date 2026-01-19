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
        <div id="contentWrapper" class="flex-1 flex flex-col min-h-screen transition-all duration-300">

            <!-- NAVBAR -->
            <?php include '../../../includes/navbar.php'; ?>

            <!-- MAIN -->
            <main class="flex-1 overflow-auto p-4 md:p-6 lg:p-8" style="margin-top:76px">

                <!-- HEADER -->
                <div class="mb-8">
                    <h2 class="text-3xl font-bold text-green-600 mb-2">
                        🏢 Trạm Nguyễn Huệ
                    </h2>
                    <p class="text-gray-600">
                        Quận 1, TP.HCM
                    </p>
                </div>

                <!-- OVERVIEW -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">

                    <!-- Ô tô -->
                    <div class="bg-white rounded-2xl shadow p-6 border-l-4 border-blue-500">
                        <p class="text-sm text-gray-500 mb-1">🚗 Ô tô</p>
                        <p class="text-3xl font-bold text-blue-600">8 xe</p>
                    </div>

                    <!-- Xe máy -->
                    <div class="bg-white rounded-2xl shadow p-6 border-l-4 border-green-500">
                        <p class="text-sm text-gray-500 mb-1">🛵 Xe máy</p>
                        <p class="text-3xl font-bold text-green-600">12 xe</p>
                    </div>

                    <!-- Tình trạng -->
                    <div class="bg-white rounded-2xl shadow p-6 border-l-4 border-emerald-500">
                        <p class="text-sm text-gray-500 mb-1">Tình trạng</p>
                        <span class="inline-block mt-2 px-4 py-1 rounded-full
                                 bg-emerald-100 text-emerald-700 font-semibold text-sm">
                            Hoạt động tốt
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
                        <tbody class="divide-y">

                            <tr class="hover:bg-slate-50">
                                <td class="px-4 py-3">1</td>
                                <td class="px-4 py-3 font-medium">Toyota Vios</td>
                                <td class="px-4 py-3">🚗 Ô tô</td>
                                <td class="px-4 py-3">51A-123.45</td>
                                <td class="px-4 py-3">
                                    <span class="px-3 py-1 rounded-full text-xs
                                             bg-green-100 text-green-700">
                                        Sẵn sàng
                                    </span>
                                </td>
                            </tr>

                            <tr class="hover:bg-slate-50">
                                <td class="px-4 py-3">2</td>
                                <td class="px-4 py-3 font-medium">Honda Vision</td>
                                <td class="px-4 py-3">🛵 Xe máy</td>
                                <td class="px-4 py-3">59B1-456.78</td>
                                <td class="px-4 py-3">
                                    <span class="px-3 py-1 rounded-full text-xs
                                             bg-yellow-100 text-yellow-700">
                                        Đang thuê
                                    </span>
                                </td>
                            </tr>

                        </tbody>
                    </table>
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
</body>

</html>