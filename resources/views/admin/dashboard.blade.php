<!-- resources/views/admin/dashboard.blade.php -->

<x-app-layout>
    <!-- Slot para el encabezado del dashboard -->
    <x-slot name="header">
        <h1 class="text-2xl font-bold text-gray-800">Dashboard Administrador</h1>
    </x-slot>

    <!-- Contenido principal del dashboard -->
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Panel de resumen o estadísticas -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <p class="text-gray-700">Bienvenido al panel administrativo. Aquí podrás ver estadísticas, informes y gestionar usuarios.</p>
                <!-- Puedes incluir otros componentes, gráficos, o secciones de resumen que necesites -->
            </div>
        </div>
    </div>
</x-app-layout>
