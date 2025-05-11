<x-app-layout>
    <!-- Header (slot) -->
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-200">
                {{ __('admin.users.show.title', ['name' => $user->name]) }}
            </h1>
            <div class="flex space-x-4">
                <a href="{{ route('admin.users.edit', $user->id) }}" class="text-blue-500 hover:underline">
                    {{ __('admin.users.show.edit_button') }}
                </a>
                <a href="{{ route('admin.users.index') }}" class="text-blue-500 hover:underline">
                    {{ __('admin.users.show.back_to_list') }}
                </a>
            </div>
        </div>
    </x-slot>

    <!-- Contenido principal -->
    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Datos básicos del usuario -->
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200 mb-4">
                    {{ __('admin.users.show.info_title') }}
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Nombre -->
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            {{ __('admin.users.show.labels.name') }}
                        </p>
                        <p class="text-lg font-medium text-gray-900 dark:text-gray-100">
                            {{ $user->name }}
                        </p>
                    </div>
                    <!-- Email -->
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            {{ __('admin.users.show.labels.email') }}
                        </p>
                        <p class="text-lg font-medium text-gray-900 dark:text-gray-100">
                            {{ $user->email }}
                        </p>
                    </div>
                    <!-- Rol -->
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            {{ __('admin.users.show.labels.role') }}
                        </p>
                        <p class="text-lg font-medium text-gray-900 dark:text-gray-100">
                            {{ $user->role }}
                        </p>
                    </div>
                    <!-- Tipo de Contrato -->
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            {{ __('admin.users.show.labels.contract_type') }}
                        </p>
                        <p class="text-lg font-medium text-gray-900 dark:text-gray-100">
                            {{ $user->contract_type }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Sección de Horarios de Trabajo -->
            @if($user->workSchedule)
                @php
                    // Utilizamos las traducciones centralizadas para los días de la semana
                    $days = [
                        'monday'    => __('admin.weekdays.monday'),
                        'tuesday'   => __('admin.weekdays.tuesday'),
                        'wednesday' => __('admin.weekdays.wednesday'),
                        'thursday'  => __('admin.weekdays.thursday'),
                        'friday'    => __('admin.weekdays.friday'),
                        'saturday'  => __('admin.weekdays.saturday'),
                        'sunday'    => __('admin.weekdays.sunday'),
                    ];

                    // Filtrado: si es sábado o domingo y no tiene horas asignadas, se omiten
                    $filteredDays = [];
                    foreach ($days as $dayKey => $dayLabel) {
                        $hours = $user->workSchedule->{$dayKey . '_hours'} ?? 0;
                        if (in_array($dayKey, ['saturday', 'sunday']) && $hours == 0) {
                            continue;
                        }
                        $filteredDays[$dayKey] = $dayLabel;
                    }

                    // Determinar si se debe mostrar la columna de "Minutos de descanso" y calcular el total de horas.
                    $showBreakColumn = false;
                    $totalHours = 0;
                    foreach ($filteredDays as $dayKey => $dayLabel) {
                        $hours = $user->workSchedule->{$dayKey . '_hours'} ?? 0;
                        $break = $user->workSchedule->{$dayKey . '_break_minutes'} ?? 0;
                        if ($break > 0) {
                            $showBreakColumn = true;
                        }
                        $totalHours += $hours;
                    }
                @endphp

                <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                    <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200 mb-4">
                        {{ __('admin.users.show.work_schedule_title') }}
                    </h2>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-900">
                                <tr>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-400">
                                        {{ __('admin.users.show.schedule.day') }}
                                    </th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-400">
                                        {{ __('admin.users.show.schedule.assigned_hours') }}
                                    </th>
                                    @if($showBreakColumn)
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-400">
                                            {{ __('admin.users.show.schedule.break_minutes') }}
                                        </th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach($filteredDays as $dayKey => $dayLabel)
                                    <tr>
                                        <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                            {{ $dayLabel }}
                                        </td>
                                        <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                            {{ $user->workSchedule->{$dayKey . '_hours'} ?? 0 }}
                                        </td>
                                        @if($showBreakColumn)
                                            <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                                {{ $user->workSchedule->{$dayKey . '_break_minutes'} ?? 0 }}
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="bg-gray-50 dark:bg-gray-900">
                                <tr>
                                    <td class="px-4 py-2 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                                        {{ __('admin.users.show.schedule.total') }}
                                    </td>
                                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                        {{ $totalHours }}
                                    </td>
                                    @if($showBreakColumn)
                                        <td></td>
                                    @endif
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            @else
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        {{ __('admin.users.show.no_work_schedule') }}
                    </p>
                </div>
            @endif

            <!-- Inclusión del partial para el historial de Work Logs -->
            @include('work_logs.partials.work-logs-table', [
                'logs'   => $logs,
                'title'  => __('admin.users.show.work_logs_title'),
                'action' => route('admin.users.show', $user)
            ])
        </div>
    </div>
</x-app-layout>
