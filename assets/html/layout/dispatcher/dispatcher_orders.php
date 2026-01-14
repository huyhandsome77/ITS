<!doctype html>
<html lang="vi" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đơn đặt xe | Dispatcher</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- CSS -->
    <link rel="stylesheet" href="../../../css/style.css">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<?php
require_once '../../../includes/bootstrap.php';


/* ===== BASE URL ===== */
$baseUrl = '../../../..';

// /* ===== CHECK LOGIN ===== */
// if (!isset($_SESSION['user_id'])) {
//     header("Location: ../../auth/login.php");
//     exit();
// }

// /* ===== CHECK ROLE ===== */
// if ($_SESSION['role'] !== 'DISPATCHER' && $_SESSION['role'] !== 'ADMIN') {
//     header("Location: ../../403.php");
//     exit();
// }
// ?>

<body class="min-h-full font-[Inter]">
    <div id="app" class="flex min-h-screen">

        <!-- SIDEBAR -->
        <?php include '../../../includes/dispatcher/dispatcher_sidebar.php'; ?>

        <div id="contentWrapper" class="flex-1 flex flex-col min-h-screen
            ml-64 lg:ml-72 transition-all duration-300">


            <!-- NAVBAR -->
            <?php include '../../../includes/navbar.php'; ?>

            <!-- ================= MAIN ================= -->
            <main class="flex-1 p-4 md:p-6 lg:p-8" style="margin-top:76px">

                <!-- HEADER -->
                <section class="mb-6">
                    <h1 class="text-2xl font-bold text-slate-800">
                        🚗 Danh sách đơn đặt xe
                    </h1>
                    <p class="text-sm text-slate-500 mt-1">
                        Dispatcher theo dõi và xử lý các đơn thuê xe
                    </p>
                </section>

                <!-- FILTER -->
                <section class="bg-white rounded-2xl shadow-sm border p-5 mb-6">
                    <h2 class="text-lg font-semibold mb-4">Bộ lọc đơn hàng</h2>

                    <div class="grid grid-cols-1 md:grid-cols-5 gap-4 items-end">

                        <input type="text" placeholder="Tên khách hàng" class="border rounded-lg px-4 py-2 text-black">

                        <select class="border text-black rounded-lg px-4 py-2">
                            <option value="">Trạng thái</option>
                            <option>Chờ xử lý</option>
                            <option>Đã xác nhận</option>
                            <option>Hoàn thành</option>
                            <option>Đã huỷ</option>
                        </select>

                        <input type="date" class="border rounded-lg px-4 py-2 text-black">

                        <select class="border rounded-lg px-4 py-2 text-black">
                            <option>Loại xe</option>
                            <option>Ô tô</option>
                            <option>Xe máy</option>
                        </select>

                        <button class="h-[42px] rounded-lg font-semibold bg-slate-100 text-black">
                            Lọc
                        </button>
                    </div>
                </section>

                <!-- TABLE -->
                <section class="bg-white rounded-2xl shadow-sm border overflow-hidden">

                    <table class="min-w-full text-sm">
                        <thead class="bg-slate-100 text-slate-600">
                            <tr>
                                <th class="px-4 py-3 text-left">#</th>
                                <th class="px-4 py-3 text-left">Khách hàng</th>
                                <th class="px-4 py-3 text-left">Xe</th>
                                <th class="px-4 py-3 text-left">Thời gian</th>
                                <th class="px-4 py-3 text-left">Trạng thái</th>
                                <th class="px-4 py-3 text-center">Hành động</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y">

                            <!-- DEMO -->
                            <tr class="hover:bg-slate-50">
                                <td class="px-4 py-3">1</td>
                                <td class="px-4 py-3 font-medium">
                                    Nguyễn Văn A
                                </td>
                                <td class="px-4 py-3">
                                    🚗 Toyota Vios
                                </td>
                                <td class="px-4 py-3">
                                    20/01/2026<br>
                                    <span class="text-xs text-slate-500">
                                        08:00 → 18:00
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    <span class="px-3 py-1 rounded-full text-xs
                                    bg-yellow-100 text-yellow-700">
                                        Chờ xử lý
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <a href="dispatcher_order_detail.php"
                                        class="text-blue-600 font-semibold hover:underline">
                                        Xem
                                    </a>
                                </td>
                            </tr>

                        </tbody>
                    </table>

                </section>

            </main>

            <!-- FOOTER -->
            <?php include '../../../includes/footer.php'; ?>

        </div>
    </div>
    <script src="../../../js/main.js"></script>
</body>

</html>