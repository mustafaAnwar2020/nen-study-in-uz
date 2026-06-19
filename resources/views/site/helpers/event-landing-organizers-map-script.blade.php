@if(!empty($locationsJson))
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var mapEl = document.getElementById('eventLandingNenMap');
            if (!mapEl || typeof L === 'undefined') {
                return;
            }

            var eventLandingMap = L.map('eventLandingNenMap').setView([30.0444, 31.2357], 3);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 18
            }).addTo(eventLandingMap);

            var locations = @json($locationsJson);

            function showDetails(location) {
                return ''
                    + (location.name ? '<strong>' + location.name + '</strong><br>' : '')
                    + (location.address ? '<strong>Address:</strong> ' + location.address + '<br>' : '')
                    + (location.landLine ? '<strong>Landline:</strong> ' + location.landLine + '<br>' : '')
                    + (location.callCenter ? '<strong>Call Center:</strong> ' + location.callCenter + '<br>' : '')
                    + (location.email ? '<strong>Email:</strong> ' + location.email + '<br>' : '')
                    + (location.schedule ? '<strong>Schedule:</strong> ' + location.schedule + '<br>' : '');
            }

            for (var key in locations) {
                if (!Object.prototype.hasOwnProperty.call(locations, key)) {
                    continue;
                }
                var location = locations[key];
                var markerIcon = location.location_type === 'Main Offices'
                    ? L.divIcon({
                        html: '<i class="fa fa-map-marker" style="color: #dc3545; font-size: 30px; text-shadow: 2px 2px 4px rgba(0,0,0,0.5);"></i>',
                        className: 'custom-red-marker',
                        iconSize: [30, 30],
                        iconAnchor: [15, 30],
                        popupAnchor: [0, -30]
                    })
                    : new L.Icon.Default();

                L.marker(location.coords, { icon: markerIcon })
                    .addTo(eventLandingMap)
                    .bindPopup(showDetails(location));
            }

            document.querySelectorAll('#organizers .flag_map').forEach(function (flagLink) {
                flagLink.addEventListener('click', function () {
                    var countryCode = flagLink.getAttribute('data-code');
                    var location = locations[countryCode];
                    if (!location) {
                        return;
                    }

                    eventLandingMap.setView(location.coords, 5);

                    var markerIcon = location.location_type === 'Main Offices'
                        ? L.divIcon({
                            className: 'custom-red-marker',
                            html: '<i class="fa fa-map-marker" style="color: #dc3545; font-size: 30px; text-shadow: 2px 2px 4px rgba(0,0,0,0.5);"></i>',
                            iconSize: [30, 30],
                            iconAnchor: [15, 30],
                            popupAnchor: [0, -30]
                        })
                        : new L.Icon.Default();

                    var marker = L.marker(location.coords, { icon: markerIcon }).addTo(eventLandingMap);
                    marker.bindPopup(showDetails(location)).openPopup();
                });
            });
        });
    </script>
@endif
