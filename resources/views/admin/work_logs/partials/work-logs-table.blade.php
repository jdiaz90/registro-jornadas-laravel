@props([
    'logs', 
    'title' => __('components.work_logs_table.title'),
    'action' => route('admin.work_logs.index'),
    'users' => collect() // Se espera que se pase la colección de usuarios desde el controlador
])

<div class="bg-white dark:bg-gray-700 shadow rounded-lg">
    <!-- Encabezado del panel -->
    <div class="bg-gray-800 dark:bg-gray-900 px-6 py-4 rounded-t-lg">
        <h3 class="text-lg font-semibold text-white">{{ $title }}</h3>
    </div>

    <!-- Filtro de registros -->
    <div class="p-4 border-b border-gray-200 dark:border-gray-600">
        <form action="{{ $action }}" method="GET" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- Input para Fecha de inicio -->
                <div>
                    <x-input-label for="start_date" value="{{ __('components.work_logs_table.filter.label_start_date') }}" />
                    <x-text-input 
                        id="start_date" 
                        name="start_date" 
                        type="date" 
                        :value="old('start_date', request('start_date'))" 
                        class="mt-1 block w-full h-10 border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                    />
                    @error('start_date')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Input para Fecha de fin -->
                <div>
                    <x-input-label for="end_date" value="{{ __('components.work_logs_table.filter.label_end_date') }}" />
                    <x-text-input 
                        id="end_date" 
                        name="end_date" 
                        type="date" 
                        :value="old('end_date', request('end_date'))" 
                        class="mt-1 block w-full h-10 border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                    />
                    @error('end_date')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Dropdown para filtrar por Usuario -->
                <div>
                    <x-input-label for="user" value="{{ __('components.work_logs_table.filter.label_user') }}" />
                    <select id="user" name="user" class="mt-1 block w-full h-10 px-4 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-left">
                        <option value="">{{ __('components.work_logs_table.filter.option_all') }}</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ old('user', request('user')) == $user->id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('user')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mt-4">
                <x-primary-button type="submit" class="w-full bg-purple-600 hover:bg-purple-700 text-white font-semibold py-2 px-4 rounded">
                    {{ __('components.work_logs_table.filter.button_filter') }}
                </x-primary-button>
            </div>
        </form>
    </div>

    <!-- Tabla de Registros -->
    <div class="p-4 overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-600">
            <thead class="bg-gray-100 dark:bg-gray-800">
                <tr>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-700 dark:text-gray-200">
                        {{ __('components.work_logs_table.table.id') }}
                    </th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-700 dark:text-gray-200">
                        {{ __('components.work_logs_table.table.user') }}
                    </th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-700 dark:text-gray-200">
                        {{ __('components.work_logs_table.table.check_in') }}
                    </th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-700 dark:text-gray-200">
                        {{ __('components.work_logs_table.table.check_out') }}
                    </th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-700 dark:text-gray-200">
                        {{ __('components.work_logs_table.table.pause_start') }}
                    </th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-700 dark:text-gray-200">
                        {{ __('components.work_logs_table.table.pause_end') }}
                    </th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-700 dark:text-gray-200">
                        {{ __('components.work_logs_table.table.ordinary_hours') }}
                    </th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-700 dark:text-gray-200">
                        {{ __('components.work_logs_table.table.complementary_hours') }}
                    </th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-700 dark:text-gray-200">
                        {{ __('components.work_logs_table.table.overtime_hours') }}
                    </th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-700 dark:text-gray-200">
                        {{ __('components.work_logs_table.table.pause_minutes') }}
                    </th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-700 dark:text-gray-200">
                        {{ __('components.work_logs_table.table.hash') }}
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white dark:bg-gray-700 divide-y divide-gray-200 dark:divide-gray-600">
                @forelse($logs as $log)
                    <tr>
                        <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                            <a href="{{ route('admin.work_logs.edit', $log->id) }}" class="text-blue-600 hover:underline">
                                {{ $log->id }}
                            </a>
                        </td>
                        <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                            {{ $log->user->name ?? '-' }}
                        </td>
                        <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                            {{ $log->check_in }}
                        </td>
                        <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                            {{ $log->check_out ?? __('components.work_logs_table.ongoing') }}
                        </td>
                        <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                            {{ $log->pause_start ?? '-' }}
                        </td>
                        <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                            {{ $log->pause_end ?? '-' }}
                        </td>
                        <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                            {{ $log->ordinary_hours ?? '-' }}
                        </td>
                        <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                            {{ $log->complementary_hours ?? '-' }}
                        </td>
                        <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                            {{ $log->overtime_hours ?? '-' }}
                        </td>
                        <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                            {{ $log->pause_minutes ?? '-' }}
                        </td>
                        <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                            {{ $log->hash ?? __('components.work_logs_table.pending') }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="11" class="px-4 py-2 text-center text-sm text-gray-600 dark:text-gray-300">
                            {{ __('components.work_logs_table.table.no_records') }}
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
