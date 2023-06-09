<!-- conversations.blade.php -->

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Conversaciones') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif      
                    <h1 class="text-lg font-medium mb-4">Mis conversaciones</h1>
                    @foreach ($conversations as $friend)
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-3">
        <div class="p-3 bg-white flex items-center justify-between">
            <div>
            <a href="{{ route('user.profile', $friend->id) }}"> <strong> {{ $friend->nickname }} </strong> <span>({{$friend->name}} {{$friend->first_surname}} {{$friend->second_surname}})</span></a>
            </div>
            <div>
                <a href="{{ route('messages.conversation', $friend->id) }}" class="mr-3">Ver conversación</a>
                <form action="{{ route('messages.destroy', $friend->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-danger">Eliminar conversación</button>
                </form>
            </div>
        </div>
    </div>
@endforeach

        </div>
    </div>
</x-app-layout>
