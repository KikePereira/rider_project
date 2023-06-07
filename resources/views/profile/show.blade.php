<!-- show.blade.php -->

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Perfil de Usuario') }}
        </h2>
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
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
