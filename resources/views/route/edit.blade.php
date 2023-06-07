<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar ruta') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h1 class="text-lg font-medium mb-4"><strong>Editar ruta</strong></h1>

                    <!-- Formulario de edición de ruta -->
                    <form action="{{ route('route.update', $route->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div id="map" class="mb-4" style="width: auto; height:500px;"></div>

                        <div class="mb-4">
                            <label for="title" class="block text-gray-700 text-sm font-bold mb-2">Titulo:</label>
                            <input type="text" name="title" id="title" value="{{ $route->title }}" class="form-control">
                            @error('title')
                                <p class="text-danger text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Descripción:</label>
                            <textarea name="description" id="description" class="form-control">{{ $route->description }}</textarea>
                            @error('description')
                                <p class="text-danger text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4" hidden>
                            <label for="start_location_lat" class="block text-gray-700 text-sm font-bold mb-2">Ubicación de inicio Lat:</label>
                            <input type="text" name="start_location_lat" id="start_location_lat" value="{{ $route->start_location_lat }}" class="form-control">
                        </div>
                        <div class="mb-4" hidden>
                            <label for="start_location_lng" class="block text-gray-700 text-sm font-bold mb-2">Ubicación de inicio Lng:</label>
                            <input type="text" name="start_location_lng" id="start_location_lng" value="{{ $route->start_location_lng }}" class="form-control">
                        </div>

                        <div class="mb-4" hidden>
                            <label for="end_location_lat" class="block text-gray-700 text-sm font-bold mb-2">Ubicación de fin Lat:</label>
                            <input type="text" name="end_location_lat" id="end_location_lat" value="{{ $route->end_location_lat }}" class="form-control">
                        </div>
                        
                        <div class="mb-4" hidden>
                            <label for="end_location_lng" class="block text-gray-700 text-sm font-bold mb-2">Ubicación de fin Lng:</label>
                            <input type="text" name="end_location_lng" id="end_location_lng" value="{{ $route->end_location_lng }}" class="form-control">
                        </div>

                        <!-- Otros campos de la ruta -->

                        <div class="flex items-center justify-end mt-4">
                            <input type="submit" class="text-primary">
                        </div>
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
        var startMarker = L.marker([{{ $route->start_location_lat }}, {{ $route->start_location_lng }}], {
            draggable: true
        }).addTo(map);
        startMarker.bindPopup('Ubicación de inicio').openPopup();

        var endMarker = L.marker([{{ $route->end_location_lat }}, {{ $route->end_location_lng }}], {
            draggable: true
        }).addTo(map);
        endMarker.bindPopup('Ubicación de destino').openPopup();

        // Manejador de evento al finalizar el arrastre del marcador de inicio
        startMarker.on('dragend', function(event) {
            updateStartLocationForm(startMarker.getLatLng());
        });

        // Manejador de evento al finalizar el arrastre del marcador de destino
        endMarker.on('dragend', function(event) {
            updateEndLocationForm(endMarker.getLatLng());
        });

        // Función para actualizar las coordenadas de inicio en el formulario
        function updateStartLocationForm(latlng) {
            var startLocationLatInput = document.getElementById('start_location_lat');
            var startLocationLngInput = document.getElementById('start_location_lng');
            startLocationLatInput.value = latlng.lat;
            startLocationLngInput.value = latlng.lng;
        }

        // Función para actualizar las coordenadas de fin en el formulario
        function updateEndLocationForm(latlng) {
            var endLocationLatInput = document.getElementById('end_location_lat');
            var endLocationLngInput = document.getElementById('end_location_lng');
            endLocationLatInput.value = latlng.lat;
            endLocationLngInput.value = latlng.lng;
        }
    </script>
</x-app-layout>
