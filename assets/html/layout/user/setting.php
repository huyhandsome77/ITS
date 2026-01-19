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
</head>

<?php $baseUrl = '../../../..'; ?>

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
                            <img src="https://ui-avatars.com/api/?name=Nguyen+Anh+Huy&background=0D8ABC&color=fff"
                                alt="Avatar" class="w-20 h-20 rounded-full shadow">

                            <div>
                                <h3 class="text-lg font-semibold text-slate-800">
                                    Nguyễn Anh Huy
                                </h3>
                                <p class="text-sm text-slate-500">
                                    Khách hàng / Người dùng
                                </p>
                            </div>
                        </div>

                        <!-- Info Grid -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="text-sm text-slate-500">Họ và tên</label>
                                <p class="mt-1 font-medium text-slate-800">Nguyễn Anh Huy</p>
                            </div>

                            <div>
                                <label class="text-sm text-slate-500">Email</label>
                                <p class="mt-1 font-medium text-slate-800">huy@example.com</p>
                            </div>

                            <div>
                                <label class="text-sm text-slate-500">Số điện thoại</label>
                                <p class="mt-1 font-medium text-slate-800">0123 456 789</p>
                            </div>

                            <div>
                                <label class="text-sm text-slate-500">Ngày tham gia</label>
                                <p class="mt-1 font-medium text-slate-800">17/11/2024</p>
                            </div>
                        </div>

                        <!-- Action -->
                        <div class="mt-8 flex justify-center">
                            <button class="px-6 py-2.5 rounded-lg text-white text-sm font-semibold shadow transition"
                                style="background-color: var(--primary-color);"
                                onmouseover="this.style.filter='brightness(0.95)'"
                                onmouseout="this.style.filter='brightness(1)'">
                                Chỉnh sửa thông tin
                            </button>
                        </div>
                    </div>

                    <!-- RIGHT: Change Password -->
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
                        <h2 class="text-lg font-semibold text-slate-800 mb-6">
                            Bảo mật tài khoản
                        </h2>

                        <form class="space-y-5">
                            <div>
                                <label class="block text-sm font-medium text-slate-600 mb-1">
                                    Mật khẩu hiện tại
                                </label>
                                <input type="password" class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm
                                  focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none"
                                    placeholder="Nhập mật khẩu hiện tại">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-slate-600 mb-1">
                                    Mật khẩu mới
                                </label>
                                <input type="password" class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm
                                  focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none"
                                    placeholder="Nhập mật khẩu mới">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-slate-600 mb-1">
                                    Xác nhận mật khẩu mới
                                </label>
                                <input type="password" class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm
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
</body>

</html>