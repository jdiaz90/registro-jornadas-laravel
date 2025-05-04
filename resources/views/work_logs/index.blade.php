<x-app-layout>
    <!-- Slot para el header -->
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('work_logs.index.header') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <!-- Contenedor principal -->
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            <!-- Contenedor para las acciones de registrar entrada y salida -->
            <div class="mb-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Tarjeta: Registrar Entrada -->
                    <div class="bg-white dark:bg-gray-700 shadow rounded-lg p-6 text-center">
                        <h3 class="text-xl font-semibold mb-2">
                            {{ __('work_logs.index.check_in.title') }}
                        </h3>
                        <p class="text-gray-600 dark:text-gray-300">
                            {{ __('work_logs.index.check_in.description') }}
                        </p>
                        <form action="{{ route('work_logs.check_in') }}" method="POST" class="mt-4">
                            @csrf
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white appearance-none focus:outline-none font-semibold py-2 px-4 rounded block mx-auto">
                                {{ __('work_logs.index.check_in.button') }}
                            </button>
                        </form>
                    </div>
                    <!-- Tarjeta: Registrar Salida -->
                    <div class="bg-white dark:bg-gray-700 shadow rounded-lg p-6 text-center">
                        <h3 class="text-xl font-semibold mb-2">
                            {{ __('work_logs.index.check_out.title') }}
                        </h3>
                        <p class="text-gray-600 dark:text-gray-300">
                            {{ __('work_logs.index.check_out.description') }}
                        </p>
                        <form action="{{ route('work_logs.check_out') }}" method="POST" class="mt-4">
                            @csrf
                            <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-white appearance-none focus:outline-none font-semibold py-2 px-4 rounded block mx-auto">
                                {{ __('work_logs.index.check_out.button') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Componente de Historial de Registros con Filtros -->
            <x-work-logs-table :logs="$logs" title="{{ __('work_logs.index.history_title') }}" />
        </div>
    </div>
</x-app-layout>
