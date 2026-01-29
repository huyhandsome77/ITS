<!doctype html>
<html lang="vi" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang chủ | Thuexe.com</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/slider-fix.css">
    <script src="../assets/js/index.js?v=<?= time() ?>" defer></script>
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="/_sdk/element_sdk.js"></script>
    <script src="/_sdk/data_sdk.js" type="text/javascript"></script>
</head>

<?php $baseUrl = '..'; ?>

<body class="min-h-full">
    <div id="app" class="flex min-h-screen">
        <?php include '../assets/includes/sidebar.php'; ?>

        <!-- Content Wrapper (Navbar + Main + Footer) -->
        <div id="contentWrapper" class="flex-1 flex flex-col min-h-screen transition-all duration-300">
            <?php include '../assets/includes/navbar.php'; ?>

            <!-- Main Section -->
            <main class="flex-1 overflow-auto p-4 md:p-6 lg:p-8" style="margin-top: 76px;">
                <!-- Hero Section -->
                <section class="relative w-full aspect-video md:aspect-auto md:h-[75vh] lg:h-[80vh] overflow-hidden rounded-2xl shadow-xl mb-8">

                    <!-- SLIDER -->
                    <img id="heroSlider" src="../assets/img/slide1.webp"
                        class=" absolute inset-0 w-full h-full object-cover transition-opacity duration-1000">

                </section>
                <!-- Stations Section -->
                <?php include '../assets/php/user/get_station.php'
                ?>

                <!-- CHỌN KHU VỰC -->
                <section class="mb-6">
                    <h3 class="text-2xl font-bold mb-4">🗺️ Chọn khu vực</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <select id="citySelect" class="p-3 rounded-lg border">
                            <option value="">-- Chọn Thành phố --</option>
                        </select>
                        <select id="districtSelect" class="p-3 rounded-lg border" disabled>
                            <option value="">-- Chọn Quận / Huyện --</option>
                        </select>
                        <button id="searchStationBtn"
                            class="px-6 py-2 rounded-lg text-white font-semibold hover:opacity-90 transition shadow-md hover:shadow-lg disabled:opacity-50 disabled:cursor-not-allowed"
                            style="background-color: rgb(0, 102, 102); font-size: 14px;">
                            🔍 Tìm trạm
                        </button>
                    </div>
                </section>

                <!-- ĐỊA CHỈ USER -->
                <section class="mb-6">
                    <h3 class="text-2xl font-bold mb-4">🏠 Địa chỉ của bạn</h3>
                    <div class="flex gap-2 relative">
                        <div class="flex-1 relative">
                            <input id="addressInput" type="text" placeholder="VD: 12 Nguyễn Huệ, Quận 1"
                                class="w-full p-3 border rounded-lg" autocomplete="off">
                            <ul id="suggestions" class="absolute z-50 bg-white border rounded-lg shadow-lg w-full mt-1 hidden max-h-60 overflow-y-auto"></ul>
                        </div>
                        <button id="geoBtn" class="px-4 py-3 bg-gray-100 hover:bg-gray-200 rounded-lg text-2xl" title="Lấy vị trí hiện tại">
                            🎯
                        </button>
                    </div>
                </section>

                <!-- DANH SÁCH TRẠM -->
                <section>
                    <h3 class="text-2xl font-bold mb-4">📍 Các trạm</h3>
                    <div id="stationList" class="grid grid-cols-1 md:grid-cols-3 gap-4"></div>
                </section>




                <!-- Featured Vehicles Slider Section -->
                <section class="mb-8 overflow-hidden">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-2xl md:text-3xl font-bold">🚗 Xe nổi bật</h3>
                        <div class="flex gap-2">
                            <button id="prevSlide" class="w-10 h-10 rounded-full bg-white shadow-lg hover:shadow-xl transition-all flex items-center justify-center hover:scale-110" style="color: rgb(0, 102, 102);">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                </svg>
                            </button>
                            <button id="nextSlide" class="w-10 h-10 rounded-full bg-white shadow-lg hover:shadow-xl transition-all flex items-center justify-center hover:scale-110" style="color: rgb(0, 102, 102);">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                    
                    <!-- Slider Container -->
                    <div class="relative overflow-hidden w-full">
                        <div id="vehicleSlider" class="flex transition-transform duration-500 ease-in-out">
                            <!-- Vehicle cards will be dynamically inserted here -->
                        </div>
                    </div>
                    
                    <!-- Slider Indicators -->
                    <div id="sliderIndicators" class="flex justify-center gap-2 mt-6">
                        <!-- Indicators will be dynamically inserted here -->
                    </div>
                </section>
            </main>

            <?php include '../assets/includes/footer.php'; ?>
        </div>
    </div>
    <script src="../assets/js/main.js"></script>
    <script src="../assets/js/vehicle-slider.js"></script>
    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
</body>


</html>