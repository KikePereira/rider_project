<!-- conversations.blade.php -->

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Conversaciones') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      
                    <h1 class="text-lg font-medium mb-4">Mis conversaciones</h1>
                        @foreach ($conversations as $friend)
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                 
                                <a href="{{ route('messages.conversation', $friend->id) }}">
                                    {{ $friend->nickname }} <span>({{$friend->name}} {{$friend->first_surname}} {{$friend->second_surname}})</span>
                                </a>
              
                            </div>
            </div>
                        @endforeach

        </div>
    </div>
</x-app-layout>
