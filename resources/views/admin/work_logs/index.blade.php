<x-app-layout>
    <!-- Slot para el header -->
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('admin.page_titles.admin_work_logs_index') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <!-- Contenedor principal -->
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            <!-- Componente de Historial de Registros con Filtros -->
            @include('admin.work_logs.partials.work-logs-table', [
                'logs'   => $logs,
                'title'  => __('work_logs.index.history_title'),
            ])

        </div>
    </div>
</x-app-layout>
