<!-- Navbar -->
<nav id="navbar"
    class="px-4 md:px-6 py-4 flex items-center justify-between shadow-lg z-20 sticky top-0 backdrop-blur-lg bg-white/90">
    <div class="flex items-center space-x-3 md:space-x-4">
        <button id="menuToggle" class="lg:hidden p-2 rounded-lg hover:bg-opacity-10 hover:bg-gray-500">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>
        <svg class="w-7 h-7 md:w-8 md:h-8" fill="currentColor" viewBox="0 0 24 24">
            <path
                d="M18.92 6.01C18.72 5.42 18.16 5 17.5 5h-11c-.66 0-1.21.42-1.42 1.01L3 12v8c0 .55.45 1 1 1h1c.55 0 1-.45 1-1v-1h12v1c0 .55.45 1 1 1h1c.55 0 1-.45 1-1v-8l-2.08-5.99zM6.5 16c-.83 0-1.5-.67-1.5-1.5S5.67 13 6.5 13s1.5.67 1.5 1.5S7.33 16 6.5 16zm11 0c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5zM5 11l1.5-4.5h11L19 11H5z" />
        </svg>
        <div>
            <a href="<?php echo isset($baseUrl) ? $baseUrl : ''; ?>/assets/html/layout/admin/dashboard.php">
        <h1 id="appTitle" class="text-xl md:text-2xl font-bold" style="color: var(--primary-color);">thuexe.com</h1> 
            </a>
        </div>
    </div>
    <div class="hidden md:flex items-center space-x-3 lg:space-x-4">
        <a href="<?php echo isset($baseUrl) ? $baseUrl : ''; ?>/assets/html/layout/admin/dashboard.php"
            class="nav-item px-4 lg:px-5 py-2.5 rounded-lg font-semibold text-sm lg:text-base shadow-sm">
            Trang chủ
        </a>
        <a href="<?php echo isset($baseUrl)? $baseUrl : '';?>/assets/html/layout/admin/notifications.php"
         class="nav-item px-4 lg:px-5 py-2.5 rounded-lg font-medium text-sm lg:text-base">
        Thông báo
        <span class="ml-auto bg-red-500 text-white text-xs font-bold rounded-full px-2 py-1">3</span>
        </a>
        

        <a href="#" class="nav-item px-4 lg:px-5 py-2.5 rounded-lg font-medium text-sm lg:text-base">
            Liên hệ
        </a>
        <?php if (!isset($_SESSION['user_id'])): ?>

        <a href="#"
            class="btn-primary px-6 lg:px-7 py-3 rounded-lg font-bold text-sm lg:text-base shadow-lg text-white"
            style="background: var(--sidebar-gradient);">
            Chào bạn!
        </a>

        <?php else: ?>
        <a href="<?php echo isset($baseUrl) ? $baseUrl : ''; ?>/assets/php/auth/logout_process.php"
            class="px-6 lg:px-7 py-3 rounded-lg font-bold text-sm lg:text-base shadow-lg text-white bg-red-600 hover:bg-red-700 transition">
            Đăng xuất
        </a>

        <?php endif; ?>
    </div>
</nav>