<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot>

        <!-- Validation Errors -->
        <!-- <x-auth-validation-errors class="mb-4" :errors="$errors" /> -->

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name -->
            <div>
                <x-label for="name" :value="__('Nombre')" />

                @error('name')
                    <span class="text-danger text-sm mt-1">{{ $message }}</span>
                @enderror

                <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" autofocus />
            </div>

            <!-- Firts Surname -->
            <div>
                <x-label for="first_surname" :value="__('Primer Apellido')" />
                @error('first_surname')
                    <span class="text-danger text-sm mt-1">{{ $message }}</span>
                @enderror
                <x-input id="first_surname" class="block mt-1 w-full" type="text" name="first_surname" :value="old('first_surname')" autofocus />
            </div>

            <!-- Second Surname -->
            <div>
                <x-label for="second_surname" :value="__('Segundo Apellido')" />
                @error('second_surname')
                    <span class="text-danger text-sm mt-1">{{ $message }}</span>
                @enderror
                <x-input id="second_surname" class="block mt-1 w-full" type="text" name="second_surname" :value="old('second_surname')" autofocus />
            </div>

            <!-- Nickname -->
            <div>
                <x-label for="nickname" :value="__('Nombre de usuario:')" />
                @error('nickname')
                    <span class="text-danger text-sm mt-1">{{ $message }}</span>
                @enderror
                <x-input id="nickname" class="block mt-1 w-full" type="text" name="nickname" :value="old('nickname')" autofocus />
            </div>

            <!-- Locality -->
            <div>
                <x-label for="locality" :value="__('Localidad:')" />
                @error('locality')
                    <span class="text-danger text-sm mt-1">{{ $message }}</span>
                @enderror
                <x-input id="locality" class="block mt-1 w-full" type="text" name="locality" :value="old('locality')" autofocus />
            </div>

            <!-- Birthday -->
            <div>
                <x-label for="birthday" :value="__('Fecha de nacimiento:')" />
                @error('birthday')
                    <span class="text-danger text-sm mt-1">{{ $message }}</span>
                @enderror
                <x-input id="birthday" class="block mt-1 w-full" type="date" name="birthday" :value="old('birthday')" autofocus />
            </div>

            <!-- Telephone -->
            <div>
                <x-label for="telephone" :value="__('Telefono:')" />
                @error('telephone')
                    <span class="text-danger text-sm mt-1">{{ $message }}</span>
                @enderror
                <x-input id="telephone" class="block mt-1 w-full" type="text" name="telephone" :value="old('telephone')" autofocus />
            </div>
            

            <!-- Email Address -->
            <div class="mt-4">
                <x-label for="email" :value="__('Email')" />
                @error('email')
                    <span class="text-danger text-sm mt-1">{{ $message }}</span>
                @enderror
                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-label for="password" :value="__('Password')" />
                @error('password')
                    <span class="text-danger text-sm mt-1">{{ $message }}</span>
                @enderror
                <x-input id="password" class="block mt-1 w-full"
                                type="password"
                                name="password"
                                autocomplete="new-password" />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-label for="password_confirmation" :value="__('Confirm Password')" />
                @error('password_confirmation')
                    <span class="text-danger text-sm mt-1">{{ $message }}</span>
                @enderror
                <x-input id="password_confirmation" class="block mt-1 w-full"
                                type="password"
                                name="password_confirmation" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>

                <x-button class="ml-4">
                    {{ __('Register') }}
                </x-button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
