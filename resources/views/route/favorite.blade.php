<!-- favorites.blade.php -->

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mis Rutas Favoritas') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

                    @if ($favoriteRoutes->count() > 0)
                            @foreach ($favoriteRoutes as $route)
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

                            @endforeach
                    @else
                    <div class="alert alert-warning mt-4 text-center">
                        <p>No tienes rutas favoritas.</p>
                    </div>
                    @endif
        </div>
    </div>
</x-app-layout>
