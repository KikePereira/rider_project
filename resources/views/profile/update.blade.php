<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Modificar perfil') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h1 class="text-lg font-medium mb-4"><strong>{{ Auth::user()->name }}</strong></h1>

                    <!-- Formulario de edición del perfil -->
                    <form action="{{ route('profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Nombre:</label>
                            <input type="text" name="name" id="name" value="{{ old('name', Auth::user()->name) }}" class="form-control">
                            @error('name')
                            <p class="text-danger text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="first_surname" class="block text-gray-700 text-sm font-bold mb-2">Primer apellido:</label>
                            <input type="text" name="first_surname" id="first_surname" value="{{ old('first_surname', Auth::user()->first_surname) }}" class="form-control">
                            @error('first_surname')
                                <p class="text-danger text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="second_surname" class="block text-gray-700 text-sm font-bold mb-2">Segundo apellido:</label>
                            <input type="text" name="second_surname" id="second_surname" value="{{ old('second_surname', Auth::user()->second_surname) }}" class="form-control">
                            @error('second_surname')
                                <p class="text-danger text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
            
                        <div class="mb-4">
                            <label for="nickname" class="block text-gray-700 text-sm font-bold mb-2">Nombre de usuario:</label>
                            <input type="text" name="nickname" id="nickname" value="{{ old('nickname', Auth::user()->nickname) }}" class="form-control">
                            @error('nickname')
                            <p class="text-danger text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="locality" class="block text-gray-700 text-sm font-bold mb-2">Localidad:</label>
                            <input type="text" name="locality" id="locality" value="{{ old('locality', Auth::user()->locality) }}" class="form-control">
                            @error('locality')
                            <p class="text-danger text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="birthday" class="block text-gray-700 text-sm font-bold mb-2">Fecha nacimiento:</label>
                            <input type="date" name="birthday" id="birthday" value="{{ old('birthday', Auth::user()->birthday) }}" class="form-control">
                            @error('birthday')
                            <p class="text-danger text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="mb-4">
                            <label for="telephone" class="block text-gray-700 text-sm font-bold mb-2">Telefono:</label>
                            <input type="text" name="telephone" id="telephone" value="{{ old('telephone', Auth::user()->telephone) }}" class="form-control">
                            @error('telephone')
                            <p class="text-danger text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>                     

                        <div class="mb-4">
                            <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email:</label>
                            <input type="email" name="email" id="email" value="{{ old('email', Auth::user()->email) }}" class="form-control">
                            @error('email')
                            <p class="text-danger text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Otros campos de perfil -->

                        <div class="mt-4">
                            <button type="submit" class="text-primary">Guardar cambios</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
