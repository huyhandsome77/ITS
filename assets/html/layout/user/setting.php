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

                <!-- KYC Verification Section -->
                <div class="mt-6 bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h2 class="text-lg font-semibold text-slate-800">Xác minh tài khoản (KYC)</h2>
                            <p class="text-sm text-slate-500 mt-1">Bắt buộc để đặt xe</p>
                        </div>
                        <span id="verificationBadge" class="px-3 py-1 rounded-full text-xs font-semibold">
                            Chưa xác minh
                        </span>
                    </div>

                    <!-- Warning Alert -->
                    <div id="kycWarning" class="mb-6 p-4 bg-yellow-50 border-l-4 border-yellow-500 rounded-lg">
                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-yellow-600 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-yellow-800">Yêu cầu xác minh</h3>
                                <p class="text-sm text-yellow-700 mt-1">
                                    Bạn cần hoàn thành xác minh tài khoản để có thể đặt xe. Vui lòng cung cấp đầy đủ thông tin bên dưới.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Upload Documents Section -->
                    <div class="mb-6">
                        <h3 class="text-md font-semibold text-slate-800 mb-4">Tải lên giấy tờ</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            <!-- CCCD Front -->
                            <div class="border-2 border-dashed border-slate-300 rounded-lg p-4 hover:border-blue-500 transition">
                                <label class="block text-sm font-medium text-slate-700 mb-2">
                                    CCCD/CMND Mặt trước <span class="text-red-500">*</span>
                                </label>
                                <div id="idCardFrontPreview" class="mb-2 h-32 bg-slate-100 rounded flex items-center justify-center">
                                    <svg class="w-12 h-12 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <input type="file" id="idCardFrontInput" class="hidden" accept="image/*,application/pdf" onchange="uploadDocument('id_card_front')">
                                <button type="button" onclick="document.getElementById('idCardFrontInput').click()" 
                                    class="w-full px-3 py-2 bg-blue-50 text-blue-600 rounded-lg text-sm font-medium hover:bg-blue-100 transition">
                                    Chọn file
                                </button>
                            </div>

                            <!-- CCCD Back -->
                            <div class="border-2 border-dashed border-slate-300 rounded-lg p-4 hover:border-blue-500 transition">
                                <label class="block text-sm font-medium text-slate-700 mb-2">
                                    CCCD/CMND Mặt sau <span class="text-red-500">*</span>
                                </label>
                                <div id="idCardBackPreview" class="mb-2 h-32 bg-slate-100 rounded flex items-center justify-center">
                                    <svg class="w-12 h-12 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <input type="file" id="idCardBackInput" class="hidden" accept="image/*,application/pdf" onchange="uploadDocument('id_card_back')">
                                <button type="button" onclick="document.getElementById('idCardBackInput').click()" 
                                    class="w-full px-3 py-2 bg-blue-50 text-blue-600 rounded-lg text-sm font-medium hover:bg-blue-100 transition">
                                    Chọn file
                                </button>
                            </div>

                            <!-- Face Image -->
                            <div class="border-2 border-dashed border-slate-300 rounded-lg p-4 hover:border-blue-500 transition">
                                <label class="block text-sm font-medium text-slate-700 mb-2">
                                    Ảnh khuôn mặt <span class="text-red-500">*</span>
                                </label>
                                <div id="faceImagePreview" class="mb-2 h-32 bg-slate-100 rounded flex items-center justify-center">
                                    <svg class="w-12 h-12 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                </div>
                                <input type="file" id="faceImageInput" class="hidden" accept="image/*" onchange="uploadDocument('face_image')">
                                <button type="button" onclick="document.getElementById('faceImageInput').click()" 
                                    class="w-full px-3 py-2 bg-blue-50 text-blue-600 rounded-lg text-sm font-medium hover:bg-blue-100 transition">
                                    Chọn file
                                </button>
                            </div>

                            <!-- Driver License Front (Optional) -->
                            <div class="border-2 border-dashed border-slate-300 rounded-lg p-4 hover:border-blue-500 transition">
                                <label class="block text-sm font-medium text-slate-700 mb-2">
                                    Bằng lái xe (Mặt trước)
                                </label>
                                <div id="driverLicenseFrontPreview" class="mb-2 h-32 bg-slate-100 rounded flex items-center justify-center">
                                    <svg class="w-12 h-12 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                </div>
                                <input type="file" id="driverLicenseFrontInput" class="hidden" accept="image/*,application/pdf" onchange="uploadDocument('driver_license_front')">
                                <button type="button" onclick="document.getElementById('driverLicenseFrontInput').click()" 
                                    class="w-full px-3 py-2 bg-slate-50 text-slate-600 rounded-lg text-sm font-medium hover:bg-slate-100 transition">
                                    Chọn file
                                </button>
                            </div>

                            <!-- Driver License Back (Optional) -->
                            <div class="border-2 border-dashed border-slate-300 rounded-lg p-4 hover:border-blue-500 transition">
                                <label class="block text-sm font-medium text-slate-700 mb-2">
                                    Bằng lái xe (Mặt sau)
                                </label>
                                <div id="driverLicenseBackPreview" class="mb-2 h-32 bg-slate-100 rounded flex items-center justify-center">
                                    <svg class="w-12 h-12 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                </div>
                                <input type="file" id="driverLicenseBackInput" class="hidden" accept="image/*,application/pdf" onchange="uploadDocument('driver_license_back')">
                                <button type="button" onclick="document.getElementById('driverLicenseBackInput').click()" 
                                    class="w-full px-3 py-2 bg-slate-50 text-slate-600 rounded-lg text-sm font-medium hover:bg-slate-100 transition">
                                    Chọn file
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Verification Info Form -->
                    <form id="verificationInfoForm">
                        <h3 class="text-md font-semibold text-slate-800 mb-4">Thông tin xác minh</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-6">
                            <div>
                                <label class="block text-sm font-medium text-slate-600 mb-1">
                                    Số CCCD/CMND <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="idCardNumber" name="id_card_number" required maxlength="12"
                                    class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 outline-none"
                                    placeholder="Nhập số CCCD/CMND (9-12 chữ số)">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-slate-600 mb-1">
                                    Họ tên trên CCCD <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="idCardName" name="id_card_name" required
                                    class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 outline-none"
                                    placeholder="Họ và tên">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-slate-600 mb-1">
                                    Ngày cấp
                                </label>
                                <input type="date" id="idCardDate" name="id_card_date"
                                    class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-slate-600 mb-1">
                                    Nơi cấp
                                </label>
                                <select id="idCardPlace" name="id_card_place"
                                    class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                                    <option value="">Chọn nơi cấp</option>
                                    <option value="Cục Cảnh sát đăng ký quản lý cư trú và dữ liệu quốc gia về dân cư">Cục Cảnh sát đăng ký quản lý cư trú và dữ liệu quốc gia về dân cư</option>
                                    <option value="Cục Cảnh sát quản lý hành chính về trật tự xã hội">Cục Cảnh sát quản lý hành chính về trật tự xã hội</option>
                                    <option value="Bộ Công an">Bộ Công an</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-slate-600 mb-1">
                                    Số bằng lái xe
                                </label>
                                <input type="text" id="driverLicenseNumber" name="driver_license_number" maxlength="12"
                                    class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 outline-none"
                                    placeholder="Nhập số bằng lái (nếu có)">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-slate-600 mb-1">
                                    Địa chỉ thường trú <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="address" name="address" required
                                    class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 outline-none"
                                    placeholder="Số nhà, đường, phường/xã, quận/huyện, tỉnh/TP">
                            </div>
                        </div>

                        <h3 class="text-md font-semibold text-slate-800 mb-4">Thông tin ngân hàng</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-6">
                            <div>
                                <label class="block text-sm font-medium text-slate-600 mb-1">
                                    Số tài khoản <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="bankAccountNumber" name="bank_account_number" required maxlength="20"
                                    class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 outline-none"
                                    placeholder="Nhập số tài khoản ngân hàng">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-slate-600 mb-1">
                                    Tên chủ tài khoản <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="bankAccountName" name="bank_account_name" required
                                    class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 outline-none"
                                    placeholder="Tên chủ tài khoản">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-slate-600 mb-1">
                                    Tên ngân hàng <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="bankName" name="bank_name" required
                                    class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 outline-none"
                                    placeholder="VD: Vietcombank, Techcombank, VPBank...">
                            </div>
                        </div>

                        <h3 class="text-md font-semibold text-slate-800 mb-4">Liên hệ khẩn cấp</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-6">
                            <div>
                                <label class="block text-sm font-medium text-slate-600 mb-1">
                                    Số điện thoại khẩn cấp <span class="text-red-500">*</span>
                                </label>
                                <input type="tel" id="emergencyContact" name="emergency_contact" required
                                    class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 outline-none"
                                    placeholder="Số điện thoại người thân">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-slate-600 mb-1">
                                    Tên người liên hệ <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="emergencyName" name="emergency_name" required
                                    class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 outline-none"
                                    placeholder="Tên người thân">
                            </div>
                        </div>

                        <div class="flex justify-center">
                            <button type="submit" class="px-8 py-3 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition">
                                Gửi yêu cầu xác minh
                            </button>
                        </div>
                    </form>
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

            // KYC Verification Info
            displayVerificationStatus(user);
            displayVerificationDocuments(user);
            displayVerificationInfo(user);
        }

        // Display verification status
        function displayVerificationStatus(user) {
            const badge = document.getElementById('verificationBadge');
            const warning = document.getElementById('kycWarning');
            
            if (user.is_verified === 'VERIFIED') {
                badge.textContent = '✓ Đã xác minh';
                badge.className = 'px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700';
                warning.classList.add('hidden');
            } else if (user.is_verified === 'PENDING') {
                badge.textContent = '⏳ Đang chờ duyệt';
                badge.className = 'px-3 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-700';
                warning.innerHTML = `
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-yellow-600 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-yellow-800">Đang chờ xác minh</h3>
                            <p class="text-sm text-yellow-700 mt-1">
                                Hồ sơ của bạn đang được xem xét. Vui lòng chờ admin phê duyệt.
                            </p>
                        </div>
                    </div>
                `;
            } else if (user.is_verified === 'REJECTED') {
                badge.textContent = '✗ Từ chối';
                badge.className = 'px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700';
                warning.innerHTML = `
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-red-600 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-800">Hồ sơ không đạt yêu cầu</h3>
                            <p class="text-sm text-red-700 mt-1">
                                ${user.verification_note || 'Vui lòng kiểm tra lại thông tin và tải lại hồ sơ.'}
                            </p>
                        </div>
                    </div>
                `;
            } else {
                badge.textContent = 'Chưa xác minh';
                badge.className = 'px-3 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-700';
            }
        }

        // Display uploaded documents with previews
        function displayVerificationDocuments(user) {
            // ID Card Front
            if (user.id_card_front_url) {
                showDocumentPreview('idCardFrontPreview', user.id_card_front_url);
            }

            // ID Card Back
            if (user.id_card_back_url) {
                showDocumentPreview('idCardBackPreview', user.id_card_back_url);
            }

            // Face Image
            if (user.face_image_url) {
                showDocumentPreview('faceImagePreview', user.face_image_url);
            }

            // Driver License Front
            if (user.driver_license_front_url) {
                showDocumentPreview('driverLicenseFrontPreview', user.driver_license_front_url);
            }

            // Driver License Back
            if (user.driver_license_back_url) {
                showDocumentPreview('driverLicenseBackPreview', user.driver_license_back_url);
            }
        }

        // Helper function to show document preview
        function showDocumentPreview(previewId, documentUrl) {
            const preview = document.getElementById(previewId);
            if (documentUrl.toLowerCase().endsWith('.pdf')) {
                preview.innerHTML = `
                    <a href="${documentUrl}" target="_blank" class="flex flex-col items-center justify-center h-full text-blue-600 hover:text-blue-700">
                        <svg class="w-12 h-12" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd"/>
                        </svg>
                        <span class="text-xs mt-1">Xem PDF</span>
                    </a>
                `;
            } else {
                preview.innerHTML = `<img src="${documentUrl}" class="w-full h-full object-cover rounded" alt="Document">`;
            }
        }

        // Display verification info in form fields
        function displayVerificationInfo(user) {
            document.getElementById('idCardNumber').value = user.id_card_number || '';
            document.getElementById('idCardName').value = user.id_card_name || '';
            document.getElementById('idCardDate').value = user.id_card_date || '';
            document.getElementById('idCardPlace').value = user.id_card_place || '';
            document.getElementById('driverLicenseNumber').value = user.driver_license_number || '';
            document.getElementById('address').value = user.address || '';
            document.getElementById('bankAccountNumber').value = user.bank_account_number || '';
            document.getElementById('bankAccountName').value = user.bank_account_name || '';
            document.getElementById('bankName').value = user.bank_name || '';
            document.getElementById('emergencyContact').value = user.emergency_contact || '';
            document.getElementById('emergencyName').value = user.emergency_name || '';
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

        // Upload verification document
        async function uploadDocument(docType) {
            const inputMap = {
                'id_card_front': 'idCardFrontInput',
                'id_card_back': 'idCardBackInput',
                'face_image': 'faceImageInput',
                'driver_license_front': 'driverLicenseFrontInput',
                'driver_license_back': 'driverLicenseBackInput'
            };

            const previewMap = {
                'id_card_front': 'idCardFrontPreview',
                'id_card_back': 'idCardBackPreview',
                'face_image': 'faceImagePreview',
                'driver_license_front': 'driverLicenseFrontPreview',
                'driver_license_back': 'driverLicenseBackPreview'
            };

            const inputId = inputMap[docType];
            const previewId = previewMap[docType];
            const fileInput = document.getElementById(inputId);
            const file = fileInput.files[0];

            if (!file) return;

            // Validate file type
            const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'application/pdf'];
            if (!allowedTypes.includes(file.type)) {
                showError('Lỗi', 'Chỉ chấp nhận file ảnh (JPG, PNG, GIF) hoặc PDF');
                fileInput.value = '';
                return;
            }

            // Validate file size (10MB)
            const maxSize = 10 * 1024 * 1024;
            if (file.size > maxSize) {
                showError('Lỗi', 'Kích thước file không được vượt quá 10MB');
                fileInput.value = '';
                return;
            }

            // Show loading
            Swal.fire({
                title: 'Đang tải lên...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            try {
                const formData = new FormData();
                formData.append('document', file);
                formData.append('doc_type', docType);

                const response = await fetch('/ITS/assets/php/user/upload_verification_docs.php', {
                    method: 'POST',
                    body: formData
                });

                const data = await response.json();

                Swal.close();

                if (data.error) {
                    showError('Lỗi', data.error);
                    fileInput.value = '';
                    return;
                }

                // Show preview
                showDocumentPreview(previewId, data.file_url + '?t=' + new Date().getTime());

                Swal.fire({
                    icon: 'success',
                    title: 'Thành công',
                    text: data.message,
                    confirmButtonColor: '#2563eb'
                });

                fileInput.value = '';

                // Reload to update verification status
                setTimeout(() => loadUserInfo(), 1000);

            } catch (error) {
                console.error('Error:', error);
                Swal.close();
                showError('Lỗi', 'Không thể tải file lên. Vui lòng thử lại.');
                fileInput.value = '';
            }
        }

        // Verification info form submit
        document.getElementById('verificationInfoForm').addEventListener('submit', async function(e) {
            e.preventDefault();

            const formData = {
                id_card_number: document.getElementById('idCardNumber').value.trim(),
                id_card_name: document.getElementById('idCardName').value.trim(),
                id_card_date: document.getElementById('idCardDate').value,
                id_card_place: document.getElementById('idCardPlace').value.trim(),
                driver_license_number: document.getElementById('driverLicenseNumber').value.trim(),
                address: document.getElementById('address').value.trim(),
                bank_account_number: document.getElementById('bankAccountNumber').value.trim(),
                bank_account_name: document.getElementById('bankAccountName').value.trim(),
                bank_name: document.getElementById('bankName').value.trim(),
                emergency_contact: document.getElementById('emergencyContact').value.trim(),
                emergency_name: document.getElementById('emergencyName').value.trim()
            };

            // Validate required fields
            if (!formData.id_card_number || !formData.id_card_name || !formData.address) {
                showError('Lỗi', 'Vui lòng điền đầy đủ thông tin CCCD và địa chỉ');
                return;
            }

            if (!formData.bank_account_number || !formData.bank_account_name || !formData.bank_name) {
                showError('Lỗi', 'Vui lòng điền đầy đủ thông tin ngân hàng');
                return;
            }

            if (!formData.emergency_contact || !formData.emergency_name) {
                showError('Lỗi', 'Vui lòng điền đầy đủ thông tin liên hệ khẩn cấp');
                return;
            }

            // Validate CCCD number (9-12 digits)
            if (!/^\d{9,12}$/.test(formData.id_card_number)) {
                showError('Lỗi', 'Số CCCD/CMND phải là 9-12 chữ số');
                return;
            }

            // Validate bank account (6-20 digits)
            if (!/^\d{6,20}$/.test(formData.bank_account_number)) {
                showError('Lỗi', 'Số tài khoản ngân hàng phải là 6-20 chữ số');
                return;
            }

            // Validate driver license if provided (10-12 digits)
            if (formData.driver_license_number && !/^\d{10,12}$/.test(formData.driver_license_number)) {
                showError('Lỗi', 'Số bằng lái xe phải là 10-12 chữ số');
                return;
            }

            // Validate phone numbers
            if (!/^[0-9]{10,11}$/.test(formData.emergency_contact)) {
                showError('Lỗi', 'Số điện thoại khẩn cấp không hợp lệ');
                return;
            }

            // Show loading
            Swal.fire({
                title: 'Đang gửi yêu cầu...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            try {
                const response = await fetch('/ITS/assets/php/user/update_verification_info.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(formData)
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
                showError('Lỗi', 'Không thể gửi yêu cầu. Vui lòng thử lại.');
            }
        });
    </script>
</body>

</html>