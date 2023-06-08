<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Amigos') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                <h3> <strong>Agregar amigo:</strong> </h3>
                    <br>
                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    <form method="POST" action="{{ route('friends.send') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="nickname" class="block">Nombre de usuario del amigo:</label>
                            <input type="text" name="nickname" id="nickname" class="border border-gray-300 rounded w-full py-2 px-3" required>
                        </div>
                        <button type="submit" class="text-primary">Enviar solicitud de amistad</button>
                    </form>
                </div>
            </div>
            <br>
            
                    @if ($friends->count() > 0)
                            @foreach ($friends as $friend)
                            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                                <div class="p-6 bg-white border-b border-gray-200">
                                    <a href="{{ route('user.profile', $friend->id) }}" class="">
                                        <p> <strong>{{ $friend->nickname }}</strong> ( {{ $friend->name}} {{ $friend->first_surname}} {{ $friend->second_surname}}) </p>
                                    </a>
                                    <form action="{{ route('friend.destroy', $friend->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-danger">Eliminar amigo</button>
                                    </form>

                                </div>
                            </div>
                            @endforeach
                            <div class="pagination d-flex justify-content-center">
                                {{ $friends->render('pagination::bootstrap-4') }}
                            </div>
                    @else
                        <p>No tienes amigos.</p>
                    @endif


        </div>
    </div>
</x-app-layout>
