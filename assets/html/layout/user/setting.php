<!doctype html>
<html lang="vi" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cài đặt tài khoản | Thuexe.com</title>
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
                <div class="mb-6">
                    <h1 class="text-2xl font-bold text-slate-800">Cài đặt tài khoản</h1>
                    <p class="text-sm text-slate-500 mt-1">
                        Quản lý thông tin cá nhân và bảo mật tài khoản của bạn
                    </p>
                </div>

                <!-- Grid 2 Columns -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                    <!-- LEFT: Personal Information -->
                    <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
                        <div class="flex items-center justify-between mb-6">
                            <h2 class="text-lg font-semibold text-slate-800">
                                Thông tin cá nhân
                            </h2>
                            <span class="text-xs px-3 py-1 rounded-full bg-blue-50 text-blue-600 font-medium">
                                Hồ sơ
                            </span>
                        </div>

                        <!-- Avatar + Basic Info -->
                        <div class="flex items-center gap-5 mb-8">
                            <div class="relative">
                                <img id="avatarPreview" src="https://ui-avatars.com/api/?name=User&background=0D8ABC&color=fff"
                                    alt="Avatar" class="w-20 h-20 rounded-full shadow">
                                <label for="avatarInput" class="absolute bottom-0 right-0 bg-blue-600 text-white p-2 rounded-full cursor-pointer hover:bg-blue-700 transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                </label>
                                <input type="file" id="avatarInput" class="hidden" accept="image/*" onchange="uploadAvatar()">
                            </div>

                            <div>
                                <h3 id="displayName" class="text-lg font-semibold text-slate-800">
                                    Loading...
                                </h3>
                                <p id="displayRole" class="text-sm text-slate-500">
                                    Người dùng
                                </p>
                            </div>
                        </div>

                        <!-- Info Grid -->
                        <form id="updateInfoForm">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <div>
                                    <label class="text-sm text-slate-500">Họ và tên <span class="text-red-500">*</span></label>
                                    <input type="text" id="fullName" name="full_name" required
                                        class="mt-1 w-full px-4 py-2 border-2 border-slate-300 rounded-lg focus:outline-none focus:border-blue-500 transition">
                                </div>

                                <div>
                                    <label class="text-sm text-slate-500">Email (không thể thay đổi)</label>
                                    <input type="email" id="email" readonly
                                        class="mt-1 w-full px-4 py-2 border-2 border-slate-200 rounded-lg bg-slate-50 cursor-not-allowed">
                                </div>

                                <div>
                                    <label class="text-sm text-slate-500">Số điện thoại</label>
                                    <input type="tel" id="phone" name="phone"
                                        class="mt-1 w-full px-4 py-2 border-2 border-slate-300 rounded-lg focus:outline-none focus:border-blue-500 transition"
                                        placeholder="Nhập số điện thoại">
                                </div>

                                <div>
                                    <label class="text-sm text-slate-500">Ngày sinh</label>
                                    <input type="date" id="birthday" name="birthday"
                                        class="mt-1 w-full px-4 py-2 border-2 border-slate-300 rounded-lg focus:outline-none focus:border-blue-500 transition">
                                </div>

                                <div>
                                    <label class="text-sm text-slate-500">Ngày tham gia</label>
                                    <input type="text" id="createdAt" readonly
                                        class="mt-1 w-full px-4 py-2 border-2 border-slate-200 rounded-lg bg-slate-50 cursor-not-allowed">
                                </div>

                                <div>
                                    <label class="text-sm text-slate-500">Trạng thái tài khoản</label>
                                    <input type="text" id="status" readonly
                                        class="mt-1 w-full px-4 py-2 border-2 border-slate-200 rounded-lg bg-slate-50 cursor-not-allowed">
                                </div>
                            </div>

                            <!-- Action -->
                            <div class="mt-8 flex justify-center">
                                <button type="submit" class="px-6 py-2.5 rounded-lg text-white text-sm font-semibold shadow transition"
                                    style="background-color: var(--primary-color);"
                                    onmouseover="this.style.filter='brightness(0.95)'"
                                    onmouseout="this.style.filter='brightness(1)'">
                                    Cập nhật thông tin
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- RIGHT: Change Password -->
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
                        <h2 class="text-lg font-semibold text-slate-800 mb-6">
                            Bảo mật tài khoản
                        </h2>

                        <form id="changePasswordForm" class="space-y-5">
                            <div>
                                <label class="block text-sm font-medium text-slate-600 mb-1">
                                    Mật khẩu hiện tại <span class="text-red-500">*</span>
                                </label>
                                <input type="password" id="currentPassword" name="current_password" required
                                    class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm
                                  focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none"
                                    placeholder="Nhập mật khẩu hiện tại">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-slate-600 mb-1">
                                    Mật khẩu mới <span class="text-red-500">*</span>
                                </label>
                                <input type="password" id="newPassword" name="new_password" required minlength="6"
                                    class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm
                                  focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none"
                                    placeholder="Nhập mật khẩu mới (tối thiểu 6 ký tự)">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-slate-600 mb-1">
                                    Xác nhận mật khẩu mới <span class="text-red-500">*</span>
                                </label>
                                <input type="password" id="confirmPassword" name="confirm_password" required
                                    class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm
                                  focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none"
                                    placeholder="Nhập lại mật khẩu mới">
                            </div>

                            <button type="submit" class="w-full mt-2 px-6 py-2.5 rounded-lg bg-slate-800 text-white text-sm font-semibold
                           hover:bg-slate-900 transition">
                                Cập nhật mật khẩu
                            </button>
                        </form>
                    </div>

                </div>
            </main>


            <?php include '../../../includes/footer.php'; ?>
        </div>
    </div>
    <script src="../../../js/main.js"></script>
    <script>
        let currentUserData = null;

        // Load user info when page loads
        document.addEventListener('DOMContentLoaded', function() {
            loadUserInfo();
        });

        // Load user information
        async function loadUserInfo() {
            try {
                const response = await fetch('/ITS/assets/php/user/get_user_info.php');
                const data = await response.json();

                if (data.error) {
                    if (data.error === 'Vui lòng đăng nhập') {
                        window.location.href = '/ITS/assets/html/auth/login.php';
                    } else {
                        showError('Lỗi', data.error);
                    }
                    return;
                }

                currentUserData = data.user;
                displayUserInfo(data.user);

            } catch (error) {
                console.error('Error:', error);
                showError('Lỗi', 'Không thể tải thông tin người dùng');
            }
        }

        // Display user information
        function displayUserInfo(user) {
            // Avatar
            document.getElementById('avatarPreview').src = user.avatar_url;
            
            // Display name and role
            document.getElementById('displayName').textContent = user.full_name;
            document.getElementById('displayRole').textContent = user.role_text;

            // Form fields
            document.getElementById('fullName').value = user.full_name;
            document.getElementById('email').value = user.email;
            document.getElementById('phone').value = user.phone || '';
            document.getElementById('birthday').value = user.birthday || '';
            document.getElementById('createdAt').value = user.created_at_formatted;
            
            // Status
            const statusText = user.status === 'ACTIVE' ? 'Đang hoạt động' : 'Bị khóa';
            const statusClass = user.status === 'ACTIVE' ? 'text-green-600' : 'text-red-600';
            document.getElementById('status').value = statusText;
            document.getElementById('status').className = document.getElementById('status').className.replace(/text-\w+-\d+/, statusClass);
        }

        // Upload avatar
        async function uploadAvatar() {
            const fileInput = document.getElementById('avatarInput');
            const file = fileInput.files[0];

            if (!file) return;

            // Validate file type
            const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
            if (!allowedTypes.includes(file.type)) {
                showError('Lỗi', 'Chỉ chấp nhận file ảnh định dạng JPG, PNG, GIF');
                fileInput.value = '';
                return;
            }

            // Validate file size (5MB)
            const maxSize = 5 * 1024 * 1024;
            if (file.size > maxSize) {
                showError('Lỗi', 'Kích thước ảnh không được vượt quá 5MB');
                fileInput.value = '';
                return;
            }

            // Show loading
            Swal.fire({
                title: 'Đang tải ảnh lên...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            try {
                const formData = new FormData();
                formData.append('avatar', file);

                const response = await fetch('/ITS/assets/php/user/upload_avatar.php', {
                    method: 'POST',
                    body: formData
                });

                const data = await response.json();

                if (data.error) {
                    Swal.close();
                    showError('Lỗi', data.error);
                    fileInput.value = '';
                    return;
                }

                // Update avatar preview
                document.getElementById('avatarPreview').src = data.avatar_url + '?t=' + new Date().getTime();

                Swal.fire({
                    icon: 'success',
                    title: 'Thành công',
                    text: data.message,
                    confirmButtonColor: '#2563eb'
                });

                fileInput.value = '';

            } catch (error) {
                console.error('Error:', error);
                Swal.close();
                showError('Lỗi', 'Không thể tải ảnh lên. Vui lòng thử lại.');
                fileInput.value = '';
            }
        }

        // Update user info form
        document.getElementById('updateInfoForm').addEventListener('submit', async function(e) {
            e.preventDefault();

            const fullName = document.getElementById('fullName').value.trim();
            const phone = document.getElementById('phone').value.trim();
            const birthday = document.getElementById('birthday').value;

            if (!fullName) {
                showError('Lỗi', 'Họ tên không được để trống');
                return;
            }

            // Show loading
            Swal.fire({
                title: 'Đang cập nhật...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            try {
                const response = await fetch('/ITS/assets/php/user/update_user_info.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({
                        full_name: fullName,
                        phone: phone,
                        birthday: birthday
                    })
                });

                const data = await response.json();

                Swal.close();

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
                    loadUserInfo();
                });

            } catch (error) {
                console.error('Error:', error);
                Swal.close();
                showError('Lỗi', 'Không thể cập nhật thông tin. Vui lòng thử lại.');
            }
        });

        // Change password form
        document.getElementById('changePasswordForm').addEventListener('submit', async function(e) {
            e.preventDefault();

            const currentPassword = document.getElementById('currentPassword').value;
            const newPassword = document.getElementById('newPassword').value;
            const confirmPassword = document.getElementById('confirmPassword').value;

            if (!currentPassword || !newPassword || !confirmPassword) {
                showError('Lỗi', 'Vui lòng điền đầy đủ thông tin');
                return;
            }

            if (newPassword.length < 6) {
                showError('Lỗi', 'Mật khẩu mới phải có ít nhất 6 ký tự');
                return;
            }

            if (newPassword !== confirmPassword) {
                showError('Lỗi', 'Mật khẩu mới và xác nhận không khớp');
                return;
            }

            // Show loading
            Swal.fire({
                title: 'Đang cập nhật...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            try {
                const response = await fetch('/ITS/assets/php/user/change_password.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({
                        current_password: currentPassword,
                        new_password: newPassword,
                        confirm_password: confirmPassword
                    })
                });

                const data = await response.json();

                Swal.close();

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
                    // Reset form
                    document.getElementById('changePasswordForm').reset();
                });

            } catch (error) {
                console.error('Error:', error);
                Swal.close();
                showError('Lỗi', 'Không thể đổi mật khẩu. Vui lòng thử lại.');
            }
        });

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