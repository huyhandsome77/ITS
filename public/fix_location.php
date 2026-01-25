<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chỉnh sửa vị trí trạm | Admin Tool</title>
    <!-- Tailwind & Leaflet -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <style>
        #map { height: calc(100vh - 64px); width: 100%; }
        .success-toast { 
            position: fixed; bottom: 20px; right: 20px; 
            background: #22c55e; color: white; padding: 1rem 1.5rem; 
            border-radius: 0.5rem; font-weight: bold;
            display: none; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            animation: slideIn 0.3s ease; z-index: 9999;
        }
        @keyframes slideIn { from { transform: translateY(100%); opacity: 0; } to { transform: translateY(0); opacity: 1; } }
    </style>
</head>
<body class="bg-gray-100 overflow-hidden">
    <!-- Header -->
    <div class="h-16 bg-white shadow flex justify-between items-center px-6 relative z-10">
        <div class="flex items-center gap-3">
            <h1 class="text-xl font-bold text-gray-800">📍 Công cụ chỉnh sửa vị trí trạm</h1>
            <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded">Admin Mode</span>
        </div>
        <div class="flex items-center gap-4">
            <p class="text-sm text-gray-500 hidden md:block">ℹ️ Kéo thả ghim đỏ để cập nhật vị trí</p>
            <a href="index.php" class="text-blue-600 hover:text-blue-800 font-medium transition flex items-center gap-1">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                </svg>
                Quay lại Trang chủ
            </a>
        </div>
    </div>
    
    <!-- Map -->
    <div id="map"></div>
    
    <!-- Toast Notification -->
    <div id="toast" class="success-toast">
        <div class="flex items-center gap-2">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            <span id="toastMsg">Đã lưu vị trí mới!</span>
        </div>
    </div>

    <!-- Get data (hidden) -->
    <?php include '../assets/php/user/get_station.php'; ?>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            // Init Map (Default center over Vietnam)
            const map = L.map('map').setView([10.762622, 106.660172], 13);
            
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors'
            }).addTo(map);

            // Parse Stations
            const stationCards = document.querySelectorAll('.station-card');
            const bounds = [];

            console.log(`Found ${stationCards.length} stations to map.`);

            stationCards.forEach(card => {
                const lat = parseFloat(card.dataset.lat);
                const lng = parseFloat(card.dataset.lng);
                const name = card.dataset.name;
                const address = card.dataset.address;
                const id = card.dataset.id;

                if (!isNaN(lat) && !isNaN(lng)) {
                    // Create draggable marker
                    const marker = L.marker([lat, lng], { 
                        draggable: true,
                        title: name 
                    }).addTo(map);
                    
                    // Popup content
                    const popupContent = `
                        <div class="p-1">
                            <h3 class="font-bold text-base mb-1">${name}</h3>
                            <p class="text-sm text-gray-600 mb-2">${address}</p>
                            <p class="text-xs text-blue-600 italic">👉 Kéo thả để chỉnh sửa</p>
                        </div>
                    `;
                    marker.bindPopup(popupContent);
                    marker.bindTooltip(name, { direction: 'top', offset: [0, -20] });

                    bounds.push([lat, lng]);

                    // Drag Event
                    marker.on('dragstart', function(e) {
                        this.openPopup();
                    });

                    marker.on('dragend', function(e) {
                        const position = marker.getLatLng();
                        console.log(`📍 ${name} moved to:`, position);
                        updatePosition(id, position.lat, position.lng, name);
                    });
                } else {
                    console.warn(`⚠️ Station ${name} has invalid coords: ${lat}, ${lng}`);
                }
            });

            // Fit bounds to show all stations
            if (bounds.length > 0) {
                map.fitBounds(bounds, { padding: [50, 50] });
            }

            // API Update Function
            function updatePosition(id, lat, lng, name) {
                const formData = new FormData();
                formData.append('id', id);
                formData.append('lat', lat);
                formData.append('lng', lng);

                fetch('../assets/php/update_station_coords.php', {
                    method: 'POST',
                    body: formData
                })
                .then(res => res.json())
                .then(data => {
                    if(data.status === 'success') {
                        showToast(`Đã lưu vị trí: ${name}`);
                    } else {
                        alert('❌ Lỗi khi lưu: ' + data.message);
                    }
                })
                .catch(err => {
                    console.error(err);
                    alert('❌ Lỗi kết nối server!');
                });
            }

            function showToast(msg) {
                const t = document.getElementById('toast');
                const tMsg = document.getElementById('toastMsg');
                if(msg) tMsg.textContent = msg;
                
                t.style.display = 'block';
                
                // Reset animation
                t.style.animation = 'none';
                t.offsetHeight; /* trigger reflow */
                t.style.animation = null; 

                // Hide after 3s
                if(window.toastTimeout) clearTimeout(window.toastTimeout);
                window.toastTimeout = setTimeout(() => {
                    t.style.display = 'none';
                }, 3000);
            }
        });
    </script>
</body>
</html>
