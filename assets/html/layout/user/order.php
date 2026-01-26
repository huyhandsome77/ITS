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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<?php 
session_start();
$baseUrl = '../../../..'; 

// Kiểm tra đăng nhập
if (!isset($_SESSION['user_id'])) {
    header('Location: /ITS/assets/html/auth/login.php');
    exit;
}
?>

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
                <div id="statsContainer" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8 animate-fadeInUp"
                    style="animation-delay: 0.1s;">
                    <!-- Total Orders -->
                    <div class="bg-white rounded-xl shadow-lg p-6 border-l-4"
                        style="border-color: var(--primary-color);">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-600 text-sm font-medium mb-1">Tổng đơn hàng</p>
                                <p id="totalOrders" class="text-3xl font-bold" style="color: var(--primary-color);">0</p>
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
                                <p id="totalPending" class="text-3xl font-bold text-yellow-600">0</p>
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
                                <p id="totalCompleted" class="text-3xl font-bold text-green-600">0</p>
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
                                <p id="totalCancelled" class="text-3xl font-bold text-red-600">0</p>
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
                            <input id="searchInput" type="text" placeholder="Mã đơn hàng, tên xe..."
                                class="w-full px-4 py-2 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-primary-color transition-all">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold mb-2" style="color: var(--text-primary);">Trạng
                                thái</label>
                            <select id="statusFilter"
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
                            <select id="sortSelect"
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
                <div id="ordersList" class="space-y-6 animate-fadeInUp" style="animation-delay: 0.3s;">
                    <!-- Loading state -->
                    <div class="text-center py-12">
                        <div class="inline-block animate-spin rounded-full h-12 w-12 border-b-2 border-primary-color"></div>
                        <p class="mt-4 text-gray-600">Đang tải dữ liệu...</p>
                    </div>
                </div>

                <!-- Pagination -->
                <div id="paginationContainer" class="flex justify-center mt-8 animate-fadeInUp" style="animation-delay: 0.4s; display: none;">
                    <nav id="pagination" class="flex items-center space-x-2">
                        <!-- Pagination will be generated by JavaScript -->
                    </nav>
                </div>
            </main>

            <?php include '../../../includes/footer.php'; ?>
        </div>
    </div>

    <script src="../../../js/main.js"></script>
    <script>
        let currentPage = 1;
        let currentSearch = '';
        let currentStatus = '';
        let currentSort = 'newest';

        // Load orders khi trang load
        document.addEventListener('DOMContentLoaded', function() {
            loadOrders();

            // Tìm kiếm với debounce
            let searchTimeout;
            document.getElementById('searchInput').addEventListener('input', function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    currentSearch = this.value;
                    currentPage = 1;
                    loadOrders();
                }, 500);
            });

            // Lọc theo trạng thái
            document.getElementById('statusFilter').addEventListener('change', function() {
                currentStatus = this.value;
                currentPage = 1;
                loadOrders();
            });

            // Sắp xếp
            document.getElementById('sortSelect').addEventListener('change', function() {
                currentSort = this.value;
                currentPage = 1;
                loadOrders();
            });
        });

        // Hàm load danh sách đơn hàng
        async function loadOrders() {
            const url = `/ITS/assets/php/user/xuly_user_order.php?page=${currentPage}&search=${encodeURIComponent(currentSearch)}&status=${currentStatus}&sort=${currentSort}`;
            
            try {
                const response = await fetch(url);
                const data = await response.json();

                if (data.error) {
                    if (data.error === 'Vui lòng đăng nhập') {
                        window.location.href = '/ITS/assets/html/auth/login.php';
                    } else {
                        showError('Lỗi', data.error);
                    }
                    return;
                }

                // Cập nhật thống kê
                document.getElementById('totalOrders').textContent = data.stats.total_orders;
                document.getElementById('totalPending').textContent = data.stats.total_pending;
                document.getElementById('totalCompleted').textContent = data.stats.total_completed;
                document.getElementById('totalCancelled').textContent = data.stats.total_cancelled;

                // Hiển thị danh sách đơn hàng
                renderOrders(data.orders);

                // Hiển thị pagination
                renderPagination(data.pagination);

            } catch (error) {
                console.error('Error:', error);
                showError('Lỗi', 'Không thể tải dữ liệu. Vui lòng thử lại.');
            }
        }

        // Render danh sách đơn hàng
        function renderOrders(orders) {
            const container = document.getElementById('ordersList');
            
            if (orders.length === 0) {
                container.innerHTML = `
                    <div class="bg-white rounded-xl shadow-lg p-12 text-center">
                        <svg class="w-24 h-24 mx-auto text-gray-300 mb-4" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/>
                            <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"/>
                        </svg>
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Chưa có đơn hàng</h3>
                        <p class="text-gray-600">Bạn chưa có đơn hàng nào</p>
                    </div>
                `;
                return;
            }

            container.innerHTML = orders.map(order => `
                <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition-all">
                    <div class="p-6">
                        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between mb-4">
                            <div class="flex items-center space-x-4 mb-4 lg:mb-0">
                                <div class="w-20 h-20 rounded-lg flex items-center justify-center" style="background: var(--accent-gradient);">
                                    <svg class="w-12 h-12 text-white" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M18.92 6.01C18.72 5.42 18.16 5 17.5 5h-11c-.66 0-1.21.42-1.42 1.01L3 12v8c0 .55.45 1 1 1h1c.55 0 1-.45 1-1v-1h12v1c0 .55.45 1 1 1h1c.55 0 1-.45 1-1v-8l-2.08-5.99zM6.5 16c-.83 0-1.5-.67-1.5-1.5S5.67 13 6.5 13s1.5.67 1.5 1.5S7.33 16 6.5 16zm11 0c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5zM5 11l1.5-4.5h11L19 11H5z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-xl font-bold text-gray-800">${order.vehicle_name}</h3>
                                    <p class="text-sm text-gray-600">Mã đơn: #${order.order_code}</p>
                                    <p class="text-sm text-gray-600">Ngày đặt: ${order.created_at_formatted}</p>
                                </div>
                            </div>
                            ${getStatusBadge(order.status_class, order.status_text)}
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4 pt-4 border-t">
                            <div>
                                <p class="text-sm text-gray-600 mb-1">Thời gian thuê</p>
                                <p class="font-semibold text-gray-800">${order.start_date_formatted} - ${order.end_date_formatted}</p>
                                <p class="text-sm text-gray-500">${order.rental_days} ngày</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600 mb-1">Địa điểm nhận xe</p>
                                <p class="font-semibold text-gray-800">${order.station_address}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600 mb-1">Tổng tiền</p>
                                <p class="text-2xl font-bold" style="color: var(--primary-color);">${order.total_amount_formatted}</p>
                            </div>
                        </div>
                        <div class="flex flex-wrap gap-3 pt-4 border-t">
                            <button onclick="viewOrderDetail('${order.order_code}')" class="px-6 py-2 rounded-lg font-semibold text-sm transition-all border-2 hover:bg-gray-50" style="border-color: var(--primary-color); color: var(--primary-color);">
                                Xem chi tiết
                            </button>
                            ${order.can_cancel ? `
                                <button onclick="cancelOrder('${order.order_code}')" class="px-6 py-2 rounded-lg font-semibold text-sm border-2 border-red-500 text-red-600 hover:bg-red-50 transition-all">
                                    Hủy đơn
                                </button>
                            ` : ''}
                            ${order.status_class === 'completed' ? `
                                <button onclick="rebookOrder('${order.order_code}')" class="px-6 py-2 rounded-lg font-semibold text-sm text-white transition-all hover:opacity-90" style="background: var(--accent-gradient);">
                                    Thuê lại
                                </button>
                            ` : ''}
                        </div>
                    </div>
                </div>
            `).join('');
        }

        // Get status badge HTML
        function getStatusBadge(statusClass, statusText) {
            const badges = {
                'pending': 'bg-yellow-100 text-yellow-700',
                'confirmed': 'bg-blue-100 text-blue-700',
                'completed': 'bg-green-100 text-green-700',
                'cancelled': 'bg-red-100 text-red-700'
            };
            
            const icons = {
                'pending': '⏳',
                'confirmed': '✓',
                'completed': '✓',
                'cancelled': '✗'
            };

            return `<span class="px-4 py-2 rounded-full text-sm font-bold ${badges[statusClass]} inline-block w-fit">${icons[statusClass]} ${statusText}</span>`;
        }

        // Render pagination
        function renderPagination(pagination) {
            const container = document.getElementById('paginationContainer');
            const paginationNav = document.getElementById('pagination');
            
            if (pagination.total_pages <= 1) {
                container.style.display = 'none';
                return;
            }

            container.style.display = 'flex';
            
            let html = '';
            
            // Previous button
            html += `
                <button onclick="changePage(${pagination.current_page - 1})" 
                    ${pagination.current_page === 1 ? 'disabled' : ''}
                    class="px-4 py-2 rounded-lg border-2 border-gray-300 text-gray-700 hover:bg-gray-50 transition-all ${pagination.current_page === 1 ? 'opacity-50 cursor-not-allowed' : ''}">
                    Trước
                </button>
            `;

            // Page numbers
            for (let i = 1; i <= pagination.total_pages; i++) {
                if (i === pagination.current_page) {
                    html += `
                        <button class="px-4 py-2 rounded-lg font-bold text-white transition-all" style="background: var(--accent-gradient);">
                            ${i}
                        </button>
                    `;
                } else if (i === 1 || i === pagination.total_pages || Math.abs(i - pagination.current_page) <= 1) {
                    html += `
                        <button onclick="changePage(${i})" class="px-4 py-2 rounded-lg border-2 border-gray-300 text-gray-700 hover:bg-gray-50 transition-all">
                            ${i}
                        </button>
                    `;
                } else if (Math.abs(i - pagination.current_page) === 2) {
                    html += '<span class="px-2">...</span>';
                }
            }

            // Next button
            html += `
                <button onclick="changePage(${pagination.current_page + 1})" 
                    ${pagination.current_page === pagination.total_pages ? 'disabled' : ''}
                    class="px-4 py-2 rounded-lg border-2 border-gray-300 text-gray-700 hover:bg-gray-50 transition-all ${pagination.current_page === pagination.total_pages ? 'opacity-50 cursor-not-allowed' : ''}">
                    Sau
                </button>
            `;

            paginationNav.innerHTML = html;
        }

        // Change page
        function changePage(page) {
            currentPage = page;
            loadOrders();
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        // View order detail
        async function viewOrderDetail(orderCode) {
            try {
                const response = await fetch(`/ITS/assets/php/user/get_user_order_detail.php?order_code=${orderCode}`);
                const data = await response.json();

                if (data.error) {
                    showError('Lỗi', data.error);
                    return;
                }

                const order = data.order;
                
                Swal.fire({
                    title: `<h3 class="text-2xl font-bold">Chi tiết đơn hàng #${order.order_code}</h3>`,
                    html: `
                        <div class="text-left space-y-4">
                            <div class="border-b pb-3">
                                <h4 class="font-bold text-lg mb-2">Thông tin xe</h4>
                                <p><strong>Tên xe:</strong> ${order.vehicle_name}</p>
                                <p><strong>Biển số:</strong> ${order.license_plate}</p>
                                <p><strong>Hãng:</strong> ${order.brand} ${order.model}</p>
                                <p><strong>Năm:</strong> ${order.year}</p>
                            </div>
                            <div class="border-b pb-3">
                                <h4 class="font-bold text-lg mb-2">Thời gian thuê</h4>
                                <p><strong>Từ:</strong> ${order.start_date_formatted}</p>
                                <p><strong>Đến:</strong> ${order.end_date_formatted}</p>
                                <p><strong>Số ngày:</strong> ${order.rental_days} ngày</p>
                            </div>
                            <div class="border-b pb-3">
                                <h4 class="font-bold text-lg mb-2">Địa điểm</h4>
                                <p><strong>Trạm:</strong> ${order.station_name}</p>
                                <p><strong>Địa chỉ:</strong> ${order.station_address}</p>
                            </div>
                            <div class="border-b pb-3">
                                <h4 class="font-bold text-lg mb-2">Thanh toán</h4>
                                <p><strong>Giá thuê:</strong> ${order.price_per_day_formatted}/ngày</p>
                                <p><strong>Tổng tiền:</strong> <span class="text-2xl font-bold text-primary">${order.total_amount_formatted}</span></p>
                            </div>
                            <div>
                                <h4 class="font-bold text-lg mb-2">Trạng thái</h4>
                                <p><strong>Hiện tại:</strong> ${order.status_text}</p>
                                ${order.notes ? `<p><strong>Ghi chú:</strong> ${order.notes}</p>` : ''}
                                ${order.cancel_reason ? `<p><strong>Lý do hủy:</strong> ${order.cancel_reason}</p>` : ''}
                            </div>
                        </div>
                    `,
                    width: 600,
                    confirmButtonText: 'Đóng',
                    confirmButtonColor: '#2563eb'
                });

            } catch (error) {
                console.error('Error:', error);
                showError('Lỗi', 'Không thể tải chi tiết đơn hàng');
            }
        }

        // Cancel order
        async function cancelOrder(orderCode) {
            const { value: reason } = await Swal.fire({
                title: 'Hủy đơn hàng',
                html: `
                    <p class="mb-4">Bạn có chắc muốn hủy đơn hàng <strong>#${orderCode}</strong>?</p>
                    <textarea id="cancelReason" class="w-full p-3 border-2 rounded-lg" placeholder="Lý do hủy (không bắt buộc)" rows="3"></textarea>
                `,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Hủy đơn',
                cancelButtonText: 'Không',
                confirmButtonColor: '#dc2626',
                preConfirm: () => {
                    return document.getElementById('cancelReason').value;
                }
            });

            if (reason === undefined) return;

            try {
                const response = await fetch('/ITS/assets/php/user/cancel_user_order.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ order_code: orderCode, cancel_reason: reason })
                });

                const data = await response.json();

                if (data.error) {
                    showError('Lỗi', data.message || data.error);
                    return;
                }

                Swal.fire({
                    icon: 'success',
                    title: 'Thành công',
                    text: data.message,
                    confirmButtonColor: '#2563eb'
                }).then(() => {
                    loadOrders();
                });

            } catch (error) {
                console.error('Error:', error);
                showError('Lỗi', 'Không thể hủy đơn hàng. Vui lòng thử lại.');
            }
        }

        // Rebook order
        async function rebookOrder(orderCode) {
            const { value: formValues } = await Swal.fire({
                title: 'Thuê lại xe',
                html: `
                    <div class="text-left space-y-4">
                        <div>
                            <label class="block font-semibold mb-2">Ngày bắt đầu</label>
                            <input type="date" id="rebookStartDate" class="w-full p-3 border-2 rounded-lg" min="${new Date().toISOString().split('T')[0]}">
                        </div>
                        <div>
                            <label class="block font-semibold mb-2">Ngày kết thúc</label>
                            <input type="date" id="rebookEndDate" class="w-full p-3 border-2 rounded-lg" min="${new Date().toISOString().split('T')[0]}">
                        </div>
                        <div>
                            <label class="block font-semibold mb-2">Ghi chú (không bắt buộc)</label>
                            <textarea id="rebookNotes" class="w-full p-3 border-2 rounded-lg" rows="2"></textarea>
                        </div>
                    </div>
                `,
                showCancelButton: true,
                confirmButtonText: 'Đặt xe',
                cancelButtonText: 'Hủy',
                confirmButtonColor: '#2563eb',
                width: 500,
                preConfirm: () => {
                    const startDate = document.getElementById('rebookStartDate').value;
                    const endDate = document.getElementById('rebookEndDate').value;
                    const notes = document.getElementById('rebookNotes').value;

                    if (!startDate || !endDate) {
                        Swal.showValidationMessage('Vui lòng chọn ngày bắt đầu và kết thúc');
                        return false;
                    }

                    return { startDate, endDate, notes };
                }
            });

            if (!formValues) return;

            try {
                const response = await fetch('/ITS/assets/php/user/rebook_order.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({
                        order_code: orderCode,
                        start_date: formValues.startDate,
                        end_date: formValues.endDate,
                        notes: formValues.notes
                    })
                });

                const data = await response.json();

                if (data.error) {
                    showError('Lỗi', data.message || data.error);
                    return;
                }

                Swal.fire({
                    icon: 'success',
                    title: 'Đặt xe thành công!',
                    html: `
                        <p>Mã đơn hàng mới: <strong>#${data.order_code}</strong></p>
                        <p>Số ngày thuê: <strong>${data.rental_days} ngày</strong></p>
                        <p>Tổng tiền: <strong class="text-xl">${data.total_amount_formatted}</strong></p>
                    `,
                    confirmButtonColor: '#2563eb'
                }).then(() => {
                    loadOrders();
                });

            } catch (error) {
                console.error('Error:', error);
                showError('Lỗi', 'Không thể tạo đơn hàng mới. Vui lòng thử lại.');
            }
        }

        // Show error alert
        function showError(title, message) {
            Swal.fire({
                icon: 'error',
                title: title,
                text: message,
                confirmButtonColor: '#dc2626'
            });
        }
    </script>
</body>

</html>