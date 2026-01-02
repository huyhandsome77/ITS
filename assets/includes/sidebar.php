<?php session_start(); ?>
<!-- Mobile Menu Overlay -->
<div id="mobileMenuOverlay" class="fixed inset-0 bg-black bg-opacity-50 z-30 hidden lg:hidden"></div>

<!-- Sidebar -->
<aside id="sidebar"
    class="mobile-menu fixed inset-y-0 left-0 w-64 lg:w-72 p-6 shadow-2xl z-40 overflow-y-auto transition-all duration-300"
    style="background: var(--sidebar-gradient);">
    <div class="flex items-center justify-between mb-8 lg:mb-10">
        <h2 id="sidebarTitle"
            class="flex items-center justify-between text-xl font-bold text-white transition-opacity duration-300">

            <img src="/QuanTriMang/assets/img/Logo.png" alt="Logo" class="h-10 w-auto ms-4">

            <span class="ms-4">MENU</span>
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
        <a href="<?php echo isset($baseUrl) ? $baseUrl : '..'; ?>/public/index.php"
            class="sidebar-item flex items-center space-x-3 px-4 py-3 rounded-lg text-white font-medium">
            <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path
                    d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
            </svg>
            <span class="sidebar-text transition-opacity duration-300">Trang chủ</span>
        </a>
        <a href="<?php echo isset($baseUrl) ? $baseUrl : '..'; ?>/assets/html/layout/user/list_car.php"
            class="sidebar-item flex items-center space-x-3 px-4 py-3 rounded-lg text-white font-medium">
            <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path
                    d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z" />
            </svg>
            <span class="sidebar-text transition-opacity duration-300">Danh mục xe</span>
        </a>
        <a href="<?php echo isset($baseUrl) ? $baseUrl : '..'; ?>/assets/html/layout/user/order.php"
            class="sidebar-item flex items-center space-x-3 px-4 py-3 rounded-lg text-white font-medium">
            <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z" />
                <path fill-rule="evenodd"
                    d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z"
                    clip-rule="evenodd" />
            </svg>
            <span class="sidebar-text transition-opacity duration-300">Đơn hàng</span>
        </a>
        <a href="<?php echo isset($baseUrl) ? $baseUrl : '..'; ?>/assets/html/layout/user/setting.php"
            class="sidebar-item flex items-center space-x-3 px-4 py-3 rounded-lg text-white font-medium">
            <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z"
                    clip-rule="evenodd" />
            </svg>
            <span class="sidebar-text transition-opacity duration-300">Cài đặt</span>
        </a>
    </nav>
</aside>