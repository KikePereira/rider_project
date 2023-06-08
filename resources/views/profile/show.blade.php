<!-- show.blade.php -->

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Perfil de ') }} {{$user->nickname}}
        </h2>
        <br>
            <hr>
            <br>
            <a href="{{ route('user.routes', ['userId' => $user->id]) }}" class="text-primary">Ver Rutas</a>

    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">                   
                    <h1 class="text-lg font-medium mb-4"><strong>{{ $user->nickname }}</strong></h1>
                    <p><strong>Nombre:</strong> {{ $user->name }} {{ $user->first_surname }} {{ $user->second_surname }}</p>
                    <p><strong>Email:</strong> {{ $user->email }}</p>
                    <p><strong>Cumpleaños:</strong> {{ $user->birthday }}</p>
                    <p><strong>Localidad:</strong> {{ $user->locality }}</p>
                    <p><strong>Teléfono:</strong> {{ $user->telephone }}</p>
                   
                    @if($user->motorbike)
                    <br>
                    <h1 class="text-lg font-medium mb-4"><strong>{{$user->motorbike->brand}} {{$user->motorbike->model}} {{$user->motorbike->year}}</strong></h1>
                    <p><strong>Matricula:</strong> {{ $user->motorbike->registration_number }}</p>
                    <p><strong>Fecha de adquisicion:</strong> {{ $user->motorbike->adquired_at }}</p>
                    @endif
                    <div class="mt-2">
                    @if ($user->friends()->where('friend_id', Auth::user()->id)->exists())
                        <p class="text-success">Sois amigos</p>
                    @else
                        <form action="{{ route('friends.send', ['friendNickname' => $user->nickname]) }}" method="POST">
                            @csrf
                            <button type="submit" class="text-primary">Enviar solicitud de amistad</button>
                        </form>
                    @endif


                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
