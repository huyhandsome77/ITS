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
    <script src="../assets/js/index.js" defer></script>
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
                <section class="relative w-full h-[70vh] md:h-[85vh] overflow-hidden rounded-2xl shadow-xl mb-8">

                    <!-- SLIDER -->
                    <img id="heroSlider" src="../assets/img/slide1.webp"
                        class=" absolute inset-0 w-full h-full object-cover transition-opacity duration-1000">

                </section>
                <!-- Stations Section -->
                <section class="mb-6">
                    <h3 class="text-2xl font-bold mb-4">🗺️ Chọn khu vực (Quận / Huyện)</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <select id="citySelect" class="p-3 rounded-lg border">
                            <option value="">-- Chọn Thành phố --</option>
                            <option value="hcm">TP. Hồ Chí Minh</option>
                            <option value="hn">Hà Nội</option>
                        </select>

                        <select id="districtSelect" class="p-3 rounded-lg border">
                            <option value="">-- Chọn Quận / Huyện --</option>
                        </select>
                    </div>
                </section>

                <!-- Map -->
                <section class="mb-8">
                    <div class="w-full h-[420px] rounded-xl overflow-hidden shadow border">
                        <div id="map" class="w-full h-full"></div>
                    </div>
                </section>
                <!-- Address Input -->
                <h3 class="text-2xl font-bold mb-4">🏠 Nhập địa chỉ của bạn</h3>
                <div class="relative mb-4">
                    <input id="addressInput" type="text" placeholder="Nhập địa chỉ (VD: 12 Nguyễn Huệ, Quận 1)"
                        class="w-full p-3 border rounded-lg" autocomplete="off" />

                    <ul id="addressSuggest"
                        class="absolute left-0 right-0 bg-white border rounded-lg mt-1 max-h-60 overflow-auto hidden z-50">
                    </ul>
                </div>


                <!-- Danh sách trạm -->
                <section>
                    <h3 class="text-2xl font-bold mb-4">📍 Các trạm trong khu vực</h3>
                    <div id="stationList" class="grid grid-cols-1 md:grid-cols-3 gap-4"></div>
                </section>



                <!-- Featured Vehicles Section -->
                <section class="mb-8">
                    <h3 id="featuredTitle" class="text-2xl md:text-3xl font-bold mb-6"></h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
                        <!-- Vehicle Card 1 -->
                        <div class="vehicle-card bg-white rounded-xl shadow-lg overflow-hidden animate-fadeInUp"
                            style="animation-delay: 0.1s;">
                            <div class="h-48 flex items-center justify-center relative"
                                style="background: var(--accent-gradient);">
                                <div class="absolute top-3 right-3 bg-white/90 backdrop-blur-sm px-3 py-1 rounded-full text-xs font-bold"
                                    style="color: var(--primary-color);">
                                    ⭐ Phổ biến</div>
                                <svg class="w-24 h-24 text-white drop-shadow-2xl" fill="currentColor"
                                    viewbox="0 0 24 24">
                                    <path
                                        d="M18.92 6.01C18.72 5.42 18.16 5 17.5 5h-11c-.66 0-1.21.42-1.42 1.01L3 12v8c0 .55.45 1 1 1h1c.55 0 1-.45 1-1v-1h12v1c0 .55.45 1 1 1h1c.55 0 1-.45 1-1v-8l-2.08-5.99zM6.5 16c-.83 0-1.5-.67-1.5-1.5S5.67 13 6.5 13s1.5.67 1.5 1.5S7.33 16 6.5 16zm11 0c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5zM5 11l1.5-4.5h11L19 11H5z" />
                                </svg>
                            </div>
                            <div class="p-6">
                                <h4 class="text-xl font-bold mb-2 text-gray-800">🚗 Toyota Camry</h4>
                                <p class="text-gray-600 mb-4 text-sm">Sedan sang trọng, phù hợp đi công tác</p>
                                <div class="flex items-center gap-2 mb-4">
                                    <span class="text-xs bg-blue-50 text-blue-600 px-2 py-1 rounded">5 chỗ</span>
                                    <span class="text-xs bg-green-50 text-green-600 px-2 py-1 rounded">Tự động</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-xs text-gray-500">Chỉ từ</p>
                                        <span class="text-2xl font-bold bg-clip-text text-transparent"
                                            style="background-image: var(--hover-gradient);">800.000₫</span>
                                        <span class="text-xs text-gray-500">/ngày</span>
                                    </div>
                                    <button
                                        class="px-6 py-2 rounded-lg text-white font-semibold hover:opacity-90 transition shadow-md hover:shadow-lg"
                                        style="background: var(--primary-color);">
                                        Thuê ngay
                                    </button>
                                </div>
                            </div>
                        </div><!-- Vehicle Card 2 -->
                        <div class="vehicle-card bg-white rounded-xl shadow-lg overflow-hidden animate-fadeInUp"
                            style="animation-delay: 0.2s;">
                            <div class="h-48 flex items-center justify-center relative"
                                style="background: var(--accent-gradient);">
                                <div class="absolute top-3 right-3 bg-white/90 backdrop-blur-sm px-3 py-1 rounded-full text-xs font-bold"
                                    style="color: var(--primary-color);">
                                    👨‍👩‍👧‍👦 Gia đình</div>
                                <svg class="w-24 h-24 text-white drop-shadow-2xl" fill="currentColor"
                                    viewbox="0 0 24 24">
                                    <path
                                        d="M18.92 6.01C18.72 5.42 18.16 5 17.5 5h-11c-.66 0-1.21.42-1.42 1.01L3 12v8c0 .55.45 1 1 1h1c.55 0 1-.45 1-1v-1h12v1c0 .55.45 1 1 1h1c.55 0 1-.45 1-1v-8l-2.08-5.99zM6.5 16c-.83 0-1.5-.67-1.5-1.5S5.67 13 6.5 13s1.5.67 1.5 1.5S7.33 16 6.5 16zm11 0c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5zM5 11l1.5-4.5h11L19 11H5z" />
                                </svg>
                            </div>
                            <div class="p-6">
                                <h4 class="text-xl font-bold mb-2 text-gray-800">🚙 Honda CR-V</h4>
                                <p class="text-gray-600 mb-4 text-sm">SUV rộng rãi cho gia đình</p>
                                <div class="flex items-center gap-2 mb-4">
                                    <span class="text-xs bg-blue-50 px-2 py-1 rounded"
                                        style="color: var(--primary-color);">7
                                        chỗ</span>
                                    <span class="text-xs bg-blue-50 px-2 py-1 rounded"
                                        style="color: var(--primary-color);">Tự
                                        động</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-xs text-gray-500">Chỉ từ</p>
                                        <span class="text-2xl font-bold bg-clip-text text-transparent"
                                            style="background-image: var(--hover-gradient);">950.000₫</span>
                                        <span class="text-xs text-gray-500">/ngày</span>
                                    </div>
                                    <button
                                        class="px-6 py-2 rounded-lg text-white font-semibold hover:opacity-90 transition shadow-md hover:shadow-lg"
                                        style="background: var(--primary-color);">
                                        Thuê ngay
                                    </button>
                                </div>
                            </div>
                        </div><!-- Vehicle Card 3 -->
                        <div class="vehicle-card bg-white rounded-xl shadow-lg overflow-hidden animate-fadeInUp"
                            style="animation-delay: 0.3s;">
                            <div class="h-48 flex items-center justify-center relative"
                                style="background: var(--accent-gradient);">
                                <div class="absolute top-3 right-3 bg-white/90 backdrop-blur-sm px-3 py-1 rounded-full text-xs font-bold"
                                    style="color: var(--primary-color);">
                                    🔥 Hot</div>
                                <svg class="w-24 h-24 text-white drop-shadow-2xl" fill="currentColor"
                                    viewbox="0 0 24 24">
                                    <path
                                        d="M18.92 6.01C18.72 5.42 18.16 5 17.5 5h-11c-.66 0-1.21.42-1.42 1.01L3 12v8c0 .55.45 1 1 1h1c.55 0 1-.45 1-1v-1h12v1c0 .55.45 1 1 1h1c.55 0 1-.45 1-1v-8l-2.08-5.99zM6.5 16c-.83 0-1.5-.67-1.5-1.5S5.67 13 6.5 13s1.5.67 1.5 1.5S7.33 16 6.5 16zm11 0c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5zM5 11l1.5-4.5h11L19 11H5z" />
                                </svg>
                            </div>
                            <div class="p-6">
                                <h4 class="text-xl font-bold mb-2 text-gray-800">🏎️ Mazda CX-5</h4>
                                <p class="text-gray-600 mb-4 text-sm">Crossover thể thao, hiện đại</p>
                                <div class="flex items-center gap-2 mb-4">
                                    <span class="text-xs bg-blue-50 px-2 py-1 rounded"
                                        style="color: var(--primary-color);">5
                                        chỗ</span>
                                    <span class="text-xs bg-orange-50 text-orange-600 px-2 py-1 rounded">Thể thao</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-xs text-gray-500">Chỉ từ</p>
                                        <span class="text-2xl font-bold bg-clip-text text-transparent"
                                            style="background-image: var(--hover-gradient);">900.000₫</span>
                                        <span class="text-xs text-gray-500">/ngày</span>
                                    </div>
                                    <button
                                        class="px-6 py-2 rounded-lg text-white font-semibold hover:opacity-90 transition shadow-md hover:shadow-lg"
                                        style="background: var(--primary-color);">
                                        Thuê ngay
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </main>

            <?php include '../assets/includes/footer.php'; ?>
        </div>
    </div>
    <script src="../assets/js/main.js"></script>
    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
</body>
</script>


</html>