<?php
require_once __DIR__ . '/../bootstrap.php';?>

<!-- Mobile Menu Overlay -->
<div id="mobileMenuOverlay" class="fixed inset-0 bg-black bg-opacity-50 z-30 hidden lg:hidden"></div>

<!-- Sidebar -->
<aside id="sidebar" class="mobile-menu fixed inset-y-0 left-0 w-64 lg:w-72 p-6 shadow-2xl z-40
           overflow-y-auto transition-all duration-300" style="background: var(--sidebar-gradient);">

    <!-- LOGO + TITLE -->
    <div class="flex items-center justify-between mb-8">
        <h2 id="sidebarTitle" class="flex items-center gap-3 text-xl font-bold text-white">

            <img src="/QuanTriMang/assets/img/Logo.png" alt="Logo" class="h-10 w-auto">

            <span>DISPATCHER</span>
        </h2>

        <!-- Mobile Close -->
        <button id="closeSidebar" class="lg:hidden p-2 rounded-lg text-white hover:bg-white/10">
            ✕
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