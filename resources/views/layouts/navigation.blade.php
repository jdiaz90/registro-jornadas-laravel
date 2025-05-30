<nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
    <!-- Menú Principal -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <!-- Izquierda: logo e ítems de navegación -->
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
                    </a>
                </div>

                <!-- Enlaces de navegación (ocultos en móvil) -->
                <div class="hidden sm:flex sm:space-x-8 sm:ml-10">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('layouts.navigation.dashboard') }}
                    </x-nav-link>
                    <x-nav-link :href="route('work_logs.index')" :active="request()->routeIs('work_logs.*')">
                        {{ __('layouts.navigation.work_logs') }}
                    </x-nav-link>
                    <!-- Nueva opción Calendario -->
                    <x-nav-link :href="route('calendar.index')" :active="request()->routeIs('calendar.*')">
                        {{ __('layouts.navigation.calendario') }}
                    </x-nav-link>
                    
                    <!-- Enlace exclusivo para administradores -->
                    @if(Auth::check() && Auth::user()->role === 'admin')
                        <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                            {{ __('layouts.navigation.admin_dashboard') }}
                        </x-nav-link>
                    @endif
                </div>
            </div>

            <!-- Derecha: Dropdowns de idioma y usuario -->
            <div class="hidden sm:flex sm:items-center sm:ml-6 space-x-4">
                <!-- Dropdown para la selección de idioma -->
                <x-dropdown align="right" width="48">
                    <!-- Trigger -->
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition duration-150 ease-in-out">
                            <div>{{ strtoupper(App::getLocale()) }}</div>
                            <svg class="ml-1 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7l3-3 3 3m0 6l-3 3-3-3" />
                            </svg>
                        </button>
                    </x-slot>
                    
                    <!-- Dropdown Content -->
                    <x-slot name="content">
                        <x-dropdown-link :href="route('locale.change', ['locale' => 'es'])">
                            Español
                        </x-dropdown-link>
                        <x-dropdown-link :href="route('locale.change', ['locale' => 'en'])">
                            English
                        </x-dropdown-link>
                        <x-dropdown-link :href="route('locale.change', ['locale' => 'gl'])">
                            Galego
                        </x-dropdown-link>
                    </x-slot>
                </x-dropdown>

                <!-- Dropdown de usuario -->
                <x-dropdown align="right" width="48">
                    <!-- Trigger -->
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition duration-150 ease-in-out">
                            <div>{{ Auth::user()->name }}</div>
                            <svg class="ml-1 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7l3-3 3 3m0 6l-3 3-3-3" />
                            </svg>
                        </button>
                    </x-slot>
                    
                    <!-- Dropdown Content -->
                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('layouts.navigation.profile') }}
                        </x-dropdown-link>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                {{ __('layouts.navigation.log_out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Menú Hamburguesa (para móviles) -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Menú Responsive -->
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">
        <!-- Enlaces primarios -->
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('layouts.navigation.dashboard') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('work_logs.index')" :active="request()->routeIs('work_logs.*')">
                {{ __('layouts.navigation.work_logs') }}
            </x-responsive-nav-link>
            <!-- Nueva opción Calendario en menú responsive -->
            <x-responsive-nav-link :href="route('calendar.index')" :active="request()->routeIs('calendar.*')">
                {{ __('layouts.navigation.calendario') }}
            </x-responsive-nav-link>
            
            <!-- Enlace Admin solo si el usuario tiene rol admin -->
            @if(Auth::check() && Auth::user()->role === 'admin')
                <x-responsive-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                    {{ __('layouts.navigation.admin_dashboard') }}
                </x-responsive-nav-link>
            @endif
        </div>

        <!-- Opciones de usuario en móvil -->
        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>
            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('layouts.navigation.profile') }}
                </x-responsive-nav-link>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                                            onclick="event.preventDefault(); this.closest('form').submit();">
                        {{ __('layouts.navigation.log_out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
