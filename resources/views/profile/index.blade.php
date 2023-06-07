<!-- index.blade.php -->

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mi perfil') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <!-- Información del perfil -->
                    <h1 class="text-lg font-medium mb-4"><strong>{{Auth::user()->nickname}}</strong></h1>
                    <p><strong>Nombre:</strong> {{ Auth::user()->name }} {{ Auth::user()->first_surname }} {{ Auth::user()->second_surname }}</p>
                    <p><strong>Email:</strong> {{ Auth::user()->email }}</p>
                    <p><strong>Cumpleaños: </strong>{{ Auth::user()->birthday }}</p>
                    <p><strong>Localidad: </strong>{{ Auth::user()->locality }}</p>
                    <p><strong>Telefono: </strong>{{ Auth::user()->telephone }}</p>
                    <br>
                    <a href="{{ route('profile.edit', Auth::user()->id) }}" class="text-primary mr-2">Editar perfil</a>

                    <a href="{{ route('profile.confirm-delete', Auth::user()->id) }}" class="text-danger">Eliminar perfil</a>
                    <br>
                    <!-- Verificar si el usuario tiene una motocicleta -->
                    @if (!Auth::user()->motorbike)
                    <div class="alert alert-warning mt-4 text-center">
                        <p class="">¡Atención!</p>
                        <p>No tienes una motocicleta registrada en tu perfil. Por favor, añade una motocicleta.</p>

                            
                        <!-- Botón para añadir motocicleta -->
                        <a href="{{ route('motorbikes.create') }}" class="btn btn-warning mt-2 form-control">Añadir motocicleta</a>
                    </div>
                    @else
                     <!-- Información de motocicleta -->
                     <br>
                    <h1 class="text-lg font-medium mb-4"><strong>{{Auth::user()->motorbike->brand}} {{Auth::user()->motorbike->model}} {{Auth::user()->motorbike->year}}</strong></h1>
                    <p><strong>Matricula:</strong> {{ Auth::user()->motorbike->registration_number }}</p>
                    <p><strong>Fecha de adquisicion:</strong> {{ Auth::user()->motorbike->adquired_at }}</p>
                    <br>
                    <a href="{{ route('motorbike.edit', Auth::user()->motorbike->id) }}" class="text-primary mr-2">Editar perfil</a>

                    <a href="{{ route('motorbike.confirm-delete', Auth::user()->motorbike->id) }}" class="text-danger">Eliminar motocicleta</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
