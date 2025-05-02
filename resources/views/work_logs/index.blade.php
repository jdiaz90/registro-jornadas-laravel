<x-app-layout>
    <!-- Slot para el header -->
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Registro de Jornada') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <!-- Contenedor principal -->
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <!-- Mensajes flash (éxito o error) -->
            @if(session('success'))
                <div class="bg-green-100 dark:bg-green-900 border border-green-400 dark:border-green-700 text-green-700 dark:text-green-100 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                    <button type="button" class="absolute top-0 bottom-0 right-0 px-4 py-3" onclick="this.parentElement.remove()">
                        <svg class="fill-current h-6 w-6 text-green-500 dark:text-green-300" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <title>Cerrar</title>
                            <path d="M14.348 5.652a1 1 0 00-1.414 0L10 8.586 7.066 5.652A1 1 0 105.652 7.066L8.586 10l-2.934 2.934a1 1 0 101.414 1.414L10 11.414l2.934 2.934a1 1 0 001.414-1.414L11.414 10l2.934-2.934a1 1 0 000-1.414z"/>
                        </svg>
                    </button>
                </div>
            @endif
            
            @if(session('error'))
                <div class="bg-red-100 dark:bg-red-900 border border-red-400 dark:border-red-700 text-red-700 dark:text-red-100 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                    <button type="button" class="absolute top-0 bottom-0 right-0 px-4 py-3" onclick="this.parentElement.remove()">
                        <svg class="fill-current h-6 w-6 text-red-500 dark:text-red-300" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <title>Cerrar</title>
                            <path d="M14.348 5.652a1 1 0 00-1.414 0L10 8.586 7.066 5.652A1 1 0 105.652 7.066L8.586 10l-2.934 2.934a1 1 0 101.414 1.414L10 11.414l2.934 2.934a1 1 0 001.414-1.414L11.414 10l2.934-2.934a1 1 0 000-1.414z"/>
                        </svg>
                    </button>
                </div>
            @endif

            <!-- Contenedor para las acciones de registrar entrada y salida -->
            <div class="mb-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Tarjeta: Registrar Entrada -->
                    <div class="bg-white dark:bg-gray-700 shadow rounded-lg p-6 text-center">
                        <h3 class="text-xl font-semibold mb-2">Registrar Entrada</h3>
                        <p class="text-gray-600 dark:text-gray-300">
                            Inicia tu jornada registrando la entrada.
                        </p>
                        <form action="{{ route('work_logs.check_in') }}" method="POST" class="mt-4">
                            @csrf
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white appearance-none focus:outline-none font-semibold py-2 px-4 rounded block mx-auto">
                                Entrada
                            </button>
                        </form>
                    </div>
                    <!-- Tarjeta: Registrar Salida -->
                    <div class="bg-white dark:bg-gray-700 shadow rounded-lg p-6 text-center">
                        <h3 class="text-xl font-semibold mb-2">Registrar Salida</h3>
                        <p class="text-gray-600 dark:text-gray-300">
                            Termina tu jornada registrando la salida.
                        </p>
                        <form action="{{ route('work_logs.check_out') }}" method="POST" class="mt-4">
                            @csrf
                            <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-white appearance-none focus:outline-none font-semibold py-2 px-4 rounded block mx-auto">
                                Salida
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Componente de Historial de Registros con Filtros -->
            <x-work-logs-table :logs="$logs" title="Historial de Registros" />
            </div>
        </div>
    </div>
</x-app-layout>
