<!-- favorites.blade.php -->

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Rutas') }} de {{$user->nickname}}
        </h2>
        <br>
        <hr>
        <br>
        <a href="{{ route('user.routes', ['userId' => $user->id]) }}" class="text-primary">Ultimas</a>
        <span class="separator">|</span>
        <a href="{{ route('user.routes_likes', ['userId' => $user->id]) }}" class="text-primary">Mas gustadas</a>
        <span class="separator">|</span>
        <a href="{{ route('user.routes_comments', ['userId' => $user->id]) }}" class="text-primary">Mas comentadas</a>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

                    @if ($routes->count() > 0)
                            @foreach ($routes as $route)
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
                                        </div>

                                        @if ($route->visibility == 'friends')
                                            <span class="text-secondary">Visibilidad: Amigos</span>
                                        @elseif ($route->visibility == 'private')
                                            <span class="text-secondary">Visibilidad: Privado</span>
                                        @elseif ($route->visibility == 'public')
                                            <span class="text-secondary">Visibilidad: Público</span>
                                        @endif

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
                            <div class="pagination d-flex justify-content-center">
                                {{ $routes->render('pagination::bootstrap-4') }}
                            </div>

                    @else
                    <div class="alert alert-warning mt-4 text-center">
                        <p>No tienes rutas favoritas.</p>
                    </div>
                    @endif
        </div>
    </div>
</x-app-layout>
