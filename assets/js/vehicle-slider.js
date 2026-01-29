// Vehicle Slider Functionality - Wrapped in IIFE to avoid conflicts with hero slider
(function() {
    'use strict';
    
    let allVehicles = [];
    let currentSlideIndex = 0;
    let itemsPerSlide = 3;

    // Initialize slider on page load
    document.addEventListener('DOMContentLoaded', async () => {
        await loadVehicles();
        updateItemsPerSlide();
        window.addEventListener('resize', updateItemsPerSlide);
        
        // Auto-slide every 5 seconds
        setInterval(() => {
            nextSlide();
        }, 5000);
    });

    // Update items per slide based on screen size
    function updateItemsPerSlide() {
        const width = window.innerWidth;
        if (width < 768) {
            itemsPerSlide = 1;
        } else if (width < 1024) {
            itemsPerSlide = 2;
        } else {
            itemsPerSlide = 3;
        }
        renderSlider();
    }

    // Load vehicles from API
    async function loadVehicles() {
        try {
            console.log('Fetching vehicles from API...');
            const response = await fetch('../assets/php/user/get_all_vehicles.php');
            const data = await response.json();
            
            console.log('API Response:', data);
            
            if (data.success) {
                allVehicles = data.data;
                console.log('Loaded vehicles:', allVehicles.length);
                renderSlider();
            } else {
                console.error('Failed to load vehicles:', data.message);
            }
        } catch (error) {
            console.error('Error loading vehicles:', error);
        }
    }

    // Get vehicle icon based on type
    function getVehicleIcon(type) {
        return type === 'Oto' ? '🚗' : '🏍️';
    }

    // Get vehicle type badge
    function getVehicleTypeBadge(type) {
        if (type === 'Oto') {
            return '<span class="text-xs bg-blue-50 text-blue-600 px-2 py-1 rounded">Ô tô</span>';
        } else {
            return '<span class="text-xs bg-green-50 text-green-600 px-2 py-1 rounded">Xe máy</span>';
        }
    }

    // Format price
    function formatPrice(price) {
        return new Intl.NumberFormat('vi-VN').format(price);
    }

    // Create vehicle card HTML
    function createVehicleCard(vehicle) {
        const gradients = [
            'linear-gradient(135deg, #667eea 0%, #764ba2 100%)',
            'linear-gradient(135deg, #f093fb 0%, #f5576c 100%)',
            'linear-gradient(135deg, #4facfe 0%, #00f2fe 100%)',
            'linear-gradient(135deg, #43e97b 0%, #38f9d7 100%)',
            'linear-gradient(135deg, #fa709a 0%, #fee140 100%)',
            'linear-gradient(135deg, #30cfd0 0%, #330867 100%)'
        ];
        
        const randomGradient = gradients[Math.floor(Math.random() * gradients.length)];
        
        return `
            <div class="flex-shrink-0 w-full md:w-1/2 lg:w-1/3 px-3">
                <div class="bg-white rounded-xl shadow-lg overflow-hidden transform transition-all duration-300 hover:scale-105 hover:shadow-2xl h-full">
                    <div class="h-48 flex items-center justify-center relative" style="background: ${randomGradient};">
                        <div class="absolute top-3 right-3 bg-white/90 backdrop-blur-sm px-3 py-1 rounded-full text-xs font-bold" style="color: rgb(0, 102, 102);">
                            ${getVehicleIcon(vehicle.vehicle_type)} ${vehicle.vehicle_type === 'Oto' ? 'Ô tô' : 'Xe máy'}
                        </div>
                        ${vehicle.image ? 
                            `<img src="../assets/img/vehicles/${vehicle.image}" alt="${vehicle.vehicle_name}" class="w-full h-full object-cover">` :
                            `<svg class="w-24 h-24 text-white drop-shadow-2xl" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M18.92 6.01C18.72 5.42 18.16 5 17.5 5h-11c-.66 0-1.21.42-1.42 1.01L3 12v8c0 .55.45 1 1 1h1c.55 0 1-.45 1-1v-1h12v1c0 .55.45 1 1 1h1c.55 0 1-.45 1-1v-8l-2.08-5.99zM6.5 16c-.83 0-1.5-.67-1.5-1.5S5.67 13 6.5 13s1.5.67 1.5 1.5S7.33 16 6.5 16zm11 0c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5zM5 11l1.5-4.5h11L19 11H5z"/>
                            </svg>`
                        }
                    </div>
                    <div class="p-6">
                        <h4 class="text-xl font-bold mb-2 text-gray-800">${getVehicleIcon(vehicle.vehicle_type)} ${vehicle.vehicle_name}</h4>
                        <p class="text-gray-600 mb-3 text-sm">${vehicle.brand} ${vehicle.model} - ${vehicle.year || 'N/A'}</p>
                        <div class="flex items-center gap-2 mb-4 flex-wrap">
                            ${getVehicleTypeBadge(vehicle.vehicle_type)}
                            <span class="text-xs bg-purple-50 text-purple-600 px-2 py-1 rounded">${vehicle.seats} chỗ</span>
                            <span class="text-xs bg-gray-50 text-gray-600 px-2 py-1 rounded">${vehicle.license_plate}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs text-gray-500">Chỉ từ</p>
                                <span class="text-2xl font-bold" style="background: linear-gradient(135deg, rgb(0, 102, 102) 0%, rgb(0, 153, 153) 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">${formatPrice(vehicle.price_per_day)}₫</span>
                                <span class="text-xs text-gray-500">/ngày</span>
                            </div>
                        </div>
                        ${vehicle.station_name ? `
                        <div class="mt-3 pt-3 border-t border-gray-100">
                            <p class="text-xs text-gray-500">📍 ${vehicle.station_name}</p>
                        </div>
                        ` : ''}
                    </div>
                </div>
            </div>
        `;
    }

    // Render slider
    function renderSlider() {
        const vehicleSliderEl = document.getElementById('vehicleSlider');
        const indicators = document.getElementById('sliderIndicators');
        
        if (!vehicleSliderEl || !allVehicles.length) return;
        
        // Clear existing content
        vehicleSliderEl.innerHTML = '';
        indicators.innerHTML = '';
        
        // Render all vehicles
        allVehicles.forEach(vehicle => {
            vehicleSliderEl.innerHTML += createVehicleCard(vehicle);
        });
        
        // Calculate total slides
        const totalSlides = Math.ceil(allVehicles.length / itemsPerSlide);
        
        // Create indicators
        for (let i = 0; i < totalSlides; i++) {
            const indicator = document.createElement('button');
            indicator.className = `w-2 h-2 rounded-full transition-all duration-300 ${i === currentSlideIndex ? 'bg-teal-600 w-8' : 'bg-gray-300'}`;
            indicator.onclick = () => goToSlide(i);
            indicators.appendChild(indicator);
        }
        
        // Update slider position
        updateSliderPosition();
        
        // Setup navigation buttons
        setupNavigationButtons();
    }

    // Update slider position
    function updateSliderPosition() {
        const vehicleSliderEl = document.getElementById('vehicleSlider');
        if (!vehicleSliderEl || !allVehicles.length) return;
        
        // Calculate offset: each slide shows itemsPerSlide cards
        // We move by 100% of the visible width per slide
        const offset = -(currentSlideIndex * 100);
        vehicleSliderEl.style.transform = `translateX(${offset}%)`;
        
        // Update indicators
        updateIndicators();
    }

    // Update indicators
    function updateIndicators() {
        const indicators = document.getElementById('sliderIndicators');
        if (!indicators) return;
        
        const buttons = indicators.querySelectorAll('button');
        buttons.forEach((btn, index) => {
            if (index === currentSlideIndex) {
                btn.className = 'w-8 h-2 rounded-full transition-all duration-300 bg-teal-600';
            } else {
                btn.className = 'w-2 h-2 rounded-full transition-all duration-300 bg-gray-300';
            }
        });
    }

    // Go to specific slide
    function goToSlide(index) {
        const totalSlides = Math.ceil(allVehicles.length / itemsPerSlide);
        currentSlideIndex = Math.max(0, Math.min(index, totalSlides - 1));
        updateSliderPosition();
    }

    // Next slide
    function nextSlide() {
        const totalSlides = Math.ceil(allVehicles.length / itemsPerSlide);
        currentSlideIndex = (currentSlideIndex + 1) % totalSlides;
        updateSliderPosition();
    }

    // Previous slide
    function prevSlide() {
        const totalSlides = Math.ceil(allVehicles.length / itemsPerSlide);
        currentSlideIndex = (currentSlideIndex - 1 + totalSlides) % totalSlides;
        updateSliderPosition();
    }

    // Setup navigation buttons
    function setupNavigationButtons() {
        const prevBtn = document.getElementById('prevSlide');
        const nextBtn = document.getElementById('nextSlide');
        
        if (prevBtn) {
            prevBtn.onclick = prevSlide;
        }
        
        if (nextBtn) {
            nextBtn.onclick = nextSlide;
        }
    }
})();
