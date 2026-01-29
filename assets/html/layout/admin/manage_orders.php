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

<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/ITS/assets/php/auth/check_permission.php';
requireAdmin();
?>
<?php $baseUrl = '../../../..'; ?>
<?php
include '../../../php/admin/xuly_order.php';

// $orders = getAllOrders($conn);
// $totalOrders = countOrders($conn);
?>

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
                    <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-2xl shadow-lg p-6 text-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-green-100 text-sm">Tổng đơn</p>
                                <h3 class="text-3xl font-bold mt-1">
                                    <?= number_format($stats['total_orders'] ?? 0) ?>
                                </h3>


                            </div>
                            <div class="bg-white bg-opacity-20 p-3 rounded-lg">
                                <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z" />
                                    <path
                                        d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1v-5a1 1 0 00-.293-.707l-2-2A1 1 0 0015 7h-1z" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl shadow-lg p-6 text-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-blue-100 text-sm">Đơn mới</p>
                                <h3 class="text-3xl font-bold mt-1">
                                    <?= number_format($stats['total_new'] ?? 0) ?>
                                </h3>

                            </div>
                            <div class="bg-white bg-opacity-20 p-3 rounded-lg">
                                <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z" />
                                    <path fill-rule="evenodd"
                                        d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-2xl shadow-lg p-6 text-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-yellow-100 text-sm">Chờ trả xe</p>
                                <h3 class="text-3xl font-bold mt-1">
                                    <?= number_format($stats['total_waiting'] ?? 0) ?>
                                </h3>

                            </div>
                            <div class="bg-white bg-opacity-20 p-3 rounded-lg">
                                <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl shadow-lg p-6 text-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-purple-100 text-sm">Hoàn thành</p>
                                <h3 class="text-3xl font-bold mt-1">
                                    <?= number_format($stats['total_completed'] ?? 0) ?>
                                </h3>

                            </div>
                            <div class="bg-white bg-opacity-20 p-3 rounded-lg">
                                <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gradient-to-br from-red-500 to-red-600 rounded-2xl shadow-lg p-6 text-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-red-100 text-sm">Đã hủy</p>
                                <h3 class="text-3xl font-bold mt-1">
                                    <?= number_format($stats['total_cancelled'] ?? 0) ?>
                                </h3>

                            </div>
                            <div class="bg-white bg-opacity-20 p-3 rounded-lg">
                                <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Filter Section -->
                <section class="bg-white rounded-2xl shadow-sm border p-5 mb-6">
                    <h2 class="text-lg font-semibold mb-4">Bộ lọc</h2>

                    <form method="GET" class="grid grid-cols-1 md:grid-cols-5 gap-4">

                        <!-- Trạm -->
                        <select name="station" class="border rounded-lg px-4 py-2">
                            <option value="">Tất cả trạm</option>
                            <option value="1" <?= ($_GET['station'] ?? '') == 1 ? 'selected' : '' ?>>Nguyễn Huệ - Q1
                            </option>
                            <option value="2" <?= ($_GET['station'] ?? '') == 2 ? 'selected' : '' ?>>Lê Lợi - Q1
                            </option>
                            <option value="3" <?= ($_GET['station'] ?? '') == 3 ? 'selected' : '' ?>>Võ Văn Tần - Q3
                            </option>
                            <option value="4" <?= ($_GET['station'] ?? '') == 4 ? 'selected' : '' ?>>Hoàng Văn Thụ -
                                Q.Tân Bình</option>
                        </select>

                        <!-- Trạng thái -->
                        <select name="status" class="border rounded-lg px-4 py-2">
                            <option value="">Tất cả trạng thái</option>
                            <option value="NEW" <?= ($_GET['status'] ?? '') == 'NEW' ? 'selected' : '' ?>>Đơn mới
                            </option>
                            <option value="RENTING" <?= ($_GET['status'] ?? '') == 'RENTING' ? 'selected' : '' ?>>Đang
                                thuê</option>
                            <option value="WAITING_RETURN"
                                <?= ($_GET['status'] ?? '') == 'WAITING_RETURN' ? 'selected' : '' ?>>Chờ trả xe</option>
                            <option value="COMPLETED" <?= ($_GET['status'] ?? '') == 'COMPLETED' ? 'selected' : '' ?>>
                                Hoàn thành</option>
                            <option value="CANCELLED" <?= ($_GET['status'] ?? '') == 'CANCELLED' ? 'selected' : '' ?>>Đã
                                hủy</option>
                        </select>

                        <!-- Từ ngày -->
                        <input type="date" name="from_date" value="<?= $_GET['from_date'] ?? '' ?>"
                            class="border rounded-lg px-4 py-2">

                        <!-- Đến ngày -->
                        <input type="date" name="to_date" value="<?= $_GET['to_date'] ?? '' ?>"
                            class="border rounded-lg px-4 py-2">

                        <!-- Nút lọc -->
                        <button type="submit" class="px-6 py-2 rounded-lg font-semibold text-white"
                            style="background: var(--primary-color);">
                            🔍 Lọc
                        </button>

                    </form>
                </section>


                <!-- Order List -->
                <section class="bg-white rounded-2xl shadow-sm border p-5">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-lg font-semibold">Danh sách đơn đặt xe</h2>
                        <strong id="totalOrders"><?= number_format($totalOrders) ?></strong>

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
                            <tbody class="divide-y">
                                <?php foreach ($orders as $order): ?>
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3 font-mono">#<?= htmlspecialchars($order['order_code']) ?></td>

                                    <td class="px-4 py-3"><?= htmlspecialchars($order['station_name']) ?></td>

                                    <td class="px-4 py-3">
                                        <div class="font-semibold"><?= htmlspecialchars($order['full_name']) ?></div>
                                        <div class="text-xs text-gray-500"><?= htmlspecialchars($order['phone']) ?>
                                        </div>
                                    </td>

                                    <td class="px-4 py-3">
                                        <div class="font-semibold"><?= htmlspecialchars($order['vehicle_name']) ?></div>
                                        <div class="text-xs text-gray-500">
                                            <?= htmlspecialchars($order['license_plate']) ?></div>
                                    </td>

                                    <td class="px-4 py-3"><?= date('d/m/Y', strtotime($order['start_date'])) ?></td>
                                    <td class="px-4 py-3"><?= date('d/m/Y', strtotime($order['end_date'])) ?></td>

                                    <td class="px-4 py-3 font-bold text-green-600">
                                        <?= number_format($order['total_amount'], 0, ',', '.') ?>đ
                                    </td>

                                    <td class="whitespace-nowrap overflow-hidden px-4 py-3">
                                        <?php
                                        $statusMap = [
                                            'NEW' => ['Đơn mới', 'bg-blue-100 text-blue-700'],
                                            'RENTING' => ['Đang thuê', 'bg-green-100 text-green-700'],
                                            'WAITING_RETURN' => ['Chờ trả xe', 'bg-yellow-100 text-yellow-700'],
                                            'COMPLETED' => ['Hoàn tất', 'bg-gray-100 text-gray-700'],
                                            'CANCELLED' => ['Đã hủy', 'bg-red-100 text-red-700'],
                                        ];
                                        [$label, $class] = $statusMap[$order['status']];
                                        ?>
                                        <span class="px-3 py-1 rounded-full text-xs font-semibold <?= $class ?>">
                                            <?= $label ?>
                                        </span>
                                    </td>

                                    <td class="px-4 py-3 text-center">
                                        <div class="flex justify-center items-center gap-2">
                                            <!-- Xem -->
                                            <button onclick="viewOrder('<?= $order['order_code'] ?>')"
                                                class="text-blue-600 hover:text-blue-800 transition-colors tooltip-btn" title="Xem chi tiết">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            </button>

                                            <!-- Chỉ HỦY khi ĐƠN MỚI -->
                                            <?php if ($order['status'] === 'NEW'): ?>
                                            <a href="/ITS/assets/php/admin/cancel_order.php?code=<?= $order['order_code'] ?>"
                                                class="text-red-600 hover:text-red-800 transition-colors tooltip-btn"
                                                onclick="confirmLink(event, 'Bạn có chắc muốn hủy đơn này?')" title="Hủy đơn">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            </a>
                                            <?php endif; ?>

                                            <!-- Chỉ XÁC NHẬN TRẢ XE khi CHỜ TRẢ -->
                                            <?php if ($order['status'] === 'WAITING_RETURN'): ?>
                                            <a href="/ITS/assets/php/admin/return_order.php?code=<?= $order['order_code'] ?>"
                                                class="text-green-600 hover:text-green-800 transition-colors tooltip-btn"
                                                onclick="confirmLink(event, 'Xác nhận khách đã trả xe?')" title="Xác nhận trả xe">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                </svg>
                                            </a>
                                            <?php endif; ?>
                                        </div>
                                    </td>

                                </tr>
                                <?php endforeach; ?>
                            </tbody>

                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="flex justify-between items-center mt-4">
                        <span class="text-sm text-gray-600">
                            Hiển thị <?= $from ?>–<?= $to ?> của <?= number_format($totalOrders) ?> đơn
                        </span>

                        <div class="flex space-x-2">
                            <!-- Trước -->
                            <?php if ($page > 1): ?>
                            <a href="?page=<?= $page - 1 ?>" class="px-4 py-2 border rounded-lg hover:bg-gray-50">
                                Trước
                            </a>
                            <?php endif; ?>

                            <!-- Các trang -->
                            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                            <a href="?page=<?= $i ?>" class="px-4 py-2 border rounded-lg
           <?= $i == $page 
                ? 'text-white bg-blue-600' 
                : 'hover:bg-gray-50' ?>">
                                <?= $i ?>
                            </a>
                            <?php endfor; ?>

                            <!-- Sau -->
                            <?php if ($page < $totalPages): ?>
                            <a href="?page=<?= $page + 1 ?>" class="px-4 py-2 border rounded-lg hover:bg-gray-50">
                                Sau
                            </a>
                            <?php endif; ?>
                        </div>

                    </div>
                </section>

            </main>

            <?php include '../../../includes/footer.php'; ?>
        </div>
    </div>
    <div id="viewOrderModal"
        class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4 backdrop-blur-sm">

        <div class="bg-white rounded-2xl shadow-2xl max-w-3xl w-full">
            <!-- Header -->
            <div class="p-6 rounded-t-2xl"
                style="background: linear-gradient(to right, rgb(0,102,102), rgb(0,120,120));">
                <div class="flex justify-between items-center">
                    <h2 class="text-2xl font-bold text-white">
                        Chi tiết đơn đặt xe
                    </h2>
                    <button onclick="closeOrderModal()" class="text-white p-2">
                        ✕
                    </button>
                </div>
            </div>

            <!-- Content -->
            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-4">

                <div><b>Mã đơn:</b> <span id="v_orderCode"></span></div>
                <div><b>Trạng thái:</b> <span id="v_status"></span></div>

                <div><b>Trạm:</b> <span id="v_station"></span></div>
                <div><b>Xe:</b> <span id="v_vehicle"></span></div>

                <div><b>Biển số:</b> <span id="v_plate"></span></div>
                <div><b>Loại xe:</b> <span id="v_type"></span></div>

                <div><b>Khách hàng:</b> <span id="v_user"></span></div>
                <div><b>SĐT:</b> <span id="v_phone"></span></div>

                <div><b>Ngày thuê:</b> <span id="v_start"></span></div>
                <div><b>Ngày trả:</b> <span id="v_end"></span></div>

                <div><b>Tổng tiền:</b> <span id="v_amount" class="text-green-600 font-bold"></span></div>
                <div><b>Ngày tạo:</b> <span id="v_created"></span></div>

            </div>

            <!-- Footer -->
            <div class="p-6 bg-gray-50 rounded-b-2xl text-right">
                <button onclick="closeOrderModal()" class="px-6 py-2 text-white rounded-lg"
                    style="background: linear-gradient(to right, rgb(0,102,102), rgb(0,120,120));">
                    Đóng
                </button>
            </div>
        </div>
    </div>

    <script src="../../../js/main.js"></script>
    <script>
    function viewOrder(code) {
        fetch('/ITS/assets/php/admin/order_view.php?code=' + code)
            .then(res => res.json())
            .then(o => {
                document.getElementById('v_orderCode').innerText = '#' + o.order_code;
                document.getElementById('v_station').innerText = o.station_name;
                document.getElementById('v_vehicle').innerText = o.vehicle_name;
                document.getElementById('v_plate').innerText = o.license_plate;
                document.getElementById('v_type').innerText = o.vehicle_type;

                document.getElementById('v_user').innerText = o.full_name;
                document.getElementById('v_phone').innerText = o.phone;

                document.getElementById('v_start').innerText = formatDate(o.start_date);
                document.getElementById('v_end').innerText = formatDate(o.end_date);
                document.getElementById('v_created').innerText = formatDateTime(o.created_at);

                document.getElementById('v_amount').innerText =
                    Number(o.total_amount).toLocaleString('vi-VN') + 'đ';

                document.getElementById('v_status').innerHTML = renderStatus(o.status);

                document.getElementById('viewOrderModal').classList.remove('hidden');
            });
    }

    function confirmLink(event, message) {
        event.preventDefault();
        const url = event.currentTarget.getAttribute('href');
        Swal.fire({
            title: 'Xác nhận',
            text: message,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Đồng ý',
            cancelButtonText: 'Hủy'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = url;
            }
        });
    }

    function closeOrderModal() {
        document.getElementById('viewOrderModal').classList.add('hidden');
    }

    function formatDate(d) {
        return new Date(d).toLocaleDateString('vi-VN');
    }

    function formatDateTime(d) {
        return new Date(d).toLocaleString('vi-VN');
    }

    function renderStatus(status) {
        const map = {
            NEW: ['Đơn mới', 'text-blue-600'],
            RENTING: ['Đang thuê', 'text-green-600'],
            WAITING_RETURN: ['Chờ trả xe', 'text-yellow-600'],
            COMPLETED: ['Hoàn tất', 'text-gray-600'],
            CANCELLED: ['Đã hủy', 'text-red-600']
        };
        return `<b class="${map[status][1]}">${map[status][0]}</b>`;
    }
    </script>
    <?php if (!empty($_SESSION['alert'])): ?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
    Swal.fire({
        icon: '<?= $_SESSION['alert']['type'] ?>',
        title: '<?= $_SESSION['alert']['title'] ?>',
        text: '<?= $_SESSION['alert']['text'] ?>',
        confirmButtonText: 'OK'
    });
    </script>
    <?php unset($_SESSION['alert']); endif; ?>
</body>

</html>