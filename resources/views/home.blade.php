<x-app-layout>
    <x-slot name="header">
        <div class="row">
        <div class="col-12 col-md-6">
            <a href="{{ route('route.create') }}" class="btn btn-primary mt-2 form-control">Añadir ruta</a>
        </div>
        <div class=" col-12 col-md-6">
            <form action="{{ route('route.search') }}" method="GET">
                <div class="">
                    <input type="text" name="nickname" id="nickname" class="mt-2 form-control" placeholder="Ingrese el nombre del usuario">
                    <button type="submit" class="text-primary">Buscar</button>
                </div>
            </form>
        </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @foreach($routes as $route)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-4">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="grid grid-cols-2 gap-4 row">
                        <div class="col-6">
                                <h1 class="text-lg font-medium mb-4"> <strong>{{ $route->title }} </strong> </h1>
                                @if ($route->user->id === Auth::user()->id)
                                <a href="{{ route('profile') }}" class="">
                                @else
                                <a href="{{ route('user.profile', $route->user->id) }}" class="">
                                @endif
                                    <h3> <strong>{{ $route->user->nickname }}</strong> <span class="text-secondary">({{ $route->user->name }} {{ $route->user->first_surname }} {{ $route->user->second_surname }})</span></h3>
                                </a>
                                <br>
                                <p>{{ $route->description }}</p>
                                <!-- Muestra otros detalles de la ruta según tus necesidades -->
                            </div>

                            <p><span class="mr-2">Likes: {{ $route->likes()->count() }} </span>

                            <span class="ml-2">Comentarios: {{ $route->comments->count() }}</span></p>

                            <div class="">
                                <div id="map-{{ $route->id }}" style="width: auto; height:200px;"></div>
                            </div>

                            <a href="{{ route('route.show', ['id' => $route->id]) }}" class="text-primary">Ver ruta</a>

                        </div>
                    </div>
                </div>

                <script>
                    var map{{ $route->id }} = L.map('map-{{ $route->id }}');

                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors',
                        maxZoom: 18,
                    }).addTo(map{{ $route->id }});

                    var startLatLng = L.latLng({{ $route->start_location_lat }}, {{ $route->start_location_lng }});
                    var endLatLng = L.latLng({{ $route->end_location_lat }}, {{ $route->end_location_lng }});

                    // Agregar marcadores de inicio y fin
                    L.marker(startLatLng).addTo(map{{ $route->id }});
                    L.marker(endLatLng).addTo(map{{ $route->id }});

                    // Realizar solicitud a la API de Openrouteservice
                    var apiKey = '5b3ce3597851110001cf6248d901aa0529a7499cb5f3a887098de81b'; // Reemplaza con tu propia clave de API de Openrouteservice
                    var url = 'https://api.openrouteservice.org/v2/directions/driving-car?api_key=' + apiKey +
                        '&start=' + startLatLng.lng + ',' + startLatLng.lat +
                        '&end=' + endLatLng.lng + ',' + endLatLng.lat;

                    fetch(url)
                        .then(response => response.json())
                        .then(data => {
                            var routeCoordinates = data.features[0].geometry.coordinates;
                            var routePoints = routeCoordinates.map(coord => L.latLng(coord[1], coord[0]));

                            // Dibujar la ruta
                            var routeLayer = L.polyline(routePoints, { color: 'blue' }).addTo(map{{ $route->id }});

                            // Ajustar la vista del mapa para mostrar toda la ruta
                            var bounds = L.latLngBounds(routePoints);
                            map{{ $route->id }}.fitBounds(bounds);
                        })
                        .catch(error => {
                            console.error('Error al obtener la ruta:', error);
                        });
                </script>
            @endforeach
        </div>
        <div class="pagination d-flex justify-content-center">
            {{ $routes->render('pagination::bootstrap-4') }}
        </div>

    </div>
</x-app-layout>
