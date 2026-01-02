document.addEventListener("DOMContentLoaded", function () {

  /*********************************
   * MAPBOX TOKEN
   *********************************/
  const MAPBOX_TOKEN = "pk.eyJ1Ijoic29pY2FjYTc3IiwiYSI6ImNtanBwM2NrNjJjczIzZXB5aTFsejhvMTcifQ.PycPOcu1-ch0-NXaz82bWA"; // 👈 token Mapbox của bạn

  /*********************************
   * DATA: QUẬN / HUYỆN
   *********************************/
  const districtsByCity = {
    hcm: [
      { id: "q1", name: "Quận 1", lat: 10.7769, lng: 106.7009 },
      { id: "q7", name: "Quận 7", lat: 10.734, lng: 106.7216 },
      { id: "td", name: "TP. Thủ Đức", lat: 10.8456, lng: 106.7645 }
    ]
  };

  /*********************************
   * DATA: TRẠM
   *********************************/
  const stationsByDistrict = {
  q1: [
    {
      name: "Trạm Nguyễn Huệ",
      address: "12 Nguyễn Huệ, Quận 1, TP.HCM",
      lat: 10.7758,
      lng: 106.703,
      cars: 8,
      bikes: 12
    },
    {
      name: "Trạm Bến Thành",
      address: "Chợ Bến Thành, Quận 1, TP.HCM",
      lat: 10.7725,
      lng: 106.698,
      cars: 4,
      bikes: 6
    }
  ]
};


  /*********************************
   * MAP INIT
   *********************************/
  const map = L.map("map").setView([10.7769, 106.7009], 12);
  L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
    attribution: "&copy; OpenStreetMap contributors"
  }).addTo(map);

  let userLocation = null;
  let userMarker = null;

  /*********************************
   * DOM
   *********************************/
  const citySelect = document.getElementById("citySelect");
  const districtSelect = document.getElementById("districtSelect");
  const stationList = document.getElementById("stationList");
  const addressInput = document.getElementById("addressInput");
  const addressSuggest = document.getElementById("addressSuggest");

  /*********************************
   * HELPER: SET USER MARKER
   *********************************/
  function setUserMarker(text) {
    if (!userLocation) return;
    if (userMarker) map.removeLayer(userMarker);

    userMarker = L.marker([userLocation.lat, userLocation.lng])
      .addTo(map)
      .bindPopup(text)
      .openPopup();
  }

  /*********************************
   * AUTOCOMPLETE ĐỊA CHỈ (MAPBOX)
   * 👉 ĐỊA CHỈ NÀY = VỊ TRÍ CỦA TÔI
   *********************************/
  let debounceTimer = null;

  addressInput.addEventListener("input", function () {
    const query = this.value.trim();
    addressSuggest.innerHTML = "";
    addressSuggest.classList.add("hidden");

    if (query.length < 3) return;

    clearTimeout(debounceTimer);
    debounceTimer = setTimeout(async () => {
      try {
        const url =
          `https://api.mapbox.com/geocoding/v5/mapbox.places/${encodeURIComponent(query)}.json` +
          `?autocomplete=true&country=VN&language=vi&limit=6&access_token=${MAPBOX_TOKEN}`;

        const res = await fetch(url);
        if (!res.ok) return;

        const data = await res.json();
        if (!data.features || data.features.length === 0) return;

        addressSuggest.classList.remove("hidden");

        data.features.forEach(item => {
          const li = document.createElement("li");
          li.className = "px-3 py-2 cursor-pointer hover:bg-blue-50";

          li.innerHTML = `
            <div class="font-medium text-sm">${item.text}</div>
            <div class="text-xs text-gray-500">${item.place_name}</div>
          `;

          li.onclick = () => {
            addressInput.value = item.place_name;
            addressSuggest.classList.add("hidden");

            // ⚠️ Mapbox trả về [lng, lat]
            const [lng, lat] = item.center;

            // 👉 ĐÂY CHÍNH LÀ VỊ TRÍ CỦA BẠN
           userLocation = { lat, lng };
            window.userLocation = userLocation; // 👈 BẮT BUỘC


            setUserMarker("📍 Vị trí của bạn");
            map.setView([lat, lng], 16);

            if (districtSelect.value) {
              renderStations(districtSelect.value);
            }
          };

          addressSuggest.appendChild(li);
        });
      } catch (err) {
        console.error("Mapbox autocomplete error:", err);
      }
    }, 350);
  });

  /*********************************
   * CLICK MAP → CHỌN VỊ TRÍ THỦ CÔNG
   *********************************/
  map.on("click", (e) => {
    userLocation = {
        lat: e.latlng.lat,
        lng: e.latlng.lng
    };
    window.userLocation = userLocation; // 👈 BẮT BUỘC

    setUserMarker("📍 Vị trí của bạn");
    if (districtSelect.value) {
      renderStations(districtSelect.value);
    }
  });

  /*********************************
   * EVENT: CHỌN THÀNH PHỐ
   *********************************/
  citySelect.addEventListener("change", () => {
    const city = citySelect.value;
    districtSelect.innerHTML = `<option value="">-- Chọn Quận / Huyện --</option>`;
    stationList.innerHTML = "";

    if (!districtsByCity[city]) return;

    districtsByCity[city].forEach(d => {
      const opt = document.createElement("option");
      opt.value = d.id;
      opt.textContent = d.name;
      districtSelect.appendChild(opt);
    });

    map.setView(
      [districtsByCity[city][0].lat, districtsByCity[city][0].lng],
      12
    );
  });

  /*********************************
   * EVENT: CHỌN QUẬN / HUYỆN
   *********************************/
  districtSelect.addEventListener("change", () => {
    renderStations(districtSelect.value);
  });

  /*********************************
   * DISTANCE – HAVERSINE
   *********************************/
  function calcDistance(lat1, lng1, lat2, lng2) {
    const R = 6371;
    const toRad = d => d * Math.PI / 180;

    const dLat = toRad(lat2 - lat1);
    const dLng = toRad(lng2 - lng1);

    const a =
      Math.sin(dLat / 2) ** 2 +
      Math.cos(toRad(lat1)) *
      Math.cos(toRad(lat2)) *
      Math.sin(dLng / 2) ** 2;

    return R * (2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a)));
  }

  /*********************************
   * RENDER STATIONS
   *********************************/
  function renderStations(districtId) {
  stationList.innerHTML = "";
  let stations = stationsByDistrict[districtId] || [];

  // Sắp xếp theo khoảng cách
  if (userLocation) {
    stations = stations.slice().sort((a, b) =>
      calcDistance(userLocation.lat, userLocation.lng, a.lat, a.lng) -
      calcDistance(userLocation.lat, userLocation.lng, b.lat, b.lng)
    );
  }

  stations.forEach(s => {
    // Khoảng cách
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

    const card = document.createElement("div");
    card.className = "bg-white rounded-xl shadow p-4 flex flex-col";

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

    const btn = document.createElement("button");
    btn.className =
      "mt-auto w-full px-4 py-2 rounded-lg text-white font-semibold";
    btn.style.background = "#2563eb";
    btn.textContent = "🧭 Chỉ đường";

    btn.addEventListener("click", () => {
      openGoogleMapsDirection(s.lat, s.lng);
    });

    card.appendChild(btn);
    stationList.appendChild(card);
  });
  }



});


function openGoogleMapsDirection(destLat, destLng) {
  if (!window.userLocation) {
    alert("Vui lòng nhập hoặc chọn vị trí của bạn trước");
    return;
  }

  const origin = `${window.userLocation.lat},${window.userLocation.lng}`;
  const destination = `${destLat},${destLng}`;

  const url =
    `https://www.google.com/maps/dir/?api=1` +
    `&origin=${origin}` +
    `&destination=${destination}` +
    `&travelmode=driving`;

  window.open(url, "_blank");
}
