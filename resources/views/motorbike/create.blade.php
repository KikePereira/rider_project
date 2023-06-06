<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Crear Motorbike') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('motorbikes.store') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="brand" class="block text-gray-700 text-sm font-bold mb-2">Marca:</label>
                            @error('brand')
                                <span class="text-danger text-sm mt-1">{{ $message }}</span>
                            @enderror
                            <input type="text" name="brand" id="brand" class="form-control" value="{{ old('brand') }}">
                        </div>

                        <div class="mb-4">
                            <label for="model" class="block text-gray-700 text-sm font-bold mb-2">Modelo:</label>
                            @error('model')
                                <span class="text-danger text-sm mt-1">{{ $message }}</span>
                            @enderror
                            <input type="text" name="model" id="model" class="form-control" value="{{ old('model') }}">
                        </div>

                        <div class="mb-4">
                            <label for="year" class="block text-gray-700 text-sm font-bold mb-2">Año:</label>
                            @error('year')
                                <span class="text-danger text-sm mt-1">{{ $message }}</span>
                            @enderror
                            <input type="number" name="year" id="year" class="form-control" min="1900" max="{{ date('Y') }}" placeholder="YYYY" value="{{ old('year') }}">
                        </div>


                        <div class="mb-4">
                            <label for="adquired_at" class="block text-gray-700 text-sm font-bold mb-2">Fecha de adquisicion:</label>
                            @error('adquired_at')
                                <span class="text-danger text-sm mt-1">{{ $message }}</span>
                            @enderror
                            <input type="date" name="adquired_at" id="adquired_at" class="form-control" value="{{ old('adquired_at') }}">
                        </div>

                        <div class="mb-4">
                            <label for="registration_number" class="block text-gray-700 text-sm font-bold mb-2">Matrícula:</label>
                            @error('registration_number')
                                <span class="text-danger text-sm mt-1">{{ $message }}</span>
                            @enderror
                            <input type="text" name="registration_number" id="registration_number" class="form-control" value="{{ old('registration_number') }}">
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <button type="submit" class="text-primary">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
