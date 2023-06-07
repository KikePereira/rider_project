<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Crear ruta') }}
        </h2>
    </x-slot>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h1 class="text-lg font-medium mb-4"><strong>Crear nueva ruta</strong></h1>

                    <!-- Formulario de creación de ruta -->
                    <form action="{{ route('route.store') }}" method="POST">
                        @csrf

                        <div id="map" class="mb-4" style="width: auto; height:500px;"></div>
                        @error('start_location')
                            <p class="text-danger text-xs mt-1 mb-3">{{ $message }}</p>
                        @enderror

                        @error('end_location')
                            <p class="text-danger text-xs mt-1 mb-3">{{ $message }}</p>
                        @enderror

                        <div class="mb-4">
                            <label for="title" class="block text-gray-700 text-sm font-bold mb-2">Titulo:</label>
                            <input type="text" name="title" id="title" value="{{ old('title') }}" class="form-control">
                            @error('title')
                                <p class="text-danger text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Descripción:</label>
                            <textarea name="description" id="description" class="form-control">{{ old('description') }}</textarea>
                            @error('description')
                                <p class="text-danger text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>


                        <div class="mb-4" hidden>
                            <label for="start_location" class="block text-gray-700 text-sm font-bold mb-2">Ubicación de inicio:</label>
                            <input type="text" name="start_location" id="start_location" class="form-control places-autocomplete">

                        </div>

                        <div class="mb-4" hidden>
                            <label for="end_location" class="block text-gray-700 text-sm font-bold mb-2">Ubicación de fin:</label>
                            <input type="text" name="end_location" id="end_location" class="form-control places-autocomplete">
                        </div>

                        <!-- Otros campos de la ruta -->

                            <input type="submit" class="text-primary">
                    </form>

                    
                </div>
            </div>
        </div>
    </div>

    <script>
        var map = L.map('map').setView([37.2615, -6.9447], 13);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors',
            maxZoom: 18,
        }).addTo(map);

        // Variables para almacenar los marcadores de inicio y destino
        var startMarker = null;
        var endMarker = null;

        // Manejador de clic en el mapa
        function onMapClick(e) {
            var clickedLatLng = e.latlng;

            if (!startMarker) {
                // Agregar marcador de inicio
                startMarker = L.marker(clickedLatLng, {
                    draggable: true
                }).addTo(map);
                startMarker.bindPopup('Ubicación de inicio').openPopup();
                console.log(startMarker);
                updateStartLocationForm(startMarker['_latlng']);
            } else if (!endMarker) {
                // Agregar marcador de destino
                endMarker = L.marker(clickedLatLng, {
                    draggable: true
                }).addTo(map);
                endMarker.bindPopup('Ubicación de destino').openPopup();
                updateEndLocationForm(endMarker['_latlng']);

                // Calcular y mostrar la ruta entre los puntos
                calculateRoute(startMarker.getLatLng(), endMarker.getLatLng());

                // Deshabilitar el clic en el mapa
                map.off('click', onMapClick);
            }
                            // Manejador de evento al finalizar el arrastre del marcador de inicio
                            startMarker.on('dragend', function (event) {
                    calculateRoute(startMarker.getLatLng(), endMarker.getLatLng());
                    updateStartLocationForm(startMarker['_latlng']);
                });

                               // Manejador de evento al finalizar el arrastre del marcador de destino
                               endMarker.on('dragend', function (event) {
                    calculateRoute(startMarker.getLatLng(), endMarker.getLatLng());
                    updateEndLocationForm(endMarker['_latlng']);
                });
        }
        // Variables para almacenar la capa de la ruta
        var routeLayer = null;

        // Calcular y mostrar la ruta entre los puntos de inicio y destino
        function calculateRoute(startLatLng, endLatLng) {
            var url = 'https://api.openrouteservice.org/v2/directions/driving-car?api_key=5b3ce3597851110001cf6248d901aa0529a7499cb5f3a887098de81b' +
                '&start=' + startLatLng.lng + ',' + startLatLng.lat +
                '&end=' + endLatLng.lng + ',' + endLatLng.lat;

            fetch(url)
                .then(response => response.json())
                .then(data => {
                    var coordinates = data.features[0].geometry.coordinates;

                    var routeCoordinates = coordinates.map(coordinate => {
                        return [coordinate[1], coordinate[0]];
                    });

                    // Borrar ruta anterior (si existe)
                    if (routeLayer) {
                        map.removeLayer(routeLayer);
                    }

                    // Dibujar nueva ruta
                    routeLayer = L.polyline(routeCoordinates, {
                        color: 'blue',
                        weight: 4,
                        opacity: 0.6
                    }).addTo(map);
                });
        }

        // Función para actualizar las coordenadas del punto de inicio en el formulario
            function updateStartLocationForm(latlng) {
                var startLocationInput = document.getElementById('start_location');
                startLocationInput.value = latlng.lat + ',' + latlng.lng;
            }

            // Función para actualizar las coordenadas del punto de inicio en el formulario
            function updateEndLocationForm(latlng) {
                var startLocationInput = document.getElementById('end_location');
                startLocationInput.value = latlng.lat + ',' + latlng.lng;
            }

        map.on('click', onMapClick);
    </script>

</x-app-layout>

