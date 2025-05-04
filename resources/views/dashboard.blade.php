<x-app-layout>
    <!-- Slot para el encabezado -->
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('dashboard.header') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <!-- Contenedor central con espacio vertical entre secciones -->
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            <!-- Sección de Bienvenida -->
            <div class="bg-white dark:bg-gray-700 shadow rounded-lg p-6">
                <h3 class="text-2xl font-semibold text-gray-900 dark:text-gray-100">
                    {{ __('dashboard.welcome.greeting', ['name' => Auth::user()->name]) }}
                </h3>
                <p class="mt-2 text-gray-600 dark:text-gray-300">
                    {{ __('dashboard.welcome.description') }}
                </p>
            </div>

            <!-- Grid de tarjetas de resumen -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Tarjeta de Mis Work Logs -->
                <div class="bg-white dark:bg-gray-700 shadow rounded-lg p-6 text-center">
                    <h3 class="text-xl font-semibold mb-2">
                        {{ __('dashboard.cards.work_logs.title') }}
                    </h3>
                    <p class="text-gray-600 dark:text-gray-300">
                        {{ __('dashboard.cards.work_logs.description') }}
                    </p>
                    <a href="{{ route('work_logs.index') }}"
                       class="mt-4 inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded">
                        {{ __('dashboard.cards.work_logs.button') }}
                    </a>
                    <!-- Contador dinámico -->
                    <div class="mt-4">
                        <span class="text-xl font-bold text-gray-900 dark:text-gray-100">{{ $logCount }}</span>
                        <span class="text-sm text-gray-600 dark:text-gray-300">
                            {{ __('dashboard.cards.work_logs.count_label') }}
                        </span>
                    </div>
                </div>

                <!-- Tarjeta de Mi Perfil -->
                <div class="bg-white dark:bg-gray-700 shadow rounded-lg p-6 text-center">
                    <h3 class="text-xl font-semibold mb-2">
                        {{ __('dashboard.cards.profile.title') }}
                    </h3>
                    <p class="text-gray-600 dark:text-gray-300">
                        {{ __('dashboard.cards.profile.description') }}
                    </p>
                    <a href="{{ route('profile.edit') }}"
                       class="mt-4 inline-block bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded">
                        {{ __('dashboard.cards.profile.button') }}
                    </a>
                </div>

                <!-- Tarjeta de Estadísticas -->
                <div class="bg-white dark:bg-gray-700 shadow rounded-lg p-6 text-center">
                    <h3 class="text-xl font-semibold mb-2">
                        {{ __('dashboard.cards.statistics.title') }}
                    </h3>
                    <p class="text-gray-600 dark:text-gray-300">
                        {{ __('dashboard.cards.statistics.description') }}
                    </p>
                    <div class="mt-4">
                        <span class="text-2xl font-bold text-gray-900 dark:text-gray-100">0</span>
                        <span class="text-sm text-gray-600 dark:text-gray-300">
                            {{ __('dashboard.cards.statistics.data_counter', ['count' => 0]) }}
                        </span>
                    </div>
                </div>

                <!-- Tarjeta de Calendario -->
                <div class="bg-white dark:bg-gray-700 shadow rounded-lg p-6 text-center">
                    <h3 class="text-xl font-semibold mb-2">
                        {{ __('dashboard.cards.calendar.title') }}
                    </h3>
                    <p class="text-gray-600 dark:text-gray-300">
                        {{ __('dashboard.cards.calendar.description') }}
                    </p>
                    <a href="{{ route('calendar.index') }}"
                       class="mt-4 inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded">
                        {{ __('dashboard.cards.calendar.button') }}
                    </a>
                </div>

                <!-- Tarjeta de Exportar Informe -->
                <div class="bg-white dark:bg-gray-700 shadow rounded-lg p-6 text-center">
                    <h3 class="text-xl font-semibold mb-2">
                        {{ __('dashboard.cards.export_report.title') }}
                    </h3>
                    <p class="text-gray-600 dark:text-gray-300">
                        {{ __('dashboard.cards.export_report.description') }}
                    </p>
                    <a href="{{ route('worklogs.export.yearly', ['year' => now()->year]) }}"
                       class="mt-4 inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded">
                        {{ __('dashboard.cards.export_report.button') }}
                    </a>
                </div>

                <!-- Tarjeta de Verificar Registro -->
                <div class="bg-white dark:bg-gray-700 shadow rounded-lg p-6 text-center">
                    <h3 class="text-xl font-semibold mb-2">
                        {{ __('dashboard.cards.verify_record.title') }}
                    </h3>
                    <p class="text-gray-600 dark:text-gray-300">
                        {{ __('dashboard.cards.verify_record.description') }}
                    </p>
                    <a href="{{ route('work_logs.verify') }}"
                       class="mt-4 inline-block bg-yellow-500 hover:bg-purple-700 text-white font-semibold py-2 px-4 rounded">
                        {{ __('dashboard.cards.verify_record.button') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
