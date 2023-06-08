<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Solicitudes de amistad') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    @if($friendRequests->isEmpty())
                        <p class="alert alert-warning mt-4 text-center">No tienes ninguna solicitud de amistad.</p>
                    @else

                            @foreach($friendRequests as $request)
                            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6 bg-white border-b border-gray-200">
                            <a href="{{ route('user.profile', $request->user->id) }}" class="">
                                <h1> <strong>{{ $request->user->nickname }} </strong> <span class="text-secondary">({{ $request->user->name }} {{ $request->user->first_surname }} {{ $request->user->second_surname }})</span></h1>
                                </a>
                                <br>
                                <div class="row">
                                    <div class="col-6">
                                <form action="{{ route('friend.accepted', $request->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="text-success">Aceptar</button>
                                </form>
                                </div>
                                <div class="col-6">

                                <form action="{{ route('friend.deny', $request->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-danger">Denegar</button>
                                </form>
                                </div>
                                </div>
                            </div>
                            </div>
                            @endforeach
                    @endif
        </div>
    </div>
</x-app-layout>
