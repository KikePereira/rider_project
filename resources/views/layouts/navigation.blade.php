<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('home') }}">
                        <img src="{{ asset('img/full_logo_b.png') }}" alt="Logo" class="block h-10 w-auto fill-current text-gray-600">
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex justify-center">
                    <x-nav-link :href="route('home')" :active="request()->routeIs('home')">
                        {{ __('Inicio') }}
                    </x-nav-link>
                    <x-nav-link :href="route('route.favorites')" :active="request()->routeIs('route.favorites')">
                        {{ __('Favoritas') }}
                    </x-nav-link>
                    <x-nav-link :href="route('friends')" :active="request()->routeIs('friends')">
                        {{ __('Amigos') }}
                    </x-nav-link>



                    <x-nav-link :href="route('friend.show')" :active="request()->routeIs('friend.show')">
                        {{ __('Peticiones Amistad') }} 
                        @if(Auth::user()->friendRequests()->count() > 0)
                            <span class="bg-success text-white p-1 rounded ml-2">{{ Auth::user()->friendRequests()->count() }}</span>
                        @endif
                    </x-nav-link>


                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ml-6">
            <x-nav-link :href="route('profile')" :active="request()->routeIs('profile')">
                        {{ Auth::user()->nickname }}
                    </x-nav-link>

                    <x-nav-link :href="route('logout')" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <span class="text-danger"> Logout</span>
                    </x-nav-link>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
            </div>

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">

        <x-responsive-nav-link :href="route('home')" :active="request()->routeIs('home')">
                {{ __('Inicio') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('route.favorites')" :active="request()->routeIs('route.favorites')">
                {{ __('Favorito') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('friends')" :active="request()->routeIs('friends')">
                {{ __('Amigos') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('friend.show')" :active="request()->routeIs('friend.show')">
                {{ __('Peticiones de Amistad') }}

                @if(Auth::user()->friendRequests()->count() > 0)
                            <span class="bg-success text-white p-1 rounded ml-2">{{ Auth::user()->friendRequests()->count() }}</span>
                        @endif
            </x-responsive-nav-link>



     
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
        <x-responsive-nav-link :href="route('profile')" :active="request()->routeIs('profile')">
                {{ Auth::user()->nickname }}
        </x-responsive-nav-link>


            <div class="mt-3 space-y-1">
                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        <span class="text-danger"> Logout</span>

                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
