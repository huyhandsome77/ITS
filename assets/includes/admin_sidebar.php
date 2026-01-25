<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!-- Mobile Menu Overlay -->
<div id="mobileMenuOverlay" class="fixed inset-0 bg-black bg-opacity-50 z-30 hidden lg:hidden"></div>

<!-- Sidebar for Admin -->
<aside id="sidebar"
    class="mobile-menu fixed inset-y-0 left-0 w-64 lg:w-72 p-6 shadow-2xl z-40 overflow-y-auto transition-all duration-300"
    style="background: var(--sidebar-gradient);">
    <div class="flex items-center justify-between mb-8 lg:mb-10">
        <h2 id="sidebarTitle"
            class="flex items-center justify-between text-xl font-bold text-white transition-opacity duration-300">

            <img src="/ITS/assets/img/Logo.png" alt="Logo" class="h-10 w-auto ms-4">

            <span class="ms-4">ADMIN</span>
        </h2>

        <button id="closeSidebar" class="lg:hidden p-2 rounded-lg text-white hover:bg-white hover:bg-opacity-10">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
        <button id="toggleSidebar" class="hidden lg:block p-2 rounded-lg text-white hover:bg-white hover:bg-opacity-10">
            <svg id="toggleIcon" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M11 19l-7-7 7-7m8 14l-7-7 7-7" />
            </svg>
        </button>
    </div>
    <nav class="space-y-3">
        <!-- Dashboard -->
        <a href="<?php echo isset($baseUrl) ? $baseUrl : '..'; ?>/assets/html/layout/admin/dashboard.php"
            class="sidebar-item flex items-center space-x-3 px-4 py-3 rounded-lg text-white font-medium">
            <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path
                    d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z" />
            </svg>
            <span class="sidebar-text transition-opacity duration-300">Tổng quan</span>
        </a>

        <!-- Divider -->
        <div class="my-4 border-t border-white border-opacity-20"></div>

        <!-- Management Section -->
        <div class="px-4 mb-2">
            <span
                class="sidebar-text text-xs text-white text-opacity-60 font-semibold uppercase tracking-wider transition-opacity duration-300">Quản
                lý</span>
        </div>

        <a href="<?php echo isset($baseUrl) ? $baseUrl : '..'; ?>/assets/html/layout/admin/manage_users.php"
            class="sidebar-item flex items-center space-x-3 px-4 py-3 rounded-lg text-white font-medium">
            <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path
                    d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z" />
            </svg>
            <span class="sidebar-text transition-opacity duration-300">Quản lý người dùng</span>
        </a>

        <a href="<?php echo isset($baseUrl) ? $baseUrl : '..'; ?>/assets/html/layout/admin/manage_stations.php"
            class="sidebar-item flex items-center space-x-3 px-4 py-3 rounded-lg text-white font-medium">
            <svg class="w-5 h-5 flex-shrink-0" viewBox="0 0 24 24" fill="currentColor">
                <!-- Location pin -->
                <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z" />
                <circle cx="12" cy="9" r="2.5" fill="white" />

                <!-- Station building -->
                <rect x="9" y="13.5" width="6" height="5" rx="0.5" />
                <rect x="10" y="14.5" width="1.2" height="1.5" fill="white" />
                <rect x="12.4" y="14.5" width="1.2" height="1.5" fill="white" />
            </svg>

            <span class="sidebar-text transition-opacity duration-300">Quản lý trạm</span>
        </a>

        <a href="<?php echo isset($baseUrl) ? $baseUrl : '..'; ?>/assets/html/layout/admin/manage_vehicles.php"
            class="sidebar-item flex items-center space-x-3 px-4 py-3 rounded-lg text-white font-medium">
            <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z" />
                <path
                    d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1v-5a1 1 0 00-.293-.707l-2-2A1 1 0 0015 7h-1z" />
            </svg>
            <span class="sidebar-text transition-opacity duration-300">Quản lý phương tiện</span>
        </a>

        <a href="<?php echo isset($baseUrl) ? $baseUrl : '..'; ?>/assets/html/layout/admin/manage_orders.php"
            class="sidebar-item flex items-center space-x-3 px-4 py-3 rounded-lg text-white font-medium">
            <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                    d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                    clip-rule="evenodd" />
            </svg>
            <span class="sidebar-text transition-opacity duration-300">Quản lý đơn đặt xe</span>
        </a>

        <a href="<?php echo isset($baseUrl) ? $baseUrl : '..'; ?>/assets/html/layout/admin/manage_reviews.php"
            class="sidebar-item flex items-center space-x-3 px-4 py-3 rounded-lg text-white font-medium">
            <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path
                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
            </svg>
            <span class="sidebar-text transition-opacity duration-300">Quản lý đánh giá</span>
        </a>

        <!-- Divider -->
        <div class="my-4 border-t border-white border-opacity-20"></div>

        <!-- Reports & Analytics -->
        <div class="px-4 mb-2">
            <span
                class="sidebar-text text-xs text-white text-opacity-60 font-semibold uppercase tracking-wider transition-opacity duration-300">Báo
                cáo</span>
        </div>

        <a href="<?php echo isset($baseUrl) ? $baseUrl : '..'; ?>/assets/html/layout/admin/statistics.php"
            class="sidebar-item flex items-center space-x-3 px-4 py-3 rounded-lg text-white font-medium">
            <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path
                    d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z" />
            </svg>
            <span class="sidebar-text transition-opacity duration-300">Thống kê hệ thống</span>
        </a>

        <a href="<?php echo isset($baseUrl) ? $baseUrl : '..'; ?>/assets/html/layout/admin/payment_history.php"
            class="sidebar-item flex items-center space-x-3 px-4 py-3 rounded-lg text-white font-medium">
            <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z" />
                <path fill-rule="evenodd"
                    d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z"
                    clip-rule="evenodd" />
            </svg>
            <span class="sidebar-text transition-opacity duration-300">Lịch sử thanh toán</span>
        </a>
    </nav>
</aside>