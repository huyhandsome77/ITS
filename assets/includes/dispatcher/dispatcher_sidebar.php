<?php
require_once __DIR__ . '/../bootstrap.php';?>

<!-- Mobile Menu Overlay -->
<div id="mobileMenuOverlay" class="fixed inset-0 bg-black bg-opacity-50 z-30 hidden lg:hidden"></div>

<!-- Sidebar -->
<aside id="sidebar" class="mobile-menu fixed inset-y-0 left-0 w-64 lg:w-72 p-6 shadow-2xl z-40
           overflow-y-auto transition-all duration-300" style="background: var(--sidebar-gradient);">

    <!-- LOGO + TITLE -->
    <div class="flex items-center justify-between mb-8 lg:mb-10">
        <h2 id="sidebarTitle"
            class="flex items-center justify-between text-xl font-bold text-white transition-opacity duration-300">

            <img src="/QuanTriMang/assets/img/Logo.png" alt="Logo" class="h-10 w-auto ms-2">

            <span class="ms-4">DISPATCHER</span>
        </h2>

        <!-- Mobile Close -->
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

    <!-- DIVIDER -->
    <div class="border-t border-white/20 mb-6"></div>

    <!-- MENU -->
    <nav class="space-y-3">

        <!-- XEM ĐƠN ĐẶT XE -->
        <a href="<?= $baseUrl ?>/assets/html/layout/dispatcher/dispatcher_orders.php"
            class="sidebar-item flex items-center gap-3 px-4 py-3 rounded-lg text-white font-medium">

            📋
            <span class="sidebar-text">Xem đơn đặt xe</span>
        </a>

        <!-- ĐÁNH GIÁ & NHẬN XÉT -->
        <a href="<?= $baseUrl ?>/assets/html/layout/dispatcher/reviews.php"
            class="sidebar-item flex items-center gap-3 px-4 py-3 rounded-lg text-white font-medium">

            ⭐
            <span class="sidebar-text">Đánh giá & nhận xét</span>
        </a>

        <!-- QUẢN LÝ LƯU LƯỢNG XE -->
        <a href="<?= $baseUrl ?>/assets/html/layout/dispatcher/station_traffic.php"
            class="sidebar-item flex items-center gap-3 px-4 py-3 rounded-lg text-white font-medium">

            🚦
            <span class="sidebar-text">Lưu lượng xe từng trạm</span>
        </a>

    </nav>
</aside>