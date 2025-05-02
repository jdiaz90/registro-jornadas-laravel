<x-app-layout>
    <!-- Header (slot) -->
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-200">
                Ficha del Usuario: {{ $user->name }}
            </h1>
            <a href="{{ route('admin.users.index') }}" class="text-blue-500 hover:underline">
                Volver al listado
            </a>
        </div>
    </x-slot>

    <!-- Contenido principal -->
    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Datos básicos del usuario -->
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200 mb-4">
                    Información del Usuario
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Nombre</p>
                        <p class="text-lg font-medium text-gray-900 dark:text-gray-100">{{ $user->name }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Email</p>
                        <p class="text-lg font-medium text-gray-900 dark:text-gray-100">{{ $user->email }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Rol</p>
                        <p class="text-lg font-medium text-gray-900 dark:text-gray-100">{{ $user->role }}</p>
                    </div>
                </div>
            </div>

            <!-- Aquí invocamos el componente reutilizable para el historial de registros -->
            <x-work-logs-table 
                :logs="$logs" 
                title="Historial de Registros de Jornada" 
                :action="route('admin.users.show', $user)" 
            />
        </div>
    </div>
</x-app-layout>
