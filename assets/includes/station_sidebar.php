<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!-- Mobile Menu Overlay -->
<div id="mobileMenuOverlay" class="fixed inset-0 bg-black bg-opacity-50 z-30 hidden lg:hidden"></div>

<!-- Sidebar for Station Management -->
<aside id="sidebar"
    class="mobile-menu fixed inset-y-0 left-0 w-64 lg:w-72 p-6 shadow-2xl z-40 overflow-y-auto transition-all duration-300"
    style="background: var(--sidebar-gradient);">
    <div class="flex items-center justify-between mb-8 lg:mb-10">
        <h2 id="sidebarTitle"
            class="flex items-center justify-between text-xl font-bold text-white transition-opacity duration-300">

            <img src="/ITS/assets/img/Logo.png" alt="Logo" class="h-10 w-auto ms-4">

            <span class="ms-4">QUẢN LÝ TRẠM ...</span>
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
       
        <!-- Station Management Section -->
        <div class="px-4 mb-2">
            <span class="sidebar-text text-xs text-white text-opacity-60 font-semibold uppercase tracking-wider transition-opacity duration-300">Menu nè</span>
        </div>
        
        <a href="<?php echo isset($baseUrl) ? $baseUrl : '..'; ?>/assets/html/layout/station/manage_vehicles.php"
            class="sidebar-item flex items-center space-x-3 px-4 py-3 rounded-lg text-white font-medium">
            <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"/>
                <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1v-5a1 1 0 00-.293-.707l-2-2A1 1 0 0015 7h-1z"/>
            </svg>
            <span class="sidebar-text transition-opacity duration-300">Quản lý phương tiện</span>
        </a>

        <a href="<?php echo isset($baseUrl) ? $baseUrl : '..'; ?>/assets/html/layout/station/manage_orders.php"
            class="sidebar-item flex items-center space-x-3 px-4 py-3 rounded-lg text-white font-medium">
            <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
            </svg>
            <span class="sidebar-text transition-opacity duration-300">Quản lý đơn đặt xe</span>
        </a>

        <a href="<?php echo isset($baseUrl) ? $baseUrl : '..'; ?>/assets/html/layout/station/statistics.php"
            class="sidebar-item flex items-center space-x-3 px-4 py-3 rounded-lg text-white font-medium">
            <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z"/>
            </svg>
            <span class="sidebar-text transition-opacity duration-300">Thống kê trạm</span>
        </a>
    </nav>
</aside>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
