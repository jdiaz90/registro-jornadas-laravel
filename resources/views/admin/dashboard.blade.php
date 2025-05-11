<x-app-layout>
    <!-- Slot para el header -->
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('admin.admin_panel') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <!-- Contenedor central con espaciamiento vertical entre secciones -->
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            <!-- Sección de Bienvenida -->
            <div class="bg-white dark:bg-gray-700 shadow rounded-lg p-6">
                <h3 class="text-2xl font-semibold text-gray-900 dark:text-gray-100">
                    {{ __('admin.welcome', ['name' => Auth::user()->name]) }}
                </h3>
                <p class="mt-2 text-gray-600 dark:text-gray-300">
                    {{ __('admin.description') }}
                </p>
            </div>

            <!-- Grid de tarjetas de resumen -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Tarjeta: Gestión de Usuarios -->
                <div class="bg-white dark:bg-gray-700 shadow rounded-lg p-6 text-center">
                    <h3 class="text-xl font-semibold mb-2">{{ __('admin.user_management.title') }}</h3>
                    <p class="text-gray-600 dark:text-gray-300">
                        {{ __('admin.user_management.description') }}
                    </p>
                    <a href="{{ route('admin.users.index') }}">
                        <x-primary-button class="mt-4 bg-blue-600 hover:bg-blue-700">
                            {{ __('admin.user_management.button') }}
                        </x-primary-button>
                    </a>
                </div>

                <!-- Tarjeta: Crear Usuario -->
                <div class="bg-white dark:bg-gray-700 shadow rounded-lg p-6 text-center">
                    <h3 class="text-xl font-semibold mb-2">{{ __('admin.create_user.title') }}</h3>
                    <p class="text-gray-600 dark:text-gray-300">
                        {{ __('admin.create_user.description') }}
                    </p>
                    <a href="{{ route('admin.users.create') }}">
                        <x-primary-button class="mt-4 bg-blue-600 hover:bg-blue-700">
                            {{ __('admin.create_user.button') }}
                        </x-primary-button>
                    </a>
                </div>

                <!-- Tarjeta: Registros de Jornada -->
                <div class="bg-white dark:bg-gray-700 shadow rounded-lg p-6 text-center">
                    <h3 class="text-xl font-semibold mb-2">{{ __('admin.work_logs.title') }}</h3>
                    <p class="text-gray-600 dark:text-gray-300">
                        {{ __('admin.work_logs.description') }}
                    </p>
                    <a href="{{ route('work_logs.index') }}">
                        <x-primary-button class="mt-4 bg-yellow-600 hover:bg-yellow-700">
                            {{ __('admin.work_logs.button') }}
                        </x-primary-button>
                    </a>
                </div>

                <!-- Tarjeta: Calendario -->
                <div class="bg-white dark:bg-gray-700 shadow rounded-lg p-6 text-center">
                    <h3 class="text-xl font-semibold mb-2">{{ __('admin.calendar.title') }}</h3>
                    <p class="text-gray-600 dark:text-gray-300">
                        {{ __('admin.calendar.description') }}
                    </p>
                    <a href="{{ route('calendar.index') }}">
                        <x-primary-button class="mt-4 bg-blue-600 hover:bg-blue-700">
                            {{ __('admin.calendar.button') }}
                        </x-primary-button>
                    </a>
                </div>

                <!-- Tarjeta: Exportar Informes -->
                <div class="bg-white dark:bg-gray-700 shadow rounded-lg p-6 text-center">
                    <h3 class="text-xl font-semibold mb-2">{{ __('admin.reports.title') }}</h3>
                    <p class="text-gray-600 dark:text-gray-300">
                        {{ __('admin.reports.description') }}
                    </p>
                    <a href="{{ route('worklogs.export.yearly', ['year' => date('Y')]) }}">
                        <x-primary-button class="mt-4 bg-blue-600 hover:bg-blue-700">
                            {{ __('admin.reports.button') }}
                        </x-primary-button>
                    </a>
                </div>

                <!-- Tarjeta: Configuraciones -->
                <div class="bg-white dark:bg-gray-700 shadow rounded-lg p-6 text-center">
                    <h3 class="text-xl font-semibold mb-2">{{ __('admin.settings.title') }}</h3>
                    <p class="text-gray-600 dark:text-gray-300">
                        {{ __('admin.settings.description') }}
                    </p>
                    <a href="{{-- route('admin.settings') --}}">
                        <x-primary-button class="mt-4 bg-purple-600 hover:bg-purple-700">
                            {{ __('admin.settings.button') }}
                        </x-primary-button>
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
