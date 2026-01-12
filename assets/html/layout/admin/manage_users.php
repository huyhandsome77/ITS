<!doctype html>
<html lang="vi" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý người dùng | Admin</title>

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
                        <h1 class="text-3xl font-bold" style="color: var(--primary-color);">QUẢN LÝ NGƯỜI DÙNG</h1>
                        
                    </div>
                    <button id="btnAddUser" class="btn-primary px-6 lg:px-7 py-3 rounded-lg font-bold text-sm lg:text-base shadow-lg text-white"
                        style="background: var(--sidebar-gradient);">
                        <svg class="w-5 h-5 inline-block mr-2" fill="currentColor" viewBox="0 0 20 20">
                           <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"/>
                        </svg>
                        Thêm người dùng
                    </button>
                </div>

                <!-- Statistics Cards -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                    <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl shadow-lg p-6 text-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-blue-100 text-sm">Tổng người dùng</p>
                                <h3 class="text-3xl font-bold mt-1">1,247</h3>
                            </div>
                            <div class="bg-white bg-opacity-20 p-3 rounded-lg">
                                <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-2xl shadow-lg p-6 text-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-green-100 text-sm">Đang hoạt động</p>
                                <h3 class="text-3xl font-bold mt-1">1,189</h3>
                            </div>
                            <div class="bg-white bg-opacity-20 p-3 rounded-lg">
                                <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gradient-to-br from-red-500 to-red-600 rounded-2xl shadow-lg p-6 text-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-red-100 text-sm">Bị khóa</p>
                                <h3 class="text-3xl font-bold mt-1">58</h3>
                            </div>
                            <div class="bg-white bg-opacity-20 p-3 rounded-lg">
                                <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl shadow-lg p-6 text-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-purple-100 text-sm">Quản lý trạm</p>
                                <h3 class="text-3xl font-bold mt-1">24</h3>
                            </div>
                            <div class="bg-white bg-opacity-20 p-3 rounded-lg">
                                <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Filter Section -->
                <section class="bg-white rounded-2xl shadow-sm border p-5 mb-6">
                    <h2 class="text-lg font-semibold mb-4">Bộ lọc</h2>
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <select id="filterRole" class="border rounded-lg px-4 py-2">
                            <option value="">Tất cả vai trò</option>
                            <option value="USER">Người dùng</option>
                            <option value="MANAGEMENT">Quản lý trạm</option>
                            <option value="ADMIN">Admin</option>
                        </select>

                        <select id="filterStatus" class="border rounded-lg px-4 py-2">
                            <option value="">Tất cả trạng thái</option>
                            <option value="ACTIVE">Hoạt động</option>
                            <option value="BLOCKED">Bị khóa</option>
                        </select>

                        <input type="text" id="searchUser" placeholder="Tìm theo tên, email, SĐT..." class="border rounded-lg px-4 py-2">

                        <button class="px-6 py-2 rounded-lg font-semibold text-white" style="background: var(--primary-color);">
                            <svg class="w-5 h-5 inline-block mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"/>
                            </svg>
                            Tìm kiếm
                        </button>
                    </div>
                </section>

                <!-- User List -->
                <section class="bg-white rounded-2xl shadow-sm border p-5">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-lg font-semibold">Danh sách người dùng</h2>
                        <span class="text-gray-600">Tổng số: <strong id="totalUsers">1,247</strong> người</span>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-50 border-b">
                                <tr>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">ID</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Họ tên</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Email</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Số điện thoại</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Vai trò</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Trạng thái</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Ngày tạo</th>
                                    <th class="px-4 py-3 text-center text-sm font-semibold text-gray-700">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody id="userTableBody" class="divide-y">
                                <!-- Sample Data -->
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3 text-sm">#001</td>
                                    <td class="px-4 py-3 text-sm">
                                        <div class="flex items-center space-x-3">
                                            <div class="w-10 h-10 bg-blue-500 text-white rounded-full flex items-center justify-center font-semibold">NA</div>
                                            <span class="font-semibold">Nguyễn Văn A</span>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 text-sm">nguyenvana@email.com</td>
                                    <td class="px-4 py-3 text-sm">0901234567</td>
                                    <td class="px-4 py-3">
                                        <span class="px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-700">
                                            Người dùng
                                        </span>
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">
                                            Hoạt động
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-sm">05/01/2026</td>
                                    <td class="px-4 py-3 text-center">
                                        <button class="text-blue-600 hover:text-blue-800 mx-1" title="Xem chi tiết" onclick="viewUser(1)">
                                            <svg class="w-5 h-5 inline-block" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/>
                                                <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/>
                                            </svg>
                                        </button>
                                        <button class="text-yellow-600 hover:text-yellow-800 mx-1" title="Chỉnh sửa" onclick="editUser(1)">
                                            <svg class="w-5 h-5 inline-block" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"/>
                                            </svg>
                                        </button>
                                        <button class="text-red-600 hover:text-red-800 mx-1" title="Khóa tài khoản" onclick="blockUser(1)">
                                            <svg class="w-5 h-5 inline-block" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/>
                                            </svg>
                                        </button>
                                    </td>
                                </tr>

                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3 text-sm">#002</td>
                                    <td class="px-4 py-3 text-sm">
                                        <div class="flex items-center space-x-3">
                                            <div class="w-10 h-10 bg-purple-500 text-white rounded-full flex items-center justify-center font-semibold">TB</div>
                                            <span class="font-semibold">Trần Thị B</span>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 text-sm">tranthib@email.com</td>
                                    <td class="px-4 py-3 text-sm">0912345678</td>
                                    <td class="px-4 py-3">
                                        <span class="px-3 py-1 rounded-full text-xs font-semibold bg-purple-100 text-purple-700">
                                            Quản lý trạm
                                        </span>
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">
                                            Hoạt động
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-sm">03/01/2026</td>
                                    <td class="px-4 py-3 text-center">
                                        <button class="text-blue-600 hover:text-blue-800 mx-1" title="Xem chi tiết" onclick="viewUser(2)">
                                            <svg class="w-5 h-5 inline-block" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/>
                                                <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/>
                                            </svg>
                                        </button>
                                        <button class="text-yellow-600 hover:text-yellow-800 mx-1" title="Chỉnh sửa" onclick="editUser(2)">
                                            <svg class="w-5 h-5 inline-block" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"/>
                                            </svg>
                                        </button>
                                        <button class="text-red-600 hover:text-red-800 mx-1" title="Khóa tài khoản" onclick="blockUser(2)">
                                            <svg class="w-5 h-5 inline-block" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/>
                                            </svg>
                                        </button>
                                    </td>
                                </tr>

                                <tr class="hover:bg-gray-50 bg-red-50">
                                    <td class="px-4 py-3 text-sm">#003</td>
                                    <td class="px-4 py-3 text-sm">
                                        <div class="flex items-center space-x-3">
                                            <div class="w-10 h-10 bg-gray-400 text-white rounded-full flex items-center justify-center font-semibold">LC</div>
                                            <span class="font-semibold">Lê Văn C</span>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 text-sm">levanc@email.com</td>
                                    <td class="px-4 py-3 text-sm">0923456789</td>
                                    <td class="px-4 py-3">
                                        <span class="px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-700">
                                            Người dùng
                                        </span>
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700">
                                            Bị khóa
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-sm">28/12/2025</td>
                                    <td class="px-4 py-3 text-center">
                                        <button class="text-blue-600 hover:text-blue-800 mx-1" title="Xem chi tiết" onclick="viewUser(3)">
                                            <svg class="w-5 h-5 inline-block" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/>
                                                <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/>
                                            </svg>
                                        </button>
                                        <button class="text-yellow-600 hover:text-yellow-800 mx-1" title="Chỉnh sửa" onclick="editUser(3)">
                                            <svg class="w-5 h-5 inline-block" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"/>
                                            </svg>
                                        </button>
                                        <button class="text-green-600 hover:text-green-800 mx-1" title="Mở khóa" onclick="unblockUser(3)">
                                            <svg class="w-5 h-5 inline-block" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M10 2a5 5 0 00-5 5v2a2 2 0 00-2 2v5a2 2 0 002 2h10a2 2 0 002-2v-5a2 2 0 00-2-2H7V7a3 3 0 015.905-.75 1 1 0 001.937-.5A5.002 5.002 0 0010 2z"/>
                                            </svg>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="flex justify-between items-center mt-4">
                        <span class="text-sm text-gray-600">Hiển thị 1-3 của 1,247 người</span>
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

    <!-- Modal: Add/Edit User -->
    <div id="userModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
            <div class="p-6 border-b flex justify-between items-center">
                <h2 class="text-2xl font-bold " style="color: var(--primary-color);">Thêm người dùng mới</h2>
                <button id="closeModal" class="text-gray-500 hover:text-gray-700">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                    </svg>
                </button>
            </div>
            <form id="userForm" class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold mb-2">Họ và tên *</label>
                        <input type="text" placeholder="Nguyễn Văn A" class="w-full border rounded-lg px-4 py-2" required>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold mb-2">Email *</label>
                        <input type="email" placeholder="user@email.com" class="w-full border rounded-lg px-4 py-2" required>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold mb-2">Số điện thoại *</label>
                        <input type="tel" placeholder="0901234567" class="w-full border rounded-lg px-4 py-2" required>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold mb-2">Mật khẩu *</label>
                        <input type="password" placeholder="••••••••" class="w-full border rounded-lg px-4 py-2" required>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold mb-2">Ngày sinh</label>
                        <input type="date" class="w-full border rounded-lg px-4 py-2">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold mb-2">Vai trò *</label>
                        <select class="w-full border rounded-lg px-4 py-2" required>
                            <option value="USER" selected>Người dùng</option>
                            <option value="MANAGEMENT">Quản lý trạm</option>
                            <option value="ADMIN">Admin</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold mb-2">Trạng thái *</label>
                        <select class="w-full border rounded-lg px-4 py-2" required>
                            <option value="ACTIVE" selected>Hoạt động</option>
                            <option value="BLOCKED">Bị khóa</option>
                        </select>
                    </div>
                </div>
                <div class="flex justify-end space-x-3 mt-6">
                    <button type="button" id="cancelBtn" class="px-6 py-2 border rounded-lg hover:bg-gray-50">Hủy</button>
                    <button type="submit"  class="btn-primary px-6 py-2 rounded-lg font-bold text-sm lg:text-base shadow-lg text-white" style="background: var(--sidebar-gradient);">Lưu</button>
                </div>
            </form>
        </div>
    </div>

    <script src="../../../js/main.js"></script>
    <script>
        // Modal handling
        const modal = document.getElementById('userModal');
        const btnAddUser = document.getElementById('btnAddUser');
        const closeModal = document.getElementById('closeModal');
        const cancelBtn = document.getElementById('cancelBtn');

        btnAddUser.addEventListener('click', () => {
            modal.classList.remove('hidden');
        });

        closeModal.addEventListener('click', () => {
            modal.classList.add('hidden');
        });

        cancelBtn.addEventListener('click', () => {
            modal.classList.add('hidden');
        });

        modal.addEventListener('click', (e) => {
            if (e.target === modal) {
                modal.classList.add('hidden');
            }
        });

        // Form submit
        document.getElementById('userForm').addEventListener('submit', (e) => {
            e.preventDefault();
            alert('Chức năng sẽ được triển khai ở backend!');
            modal.classList.add('hidden');
        });

        // Action functions
        function viewUser(id) {
            alert('Xem chi tiết người dùng #' + id);
        }

        function editUser(id) {
            modal.classList.remove('hidden');
            alert('Chỉnh sửa người dùng #' + id);
        }

        function blockUser(id) {
            if (confirm('Bạn có chắc muốn khóa tài khoản này?')) {
                alert('Chức năng khóa tài khoản sẽ được triển khai ở backend!');
            }
        }

        function unblockUser(id) {
            if (confirm('Bạn có chắc muốn mở khóa tài khoản này?')) {
                alert('Chức năng mở khóa tài khoản sẽ được triển khai ở backend!');
            }
        }
    </script>
</body>

</html>
