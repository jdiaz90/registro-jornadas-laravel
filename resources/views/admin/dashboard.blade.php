<x-app-layout>
    <!-- Slot para el header -->
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Panel de Administración') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <!-- Contenedor central con espaciamiento vertical entre secciones -->
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            <!-- Sección de Bienvenida -->
            <div class="bg-white dark:bg-gray-700 shadow rounded-lg p-6">
                <h3 class="text-2xl font-semibold text-gray-900 dark:text-gray-100">
                    Bienvenido, Administrador {{ Auth::user()->name }}!
                </h3>
                <p class="mt-2 text-gray-600 dark:text-gray-300">
                    Accede al panel para gestionar usuarios, revisar registros y obtener estadísticas del sistema.
                </p>
            </div>

            <!-- Grid de tarjetas de resumen -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Tarjeta: Gestión de Usuarios -->
                <div class="bg-white dark:bg-gray-700 shadow rounded-lg p-6 text-center">
                    <h3 class="text-xl font-semibold mb-2">Gestión de Usuarios</h3>
                    <p class="text-gray-600 dark:text-gray-300">
                        Administra usuarios, revisa perfiles y actualiza datos.
                    </p>
                    <a href="{{ route('admin.users.index') }}" class="mt-4 inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded">
                        Ver Usuarios
                    </a>
                </div>

                <!-- Tarjeta: Registros de Jornada -->
                <div class="bg-white dark:bg-gray-700 shadow rounded-lg p-6 text-center">
                    <h3 class="text-xl font-semibold mb-2">Registros de Jornada</h3>
                    <p class="text-gray-600 dark:text-gray-300">
                        Consulta y filtra los work logs de los usuarios.
                    </p>
                    <a href="{{ route('work_logs.index') }}" class="mt-4 inline-block bg-yellow-600 hover:bg-yellow-700 text-white font-semibold py-2 px-4 rounded">
                        Ver Work Logs
                    </a>
                </div>

                <!-- Tarjeta: Estadísticas Globales -->
                <div class="bg-white dark:bg-gray-700 shadow rounded-lg p-6 text-center">
                    <h3 class="text-xl font-semibold mb-2">Estadísticas Globales</h3>
                    <p class="text-gray-600 dark:text-gray-300">
                        Muestra datos relevantes y totales del sistema.
                    </p>
                    <a href="{{-- route('admin.statistics') --}}" class="mt-4 inline-block bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded">
                        Ver Estadísticas
                    </a>
                </div>

                <!-- Tarjeta: Calendario -->
                <div class="bg-white dark:bg-gray-700 shadow rounded-lg p-6 text-center">
                    <h3 class="text-xl font-semibold mb-2">Calendario</h3>
                    <p class="text-gray-600 dark:text-gray-300">
                        Consulta el calendario de actividades y registros.
                    </p>
                    <a href="{{ route('calendar.index') }}" class="mt-4 inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded">
                        Ver Calendario
                    </a>
                </div>

                <!-- Tarjeta: Exportar Informes -->
                <div class="bg-white dark:bg-gray-700 shadow rounded-lg p-6 text-center">
                    <h3 class="text-xl font-semibold mb-2">Exportar Informes</h3>
                    <p class="text-gray-600 dark:text-gray-300">
                        Descarga informes en formato Excel para análisis.
                    </p>
                    <a href="{{ route('worklogs.export.yearly', ['year' => date('Y')]) }}" class="mt-4 inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded">
                        Descargar Excel
                    </a>
                </div>
                
                <!-- Tarjeta: Configuraciones -->
                <div class="bg-white dark:bg-gray-700 shadow rounded-lg p-6 text-center">
                    <h3 class="text-xl font-semibold mb-2">Configuraciones</h3>
                    <p class="text-gray-600 dark:text-gray-300">
                        Accede a ajustes avanzados del sistema y administra permisos.
                    </p>
                    <a href="{{-- route('admin.settings') --}}" class="mt-4 inline-block bg-purple-600 hover:bg-purple-700 text-white font-semibold py-2 px-4 rounded">
                        Configurar
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
