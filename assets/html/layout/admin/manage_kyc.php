<!doctype html>
<html lang="vi" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý xác minh KYC | Admin</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="../../../css/style.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
                <div class="mb-8">
                    <h1 class="text-3xl font-bold mb-2" style="color: var(--primary-color);">QUẢN LÝ XÁC MINH KYC</h1>
                    <p class="text-gray-600">Phê duyệt hoặc từ chối yêu cầu xác minh tài khoản</p>
                </div>

                <!-- Statistics Cards -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                    <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl shadow-lg p-6 text-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-blue-100 text-sm">Tổng số user</p>
                                <h3 id="totalUsers" class="text-3xl font-bold mt-1">0</h3>
                            </div>
                            <div class="bg-white bg-opacity-20 p-3 rounded-lg">
                                <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-2xl shadow-lg p-6 text-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-yellow-100 text-sm">Chờ duyệt</p>
                                <h3 id="totalPending" class="text-3xl font-bold mt-1">0</h3>
                            </div>
                            <div class="bg-white bg-opacity-20 p-3 rounded-lg">
                                <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-2xl shadow-lg p-6 text-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-green-100 text-sm">Đã xác minh</p>
                                <h3 id="totalVerified" class="text-3xl font-bold mt-1">0</h3>
                            </div>
                            <div class="bg-white bg-opacity-20 p-3 rounded-lg">
                                <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gradient-to-br from-red-500 to-red-600 rounded-2xl shadow-lg p-6 text-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-red-100 text-sm">Từ chối</p>
                                <h3 id="totalRejected" class="text-3xl font-bold mt-1">0</h3>
                            </div>
                            <div class="bg-white bg-opacity-20 p-3 rounded-lg">
                                <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Filters -->
                <div class="bg-white rounded-xl shadow-md p-6 mb-6">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Tìm kiếm</label>
                            <input type="text" id="searchInput" placeholder="Tên, email, CCCD, SĐT..." 
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Trạng thái</label>
                            <select id="statusFilter" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none">
                                <option value="">Tất cả</option>
                                <option value="PENDING">Chờ duyệt</option>
                                <option value="VERIFIED">Đã xác minh</option>
                                <option value="REJECTED">Từ chối</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Sắp xếp</label>
                            <select id="sortSelect" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none">
                                <option value="newest">Mới nhất</option>
                                <option value="oldest">Cũ nhất</option>
                                <option value="pending_first">Chờ duyệt trước</option>
                                <option value="verified_first">Đã xác minh trước</option>
                                <option value="name_asc">Tên A-Z</option>
                                <option value="name_desc">Tên Z-A</option>
                            </select>
                        </div>
                        <div class="flex items-end">
                            <button onclick="loadUsers()" class="w-full px-6 py-2.5 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition">
                                <svg class="w-5 h-5 inline-block mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"/>
                                </svg>
                                Tìm kiếm
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Users List -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                        Người dùng
                                    </th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                        Thông tin liên hệ
                                    </th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                        CCCD
                                    </th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                        Trạng thái KYC
                                    </th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                        Hoàn thành
                                    </th>
                                    <th class="px-6 py-4 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                        Thao tác
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="usersTableBody" class="bg-white divide-y divide-gray-200">
                                <!-- Data will be loaded here -->
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div id="paginationContainer" class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                        <!-- Pagination will be rendered here -->
                    </div>
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

        // Load users when page loads
        document.addEventListener('DOMContentLoaded', function() {
            loadUsers();

            // Search with debounce
            let searchTimeout;
            document.getElementById('searchInput').addEventListener('input', function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    currentSearch = this.value;
                    currentPage = 1;
                    loadUsers();
                }, 500);
            });

            // Filter by status
            document.getElementById('statusFilter').addEventListener('change', function() {
                currentStatus = this.value;
                currentPage = 1;
                loadUsers();
            });

            // Sort
            document.getElementById('sortSelect').addEventListener('change', function() {
                currentSort = this.value;
                currentPage = 1;
                loadUsers();
            });
        });

        // Load users list
        async function loadUsers() {
            const url = `/ITS/assets/php/admin/xuly_kyc_verification.php?page=${currentPage}&search=${encodeURIComponent(currentSearch)}&status=${currentStatus}&sort=${currentSort}`;
            
            try {
                const response = await fetch(url);
                const data = await response.json();

                if (data.error) {
                    showError('Lỗi', data.error);
                    return;
                }

                // Update statistics
                document.getElementById('totalUsers').textContent = data.stats.total_users;
                document.getElementById('totalPending').textContent = data.stats.total_pending;
                document.getElementById('totalVerified').textContent = data.stats.total_verified;
                document.getElementById('totalRejected').textContent = data.stats.total_rejected;

                // Render users list
                renderUsers(data.users);

                // Render pagination
                renderPagination(data.pagination);

            } catch (error) {
                console.error('Error:', error);
                showError('Lỗi', 'Không thể tải dữ liệu. Vui lòng thử lại.');
            }
        }

        // Render users table
        function renderUsers(users) {
            const tbody = document.getElementById('usersTableBody');
            
            if (users.length === 0) {
                tbody.innerHTML = `
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                            <svg class="w-16 h-16 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                            </svg>
                            <p class="text-lg font-semibold">Không có dữ liệu</p>
                        </td>
                    </tr>
                `;
                return;
            }

            tbody.innerHTML = users.map(user => {
                const statusColors = {
                    'green': 'bg-green-100 text-green-800',
                    'yellow': 'bg-yellow-100 text-yellow-800',
                    'red': 'bg-red-100 text-red-800',
                    'gray': 'bg-gray-100 text-gray-800'
                };

                const statusColor = statusColors[user.status_color] || statusColors['gray'];
                const completionPercent = calculateCompletionPercent(user);

                return `
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <img src="${user.avatar_url}" alt="Avatar" class="w-12 h-12 rounded-full object-cover mr-3">
                                <div>
                                    <p class="font-semibold text-gray-900">${user.full_name}</p>
                                    <p class="text-sm text-gray-500">${user.email}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-sm text-gray-900">${user.phone || 'Chưa cập nhật'}</p>
                            <p class="text-xs text-gray-500">Đăng ký: ${user.created_at_formatted}</p>
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-sm font-medium text-gray-900">${user.id_card_number || 'Chưa có'}</p>
                            <p class="text-xs text-gray-500">${user.id_card_name || ''}</p>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 rounded-full text-xs font-semibold ${statusColor}">
                                ${user.status_badge}
                            </span>
                            ${user.verified_at_formatted ? `<p class="text-xs text-gray-500 mt-1">${user.verified_at_formatted}</p>` : ''}
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="flex-1 bg-gray-200 rounded-full h-2 mr-2">
                                    <div class="bg-blue-600 h-2 rounded-full" style="width: ${completionPercent}%"></div>
                                </div>
                                <span class="text-xs font-semibold text-gray-700">${completionPercent}%</span>
                            </div>
                            <div class="flex gap-1 mt-2">
                                ${user.has_id_card ? '<span class="text-xs text-green-600">✓ CCCD</span>' : '<span class="text-xs text-gray-400">✗ CCCD</span>'}
                                ${user.has_face_image ? '<span class="text-xs text-green-600">✓ Ảnh</span>' : '<span class="text-xs text-gray-400">✗ Ảnh</span>'}
                                ${user.has_bank_info ? '<span class="text-xs text-green-600">✓ NH</span>' : '<span class="text-xs text-gray-400">✗ NH</span>'}
                            </div>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <button onclick="viewUserDetail(${user.user_id})" class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-semibold hover:bg-blue-700 transition mr-2">
                                Xem chi tiết
                            </button>
                        </td>
                    </tr>
                `;
            }).join('');
        }

        // Calculate completion percentage
        function calculateCompletionPercent(user) {
            let total = 0;
            let completed = 0;

            // ID Card (2 points)
            total += 2;
            if (user.has_id_card) completed += 2;

            // Face Image (1 point)
            total += 1;
            if (user.has_face_image) completed += 1;

            // Bank Info (1 point)
            total += 1;
            if (user.has_bank_info) completed += 1;

            // ID Info (1 point)
            total += 1;
            if (user.has_id_info) completed += 1;

            return Math.round((completed / total) * 100);
        }

        // Render pagination
        function renderPagination(pagination) {
            const container = document.getElementById('paginationContainer');
            
            if (pagination.total_pages <= 1) {
                container.innerHTML = '';
                return;
            }

            let html = '<div class="flex items-center justify-between">';
            html += `<p class="text-sm text-gray-700">Hiển thị <span class="font-semibold">${Math.min((pagination.current_page - 1) * pagination.per_page + 1, pagination.total_records)}</span> đến <span class="font-semibold">${Math.min(pagination.current_page * pagination.per_page, pagination.total_records)}</span> trong tổng số <span class="font-semibold">${pagination.total_records}</span> bản ghi</p>`;
            html += '<div class="flex gap-2">';

            // Previous button
            if (pagination.current_page > 1) {
                html += `<button onclick="changePage(${pagination.current_page - 1})" class="px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 transition">Trước</button>`;
            }

            // Page numbers
            const maxPages = 5;
            let startPage = Math.max(1, pagination.current_page - Math.floor(maxPages / 2));
            let endPage = Math.min(pagination.total_pages, startPage + maxPages - 1);

            if (endPage - startPage < maxPages - 1) {
                startPage = Math.max(1, endPage - maxPages + 1);
            }

            for (let i = startPage; i <= endPage; i++) {
                if (i === pagination.current_page) {
                    html += `<button class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium">${i}</button>`;
                } else {
                    html += `<button onclick="changePage(${i})" class="px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 transition">${i}</button>`;
                }
            }

            // Next button
            if (pagination.current_page < pagination.total_pages) {
                html += `<button onclick="changePage(${pagination.current_page + 1})" class="px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 transition">Sau</button>`;
            }

            html += '</div></div>';
            container.innerHTML = html;
        }

        // Change page
        function changePage(page) {
            currentPage = page;
            loadUsers();
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        // View user detail and approve/reject
        async function viewUserDetail(userId) {
            try {
                // First, get fresh user data
                const response = await fetch(`/ITS/assets/php/admin/xuly_kyc_verification.php?page=1&search=&status=&sort=newest`);
                const data = await response.json();
                
                if (data.error) {
                    showError('Lỗi', data.error);
                    return;
                }

                const user = data.users.find(u => u.user_id == userId);
                if (!user) {
                    showError('Lỗi', 'Không tìm thấy người dùng');
                    return;
                }

                // Build document preview HTML
                let documentsHtml = '<div class="grid grid-cols-2 md:grid-cols-3 gap-4 mb-4">';
                
                if (user.id_card_front_url) {
                    documentsHtml += `
                        <div>
                            <p class="text-xs font-semibold text-gray-700 mb-2">CCCD Mặt trước</p>
                            <a href="${user.id_card_front_url}" target="_blank">
                                <img src="${user.id_card_front_url}" class="w-full h-32 object-cover rounded border-2 border-gray-300 hover:border-blue-500 cursor-pointer">
                            </a>
                        </div>
                    `;
                }
                
                if (user.id_card_back_url) {
                    documentsHtml += `
                        <div>
                            <p class="text-xs font-semibold text-gray-700 mb-2">CCCD Mặt sau</p>
                            <a href="${user.id_card_back_url}" target="_blank">
                                <img src="${user.id_card_back_url}" class="w-full h-32 object-cover rounded border-2 border-gray-300 hover:border-blue-500 cursor-pointer">
                            </a>
                        </div>
                    `;
                }
                
                if (user.face_image_url) {
                    documentsHtml += `
                        <div>
                            <p class="text-xs font-semibold text-gray-700 mb-2">Ảnh khuôn mặt</p>
                            <a href="${user.face_image_url}" target="_blank">
                                <img src="${user.face_image_url}" class="w-full h-32 object-cover rounded border-2 border-gray-300 hover:border-blue-500 cursor-pointer">
                            </a>
                        </div>
                    `;
                }

                if (user.driver_license_front_url) {
                    documentsHtml += `
                        <div>
                            <p class="text-xs font-semibold text-gray-700 mb-2">Bằng lái (Trước)</p>
                            <a href="${user.driver_license_front_url}" target="_blank">
                                <img src="${user.driver_license_front_url}" class="w-full h-32 object-cover rounded border-2 border-gray-300 hover:border-blue-500 cursor-pointer">
                            </a>
                        </div>
                    `;
                }

                if (user.driver_license_back_url) {
                    documentsHtml += `
                        <div>
                            <p class="text-xs font-semibold text-gray-700 mb-2">Bằng lái (Sau)</p>
                            <a href="${user.driver_license_back_url}" target="_blank">
                                <img src="${user.driver_license_back_url}" class="w-full h-32 object-cover rounded border-2 border-gray-300 hover:border-blue-500 cursor-pointer">
                            </a>
                        </div>
                    `;
                }

                documentsHtml += '</div>';

                // Build info HTML
                let infoHtml = `
                    <div class="text-left space-y-3 mb-4">
                        <h3 class="font-bold text-lg border-b pb-2">Thông tin CCCD</h3>
                        <div class="grid grid-cols-2 gap-3 text-sm">
                            <div><span class="font-semibold">Số CCCD:</span> ${user.id_card_number || 'Chưa có'}</div>
                            <div><span class="font-semibold">Họ tên:</span> ${user.id_card_name || 'Chưa có'}</div>
                            <div><span class="font-semibold">Ngày cấp:</span> ${user.id_card_date_formatted || 'Chưa có'}</div>
                            <div><span class="font-semibold">Nơi cấp:</span> ${user.id_card_place || 'Chưa có'}</div>
                        </div>

                        <h3 class="font-bold text-lg border-b pb-2 pt-3">Thông tin ngân hàng</h3>
                        <div class="grid grid-cols-2 gap-3 text-sm">
                            <div><span class="font-semibold">Số TK:</span> ${user.bank_account_number || 'Chưa có'}</div>
                            <div><span class="font-semibold">Chủ TK:</span> ${user.bank_account_name || 'Chưa có'}</div>
                            <div><span class="font-semibold">Ngân hàng:</span> ${user.bank_name || 'Chưa có'}</div>
                        </div>

                        <h3 class="font-bold text-lg border-b pb-2 pt-3">Thông tin khác</h3>
                        <div class="grid grid-cols-2 gap-3 text-sm">
                            <div><span class="font-semibold">Bằng lái:</span> ${user.driver_license_number || 'Không có'}</div>
                            <div><span class="font-semibold">Địa chỉ:</span> ${user.address || 'Chưa có'}</div>
                            <div><span class="font-semibold">Liên hệ khẩn cấp:</span> ${user.emergency_contact || 'Chưa có'}</div>
                            <div><span class="font-semibold">Tên người liên hệ:</span> ${user.emergency_name || 'Chưa có'}</div>
                        </div>

                        ${user.verification_note ? `
                            <div class="bg-red-50 border border-red-200 rounded p-3 mt-3">
                                <p class="text-sm font-semibold text-red-800">Lý do từ chối:</p>
                                <p class="text-sm text-red-700">${user.verification_note}</p>
                            </div>
                        ` : ''}
                    </div>
                `;

                // Show modal with action buttons
                const result = await Swal.fire({
                    title: `<div class="text-left">
                                <h2 class="text-2xl font-bold">${user.full_name}</h2>
                                <p class="text-sm text-gray-600">${user.email}</p>
                            </div>`,
                    html: documentsHtml + infoHtml,
                    width: 900,
                    showCancelButton: true,
                    showDenyButton: user.is_verified !== 'VERIFIED',
                    confirmButtonText: user.is_verified === 'PENDING' ? '✓ Phê duyệt' : 'Đóng',
                    denyButtonText: '✗ Từ chối',
                    cancelButtonText: 'Hủy',
                    confirmButtonColor: user.is_verified === 'PENDING' ? '#10b981' : '#2563eb',
                    denyButtonColor: '#dc2626',
                    customClass: {
                        popup: 'swal-wide'
                    }
                });

                if (result.isConfirmed && user.is_verified === 'PENDING') {
                    // Approve
                    await updateKYCStatus(userId, 'approve');
                } else if (result.isDenied) {
                    // Reject - ask for reason
                    const { value: rejectReason } = await Swal.fire({
                        title: 'Lý do từ chối',
                        input: 'textarea',
                        inputPlaceholder: 'Nhập lý do từ chối xác minh...',
                        inputAttributes: {
                            'aria-label': 'Nhập lý do từ chối'
                        },
                        showCancelButton: true,
                        confirmButtonText: 'Từ chối',
                        cancelButtonText: 'Hủy',
                        confirmButtonColor: '#dc2626',
                        inputValidator: (value) => {
                            if (!value) {
                                return 'Vui lòng nhập lý do từ chối!';
                            }
                        }
                    });

                    if (rejectReason) {
                        await updateKYCStatus(userId, 'reject', rejectReason);
                    }
                }

            } catch (error) {
                console.error('Error:', error);
                showError('Lỗi', 'Không thể tải thông tin người dùng');
            }
        }

        // Update KYC status (approve/reject)
        async function updateKYCStatus(userId, action, note = '') {
            try {
                const response = await fetch('/ITS/assets/php/admin/update_kyc_status.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({
                        user_id: userId,
                        action: action,
                        note: note
                    })
                });

                const data = await response.json();

                if (data.error) {
                    showError('Lỗi', data.error);
                    return;
                }

                Swal.fire({
                    icon: 'success',
                    title: 'Thành công',
                    text: data.message,
                    confirmButtonColor: '#2563eb'
                }).then(() => {
                    loadUsers();
                });

            } catch (error) {
                console.error('Error:', error);
                showError('Lỗi', 'Không thể cập nhật trạng thái');
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

    <style>
        .swal-wide {
            max-width: 90% !important;
        }
    </style>
</body>

</html>
