<nav x-data="{ open: false }" class="bg-brand-black/80 backdrop-blur-md border-b border-brand-red/20 z-50 sticky top-0">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="/">
                        <img src="{{ asset('images/logos/conejo-color.png') }}" alt="Conejo Cantú" class="block h-10 w-auto object-contain drop-shadow-[0_0_10px_rgba(230,32,32,0.4)] transition-transform hover:scale-105">
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <a href="{{ route('dashboard') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('dashboard') ? 'border-brand-red text-white' : 'border-transparent text-gray-400 hover:text-white hover:border-brand-red/50' }} text-sm font-medium leading-5 transition duration-150 ease-in-out font-racing uppercase tracking-widest text-xl mt-1">
                        Mi Panel
                    </a>
                    @if(Auth::user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('admin.*') ? 'border-brand-red text-white' : 'border-transparent text-brand-red hover:text-white hover:border-brand-red' }} text-sm font-medium leading-5 transition duration-150 ease-in-out font-racing uppercase tracking-widest text-xl mt-1">
                            Panel Admin
                        </a>
                    @endif
                    <a href="/" class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-gray-400 hover:text-white hover:border-brand-red/50 text-sm font-medium leading-5 transition duration-150 ease-in-out font-racing uppercase tracking-widest text-xl mt-1">
                        Volver a la Web
                    </a>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-brand-red/30 text-sm leading-4 font-medium rounded-full text-gray-300 bg-brand-dark/50 hover:text-white hover:bg-brand-red hover:border-brand-red focus:outline-none transition ease-in-out duration-300">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <div class="bg-brand-dark border border-white/10 rounded-md shadow-lg py-1">
                            <x-dropdown-link :href="route('profile.edit')" class="text-gray-300 hover:bg-brand-red hover:text-white">
                                Mi Perfil
                            </x-dropdown-link>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault(); this.closest('form').submit();" class="text-gray-300 hover:bg-brand-red hover:text-white">
                                    Cerrar Sesión
                                </x-dropdown-link>
                            </form>
                        </div>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-white hover:bg-brand-red/20 focus:outline-none transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-brand-dark/90 backdrop-blur-md border-b border-brand-red/20">
        <div class="pt-2 pb-3 space-y-1">
            <a href="{{ route('dashboard') }}" class="block w-full ps-3 pe-4 py-2 border-l-4 {{ request()->routeIs('dashboard') ? 'border-brand-red text-white bg-brand-red/10' : 'border-transparent text-gray-400 hover:text-white hover:bg-white/5 hover:border-gray-300' }} text-left text-base font-medium transition duration-150 ease-in-out">
                Mi Panel
            </a>
            <a href="/" class="block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-gray-400 hover:text-white hover:bg-white/5 hover:border-gray-300 text-left text-base font-medium transition duration-150 ease-in-out">
                Volver a la Web
            </a>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-brand-red/20">
            <div class="px-4">
                <div class="font-medium text-base text-white">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-400">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <a href="{{ route('profile.edit') }}" class="block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-gray-400 hover:text-white hover:bg-white/5 hover:border-gray-300 text-left text-base font-medium transition duration-150 ease-in-out">
                    Mi Perfil
                </a>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <a href="{{ route('logout') }}"
                            onclick="event.preventDefault(); this.closest('form').submit();" class="block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-brand-red hover:text-white hover:bg-brand-red/20 hover:border-brand-red text-left text-base font-medium transition duration-150 ease-in-out">
                        Cerrar Sesión
                    </a>
                </form>
            </div>
        </div>
    </div>
</nav>
