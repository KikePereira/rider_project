<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Modificar motocicleta') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h1 class="text-lg font-medium mb-4"><strong>{{ $motorbike->brand }}</strong></h1>

                    <!-- Formulario de edición de la motocicleta -->
                    <form action="{{ route('motorbike.update', $motorbike->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="brand" class="block text-gray-700 text-sm font-bold mb-2">Marca:</label>
                            <input type="text" name="brand" id="brand" value="{{ old('brand', Auth::user()->motorbike->brand) }}" class="form-control">
                            @error('brand')
                            <p class="text-danger text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="model" class="block text-gray-700 text-sm font-bold mb-2">Modelo:</label>
                            <input type="text" name="model" id="model" value="{{ old('model', Auth::user()->motorbike->model) }}" class="form-control">
                            @error('model')
                            <p class="text-danger text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="year" class="block text-gray-700 text-sm font-bold mb-2">Año:</label>
                            <input type="number" name="year" id="year" class="form-control" min="1900" max="{{ date('Y') }}" placeholder="YYYY" value="{{ old('year', Auth::user()->motorbike->year) }}" >
                            @error('year')
                            <p class="text-danger text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="registration_number" class="block text-gray-700 text-sm font-bold mb-2">Número de matrícula:</label>
                            <input type="text" name="registration_number" id="registration_number" value="{{ old('registration_number', Auth::user()->motorbike->registration_number) }}" class="form-control">
                            @error('registration_number')
                                <p class="text-danger text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="adquired_at" class="block text-gray-700 text-sm font-bold mb-2">Fecha de adquisición:</label>
                            <input type="date" name="adquired_at" id="adquired_at" value="{{ old('adquired_at', Auth::user()->motorbike->adquired_at) }}" class="form-control">
                            @error('adquired_at')
                            <p class="text-danger text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="text-primary">Guardar cambios</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
