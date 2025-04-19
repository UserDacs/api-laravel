<div class="row">
    <div class="col-md-3">

    </div>
    <div class="col-md-6">
        <div class="mb-3">
            <label for="user_id">Select Owner</label>
            <select name="user_id" id="user_id" class="form-control">
                @foreach (get_user_no_shop() as $user)
                    <option value="{{ $user->id }}"
                        {{ old('user_id', $shop->user_id ?? '') == $user->id ? 'selected' : '' }}>
                        {{ $user->name }}
                    </option>
                @endforeach
            </select>

        </div>
        <div class="mb-3">
            <label for="shop_name">Shop name</label>
            <input type="text" name="shop_name" class="form-control"
                value="{{ old('shop_name', $shop->shop_name ?? '') }}">
        </div>
        <div class="mb-3">
            <label for="shop_address">Shop Address</label>
            <input type="text" name="shop_address" class="form-control" id="shop_address"
                value="{{ old('shop_address', $shop->shop_address ?? '') }}">
        </div>
        <div class="mb-3">
            <label for="shop_details">Shop Details</label>
            <textarea name="shop_details" class="form-control" rows="5">{{ old('shop_details', $shop->shop_details ?? '') }}</textarea>

        </div>
        <!-- Search Box -->
        <div class="mb-3">
            <label for="map_search">Search Location</label>
            <input type="text" id="map_search" class="form-control" placeholder="Search shop location...">
        </div>

        <!-- Map Display -->
        <div class="mb-3">
            <div id="map" style="width: 100%; height: 250px;"></div>
        </div>

        <!-- Coordinates (read-only) -->
        <div class="mb-3" style="display: none">
            <label for="shop_lat">Shop Latitude</label>
            <input type="text" name="shop_lat" id="shop_lat" class="form-control"
                value="{{ old('shop_lat', $shop->shop_lat ?? '') }}" readonly>
        </div>

        <div class="mb-3" style="display: none">
            <label for="shop_long">Shop Longitude</label>
            <input type="text" name="shop_long" id="shop_long" class="form-control"
                value="{{ old('shop_long', $shop->shop_long ?? '') }}" readonly>
        </div>

        <!-- OpenStreetMap Leaflet JS -->
        <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>

        <script>
            const latInput = document.getElementById("shop_lat");
            const lngInput = document.getElementById("shop_long");
            const shopAddressInput = document.getElementById("shop_address");
            const searchInput = document.getElementById("map_search");

            const defaultLat = parseFloat(latInput.value) || 10.0808490; // Bohol default
            const defaultLng = parseFloat(lngInput.value) || 124.3429280;

            const map = L.map("map").setView([defaultLat, defaultLng], 13);

            L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
                attribution: "© OpenStreetMap contributors"
            }).addTo(map);

            const marker = L.marker([defaultLat, defaultLng], {
                draggable: true
            }).addTo(map);

            marker.on("dragend", function(e) {
                const latlng = marker.getLatLng();
                confirmAndSet(latlng.lat, latlng.lng);
            });

            map.on("click", function(e) {
                marker.setLatLng(e.latlng);
                confirmAndSet(e.latlng.lat, e.latlng.lng);
            });

            function confirmAndSet(lat, lng) {
                if (confirm("Is this your shop location?")) {
                    latInput.value = lat.toFixed(6);
                    lngInput.value = lng.toFixed(6);
                    // Call reverse geocoding to get the address
                    getAddressFromLatLng(lat, lng);
                }
            }

            // Reverse Geocoding using OpenStreetMap Nominatim API
            function getAddressFromLatLng(lat, lng) {
                fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}&addressdetails=1`)
                    .then(response => response.json())
                    .then(data => {
                        console.log(data);

                        if (data && data.address) {
                            const address = data.address;
                            const fullAddress =
                                `${address.village || ''} ${address.town || ''}, ${address.state || ''} ${address.postcode || ''} , ${address.country || ''} `;
                            console.log(fullAddress);
                            shopAddressInput.value = data.display_name;
                            // shopAddressInput.value = fullAddress;  // Set the address in the input field
                        }
                    })
                    .catch(err => {
                        console.error("Error fetching address:", err);
                    });
            }

            // Search using OpenStreetMap Nominatim API
            searchInput.addEventListener("keypress", function(e) {
                if (e.key === "Enter") {
                    e.preventDefault();
                    const query = searchInput.value;
                    fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}`)
                        .then(res => res.json())
                        .then(data => {
                            if (data && data.length > 0) {
                                const result = data[0];
                                const lat = parseFloat(result.lat);
                                const lon = parseFloat(result.lon);
                                map.setView([lat, lon], 15);
                                marker.setLatLng([lat, lon]);
                                confirmAndSet(lat, lon);
                            } else {
                                alert("No results found.");
                            }
                        });
                }
            });
        </script>
        <button type="submit" class="btn btn-primary w-100px me-5px">Save</button>
        <a href="javascript:;" class="btn btn-default w-100px">Cancel</a>
    </div>
    <div class="col-md-3">

    </div>
</div>
