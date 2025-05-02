<x-app-layout>
    <x-slot name="header">
        <h1 class="text-2xl font-bold">Listado de Usuarios</h1>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            <!-- Formulario de búsqueda -->
            <div class="bg-white dark:bg-gray-700 shadow rounded-lg p-6">
                <form action="{{ route('admin.users.index') }}" method="GET" class="flex flex-col sm:flex-row items-center gap-4">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar por nombre o correo" class="w-full sm:w-96 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:border-blue-500">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded">
                        Buscar
                    </button>
                </form>
            </div>

            <!-- Tabla de usuarios -->
            <div class="bg-white dark:bg-gray-700 shadow rounded-lg overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-600">
                    <thead class="bg-gray-100 dark:bg-gray-800">
                        <tr>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-700 dark:text-gray-200">ID</th>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-700 dark:text-gray-200">Nombre</th>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-700 dark:text-gray-200">Correo</th>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-700 dark:text-gray-200">Rol</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-700 divide-y divide-gray-200 dark:divide-gray-600">
                        @forelse($users as $user)
                            <tr>
                                <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ $user->id }}</td>
                                <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                    <!-- Al hacer clic en el nombre se accede a su ficha de perfil -->
                                    <a href="{{ route('admin.users.show', $user) }}" class="text-blue-500 hover:underline">
                                        {{ $user->name }}
                                    </a>
                                </td>
                                <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                    <!-- Al hacer clic en el correo se abre el cliente de email -->
                                    <a href="mailto:{{ $user->email }}" class="text-blue-500 hover:underline">
                                        {{ $user->email }}
                                    </a>
                                </td>
                                <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ $user->role }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-4 py-2 text-center text-sm text-gray-600 dark:text-gray-300">
                                    No se encontraron usuarios.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Paginación -->
            <div>
                {{ $users->withQueryString()->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
