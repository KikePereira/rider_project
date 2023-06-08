<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center">
            {{ __('Vista de Ruta') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-4">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="grid grid-cols-2 gap-4 row">
                        <div class="">
                            <h3 class="text-lg font-medium mb-4"> <strong> {{ $route->title }} </strong></h3>
                            <p>{{ $route->description }}</p>

                            <!-- USUARIO -->
                            <br>
                            @if ($route->user->id === Auth::user()->id)
                                <a href="{{ route('profile') }}" class="">
                            @else
                                <a href="{{ route('user.profile', $route->user->id) }}" class="">
                            @endif
                                <p><strong>{{$route->user->nickname}} </strong> <span class="text-secondary">({{ $route->user->name}} {{ $route->user->first_surname }} {{ $route->user->second_surname }})</span></p>
                                @if($route->user->motorbike)
                                <p> <strong> Moto: </strong> {{ $route->user->motorbike->brand }} {{ $route->user->motorbike->model }} {{ $route->user->motorbike->year }}</p>
                                @endif
                            </a>
                            <br>
                                        @if ($route->visibility == 'friends')
                                            <span class="text-secondary">Visibilidad: Amigos</span>
                                        @elseif ($route->visibility == 'private')
                                            <span class="text-secondary">Visibilidad: Privado</span>
                                        @elseif ($route->visibility == 'public')
                                            <span class="text-secondary">Visibilidad: Público</span>
                                        @endif
                            <p class="d-flex justify-content-end text-secondary">{{ $route->created_at }}</p>
                        </div>

                        <div class="">
                            <div id="map" style="width: 100%; height:600px;"></div>
                        </div>
                    </div>


                    @if($route->likedByCurrentUser())
                        <form action="{{ route('route.unlike', $route->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <span>{{ $route->likes()->count() }} Likes</span>

                            <button type="submit" class="text-danger">Quitar Like</button>
                        </form>
                    @else
                        <form action="{{ route('route.like', $route->id) }}" method="POST">
                            @csrf
                            <span>{{ $route->likes()->count() }} Likes</span>

                            <button type="submit" class="text-success">Like</button>
                        </form>
                    @endif

                    @if ($route->isFavorite())
                        <form action="{{ route('route.unfavorite', $route->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="text-danger">Quitar de favoritos</button>
                        </form>
                    @else
                        <form action="{{ route('route.favorite', $route->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="text-primary">Agregar a favoritos</button>
                        </form>
                    @endif

                    <div class="mt-2 mb-2">
                    @if(Auth::check() && $route->user_id == Auth::user()->id)
                    <a href="{{ route('route.edit', $route->id) }}" class="mr-2">Editar ruta</a>
                    <a href="{{ route('route.confirm-delete', $route->id) }}" class="text-danger ml-2">Eliminar ruta</a>
                    @endif
                    </div>
                    <br>
                    <a href="{{ url()->previous() }}" class="btn btn-primary form-control">Volver</a>
                </div>
                <form action="{{ route('route.comment', $route->id) }}" method="POST" class="p-2">
                    @csrf
                    <div class="form-group">
                        <textarea name="content" class="form-control" rows="3" placeholder="Escribe tu comentario"></textarea>
                    </div> <br>
                    <button type="submit" class=" form-control text-primary text-center">Enviar comentario</button>
                </form>
            </div>

            <div >
            @foreach ($route->comments as $comment)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-4 p-2">
                    @if ($comment->user->id === Auth::user()->id)
                        <a href="{{ route('profile') }}" class="">
                    @else
                        <a href="{{ route('user.profile', $comment->user->id) }}" class="">
                    @endif
                    <h4> <strong>{{ $comment->user->nickname }}</strong> <span class="text-secondary">({{ $route->user->name}} {{ $route->user->first_surname }} {{ $route->user->second_surname }})</span></h4>
                    </a>
                    <p class="mt-2">{{ $comment->content }}</p>

                    <small class="d-flex justify-content-end text-secondary"> 
                        
                    <span class="mr-2">{{ $comment->created_at }}</span>

                    @if($comment->user_id == Auth::user()->id)
                        <form action="{{ route('comment.destroy', $comment->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-danger">Eliminar comentario</button>
                        </form>
                    @endif
                    </small>
                </div>
            @endforeach
            </div>

            <script>
                var map = L.map('map');

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors',
                    maxZoom: 18,
                }).addTo(map);

                var startLatLng = L.latLng({{ $route->start_location_lat }}, {{ $route->start_location_lng }});
                var endLatLng = L.latLng({{ $route->end_location_lat }}, {{ $route->end_location_lng }});

                // Agregar marcadores de inicio y fin
                L.marker(startLatLng).addTo(map);
                L.marker(endLatLng).addTo(map);

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
                        var routeLayer = L.polyline(routePoints, { color: 'blue' }).addTo(map);

                        // Ajustar la vista del mapa para mostrar toda la ruta
                        var bounds = L.latLngBounds(routePoints);
                        map.fitBounds(bounds);
                    })
                    .catch(error => {
                        console.error('Error al obtener la ruta:', error);
                    });
            </script>
        </div>
    </div>
</x-app-layout>
