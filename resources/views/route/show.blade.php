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

                <div class='row'>
                    <div class="col-6">
                    @if($route->likedByCurrentUser())
                        <form action="{{ route('route.unlike', $route->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <span>{{ $route->likes()->count() }}</span>

                            <button type="submit" class="text-success mt-2"><svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-hand-thumbs-up-fill" viewBox="0 0 16 16">
                            <path d="M6.956 1.745C7.021.81 7.908.087 8.864.325l.261.066c.463.116.874.456 1.012.965.22.816.533 2.511.062 4.51a9.84 9.84 0 0 1 .443-.051c.713-.065 1.669-.072 2.516.21.518.173.994.681 1.2 1.273.184.532.16 1.162-.234 1.733.058.119.103.242.138.363.077.27.113.567.113.856 0 .289-.036.586-.113.856-.039.135-.09.273-.16.404.169.387.107.819-.003 1.148a3.163 3.163 0 0 1-.488.901c.054.152.076.312.076.465 0 .305-.089.625-.253.912C13.1 15.522 12.437 16 11.5 16H8c-.605 0-1.07-.081-1.466-.218a4.82 4.82 0 0 1-.97-.484l-.048-.03c-.504-.307-.999-.609-2.068-.722C2.682 14.464 2 13.846 2 13V9c0-.85.685-1.432 1.357-1.615.849-.232 1.574-.787 2.132-1.41.56-.627.914-1.28 1.039-1.639.199-.575.356-1.539.428-2.59z"/>
                            </svg></button>
                        </form>
                    @else
                        <form action="{{ route('route.like', $route->id) }}" method="POST">
                            @csrf
                            <span>{{ $route->likes()->count() }}</span>

                            <button type="submit" class="text-success mt-2"><svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-hand-thumbs-up" viewBox="0 0 16 16">
                            <path d="M8.864.046C7.908-.193 7.02.53 6.956 1.466c-.072 1.051-.23 2.016-.428 2.59-.125.36-.479 1.013-1.04 1.639-.557.623-1.282 1.178-2.131 1.41C2.685 7.288 2 7.87 2 8.72v4.001c0 .845.682 1.464 1.448 1.545 1.07.114 1.564.415 2.068.723l.048.03c.272.165.578.348.97.484.397.136.861.217 1.466.217h3.5c.937 0 1.599-.477 1.934-1.064a1.86 1.86 0 0 0 .254-.912c0-.152-.023-.312-.077-.464.201-.263.38-.578.488-.901.11-.33.172-.762.004-1.149.069-.13.12-.269.159-.403.077-.27.113-.568.113-.857 0-.288-.036-.585-.113-.856a2.144 2.144 0 0 0-.138-.362 1.9 1.9 0 0 0 .234-1.734c-.206-.592-.682-1.1-1.2-1.272-.847-.282-1.803-.276-2.516-.211a9.84 9.84 0 0 0-.443.05 9.365 9.365 0 0 0-.062-4.509A1.38 1.38 0 0 0 9.125.111L8.864.046zM11.5 14.721H8c-.51 0-.863-.069-1.14-.164-.281-.097-.506-.228-.776-.393l-.04-.024c-.555-.339-1.198-.731-2.49-.868-.333-.036-.554-.29-.554-.55V8.72c0-.254.226-.543.62-.65 1.095-.3 1.977-.996 2.614-1.708.635-.71 1.064-1.475 1.238-1.978.243-.7.407-1.768.482-2.85.025-.362.36-.594.667-.518l.262.066c.16.04.258.143.288.255a8.34 8.34 0 0 1-.145 4.725.5.5 0 0 0 .595.644l.003-.001.014-.003.058-.014a8.908 8.908 0 0 1 1.036-.157c.663-.06 1.457-.054 2.11.164.175.058.45.3.57.65.107.308.087.67-.266 1.022l-.353.353.353.354c.043.043.105.141.154.315.048.167.075.37.075.581 0 .212-.027.414-.075.582-.05.174-.111.272-.154.315l-.353.353.353.354c.047.047.109.177.005.488a2.224 2.224 0 0 1-.505.805l-.353.353.353.354c.006.005.041.05.041.17a.866.866 0 0 1-.121.416c-.165.288-.503.56-1.066.56z"/>
                            </svg></button>
                        </form>
                    @endif
                    </div>
                    <div class="col-6 d-flex justify-content-end">

                    @if ($route->isFavorite())
                        <form action="{{ route('route.unfavorite', $route->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="text-warning"><svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                            <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                            </svg></button>
                        </form>
                    @else
                        <form action="{{ route('route.favorite', $route->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="text-warning"><svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-star" viewBox="0 0 16 16">
                            <path d="M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256 4.389 2.256c.386.198.824-.149.746-.592l-.83-4.73 3.522-3.356c.33-.314.16-.888-.282-.95l-4.898-.696L8.465.792a.513.513 0 0 0-.927 0L5.354 5.12l-4.898.696c-.441.062-.612.636-.283.95l3.523 3.356-.83 4.73zm4.905-2.767-3.686 1.894.694-3.957a.565.565 0 0 0-.163-.505L1.71 6.745l4.052-.576a.525.525 0 0 0 .393-.288L8 2.223l1.847 3.658a.525.525 0 0 0 .393.288l4.052.575-2.906 2.77a.565.565 0 0 0-.163.506l.694 3.957-3.686-1.894a.503.503 0 0 0-.461 0z"/>
                            </svg></button>
                        </form>
                    @endif
                    </div>
                    </div>

                    <div class="mt-4 mb-2 d-flex justify-content-end">
                    @if(Auth::check() && $route->user_id == Auth::user()->id)
                    <div class="flex items-center">
                    <a href="{{ route('route.edit', $route->id) }}" class="mr-2 flex items-center"><svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                    <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                    <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                    </svg></a>
                    <a href="{{ route('route.confirm-delete', $route->id) }}" class="text-danger ml-2"><svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-trash3-fill" viewBox="0 0 16 16">
                    <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z"/>
                    </svg></a>
                    </div>
                    @endif
                    @if ($route->is_report == 0)
                        <a href="{{ route('route.report', $route->id) }}" class="text-secondary ml-2"><svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-megaphone-fill" viewBox="0 0 16 16">
  <path d="M13 2.5a1.5 1.5 0 0 1 3 0v11a1.5 1.5 0 0 1-3 0v-11zm-1 .724c-2.067.95-4.539 1.481-7 1.656v6.237a25.222 25.222 0 0 1 1.088.085c2.053.204 4.038.668 5.912 1.56V3.224zm-8 7.841V4.934c-.68.027-1.399.043-2.008.053A2.02 2.02 0 0 0 0 7v2c0 1.106.896 1.996 1.994 2.009a68.14 68.14 0 0 1 .496.008 64 64 0 0 1 1.51.048zm1.39 1.081c.285.021.569.047.85.078l.253 1.69a1 1 0 0 1-.983 1.187h-.548a1 1 0 0 1-.916-.599l-1.314-2.48a65.81 65.81 0 0 1 1.692.064c.327.017.65.037.966.06z"/>
</svg></a>
                    @endif
                    </div>

                    <br>
                    <a href="{{ url()->previous() }}" class="btn btn-primary form-control"> Volver</a>
                </div>
                <form action="{{ route('route.comment', $route->id) }}" method="POST" class="p-2">
                    @csrf
                    <div class="form-group">
                        <textarea name="content" class="form-control" rows="3" placeholder="Escribe tu comentario"></textarea>
                    </div> <br>
                    <button type="submit" class=" form-control btn btn-unstyle text-primary text-center">Enviar comentario <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-chat-left-text" viewBox="0 0 16 16">
  <path d="M14 1a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H4.414A2 2 0 0 0 3 11.586l-2 2V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12.793a.5.5 0 0 0 .854.353l2.853-2.853A1 1 0 0 1 4.414 12H14a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
  <path d="M3 3.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zM3 6a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9A.5.5 0 0 1 3 6zm0 2.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5z"/>
</svg></button>
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
                    
                    @if ($comment->is_report == 0)
                        <a href="{{ route('comment.report', $comment->id) }}" class="text-primary mr-2">Reportar</a>
                    @endif

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
