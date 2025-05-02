<x-app-layout>
    <!-- Slot para el header -->
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <!-- Contenedor central con espaciamiento vertical entre secciones -->
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            <!-- Sección de Bienvenida -->
            <div class="bg-white dark:bg-gray-700 shadow rounded-lg p-6">
                <h3 class="text-2xl font-semibold text-gray-900 dark:text-gray-100">
                    Bienvenido, {{ Auth::user()->name }}!
                </h3>
                <p class="mt-2 text-gray-600 dark:text-gray-300">
                    Explora tu actividad y gestiona tus registros desde aquí.
                </p>
            </div>

            <!-- Grid de tarjetas de resumen -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Tarjeta de Mis Work Logs -->
                <div class="bg-white dark:bg-gray-700 shadow rounded-lg p-6 text-center">
                    <h3 class="text-xl font-semibold mb-2">Mis Work Logs</h3>
                    <p class="text-gray-600 dark:text-gray-300">
                        Revisa y gestiona tus registros de entrada y salida.
                    </p>
                    <a href="{{ route('work_logs.index') }}" class="mt-4 inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded">
                        Ver Work Logs
                    </a>
                    <!-- Contador dinámico (asegúrate de que $logCount se pase a la vista) -->
                    <div class="mt-4">
                        <span class="text-xl font-bold text-gray-900 dark:text-gray-100">{{ $logCount }}</span>
                        <span class="text-sm text-gray-600 dark:text-gray-300"> Logs</span>
                    </div>
                </div>

                <!-- Tarjeta de Mi Perfil -->
                <div class="bg-white dark:bg-gray-700 shadow rounded-lg p-6 text-center">
                    <h3 class="text-xl font-semibold mb-2">Mi Perfil</h3>
                    <p class="text-gray-600 dark:text-gray-300">
                        Actualiza tus datos personales y configura tu cuenta.
                    </p>
                    <a href="{{ route('profile.edit') }}" class="mt-4 inline-block bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded">
                        Editar Perfil
                    </a>
                </div>

                <!-- Tarjeta de Estadísticas (opcional) -->
                <div class="bg-white dark:bg-gray-700 shadow rounded-lg p-6 text-center">
                    <h3 class="text-xl font-semibold mb-2">Estadísticas</h3>
                    <p class="text-gray-600 dark:text-gray-300">
                        Aquí podrías mostrar datos relevantes, como total de horas registradas o indicadores de actividad.
                    </p>
                    <!-- Ejemplo de dato adicional (ajusta según lo que necesites) -->
                    <div class="mt-4">
                        <span class="text-2xl font-bold text-gray-900 dark:text-gray-100">0</span>
                        <span class="text-sm text-gray-600 dark:text-gray-300"> Horas Registradas</span>
                    </div>
                </div>

                <!-- Nueva tarjeta para el Calendario -->
            <div class="bg-white dark:bg-gray-700 shadow rounded-lg p-6 text-center">
                <h3 class="text-xl font-semibold mb-2">Calendario</h3>
                <p class="text-gray-600 dark:text-gray-300">
                    Visualiza tu calendario anual y consulta los registros día a día.
                </p>
                <a href="{{ route('calendar.index') }}" class="mt-4 inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded">
                    Ver Calendario
                </a>
            </div>

            <div class="bg-white dark:bg-gray-700 shadow rounded-lg p-6 text-center">
                <h3 class="text-xl font-semibold mb-2">Exportar Informe</h3>
                <p class="text-gray-600 dark:text-gray-300">
                    Descarga tus registros de entrada y salida en formato Excel.
                </p>
                <a href="{{ route('worklogs.export.yearly', ['year' => 2025]) }}" class="mt-4 inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded">
                    Descargar Excel
                </a>
            </div>


            </div>
        </div>
    </div>
</x-app-layout>
