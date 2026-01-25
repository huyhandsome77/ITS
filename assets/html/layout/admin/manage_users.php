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
                    <button id="btnAddUser"
                        class="btn-primary px-6 lg:px-7 py-3 rounded-lg font-bold text-sm lg:text-base shadow-lg text-white"
                        style="background: var(--sidebar-gradient);">
                        <svg class="w-5 h-5 inline-block mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"
                                clip-rule="evenodd" />
                        </svg>
                        Thêm người dùng
                    </button>
                </div>
                <?php include '../../../php/admin/xuly_user.php'; ?>
                <!-- Statistics Cards -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                    <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl shadow-lg p-6 text-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-blue-100 text-sm">Tổng người dùng</p>
                                <h3 class="text-3xl font-bold mt-1">
                                    <?= number_format($totalUsers) ?>
                                </h3>
                            </div>
                            <div class="bg-white bg-opacity-20 p-3 rounded-lg">
                                <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-2xl shadow-lg p-6 text-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-green-100 text-sm">Đang hoạt động</p>
                                <h3 class="text-3xl font-bold mt-1">
                                    <?= number_format($activeUsers) ?>
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
                                <p class="text-red-100 text-sm">Bị khóa</p>
                                <h3 class="text-3xl font-bold mt-1">
                                    <?= number_format($blockedUsers) ?>
                                </h3>
                            </div>
                            <div class="bg-white bg-opacity-20 p-3 rounded-lg">
                                <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl shadow-lg p-6 text-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-purple-100 text-sm">Quản lý trạm</p>
                                <h3 class="text-3xl font-bold mt-1">
                                    <?= number_format($managementUsers) ?>
                                </h3>
                            </div>
                            <div class="bg-white bg-opacity-20 p-3 rounded-lg">
                                <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Filter Section -->
                <form method="GET">
                    <section class="bg-white rounded-2xl shadow-sm border p-5 mb-6">
                        <h2 class="text-lg font-semibold mb-4">Bộ lọc</h2>

                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">

                            <select name="role" class="border rounded-lg px-4 py-2">
                                <option value="">Tất cả vai trò</option>
                                <option value="USER" <?= ($_GET['role'] ?? '') == 'USER' ? 'selected' : '' ?>>Người dùng
                                </option>
                                <option value="STATION"
                                    <?= ($_GET['role'] ?? '') == 'STATION' ? 'selected' : '' ?>>Quản lý trạm</option>
                                <option value="DISPATCHER"
                                    <?= ($_GET['role'] ?? '') == 'DISPATCHER' ? 'selected' : '' ?>>Điều phối viên</option>
                                <option value="ADMIN" <?= ($_GET['role'] ?? '') == 'ADMIN' ? 'selected' : '' ?>>Admin
                                </option>
                            </select>

                            <select name="status" class="border rounded-lg px-4 py-2">
                                <option value="">Tất cả trạng thái</option>
                                <option value="ACTIVE" <?= ($_GET['status'] ?? '') == 'ACTIVE' ? 'selected' : '' ?>>Hoạt
                                    động</option>
                                <option value="BLOCKED" <?= ($_GET['status'] ?? '') == 'BLOCKED' ? 'selected' : '' ?>>Bị
                                    khóa</option>
                            </select>

                            <input type="text" name="keyword" value="<?= htmlspecialchars($_GET['keyword'] ?? '') ?>"
                                placeholder="Tìm theo tên, email, SĐT..." class="border rounded-lg px-4 py-2">

                            <button type="submit" class="px-6 py-2 rounded-lg font-semibold text-white"
                                style="background: var(--primary-color);">
                                🔍 Tìm kiếm
                            </button>

                        </div>
                    </section>
                </form>


                <!-- User List -->
                <section class="bg-white rounded-2xl shadow-sm border p-5">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-lg font-semibold">Danh sách người dùng</h2>
                        <span class="text-gray-600">Tổng số: <strong id="totalUsers">
                                <?= number_format($totalUsers) ?>
                            </strong> người</span>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-50 border-b">
                                <tr>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">ID</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Họ tên</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Email</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Số điện
                                        thoại
                                    </th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Vai trò</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Trạng thái
                                    </th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Ngày tạo
                                    </th>
                                    <th class="px-4 py-3 text-center text-sm font-semibold text-gray-700">Thao tác
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="userTableBody" class="divide-y">
                                <?php foreach ($users as $user): 
                                    [$roleText, $roleClass] = roleLabel($user['role']);
                                    [$statusText, $statusClass] = statusLabel($user['status']);
                                ?>
                                <tr class="hover:bg-gray-50 <?= $user['status'] === 'BLOCKED' ? 'bg-red-50' : '' ?>">
                                    <td class="px-4 py-3 text-sm">#<?= $user['user_id'] ?></td>

                                    <td class="px-4 py-3 text-sm">
                                        <div class="flex items-center space-x-3">
                                            <div class="w-10 h-10 rounded-full flex items-center justify-center font-semibold overflow-hidden
                                                <?= empty($user['avatar']) ? 'bg-blue-500 text-white' : '' ?>">

                                                <?php if (!empty($user['avatar'])): ?>
                                                <img src="/ITS/assets/img/avatars/<?= htmlspecialchars($user['avatar']) ?>"
                                                    alt="Avatar" class="w-full h-full object-cover">
                                                <?php else: ?>
                                                <?= getInitials($user['full_name']) ?>
                                                <?php endif; ?>

                                            </div>
                                            <span
                                                class="font-semibold"><?= htmlspecialchars($user['full_name']) ?></span>
                                        </div>
                                    </td>

                                    <td class="px-4 py-3 text-sm"><?= htmlspecialchars($user['email']) ?></td>
                                    <td class="px-4 py-3 text-sm"><?= $user['phone'] ?? '—' ?></td>

                                    <td class="px-4 py-3">
                                        <span class="px-3 py-1 rounded-full text-xs font-semibold <?= $roleClass ?>">
                                            <?= $roleText ?>
                                        </span>
                                    </td>

                                    <td class="px-4 py-3">
                                        <span class="px-3 py-1 rounded-full text-xs font-semibold <?= $statusClass ?>">
                                            <?= $statusText ?>
                                        </span>
                                    </td>

                                    <td class="px-4 py-3 text-sm">
                                        <?= date('d/m/Y', strtotime($user['created_at'])) ?>
                                    </td>

                                    <td class="px-4 py-3 text-center">
                                        <button class="text-blue-600 hover:text-blue-800 mx-1"
                                            onclick="viewUser(<?= $user['user_id'] ?>)">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </button>

                                        <button class="text-yellow-600 hover:text-yellow-800 mx-1"
                                            onclick="editUser(<?= $user['user_id'] ?>)">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </button>

                                        <?php if ($user['status'] === 'ACTIVE'): ?>
                                        <button class="text-red-600 hover:text-red-800 mx-1"
                                            onclick="blockUser(<?= $user['user_id'] ?>)">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                            </svg>
                                        </button>
                                        <?php else: ?>
                                        <button class="text-green-600 hover:text-green-800 mx-1"
                                            onclick="unblockUser(<?= $user['user_id'] ?>)">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M8 11V7a4 4 0 118 0m-4 8v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z" />
                                            </svg>
                                        </button>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>

                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="flex justify-between items-center mt-4">
                        <span class="text-sm text-gray-600">
                            Hiển thị <?= $from ?>–<?= $to ?> của <?= number_format($totalUsers) ?> người
                        </span>
                        <div class="flex space-x-2">

                            <!-- Nút Trước -->
                            <a href="?page=<?= max(1, $page - 1) ?>"
                                class="px-4 py-2 border rounded-lg <?= $page == 1 ? 'opacity-50 pointer-events-none' : 'hover:bg-gray-50' ?>">
                                Trước
                            </a>

                            <!-- Các trang -->
                            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                            <a href="?page=<?= $i ?>" class="px-4 py-2 border rounded-lg
                                <?= $i == $page ? 'text-white' : 'hover:bg-gray-50' ?>"
                                style="<?= $i == $page ? 'background: var(--primary-color);' : '' ?>">
                                <?= $i ?>
                            </a>
                            <?php endfor; ?>

                            <!-- Nút Sau -->
                            <a href="?page=<?= min($totalPages, $page + 1) ?>"
                                class="px-4 py-2 border rounded-lg <?= $page == $totalPages ? 'opacity-50 pointer-events-none' : 'hover:bg-gray-50' ?>">
                                Sau
                            </a>

                        </div>
                    </div>
                </section>

            </main>

            <?php include '../../../includes/footer.php'; ?>
        </div>
    </div>

    <!-- Modal: Add User -->
    <div id="userModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
            <div class="p-6 border-b flex justify-between items-center">
                <h2 class="text-2xl font-bold " style="color: var(--primary-color);">Thêm người dùng mới</h2>
                <button id="closeModal" class="text-gray-500 hover:text-gray-700">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                            clip-rule="evenodd" />
                    </svg>
                </button>
            </div>
            <form id="userForm" class="p-6" method="POST" action="/ITS/assets/php/admin/add_user.php">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold mb-2">Họ và tên *</label>
                        <input type="text" name="full_name" required class="w-full border rounded-lg px-4 py-2">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold mb-2">Email *</label>
                        <input type="email" name="email" required class="w-full border rounded-lg px-4 py-2">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold mb-2">Số điện thoại *</label>
                        <input type="tel" name="phone" required class="w-full border rounded-lg px-4 py-2">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold mb-2">Mật khẩu *</label>
                        <input type="password" name="password" required class="w-full border rounded-lg px-4 py-2">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold mb-2">Ngày sinh</label>
                        <input type="date" name="birthday" class="w-full border rounded-lg px-4 py-2">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold mb-2">Vai trò *</label>
                        <select name="role" id="add_role" required class="w-full border rounded-lg px-4 py-2">
                            <option value="USER">Người dùng</option>
                            <option value="STATION">Quản lý trạm</option>
                            <option value="DISPATCHER">Điều phối viên</option>
                            <option value="ADMIN">Admin</option>
                        </select>
                    </div>

                    <div id="add_station_div" class="hidden">
                        <label class="block text-sm font-semibold mb-2">Chọn trạm quản lý *</label>
                        <select name="managed_station_id" class="w-full border rounded-lg px-4 py-2">
                            <option value="">-- Chọn trạm --</option>
                            <?php foreach ($stations as $s): ?>
                                <option value="<?= $s['station_id'] ?>"><?= htmlspecialchars($s['station_name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold mb-2">Trạng thái *</label>
                        <select name="status" required class="w-full border rounded-lg px-4 py-2">
                            <option value="ACTIVE">Hoạt động</option>
                            <option value="BLOCKED">Bị khóa</option>
                        </select>
                    </div>
                </div>

                <div class="flex justify-end space-x-3 mt-6">
                    <button type="button" id="cancelBtn"
                        class="px-6 py-2 border rounded-lg hover:bg-gray-50">Hủy</button>
                    <button type="submit" class="btn-primary px-6 py-2 rounded-lg font-bold text-white">
                        Lưu
                    </button>
                </div>
            </form>

        </div>
    </div>

    <!-- Modal : Edit User -->
    <div id="editUserModal"
        class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">

        <div class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full">
            <div class="p-6 border-b flex justify-between items-center">
                <h2 class="text-2xl font-bold">Chỉnh sửa người dùng</h2>
                <button onclick="closeEditModal()">✖</button>
            </div>

            <form id="editUserForm" class="p-6">
                <input type="hidden" name="user_id" id="edit_user_id">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold mb-2">Họ tên</label>
                        <input type="text" name="full_name" id="edit_full_name"
                            class="w-full border rounded-lg px-4 py-2" required>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold mb-2">Email</label>
                        <input type="email" name="email" id="edit_email" class="w-full border rounded-lg px-4 py-2"
                            required>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold mb-2">Số điện thoại</label>
                        <input type="text" name="phone" id="edit_phone" class="w-full border rounded-lg px-4 py-2">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold mb-2">Ngày sinh</label>
                        <input type="date" name="birthday" id="edit_birthday"
                            class="w-full border rounded-lg px-4 py-2">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold mb-2">
                            Mật khẩu mới <span class="text-gray-500">(để trống nếu không đổi)</span>
                        </label>
                        <input type="password" name="password" class="w-full border rounded-lg px-4 py-2"
                            placeholder="••••••••">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold mb-2">Vai trò</label>
                        <select name="role" id="edit_role" class="w-full border rounded-lg px-4 py-2">
                            <option value="USER">Người dùng</option>
                            <option value="STATION">Quản lý trạm</option>
                            <option value="DISPATCHER">Điều phối viên</option>
                            <option value="ADMIN">Admin</option>
                        </select>
                    </div>

                    <div id="edit_station_div" class="hidden">
                        <label class="block text-sm font-semibold mb-2">Chọn trạm quản lý</label>
                        <select name="managed_station_id" id="edit_managed_station_id" class="w-full border rounded-lg px-4 py-2">
                            <option value="">-- Chọn trạm --</option>
                            <?php foreach ($stations as $s): ?>
                                <option value="<?= $s['station_id'] ?>"><?= htmlspecialchars($s['station_name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold mb-2">Trạng thái</label>
                        <select name="status" id="edit_status" class="w-full border rounded-lg px-4 py-2">
                            <option value="ACTIVE">Hoạt động</option>
                            <option value="BLOCKED">Bị khóa</option>
                        </select>
                    </div>

                </div>

                <div class="flex justify-end mt-6">
                    <button type="submit" class="px-6 py-2 rounded-lg text-white"
                        style="background: var(--primary-color);">
                        Lưu thay đổi
                    </button>
                </div>
            </form>

        </div>
    </div>
    <!-- Modal : View User -->
    <div id="viewUserModal"
        class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4 backdrop-blur-sm">

        <div class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full transform transition-all">
            <!-- Header -->
            <div class="p-6 rounded-t-2xl"
                style="background: linear-gradient(to right, rgb(0, 102, 102), rgb(0, 120, 120));">
                <div class="flex justify-between items-center">
                    <h2 class="text-2xl font-bold text-white flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        Thông tin người dùng
                    </h2>
                    <button onclick="closeViewModal()"
                        class="text-white hover:bg-white hover:bg-opacity-20 rounded-full p-2 transition-all">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>

            <div class="p-6">
                <!-- Avatar & Basic Info -->
                <div class="flex items-center space-x-4 mb-6 pb-6 border-b">
                    <div id="viewAvatar"
                        class="w-20 h-20 rounded-full bg-gradient-to-br from-blue-500 to-blue-600 text-white flex items-center justify-center text-2xl font-bold shadow-lg ring-4 ring-blue-100">
                    </div>
                    <div class="flex-1">
                        <h3 id="viewFullName" class="text-2xl font-bold text-gray-800 mb-1"></h3>
                        <p id="viewEmail" class="text-gray-600 flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            <span id="viewEmailText"></span>
                        </p>
                    </div>
                </div>

                <!-- Info Cards Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- User ID -->
                    <div class="bg-gray-50 rounded-xl p-4 hover:shadow-md transition-shadow">
                        <div class="flex items-center gap-3">
                            <div class="bg-blue-100 rounded-lg p-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 font-medium">ID Người dùng</p>
                                <p id="viewId" class="text-sm font-semibold text-gray-800"></p>
                            </div>
                        </div>
                    </div>

                    <!-- Phone -->
                    <div class="bg-gray-50 rounded-xl p-4 hover:shadow-md transition-shadow">
                        <div class="flex items-center gap-3">
                            <div class="bg-green-100 rounded-lg p-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 font-medium">Số điện thoại</p>
                                <p id="viewPhone" class="text-sm font-semibold text-gray-800"></p>
                            </div>
                        </div>
                    </div>

                    <!-- Role -->
                    <div class="bg-gray-50 rounded-xl p-4 hover:shadow-md transition-shadow">
                        <div class="flex items-center gap-3">
                            <div class="bg-purple-100 rounded-lg p-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-purple-600" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 font-medium">Vai trò</p>
                                <p id="viewRole" class="text-sm font-semibold text-gray-800"></p>
                            </div>
                        </div>
                    </div>

                    <!-- Managed Station -->
                    <div id="viewManagedStationDiv" class="bg-gray-50 rounded-xl p-4 hover:shadow-md transition-shadow hidden">
                        <div class="flex items-center gap-3">
                            <div class="bg-indigo-100 rounded-lg p-2">
                                <span class="text-xl">🏢</span>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 font-medium">Trạm quản lý</p>
                                <p id="viewManagedStation" class="text-sm font-semibold text-gray-800"></p>
                            </div>
                        </div>
                    </div>

                    <!-- Status -->
                    <div class="bg-gray-50 rounded-xl p-4 hover:shadow-md transition-shadow">
                        <div class="flex items-center gap-3">
                            <div class="bg-yellow-100 rounded-lg p-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-600" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 font-medium">Trạng thái</p>
                                <p id="viewStatus" class="text-sm font-semibold"></p>
                            </div>
                        </div>
                    </div>

                    <!-- Birthday -->
                    <div class="bg-gray-50 rounded-xl p-4 hover:shadow-md transition-shadow">
                        <div class="flex items-center gap-3">
                            <div class="bg-pink-100 rounded-lg p-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-pink-600" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 font-medium">Ngày sinh</p>
                                <p id="viewBirthday" class="text-sm font-semibold text-gray-800"></p>
                            </div>
                        </div>
                    </div>

                    <!-- Created At -->
                    <div class="bg-gray-50 rounded-xl p-4 hover:shadow-md transition-shadow">
                        <div class="flex items-center gap-3">
                            <div class="bg-indigo-100 rounded-lg p-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-600" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 font-medium">Ngày tạo</p>
                                <p id="viewCreatedAt" class="text-sm font-semibold text-gray-800"></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="p-6 bg-gray-50 rounded-b-2xl flex justify-end gap-3">
                <button onclick="closeViewModal()"
                    class="px-6 py-2.5 rounded-lg text-white font-medium transition-all shadow-md hover:shadow-lg"
                    style="background: linear-gradient(to right, rgb(0, 102, 102), rgb(0, 120, 120));"
                    onmouseover="this.style.background='linear-gradient(to right, rgb(0, 90, 90), rgb(0, 110, 110))'"
                    onmouseout="this.style.background='linear-gradient(to right, rgb(0, 102, 102), rgb(0, 120, 120))'">
                    Đóng
                </button>
            </div>
        </div>
    </div>

    <script src="../../../js/main.js"></script>
    <script>
    // Modal handling
    const modal = document.getElementById('userModal');
    const btnAddUser = document.getElementById('btnAddUser');
    const closeModal = document.getElementById('closeModal');
    const cancelBtn = document.getElementById('cancelBtn');

    // Toggle Station Dropdown Logic
    const addRole = document.getElementById('add_role');
    const addStationDiv = document.getElementById('add_station_div');
    const editRole = document.getElementById('edit_role');
    const editStationDiv = document.getElementById('edit_station_div');

    function toggleStationSelect(select, div) {
        if (select.value === 'STATION') {
            div.classList.remove('hidden');
        } else {
            div.classList.add('hidden');
        }
    }

    addRole.addEventListener('change', () => toggleStationSelect(addRole, addStationDiv));
    editRole.addEventListener('change', () => toggleStationSelect(editRole, editStationDiv));

    btnAddUser.addEventListener('click', () => {
        modal.classList.remove('hidden');
        toggleStationSelect(addRole, addStationDiv); // Reset state
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

    // Load data form edit
    function editUser(userId) {
        fetch('/ITS/assets/php/admin/get_user.php?id=' + userId)
            .then(res => res.json())
            .then(data => {
                document.getElementById('edit_user_id').value = data.user_id;
                document.getElementById('edit_full_name').value = data.full_name;
                document.getElementById('edit_email').value = data.email;
                document.getElementById('edit_phone').value = data.phone ?? '';
                document.getElementById('edit_role').value = data.role;
                document.getElementById('edit_status').value = data.status;
                document.getElementById('edit_birthday').value = data.birthday ?? '';
                
                // Managed Station
                if(data.managed_station_id) {
                    document.getElementById('edit_managed_station_id').value = data.managed_station_id;
                } else {
                    document.getElementById('edit_managed_station_id').value = "";
                }

                // Trigger toggle
                toggleStationSelect(document.getElementById('edit_role'), editStationDiv);

                document.getElementById('editUserModal').classList.remove('hidden');
            });
    }

    function closeEditModal() {
        document.getElementById('editUserModal').classList.add('hidden');
    }

    function blockUser(userId) {
        Swal.fire({
            title: 'Xác nhận khóa tài khoản',
            text: 'Người dùng sẽ không thể đăng nhập!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Khóa',
            cancelButtonText: 'Hủy'
        }).then((result) => {
            if (result.isConfirmed) {
                updateUserStatus(userId, 'BLOCKED');
            }
        });
    }

    function unblockUser(userId) {
        Swal.fire({
            title: 'Mở khóa tài khoản',
            text: 'Người dùng sẽ có thể đăng nhập lại',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Mở khóa',
            cancelButtonText: 'Hủy'
        }).then((result) => {
            if (result.isConfirmed) {
                updateUserStatus(userId, 'ACTIVE');
            }
        });
    }

    function updateUserStatus(userId, status) {
        fetch('/ITS/assets/php/admin/update_user_status.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    user_id: userId,
                    status: status
                })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Thành công',
                        text: data.message,
                        timer: 1200,
                        showConfirmButton: false
                    }).then(() => location.reload());
                } else {
                    Swal.fire('Lỗi', data.message, 'error');
                }
            });
    }


    function viewUser(userId) {
        fetch('/ITS/assets/php/admin/get_user_detail.php?id=' + userId)
            .then(res => res.json())
            .then(user => {
                // Avatar chữ cái
                const initials = user.full_name.split(' ').map(w => w[0]).join('').toUpperCase();

                document.getElementById('viewAvatar').innerText = initials;
                document.getElementById('viewFullName').innerText = user.full_name;
                document.getElementById('viewEmail').innerText = user.email;

                document.getElementById('viewId').innerText = user.user_id;
                document.getElementById('viewPhone').innerText = user.phone ?? '—';
                document.getElementById('viewRole').innerText = user.role;
                document.getElementById('viewStatus').innerText = user.status;
                document.getElementById('viewBirthday').innerText = user.birthday ?? '—';
                document.getElementById('viewCreatedAt').innerText =
                    new Date(user.created_at).toLocaleDateString('vi-VN');

                // Managed Station
                const viewStationDiv = document.getElementById('viewManagedStationDiv');
                if (user.managed_station_name) {
                    document.getElementById('viewManagedStation').innerText = user.managed_station_name;
                    viewStationDiv.classList.remove('hidden');
                } else {
                    viewStationDiv.classList.add('hidden');
                }

                document.getElementById('viewUserModal').classList.remove('hidden');
            });
    }

    function closeViewModal() {
        document.getElementById('viewUserModal').classList.add('hidden');
    }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <?php
    if (isset($_SESSION['swal'])):
            $swal = $_SESSION['swal'];
            unset($_SESSION['swal']);
        ?>
    <script>
    Swal.fire({
        icon: '<?= $swal['type'] ?>',
        title: '<?= $swal['title'] ?>',
        text: '<?= $swal['text'] ?>',
        confirmButtonText: 'OK'
    });
    </script>
    <?php endif; ?>
    <script>
    document.getElementById('userForm').addEventListener('submit', function(e) {
        e.preventDefault();
        Swal.fire({
            title: 'Xác nhận',
            text: 'Bạn có chắc muốn thêm người dùng này?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Lưu',
            cancelButtonText: 'Hủy'
        }).then((result) => {
            if (result.isConfirmed) {
                e.target.submit();
            }
        });
    });
    </script>
    <script>
    document.getElementById('editUserForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Form này dùng FormData, không phải e.target.submit() trực tiếp vì code cũ dùng fetch?
        // Ah, code cũ dùng fetch. Check lại code cũ. 
        // Oh wait, code cũ:
        // document.getElementById('editUserForm').addEventListener('submit', function(e) {
        // e.preventDefault();
        // fetch('/ITS/assets/php/admin/update_user.php', { method: 'POST', body: new FormData(this)
        
        // I need to make sure I don't break the fetch logic if I replaced everything.
        // My replacement above includes "function editUser" ... "function closeViewModal".
        // BUT I replaced up to line 800 which was the start of the `editUserForm` listener.
        // So I effectively REMOVED the listener body in my replacement string??
        // Let me check the TargetContent.
        
        // Wait, the ReplacementContent ends with fetch logic? No, it ends with `closeViewModal`. 
        // The original code had `editUserForm` listener AFTER `closeViewModal`.
        // My replacement replaces `btnAddUser.addEventListener` ... `closeViewModal`.
        // So I am REPLACING the specific block handling open/close/edit logic, BUT adding the toggle logic inside.
        // The listener for `editUserForm` was at lines 795+ which is likely NOT included in my TargetContent range if I target correctly.
        
        // Let's verify existing block range.
        
    });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <?php
    if (isset($_SESSION['swal'])):
            $swal = $_SESSION['swal'];
            unset($_SESSION['swal']);
        ?>
    <script>
    Swal.fire({
        icon: '<?= $swal['type'] ?>',
        title: '<?= $swal['title'] ?>',
        text: '<?= $swal['text'] ?>',
        confirmButtonText: 'OK'
    });
    </script>
    <?php endif; ?>
    <script>
    document.getElementById('userForm').addEventListener('submit', function(e) {
        e.preventDefault();
        Swal.fire({
            title: 'Xác nhận',
            text: 'Bạn có chắc muốn thêm người dùng này?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Lưu',
            cancelButtonText: 'Hủy'
        }).then((result) => {
            if (result.isConfirmed) {
                e.target.submit();
            }
        });
    });
    </script>
    <script>
    document.getElementById('editUserForm').addEventListener('submit', function(e) {
        e.preventDefault();

        fetch('/ITS/assets/php/admin/update_user.php', {
            method: 'POST',
            body: new FormData(this)
        }).then(() => {
            Swal.fire({
                icon: 'success',
                title: 'Đã lưu',
                text: 'Thông tin đã được cập nhật'
            }).then(() => location.reload());
        });
    });
    </script>
</body>

</html>