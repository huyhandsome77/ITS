document.addEventListener("DOMContentLoaded", () => {

  const MAPBOX_TOKEN = "pk.eyJ1Ijoic29pY2FjYTc3IiwiYSI6ImNtanBwM2NrNjJjczIzZXB5aTFsejhvMTcifQ.PycPOcu1-ch0-NXaz82bWA";

  const citySelect = document.getElementById("citySelect");
  const districtSelect = document.getElementById("districtSelect");
  const addressInput = document.getElementById("addressInput");
  const geoBtn = document.getElementById("geoBtn");
  const stationList = document.getElementById("stationList");
  const stationCards = document.querySelectorAll(".station-card");
  const searchBtn = document.getElementById("searchStationBtn");

  let userLocation = null;
  let hasSearched = false;

  console.log("🚀 SCRIPT LOADED");

  /************ PARSE STATIONS ************/
  // Read from DOM only ONCE
  const allStations = Array.from(stationCards).map(card => ({
    id: card.dataset.id,
    name: card.dataset.name,
    address: card.dataset.address,
    city: card.dataset.city,
    district: card.dataset.district,
    lat: parseFloat(card.dataset.lat),
    lng: parseFloat(card.dataset.lng),
    cars: card.dataset.cars,
    bikes: card.dataset.bikes
  })).filter(s => !isNaN(s.lat) && !isNaN(s.lng));

  console.log(`✅ Loaded ${allStations.length} stations with coordinates.`);

  /************ INIT FILTERS ************/
  const locationMap = {};
  allStations.forEach(s => {
    if (!locationMap[s.city]) locationMap[s.city] = new Set();
    locationMap[s.city].add(s.district);
  });

  Object.keys(locationMap).sort().forEach(c => {
    const opt = document.createElement('option');
    opt.value = c;
    opt.textContent = c;
    citySelect.appendChild(opt);
  });

  /************ EVENTS ************/
  citySelect.addEventListener("change", () => {
    districtSelect.innerHTML = `<option value="">-- Chọn Quận / Huyện --</option>`;
    districtSelect.disabled = !citySelect.value;
    
    if (citySelect.value) {
      Array.from(locationMap[citySelect.value]).sort().forEach(d => {
        const opt = document.createElement('option');
        opt.value = d;
        opt.textContent = d;
        districtSelect.appendChild(opt);
      });
    }
    toggleSearchButton();
  });

  districtSelect.addEventListener("change", toggleSearchButton);

  searchBtn.addEventListener("click", () => {
    hasSearched = true;
    renderStations();
  });

  if (geoBtn) {
    geoBtn.addEventListener("click", () => {
      if (!navigator.geolocation) {
        alert("Trình duyệt không hỗ trợ Geolocation.");
        return;
      }
      geoBtn.textContent = "⏳";
      navigator.geolocation.getCurrentPosition(
        (pos) => {
          userLocation = {
            lat: pos.coords.latitude,
            lng: pos.coords.longitude
          };
          console.log("📍 Got user location:", userLocation);
          geoBtn.textContent = "🎯";
          
          // Reverse geocode to show address (optional, for UX)
          reverseGeocode(userLocation.lat, userLocation.lng).then(addr => {
            if(addr) addressInput.value = addr;
          });

          // Auto search if not searched
          if (hasSearched) renderStations();
          else alert("Đã lấy vị trí! Nhấn 'Tìm trạm' để xem kết quả gần nhất.");
        },
        (err) => {
          console.error(err);
          geoBtn.textContent = "🎯";
          alert("Không thể lấy vị trí. Vui lòng cấp quyền hoặc nhập tay.");
        }
      );
    });
  }

  /************ ADDRESS AUTOCOMPLETE ************/
  if (addressInput) {
    const suggestionsBox = document.getElementById("suggestions");

    // Debounce function
    const debounce = (func, wait) => {
      let timeout;
      return (...args) => {
        clearTimeout(timeout);
        timeout = setTimeout(() => func.apply(this, args), wait);
      };
    };

    // Handle Input
    addressInput.addEventListener("input", debounce(async (e) => {
      const query = e.target.value.trim();
      
      if (query.length < 3) {
        suggestionsBox.classList.add("hidden");
        return;
      }

      try {
        const url = `https://api.mapbox.com/geocoding/v5/mapbox.places/${encodeURIComponent(query)}.json?country=VN&autocomplete=true&limit=5&access_token=${MAPBOX_TOKEN}`;
        const res = await fetch(url);
        const data = await res.json();
        
        if (data.features && data.features.length > 0) {
            renderSuggestions(data.features);
        } else {
            suggestionsBox.classList.add("hidden");
        }
      } catch (err) {
        console.error("Autocomplete error:", err);
      }
    }, 300));

    // Render Suggestions dropdown
    function renderSuggestions(features) {
        suggestionsBox.innerHTML = "";
        suggestionsBox.classList.remove("hidden");

        features.forEach(feature => {
            const li = document.createElement("li");
            li.className = "p-3 hover:bg-gray-100 cursor-pointer border-b last:border-b-0 text-sm";
            li.textContent = feature.place_name;
            
            li.addEventListener("click", () => {
                selectAddress(feature);
            });
            suggestionsBox.appendChild(li);
        });
    }

    // Select Address
    function selectAddress(feature) {
        addressInput.value = feature.place_name;
        suggestionsBox.classList.add("hidden");
        
        userLocation = {
            lat: feature.center[1],
            lng: feature.center[0]
        };
        console.log("📍 User selected location:", userLocation);
        
        // Auto render
        if (hasSearched) renderStations();
    }

    // Hide suggestions when clicking outside
    document.addEventListener("click", (e) => {
        if (!addressInput.contains(e.target) && !suggestionsBox.contains(e.target)) {
            suggestionsBox.classList.add("hidden");
        }
    });

    // Support Enter key for first suggestion or simple manual confirm
    addressInput.addEventListener("keypress", async (e) => {
        if (e.key === "Enter") {
            e.preventDefault();
            // If suggestions are visible, selecting the first one is often good UX, 
            // but let's just do a manual geocode if the user hits Enter explicitly.
            suggestionsBox.classList.add("hidden");
            const addr = addressInput.value.trim();
            if(addr) {
                const pos = await geocode(addr);
                if(pos) {
                    userLocation = pos;
                    if (hasSearched) renderStations();
                }
            }
        }
    });
  }


  /************ LOGIC ************/
  function toggleSearchButton() {
    // Always enable if wants to see all, or enforce selection. 
    // Let's enforce at least city OR user location to avoid spam? 
    // Existing logic enforced selection. Let's keep it simple.
    searchBtn.disabled = false; 
  }

  function renderStations() {
    stationList.innerHTML = "";
    
    const sCity = citySelect.value;
    const sDistrict = districtSelect.value;

    let filtered = allStations.filter(s => {
      if (sCity && s.city !== sCity) return false;
      if (sDistrict && s.district !== sDistrict) return false;
      return true;
    });

    if (userLocation) {
      filtered.forEach(s => {
        s.distance = calcDistance(userLocation.lat, userLocation.lng, s.lat, s.lng);
      });
      filtered.sort((a, b) => a.distance - b.distance);
    }

    if (filtered.length === 0) {
      stationList.innerHTML = '<div class="col-span-full text-center py-8 text-gray-500">❌ Không tìm thấy trạm phù hợp</div>';
      return;
    }

    filtered.forEach(s => {
      const distStr = s.distance 
        ? (s.distance < 1 ? Math.round(s.distance * 1000) + " m" : s.distance.toFixed(2) + " km")
        : "—";

      const card = document.createElement("div");
      card.className = "bg-white rounded-xl shadow p-4 flex flex-col hover:shadow-lg transition";
      card.innerHTML = `
        <h4 class="font-bold text-lg mb-1">🏢 ${s.name}</h4>
        <p class="text-sm text-gray-500 mb-2">📍 ${s.address}</p>
        <div class="flex gap-3 text-sm mb-2">
          <span class="bg-blue-50 text-blue-600 px-2 py-1 rounded">🚗 ${s.cars} ô tô</span>
          <span class="bg-green-50 text-green-600 px-2 py-1 rounded">🛵 ${s.bikes} xe máy</span>
        </div>
        <p class="text-sm text-gray-600 mb-3">📏 Cách bạn: <b>${distStr}</b></p>
        <button onclick="window.openGoogleMapsDirection(${s.lat}, ${s.lng})" 
          class="mt-auto w-full px-4 py-2 rounded-lg text-white font-semibold hover:opacity-90 transition shadow-md hover:shadow-lg"
          style="background-color: rgb(0, 102, 102); font-size: 14px;">
          🧭 Chỉ đường
        </button>
      `;
      stationList.appendChild(card);
    });
  }

  /************ UTILS ************/
  function calcDistance(lat1, lng1, lat2, lng2) {
    const R = 6371;
    const dLat = (lat2 - lat1) * Math.PI / 180;
    const dLng = (lng2 - lng1) * Math.PI / 180;
    const a = Math.sin(dLat/2)**2 +
              Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) * 
              Math.sin(dLng/2)**2;
    return R * 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
  }

  async function geocode(address) {
    try {
      const res = await fetch(`https://api.mapbox.com/geocoding/v5/mapbox.places/${encodeURIComponent(address)}.json?limit=1&country=VN&access_token=${MAPBOX_TOKEN}`);
      const data = await res.json();
      if (data.features?.[0]) {
        return { lat: data.features[0].center[1], lng: data.features[0].center[0] };
      }
    } catch(e) { console.error(e); }
    return null;
  }

  async function reverseGeocode(lat, lng) {
    try {
      const res = await fetch(`https://api.mapbox.com/geocoding/v5/mapbox.places/${lng},${lat}.json?limit=1&access_token=${MAPBOX_TOKEN}`);
      const data = await res.json();
      if (data.features?.[0]) return data.features[0].place_name;
    } catch(e) { console.error(e); }
    return null;
  }

  window.openGoogleMapsDirection = (lat, lng) => {
    if (!userLocation) {
        // Use current location as origin if known, else trigger it
        window.open(`https://www.google.com/maps/dir/?api=1&destination=${lat},${lng}`, "_blank");
    } else {
        window.open(`https://www.google.com/maps/dir/?api=1&origin=${userLocation.lat},${userLocation.lng}&destination=${lat},${lng}`, "_blank");
    }
  };

  // Initial render empty state
  stationList.innerHTML = '<div class="col-span-full text-center py-8 text-gray-400">Vui lòng chọn khu vực  bạn muốn tìm trạm</div>';
});