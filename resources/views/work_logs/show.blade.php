<x-app-layout>
    <!-- Slot para el encabezado con margen inferior -->
    <x-slot name="header">
        <div class="mb-4">
            <h1 class="text-2xl font-bold">
                {{ __('work_logs.show.header', ['id' => $workLog->id]) }}
            </h1>
        </div>
    </x-slot>

    <!-- Contenido principal -->
    <div class="py-6">
        <!-- Incluir el componente reutilizable -->
        <x-work-log-detail :workLog="$workLog" :audits="$audits" />
    </div>
</x-app-layout>
