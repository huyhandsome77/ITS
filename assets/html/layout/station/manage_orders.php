<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once $_SERVER['DOCUMENT_ROOT'] . '/ITS/assets/php/station/xuly_station_order.php';
?>
<!doctype html>
<html lang="vi" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý trạm</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="../../../css/style.css">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<?php $baseUrl = '../../../..'; ?>

<body class="min-h-full font-[Inter]">
    <div id="app" class="flex min-h-screen">

        <?php include '../../../includes/station_sidebar.php'; ?>

        <div id="contentWrapper" class="flex-1 flex flex-col min-h-screen transition-all duration-300">

            <?php include '../../../includes/station_navbar.php'; ?>

            <!-- ================= MAIN ================= -->
            <main class="flex-1 overflow-auto p-4 md:p-6 lg:p-8" style="margin-top:76px">

                <!-- Header Section -->
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h1 class="text-3xl font-bold" style="color: var(--primary-color);">ĐƠN ĐẶT XE</h1>
                        <p class="text-gray-600 mt-1">Trạm: <span class="font-semibold" id="stationName"><?= htmlspecialchars($stationName) ?></span></p>
                    </div>
                    <button id="btnAddOrder" class="btn-primary px-6 lg:px-7 py-3 rounded-lg font-bold text-sm lg:text-base shadow-lg text-white"
                        style="background: var(--sidebar-gradient);">
                        <svg class="w-5 h-5 inline-block mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"/>
                        </svg>
                        Tạo đơn mới
                    </button>
                </div>

                <!-- Statistics Cards -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                    <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl shadow-lg p-6 text-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-blue-100 text-sm">Đơn mới</p>
                                <h3 class="text-3xl font-bold mt-1"><?= $newOrders ?></h3>
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
                                <h3 class="text-3xl font-bold mt-1"><?= $rentingOrders ?></h3>
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
                                <h3 class="text-3xl font-bold mt-1"><?= $waitingReturn ?></h3>
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
                                <h3 class="text-3xl font-bold mt-1"><?= $completedOrders ?></h3>
                            </div>
                            <div class="bg-white bg-opacity-20 p-3 rounded-lg">
                                <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Filter Section -->
                <section class="bg-white rounded-2xl shadow-sm border p-5 mb-6">
                    <h2 class="text-lg font-semibold mb-4">Bộ lọc</h2>
                    <form method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <select name="status" id="filterStatus" class="border rounded-lg px-4 py-2">
                            <option value="">Tất cả trạng thái</option>
                            <option value="NEW" <?= $status === 'NEW' ? 'selected' : '' ?>>Đơn mới</option>
                            <option value="RENTING" <?= $status === 'RENTING' ? 'selected' : '' ?>>Đang thuê</option>
                            <option value="WAITING_RETURN" <?= $status === 'WAITING_RETURN' ? 'selected' : '' ?>>Chờ trả xe</option>
                            <option value="COMPLETED" <?= $status === 'COMPLETED' ? 'selected' : '' ?>>Hoàn thành</option>
                            <option value="CANCELLED" <?= $status === 'CANCELLED' ? 'selected' : '' ?>>Đã hủy</option>
                        </select>

                        <input type="date" name="filter_date" id="filterDate" value="<?= htmlspecialchars($filterDate) ?>" class="border rounded-lg px-4 py-2">

                        <button type="submit" class="px-6 py-2 rounded-lg font-semibold text-white" style="background: var(--primary-color);">
                            <svg class="w-5 h-5 inline-block mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"/>
                            </svg>
                            Lọc
                        </button>
                    </form>
                </section>

                <!-- Order List -->
                <section class="bg-white rounded-2xl shadow-sm border p-5">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-lg font-semibold">Danh sách đơn đặt xe</h2>
                        <span class="text-gray-600">Tổng số: <strong id="totalOrders"><?= $filteredTotal ?></strong> đơn</span>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-50 border-b">
                                <tr>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Mã đơn</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Khách hàng</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Xe</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Thời gian thuê</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Trạm</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Tổng tiền</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Trạng thái</th>
                                    <th class="px-4 py-3 text-center text-sm font-semibold text-gray-700">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody id="orderTableBody" class="divide-y">
                                <?php if (empty($orders)): ?>
                                    <tr>
                                        <td colspan="8" class="px-4 py-8 text-center text-gray-500">Không có đơn hàng nào</td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($orders as $order): 
                                        $statusBadge = getStatusBadge($order['status']);
                                    ?>
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-4 py-3 text-sm font-mono"><?= htmlspecialchars($order['order_code']) ?></td>
                                        <td class="px-4 py-3 text-sm">
                                            <div class="font-semibold"><?= htmlspecialchars($order['customer_name']) ?></div>
                                            <div class="text-xs text-gray-500"><?= htmlspecialchars($order['customer_phone']) ?></div>
                                        </td>
                                        <td class="px-4 py-3 text-sm">
                                            <div class="font-semibold"><?= htmlspecialchars($order['vehicle_name']) ?></div>
                                            <div class="text-xs text-gray-500"><?= htmlspecialchars($order['license_plate']) ?></div>
                                        </td>
                                        <td class="px-4 py-3 text-sm">
                                            <div><?= formatDate($order['start_date']) ?> - <?= formatDate($order['end_date']) ?></div>
                                            <div class="text-xs text-gray-500"><?= $order['rental_days'] ?> ngày</div>
                                        </td>
                                        <td class="px-4 py-3 text-sm"><?= htmlspecialchars($order['station_name'] ?? 'N/A') ?></td>
                                        <td class="px-4 py-3 text-sm font-semibold text-green-600"><?= formatCurrency($order['total_amount']) ?></td>
                                        <td class="px-4 py-3">
                                            <span class="px-3 py-1 rounded-full text-xs font-semibold <?= $statusBadge['class'] ?>">
                                                <?= $statusBadge['label'] ?>
                                            </span>
                                        </td>
                                        <td class="px-4 py-3 text-center">
                                            <button class="text-blue-600 hover:text-blue-800 mx-1" title="Xem chi tiết" onclick="viewOrderDetail('<?= $order['order_code'] ?>')">
                                                <svg class="w-5 h-5 inline-block" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/>
                                                    <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/>
                                                </svg>
                                            </button>
                                            <?php if ($order['status'] === 'NEW'): ?>
                                                <button class="text-green-600 hover:text-green-800 mx-1" title="Xác nhận" onclick="confirmPickup('<?= $order['order_code'] ?>')">
                                                    <svg class="w-5 h-5 inline-block" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                                    </svg>
                                                </button>
                                                <button class="text-red-600 hover:text-red-800 mx-1" title="Hủy đơn" onclick="cancelOrder('<?= $order['order_code'] ?>')">
                                                    <svg class="w-5 h-5 inline-block" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                                    </svg>
                                                </button>
                                            <?php elseif ($order['status'] === 'RENTING'): ?>
                                                <button class="text-purple-600 hover:text-purple-800 mx-1" title="Xác nhận trả xe" onclick="confirmReturn('<?= $order['order_code'] ?>')">
                                                    <svg class="w-5 h-5 inline-block" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" clip-rule="evenodd"/>
                                                    </svg>
                                                </button>
                                            <?php elseif ($order['status'] === 'WAITING_RETURN'): ?>
                                                <button class="text-green-600 hover:text-green-800 mx-1" title="Hoàn thành đơn" onclick="completeOrder('<?= $order['order_code'] ?>')">
                                                    <svg class="w-5 h-5 inline-block" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                                    </svg>
                                                </button>
                                            <?php elseif ($order['status'] === 'COMPLETED'): ?>
                                                <button class="text-gray-600 hover:text-gray-800 mx-1" title="In hóa đơn">
                                                    <svg class="w-5 h-5 inline-block" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M5 4v3H4a2 2 0 00-2 2v3a2 2 0 002 2h1v2a2 2 0 002 2h6a2 2 0 002-2v-2h1a2 2 0 002-2V9a2 2 0 00-2-2h-1V4a2 2 0 00-2-2H7a2 2 0 00-2 2zm8 0H7v3h6V4zm0 8H7v4h6v-4z" clip-rule="evenodd"/>
                                                    </svg>
                                                </button>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="flex justify-between items-center mt-4">
                        <span class="text-sm text-gray-600">
                            Hiển thị <?= min($offset + 1, $filteredTotal) ?>-<?= min($offset + $limit, $filteredTotal) ?> của <?= $filteredTotal ?> đơn
                        </span>
                        <div class="flex space-x-2">
                            <?php if ($page > 1): ?>
                                <a href="?page=<?= $page - 1 ?>&status=<?= urlencode($status) ?>&filter_date=<?= urlencode($filterDate) ?>" 
                                   class="px-4 py-2 border rounded-lg hover:bg-gray-50">Trước</a>
                            <?php else: ?>
                                <button disabled class="px-4 py-2 border rounded-lg bg-gray-100 text-gray-400 cursor-not-allowed">Trước</button>
                            <?php endif; ?>

                            <?php for ($i = max(1, $page - 2); $i <= min($totalPages, $page + 2); $i++): ?>
                                <a href="?page=<?= $i ?>&status=<?= urlencode($status) ?>&filter_date=<?= urlencode($filterDate) ?>" 
                                   class="px-4 py-2 border rounded-lg <?= $i === $page ? 'bg-teal-600 text-white' : 'hover:bg-gray-50' ?>">
                                    <?= $i ?>
                                </a>
                            <?php endfor; ?>

                            <?php if ($page < $totalPages): ?>
                                <a href="?page=<?= $page + 1 ?>&status=<?= urlencode($status) ?>&filter_date=<?= urlencode($filterDate) ?>" 
                                   class="px-4 py-2 border rounded-lg hover:bg-gray-50">Sau</a>
                            <?php else: ?>
                                <button disabled class="px-4 py-2 border rounded-lg bg-gray-100 text-gray-400 cursor-not-allowed">Sau</button>
                            <?php endif; ?>
                        </div>
                    </div>
                </section>

            </main>

            <?php include '../../../includes/footer.php'; ?>
        </div>
    </div>

    <!-- Modal: Create New Order -->
    <div id="orderModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl max-w-3xl w-full max-h-[90vh] overflow-y-auto">
            <div class="p-6 border-b flex justify-between items-center">
                <h2 class="text-2xl font-bold" style="color: var(--primary-color);">Tạo đơn đặt xe mới</h2>
                <button id="closeOrderModal" class="text-gray-500 hover:text-gray-700">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                    </svg>
                </button>
            </div>
            <form id="orderForm" class="p-6">
                <div class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold mb-2">Tên khách hàng *</label>
                            <input type="text" placeholder="Nguyễn Văn A" class="w-full border rounded-lg px-4 py-2" required>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold mb-2">Số điện thoại *</label>
                            <input type="tel" placeholder="0901234567" class="w-full border rounded-lg px-4 py-2" required>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold mb-2">Email</label>
                        <input type="email" placeholder="example@email.com" class="w-full border rounded-lg px-4 py-2">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold mb-2">Chọn xe *</label>
                        <select class="w-full border rounded-lg px-4 py-2" required>
                            <option value="">-- Chọn xe --</option>
                            <option>Toyota Camry (51G-12345) - 1,200,000đ/ngày</option>
                            <option>Honda CR-V (51H-67890) - 1,500,000đ/ngày</option>
                            <option>Mazda CX-5 (51M-13579) - 1,400,000đ/ngày</option>
                        </select>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold mb-2">Ngày đặt xe *</label>
                            <input type="datetime-local" class="w-full border rounded-lg px-4 py-2" required>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold mb-2">Ngày trả xe *</label>
                            <input type="datetime-local" class="w-full border rounded-lg px-4 py-2" required>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold mb-2">Trạm đặt xe *</label>
                            <select class="w-full border rounded-lg px-4 py-2" required>
                                <option value="">-- Chọn trạm --</option>
                                <option selected>Nguyễn Huệ - Quận 1</option>
                                <option>Bến Thành - Quận 1</option>
                                <option>Đại học - Quận 3</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold mb-2">Trạm trả xe *</label>
                            <select class="w-full border rounded-lg px-4 py-2" required>
                                <option value="">-- Chọn trạm --</option>
                                <option>Nguyễn Huệ - Quận 1</option>
                                <option>Bến Thành - Quận 1</option>
                                <option>Đại học - Quận 3</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold mb-2">Hình thức thanh toán *</label>
                        <select class="w-full border rounded-lg px-4 py-2" required>
                            <option value="">-- Chọn hình thức --</option>
                            <option>Thanh toán tại trạm - Tiền mặt</option>
                            <option>Thanh toán tại trạm - Chuyển khoản</option>
                            <option>Thanh toán online</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold mb-2">Ghi chú</label>
                        <textarea rows="3" placeholder="Yêu cầu đặc biệt..." class="w-full border rounded-lg px-4 py-2"></textarea>
                    </div>

                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h3 class="font-semibold mb-2">Tổng kết</h3>
                        <div class="flex justify-between text-sm mb-1">
                            <span>Số ngày thuê:</span>
                            <span class="font-semibold">0 ngày</span>
                        </div>
                        <div class="flex justify-between text-sm mb-1">
                            <span>Đơn giá:</span>
                            <span class="font-semibold">0đ</span>
                        </div>
                        <div class="flex justify-between text-lg font-bold mt-2 pt-2 border-t">
                            <span>Tổng tiền:</span>
                            <span class="text-green-600">0đ</span>
                        </div>
                    </div>
                </div>
                <div class="flex justify-end space-x-3 mt-6">
                    <button type="button" id="cancelOrderBtn" class="px-6 py-2 border rounded-lg hover:bg-gray-50">Hủy</button>
                    <button type="submit" class="px-6 py-2 rounded-lg font-semibold text-white" style="background: var(--sidebar-gradient);">Tạo đơn</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal: Order Detail -->
    <div id="orderDetailModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
            <div class="p-6 border-b flex justify-between items-center">
                <h2 class="text-2xl font-bold" style="color: var(--primary-color);">Chi tiết đơn hàng</h2>
                <button id="closeDetailModal" class="text-gray-500 hover:text-gray-700">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                    </svg>
                </button>
            </div>
            <div class="p-6">
                <div class="space-y-4" id="orderDetailContent">
                    <div class="flex items-center justify-between pb-3 border-b">
                        <span class="text-gray-600">Mã đơn:</span>
                        <span class="font-mono font-bold text-lg">#DH001</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-gray-600">Trạng thái:</span>
                        <span class="px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-700">Đơn mới</span>
                    </div>
                    <!-- More details will be loaded dynamically -->
                </div>
            </div>
        </div>
    </div>

    <script src="../../../js/main.js"></script>
    <script>
        // Notification function
        function showNotification(message, type = 'success') {
            const notification = document.createElement('div');
            notification.className = `fixed top-4 right-4 px-6 py-3 rounded-lg shadow-lg text-white z-50 ${type === 'success' ? 'bg-green-500' : 'bg-red-500'}`;
            notification.textContent = message;
            document.body.appendChild(notification);
            setTimeout(() => notification.remove(), 3000);
        }

        // Modal handling for Create Order
        const orderModal = document.getElementById('orderModal');
        const btnAddOrder = document.getElementById('btnAddOrder');
        const closeOrderModal = document.getElementById('closeOrderModal');
        const cancelOrderBtn = document.getElementById('cancelOrderBtn');

        btnAddOrder.addEventListener('click', () => {
            orderModal.classList.remove('hidden');
        });

        closeOrderModal.addEventListener('click', () => {
            orderModal.classList.add('hidden');
        });

        cancelOrderBtn.addEventListener('click', () => {
            orderModal.classList.add('hidden');
        });

        orderModal.addEventListener('click', (e) => {
            if (e.target === orderModal) {
                orderModal.classList.add('hidden');
            }
        });

        // Modal handling for Order Detail
        const orderDetailModal = document.getElementById('orderDetailModal');
        const closeDetailModal = document.getElementById('closeDetailModal');

        closeDetailModal.addEventListener('click', () => {
            orderDetailModal.classList.add('hidden');
        });

        orderDetailModal.addEventListener('click', (e) => {
            if (e.target === orderDetailModal) {
                orderDetailModal.classList.add('hidden');
            }
        });

        // Form submit
        document.getElementById('orderForm').addEventListener('submit', (e) => {
            e.preventDefault();
            showNotification('Chức năng tạo đơn sẽ được triển khai sau!', 'success');
            orderModal.classList.add('hidden');
        });

        // View order detail
        function viewOrderDetail(orderCode) {
            fetch(`../../../php/station/get_order_detail.php?order_code=${orderCode}`)
                .then(response => response.json())
                .then(result => {
                    if (result.success) {
                        const order = result.data;
                        const statusBadge = getStatusBadgeClass(order.status);
                        
                        document.getElementById('orderDetailContent').innerHTML = `
                            <div class="flex items-center justify-between pb-3 border-b">
                                <span class="text-gray-600">Mã đơn:</span>
                                <span class="font-mono font-bold text-lg">${order.order_code}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-gray-600">Trạng thái:</span>
                                <span class="px-3 py-1 rounded-full text-xs font-semibold ${statusBadge.class}">${statusBadge.label}</span>
                            </div>
                            <div class="border-t pt-3">
                                <h3 class="font-semibold mb-2">Thông tin khách hàng</h3>
                                <div class="space-y-1 text-sm">
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Họ tên:</span>
                                        <span class="font-semibold">${order.customer_name}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Số điện thoại:</span>
                                        <span class="font-semibold">${order.customer_phone || 'N/A'}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Email:</span>
                                        <span class="font-semibold">${order.customer_email || 'N/A'}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="border-t pt-3">
                                <h3 class="font-semibold mb-2">Thông tin xe</h3>
                                <div class="space-y-1 text-sm">
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Tên xe:</span>
                                        <span class="font-semibold">${order.vehicle_name}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Biển số:</span>
                                        <span class="font-semibold">${order.license_plate}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Loại xe:</span>
                                        <span class="font-semibold">${order.vehicle_type}</span>
                                    </div>
                                    ${order.brand ? `<div class="flex justify-between">
                                        <span class="text-gray-600">Hãng:</span>
                                        <span class="font-semibold">${order.brand} ${order.model || ''}</span>
                                    </div>` : ''}
                                </div>
                            </div>
                            <div class="border-t pt-3">
                                <h3 class="font-semibold mb-2">Thời gian thuê</h3>
                                <div class="space-y-1 text-sm">
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Ngày bắt đầu:</span>
                                        <span class="font-semibold">${formatDate(order.start_date)}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Ngày kết thúc:</span>
                                        <span class="font-semibold">${formatDate(order.end_date)}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Số ngày thuê:</span>
                                        <span class="font-semibold">${order.rental_days} ngày</span>
                                    </div>
                                    ${order.actual_return_date ? `<div class="flex justify-between">
                                        <span class="text-gray-600">Ngày trả thực tế:</span>
                                        <span class="font-semibold">${formatDateTime(order.actual_return_date)}</span>
                                    </div>` : ''}
                                </div>
                            </div>
                            <div class="border-t pt-3">
                                <h3 class="font-semibold mb-2">Trạm</h3>
                                <div class="space-y-1 text-sm">
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Tên trạm:</span>
                                        <span class="font-semibold">${order.station_name}</span>
                                    </div>
                                    ${order.station_address ? `<div class="flex justify-between">
                                        <span class="text-gray-600">Địa chỉ:</span>
                                        <span class="font-semibold">${order.station_address}</span>
                                    </div>` : ''}
                                </div>
                            </div>
                            <div class="border-t pt-3 bg-gray-50 -mx-6 px-6 py-3">
                                <div class="flex justify-between text-lg font-bold">
                                    <span>Tổng tiền:</span>
                                    <span class="text-green-600">${formatCurrency(order.total_amount)}</span>
                                </div>
                            </div>
                            ${order.notes ? `<div class="border-t pt-3">
                                <h3 class="font-semibold mb-2">Ghi chú</h3>
                                <p class="text-sm text-gray-600">${order.notes}</p>
                            </div>` : ''}
                            ${order.cancel_reason ? `<div class="border-t pt-3">
                                <h3 class="font-semibold mb-2 text-red-600">Lý do hủy</h3>
                                <p class="text-sm text-gray-600">${order.cancel_reason}</p>
                            </div>` : ''}
                        `;
                        
                        orderDetailModal.classList.remove('hidden');
                    } else {
                        showNotification(result.message, 'error');
                    }
                })
                .catch(error => {
                    showNotification('Lỗi khi tải chi tiết đơn hàng', 'error');
                    console.error(error);
                });
        }

        // Confirm pickup
        function confirmPickup(orderCode) {
            if (confirm('Xác nhận khách đã nhận xe?')) {
                updateOrderStatus(orderCode, 'confirm_pickup');
            }
        }

        // Confirm return
        function confirmReturn(orderCode) {
            if (confirm('Xác nhận khách đã trả xe?')) {
                updateOrderStatus(orderCode, 'confirm_return');
            }
        }

        // Complete order
        function completeOrder(orderCode) {
            if (confirm('Xác nhận hoàn thành đơn hàng?')) {
                updateOrderStatus(orderCode, 'complete_order');
            }
        }

        // Cancel order
        function cancelOrder(orderCode) {
            const reason = prompt('Nhập lý do hủy đơn:');
            if (reason) {
                updateOrderStatus(orderCode, 'cancel_order', reason);
            }
        }

        // Update order status
        function updateOrderStatus(orderCode, action, cancelReason = null) {
            const data = { order_code: orderCode, action: action };
            if (cancelReason) {
                data.cancel_reason = cancelReason;
            }

            fetch('../../../php/station/update_order_status.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(result => {
                if (result.success) {
                    showNotification(result.message, 'success');
                    setTimeout(() => location.reload(), 1500);
                } else {
                    showNotification(result.message, 'error');
                }
            })
            .catch(error => {
                showNotification('Lỗi khi cập nhật trạng thái đơn hàng', 'error');
                console.error(error);
            });
        }

        // Helper functions
        function getStatusBadgeClass(status) {
            const badges = {
                'NEW': { label: 'Đơn mới', class: 'bg-blue-100 text-blue-700' },
                'RENTING': { label: 'Đang thuê', class: 'bg-green-100 text-green-700' },
                'WAITING_RETURN': { label: 'Chờ trả xe', class: 'bg-yellow-100 text-yellow-700' },
                'COMPLETED': { label: 'Hoàn thành', class: 'bg-purple-100 text-purple-700' },
                'CANCELLED': { label: 'Đã hủy', class: 'bg-red-100 text-red-700' }
            };
            return badges[status] || { label: 'Không xác định', class: 'bg-gray-100 text-gray-700' };
        }

        function formatCurrency(amount) {
            return new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(amount);
        }

        function formatDate(dateString) {
            const date = new Date(dateString);
            return date.toLocaleDateString('vi-VN');
        }

        function formatDateTime(dateString) {
            const date = new Date(dateString);
            return date.toLocaleString('vi-VN');
        }
    </script>
</body>

</html>
