<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Confirmar borrado de motocicleta') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="items-center">
                        <h1 class="text-lg font-medium mb-4 text-left"><strong>Datos de la motocicleta</strong></h1>
                        <p><strong>Marca:</strong> {{ Auth::user()->motorbike->brand }}</p>
                        <p><strong>Modelo:</strong> {{ Auth::user()->motorbike->model }}</p>
                        <p><strong>Año:</strong> {{ Auth::user()->motorbike->year }}</p>
                        <p><strong>Matricula:</strong> {{ Auth::user()->motorbike->registration_number }}</p>
                        <p><strong>Fecha de adquisicion:</strong> {{ Auth::user()->motorbike->adquired_at }}</p>
                    </div>
                    <div class="alert alert-danger mt-4 text-center">
                    <p>¿Estás seguro de que deseas eliminar la motocicleta?</p>
                    </div>

                    <form action="{{ route('motorbike.destroy', $motorbike->id) }}" method="POST">
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
