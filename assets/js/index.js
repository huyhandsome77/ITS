document.addEventListener("DOMContentLoaded", () => {

  const MAPBOX_TOKEN = "pk.eyJ1Ijoic29pY2FjYTc3IiwiYSI6ImNtanBwM2NrNjJjczIzZXB5aTFsejhvMTcifQ.PycPOcu1-ch0-NXaz82bWA";

  const citySelect = document.getElementById("citySelect");
  const districtSelect = document.getElementById("districtSelect");
  const addressInput = document.getElementById("addressInput");
  const stationList = document.getElementById("stationList");
  const stationCards = document.querySelectorAll(".station-card");
  const searchBtn = document.getElementById("searchStationBtn");

  let userLocation = null;
  let hasSearched = false;

  console.log("🚀 Station Search Script Loaded");
  console.log("Found elements:", { 
    citySelect: !!citySelect, 
    districtSelect: !!districtSelect, 
    stationList: !!stationList,
    searchBtn: !!searchBtn,
    stationCards: stationCards.length 
  });

  // Guard check
  if (!citySelect || !districtSelect || !stationList) {
    console.error("❌ Missing required DOM elements");
    return;
  }

  if (stationCards.length === 0) {
    console.error("❌ No station cards found!");
    if (stationList) {
      stationList.innerHTML = '<div class="col-span-full text-center py-8 text-red-500">⚠️ Không tìm thấy dữ liệu trạm. Kiểm tra get_station.php</div>';
    }
    return;
  }

  /************ BUILD CITY / DISTRICT FROM DB ************/
  const locationMap = {};
  stationCards.forEach(card => {
    const c = card.dataset.city;
    const d = card.dataset.district;
    
    console.log("Station:", card.dataset.name, "City:", c, "District:", d);
    
    if (!c || !d) {
      console.warn("⚠️ Missing city/district for:", card.dataset.name);
      return;
    }
    
    if (!locationMap[c]) locationMap[c] = new Set();
    locationMap[c].add(d);
  });

  console.log("📍 Location Map:", locationMap);

  // Populate city dropdown
  Object.keys(locationMap).sort().forEach(c => {
    const opt = document.createElement('option');
    opt.value = c;
    opt.textContent = c;
    citySelect.appendChild(opt);
  });

  /************ GEOCODE ************/
  async function geocode(address) {
    try {
      const url =
        `https://api.mapbox.com/geocoding/v5/mapbox.places/` +
        `${encodeURIComponent(address)}.json?limit=1&country=VN&access_token=${MAPBOX_TOKEN}`;
      const res = await fetch(url);
      const data = await res.json();
      if (!data.features?.length) return null;
      const [lng, lat] = data.features[0].center;
      return { lat, lng };
    } catch (error) {
      console.error("Geocoding error:", error);
      return null;
    }
  }

  /************ DISTANCE ************/
  function calcDistance(lat1, lng1, lat2, lng2) {
    const R = 6371;
    const toRad = x => x * Math.PI / 180;
    const dLat = toRad(lat2 - lat1);
    const dLng = toRad(lng2 - lng1);
    const h =
      Math.sin(dLat/2)**2 +
      Math.cos(toRad(lat1))*Math.cos(toRad(lat2))*Math.sin(dLng/2)**2;
    return R * 2 * Math.atan2(Math.sqrt(h), Math.sqrt(1-h));
  }

  /************ TOGGLE SEARCH BUTTON ************/
  function toggleSearchButton() {
    if (!searchBtn) return;
    
    const hasSelection = citySelect.value || districtSelect.value;
    searchBtn.disabled = !hasSelection;
    console.log("🔘 Search button:", hasSelection ? "enabled" : "disabled");
  }

  /************ USER ADDRESS ************/
  if (addressInput) {
    // Support both 'change' and 'blur' events
    const handleAddressInput = async () => {
      const address = addressInput.value.trim();
      if (!address) {
        alert("Vui lòng nhập địa chỉ");
        return;
      }
      
      console.log("📍 Geocoding address:", address);
      const pos = await geocode(address);
      
      if (!pos) {
        alert("Không tìm thấy địa chỉ. Thử nhập chi tiết hơn (VD: 123 Nguyễn Huệ, Quận 1, TP.HCM)");
        return;
      }
      
      userLocation = pos;
      window.userLocation = pos;
      console.log("✅ User location set:", pos);
      
      // Auto re-render if already searched
      if (hasSearched && (citySelect.value || districtSelect.value)) {
        renderStations();
      }
    };

    addressInput.addEventListener("blur", handleAddressInput);
    addressInput.addEventListener("keypress", (e) => {
      if (e.key === "Enter") {
        e.preventDefault();
        handleAddressInput();
      }
    });
  }

  /************ SELECT EVENTS ************/
  citySelect.addEventListener("change", () => {
    console.log("🏙️ City selected:", citySelect.value);
    
    districtSelect.innerHTML = `<option value="">-- Chọn Quận / Huyện --</option>`;
    const selectedCity = citySelect.value;
    
    if (selectedCity && locationMap[selectedCity]) {
      districtSelect.disabled = false;
      Array.from(locationMap[selectedCity]).sort().forEach(d => {
        const opt = document.createElement('option');
        opt.value = d;
        opt.textContent = d;
        districtSelect.appendChild(opt);
      });
    } else {
      districtSelect.disabled = true;
    }
    
    toggleSearchButton();
    
    // Clear previous results when changing city
    if (!hasSearched) {
      stationList.innerHTML = '<div class="col-span-full text-center py-8 text-gray-400">👆 Chọn khu vực và nhấn "Tìm trạm" để xem danh sách</div>';
    }
  });

  districtSelect.addEventListener("change", () => {
    console.log("🏘️ District selected:", districtSelect.value);
    toggleSearchButton();
  });

  /************ SEARCH BUTTON CLICK ************/
  if (searchBtn) {
    searchBtn.addEventListener("click", () => {
      console.log("🔍 Search button clicked");
      hasSearched = true;
      renderStations();
    });
  } else {
    console.error("❌ Search button not found!");
  }

  /************ RENDER STATIONS ************/
  async function renderStations() {
    console.log("🎨 Rendering stations...");
    stationList.innerHTML = '<div class="col-span-full text-center py-4 text-gray-500">⏳ Đang tải dữ liệu trạm...</div>';

    let stations = [];
    const selectedCity = citySelect.value;
    const selectedDistrict = districtSelect.value;

    console.log("Filters:", { selectedCity, selectedDistrict });

    // Collect and geocode stations
    for (const card of stationCards) {
      const cardCity = card.dataset.city;
      const cardDistrict = card.dataset.district;
      const cardAddress = card.dataset.address;
      const cardName = card.dataset.name;
      const cardId = card.dataset.id;
      const cardCars = card.dataset.cars || 0;
      const cardBikes = card.dataset.bikes || 0;
      
      // Filter by selected city/district
      if (selectedCity && cardCity !== selectedCity) continue;
      if (selectedDistrict && cardDistrict !== selectedDistrict) continue;

      console.log("Geocoding:", cardName, cardAddress);
      const pos = await geocode(cardAddress);
      
      if (!pos) {
        console.warn(`⚠️ Could not geocode: ${cardAddress}`);
        continue;
      }

      stations.push({
        id: cardId,
        name: cardName,
        address: cardAddress,
        city: cardCity,
        district: cardDistrict,
        lat: pos.lat,
        lng: pos.lng,
        cars: cardCars,
        bikes: cardBikes
      });
    }

    console.log("✅ Found stations:", stations.length);

    // Sort by distance if user location is set
    if (userLocation) {
      stations.sort((a, b) =>
        calcDistance(userLocation.lat, userLocation.lng, a.lat, a.lng) -
        calcDistance(userLocation.lat, userLocation.lng, b.lat, b.lng)
      );
      console.log("📏 Sorted by distance");
    }

    // Clear and render
    stationList.innerHTML = "";

    if (stations.length === 0) {
      stationList.innerHTML = '<div class="col-span-full text-center py-8 text-gray-500">❌ Không tìm thấy trạm nào</div>';
      return;
    }

    stations.forEach(s => {
      // Calculate distance
      let distanceText = "—";
      if (userLocation) {
        const d = calcDistance(
          userLocation.lat,
          userLocation.lng,
          s.lat,
          s.lng
        );
        distanceText = d < 1
          ? Math.round(d * 1000) + " m"
          : d.toFixed(2) + " km";
      }

      // Create card
      const card = document.createElement("div");
      card.className = "bg-white rounded-xl shadow p-4 flex flex-col hover:shadow-lg transition";
      card.innerHTML = `
        <h4 class="font-bold text-lg mb-1">🏢 ${s.name}</h4>
        <p class="text-sm text-gray-500 mb-2">📍 ${s.address}</p>
        <div class="flex gap-3 text-sm mb-2">
          <span class="bg-blue-50 text-blue-600 px-2 py-1 rounded">
            🚗 ${s.cars} ô tô
          </span>
          <span class="bg-green-50 text-green-600 px-2 py-1 rounded">
            🛵 ${s.bikes} xe máy
          </span>
        </div>
        <p class="text-sm text-gray-600 mb-3">
          📏 Cách bạn: <b>${distanceText}</b>
        </p>
      `;

      // Create button
      const btn = document.createElement("button");
      btn.className = "mt-auto w-full px-4 py-2 rounded-lg text-white font-semibold hover:opacity-90 transition";
      btn.style.background = "#2563eb";
      btn.textContent = "🧭 Chỉ đường";
      btn.addEventListener("click", () => {
        openGoogleMapsDirection(s.lat, s.lng);
      });
      
      card.appendChild(btn);
      stationList.appendChild(card);
    });

    console.log("✅ Rendered", stations.length, "stations");
  }

  /************ OPEN GOOGLE MAPS ************/
  function openGoogleMapsDirection(lat, lng) {
    if (!userLocation) {
      alert("Vui lòng nhập địa chỉ của bạn trước khi chỉ đường");
      return;
    }
    window.open(
      `https://www.google.com/maps/dir/?api=1&origin=${userLocation.lat},${userLocation.lng}&destination=${lat},${lng}`,
      "_blank"
    );
  }

  // Make it global
  window.openGoogleMapsDirection = openGoogleMapsDirection;

  // INITIAL STATE
  toggleSearchButton();
  if (stationList) {
    stationList.innerHTML = '<div class="col-span-full text-center py-8 text-gray-400">👆 Chọn khu vực và nhấn "Tìm trạm" để xem danh sách</div>';
  }

  console.log("✅ Station Search Script Ready");

});