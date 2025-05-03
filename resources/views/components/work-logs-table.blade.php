@props([
    'logs',  // Colección paginada de registros
    'title' => 'Historial de Registros',  // Título del panel
    'action' => route('work_logs.index')   // Ruta por defecto para el formulario
])

<div class="bg-white dark:bg-gray-700 shadow rounded-lg">
    <!-- Encabezado del panel -->
    <div class="bg-gray-800 dark:bg-gray-900 px-6 py-4 rounded-t-lg">
        <h3 class="text-lg font-semibold text-white">{{ $title }}</h3>
    </div>
    <!-- Filtro de registros -->
    <div class="p-4 border-b border-gray-200 dark:border-gray-600">
        <form action="{{ $action }}" method="GET" class="space-y-4">
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
                        <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                            <!-- Hipervínculo: Al hacer clic se redirige a la ruta de detalle -->
                            <a href="{{ route('work_logs.show', $log->id) }}" class="text-blue-600 hover:underline">
                                {{ $log->id }}
                            </a>
                        </td>
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
    <!-- Paginación -->
    <div class="p-4">
        {{ $logs->withQueryString()->links() }}
    </div>
</div>
