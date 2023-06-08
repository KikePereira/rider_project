<!-- favorites.blade.php -->

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mis Rutas') }}
        </h2>
        <br>
        <hr>
        <br>
        <div class="flex items-center">
        <a href="{{ route('profile.routes') }}" class="text-primary">Ultimas</a>
        <span class="separator">|</span>
        <a href="{{ route('profile.routes_likes') }}" class="text-primary flex items-center">Mas gustadas <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-hand-thumbs-up" viewBox="0 0 16 16">
  <path d="M8.864.046C7.908-.193 7.02.53 6.956 1.466c-.072 1.051-.23 2.016-.428 2.59-.125.36-.479 1.013-1.04 1.639-.557.623-1.282 1.178-2.131 1.41C2.685 7.288 2 7.87 2 8.72v4.001c0 .845.682 1.464 1.448 1.545 1.07.114 1.564.415 2.068.723l.048.03c.272.165.578.348.97.484.397.136.861.217 1.466.217h3.5c.937 0 1.599-.477 1.934-1.064a1.86 1.86 0 0 0 .254-.912c0-.152-.023-.312-.077-.464.201-.263.38-.578.488-.901.11-.33.172-.762.004-1.149.069-.13.12-.269.159-.403.077-.27.113-.568.113-.857 0-.288-.036-.585-.113-.856a2.144 2.144 0 0 0-.138-.362 1.9 1.9 0 0 0 .234-1.734c-.206-.592-.682-1.1-1.2-1.272-.847-.282-1.803-.276-2.516-.211a9.84 9.84 0 0 0-.443.05 9.365 9.365 0 0 0-.062-4.509A1.38 1.38 0 0 0 9.125.111L8.864.046zM11.5 14.721H8c-.51 0-.863-.069-1.14-.164-.281-.097-.506-.228-.776-.393l-.04-.024c-.555-.339-1.198-.731-2.49-.868-.333-.036-.554-.29-.554-.55V8.72c0-.254.226-.543.62-.65 1.095-.3 1.977-.996 2.614-1.708.635-.71 1.064-1.475 1.238-1.978.243-.7.407-1.768.482-2.85.025-.362.36-.594.667-.518l.262.066c.16.04.258.143.288.255a8.34 8.34 0 0 1-.145 4.725.5.5 0 0 0 .595.644l.003-.001.014-.003.058-.014a8.908 8.908 0 0 1 1.036-.157c.663-.06 1.457-.054 2.11.164.175.058.45.3.57.65.107.308.087.67-.266 1.022l-.353.353.353.354c.043.043.105.141.154.315.048.167.075.37.075.581 0 .212-.027.414-.075.582-.05.174-.111.272-.154.315l-.353.353.353.354c.047.047.109.177.005.488a2.224 2.224 0 0 1-.505.805l-.353.353.353.354c.006.005.041.05.041.17a.866.866 0 0 1-.121.416c-.165.288-.503.56-1.066.56z"/>
</svg></a>
        <span class="separator">|</span>
        <a href="{{ route('profile.routes_comments') }}" class="text-primary flex items-center">Mas comentadas <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chat-left-text" viewBox="0 0 16 16">
  <path d="M14 1a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H4.414A2 2 0 0 0 3 11.586l-2 2V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12.793a.5.5 0 0 0 .854.353l2.853-2.853A1 1 0 0 1 4.414 12H14a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
  <path d="M3 3.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zM3 6a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9A.5.5 0 0 1 3 6zm0 2.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5z"/>
</svg></a>
<span class="separator">|</span>

<a href="{{ route('profile.routes_privates') }}" class="text-primary">Rutas Privadas</a>

        </div>
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
                                                <h3 class=""><strong>{{ $route->user->nickname }}</strong> <span class="text-secondary">({{ $route->user->name }} {{ $route->user->first_surname }} {{ $route->user->second_surname }})</span></h3>
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

                                        <a href="{{ route('route.show', ['id' => $route->id]) }}" class="text-primary"><svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16">
                                    <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/>
                                    <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"/>
                                    </svg></a>

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
