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

            <!-- Historial de Registros con filtros -->
            <div class="bg-white dark:bg-gray-700 shadow rounded-lg">
                <div class="bg-gray-800 dark:bg-gray-900 px-6 py-4 rounded-t-lg">
                    <h3 class="text-lg font-semibold text-white">Historial de Registros</h3>
                </div>
                <!-- Filtro de registros dentro del panel -->
                <div class="p-4 border-b border-gray-200 dark:border-gray-600">
                    <form action="{{ route('work_logs.index') }}" method="GET" class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-gray-700 dark:text-gray-300 text-sm font-medium">Mes</label>
                                <select name="month" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">Todos</option>
                                    <option value="1" {{ request('month') == 1 ? 'selected' : '' }}>Enero</option>
                                    <option value="2" {{ request('month') == 2 ? 'selected' : '' }}>Febrero</option>
                                    <option value="3" {{ request('month') == 3 ? 'selected' : '' }}>Marzo</option>
                                    <option value="4" {{ request('month') == 4 ? 'selected' : '' }}>Abril</option>
                                    <option value="5" {{ request('month') == 5 ? 'selected' : '' }}>Mayo</option>
                                    <option value="6" {{ request('month') == 6 ? 'selected' : '' }}>Junio</option>
                                    <option value="7" {{ request('month') == 7 ? 'selected' : '' }}>Julio</option>
                                    <option value="8" {{ request('month') == 8 ? 'selected' : '' }}>Agosto</option>
                                    <option value="9" {{ request('month') == 9 ? 'selected' : '' }}>Septiembre</option>
                                    <option value="10" {{ request('month') == 10 ? 'selected' : '' }}>Octubre</option>
                                    <option value="11" {{ request('month') == 11 ? 'selected' : '' }}>Noviembre</option>
                                    <option value="12" {{ request('month') == 12 ? 'selected' : '' }}>Diciembre</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-gray-700 dark:text-gray-300 text-sm font-medium">Año</label>
                                <input type="number" name="year" value="{{ request('year', date('Y')) }}" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            </div>
                        </div>
                        <!-- Botón en una nueva fila con margen superior -->
                        <div class="mt-4">
                            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded">
                                Filtrar
                            </button>
                        </div>
                    </form>
                </div>
                <!-- Tabla de Registros -->
                <div class="p-4 overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-600">
                        <thead class="bg-gray-100 dark:bg-gray-800">
                            <tr>
                                <th class="px-4 py-2 text-left text-sm font-medium text-gray-700 dark:text-gray-200">ID</th>
                                <th class="px-4 py-2 text-left text-sm font-medium text-gray-700 dark:text-gray-200">Entrada</th>
                                <th class="px-4 py-2 text-left text-sm font-medium text-gray-700 dark:text-gray-200">Salida</th>
                                <th class="px-4 py-2 text-left text-sm font-medium text-gray-700 dark:text-gray-200">Hash</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-700 divide-y divide-gray-200 dark:divide-gray-600">
                            @forelse($logs as $log)
                                <tr>
                                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ $log->id }}</td>
                                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ $log->check_in }}</td>
                                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ $log->check_out ?? 'En curso' }}</td>
                                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ $log->hash ?? 'Pendiente' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-4 py-2 text-center text-sm text-gray-600 dark:text-gray-300">
                                        Aún no hay registros.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <!-- Sección de Paginación -->
                <div class="p-4">
                    {{ $logs->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
