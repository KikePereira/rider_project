<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Confirmar borrado de perfil') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="items-center">
                            <!-- Información del perfil -->
                        <h1 class="text-lg font-medium mb-4"><strong>{{Auth::user()->nickname}}</strong></h1>
                        <p><strong>Nombre:</strong> {{ Auth::user()->name }} {{ Auth::user()->first_surname }} {{ Auth::user()->second_surname }}</p>
                        <p><strong>Email:</strong> {{ Auth::user()->email }}</p>
                        <p><strong>Cumpleaños: </strong>{{ Auth::user()->birthday }}</p>
                        <p><strong>Localidad: </strong>{{ Auth::user()->locality }}</p>
                        <p><strong>Telefono: </strong>{{ Auth::user()->telephone }}</p>
                    </div>
                    <div class="alert alert-danger mt-4 text-center">
                    <p>¿Estás seguro de que deseas tu perfil?</p>
                    </div>

                    <form action="{{ route('profile.destroy', Auth::user()->id) }}" method="POST">
                        @csrf
                        @method('DELETE')

                        <div class="mt-6 text-center">
                            <button type="submit" class="text-danger mr-2">
                                Confirmar borrado
                            </button>
                            <a href="{{ route('profile') }}" class="ml-2 text-secondary">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
