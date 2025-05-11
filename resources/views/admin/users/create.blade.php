<x-app-layout>
    <!-- Encabezado -->
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-200">
                {{ __('admin.users.create.header') }}
            </h1>
            <a href="{{ route('admin.users.index') }}" class="text-blue-500 hover:underline">
                {{ __('admin.users.show.back_to_list') }}
            </a>
        </div>
    </x-slot>

    <!-- Contenido principal -->
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('error'))
                <div class="mb-4 p-4 bg-red-100 text-red-600 border border-red-200 rounded">
                    {{ session('error') }}
                </div>
            @endif
            
            <!-- Formulario de creación del usuario -->
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                <form action="{{ route('admin.users.store') }}" method="POST">
                    @csrf
                    <!-- Grupo: Datos del Usuario -->
                    <div class="mb-6">
                        <h2 class="text-xl font-bold text-gray-800 dark:text-gray-200">
                           {{ __('admin.users.create.info_title') }}
                        </h2>
                    </div>

                    <!-- Campo: Nombre -->
                    <div class="mb-4">
                        <label for="name" class="block text-sm font-bold text-gray-700">
                            {{ __('admin.users.create.form.name') }}
                        </label>
                        <input 
                            type="text"
                            id="name"
                            name="name"
                            value="{{ old('name') }}"
                            class="mt-1 block w-full border border-gray-300 rounded-md"
                            required
                        />
                        @error('name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Campo: Correo Electrónico -->
                    <div class="mb-4">
                        <label for="email" class="block text-sm font-bold text-gray-700">
                            {{ __('admin.users.create.form.email') }}
                        </label>
                        <input 
                            type="email"
                            id="email"
                            name="email"
                            value="{{ old('email') }}"
                            class="mt-1 block w-full border border-gray-300 rounded-md"
                            required
                        />
                        @error('email')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Grupo en dos columnas: Rol y Tipo de Contrato -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Campo: Rol -->
                        <div class="mb-4">
                            <label for="role" class="block text-sm font-bold text-gray-700">
                                {{ __('admin.users.create.form.role') }}
                            </label>
                            <select id="role" name="role" class="mt-1 block w-full border border-gray-300 rounded-md" required>
                                <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>
                                    {{ __('admin.users.create.form.options.user') }}
                                </option>
                                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>
                                    {{ __('admin.users.create.form.options.admin') }}
                                </option>
                            </select>
                            @error('role')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Campo: Tipo de Contrato -->
                        <div class="mb-4">
                            <label for="contract_type" class="block text-sm font-bold text-gray-700">
                                {{ __('admin.users.create.form.contract_type') }}
                            </label>
                            <select id="contract_type" name="contract_type" class="mt-1 block w-full border border-gray-300 rounded-md" required>
                                <option value="fulltime" {{ old('contract_type') == 'fulltime' ? 'selected' : '' }}>
                                    {{ __('admin.users.create.form.options.fulltime') }}
                                </option>
                                <option value="parttime" {{ old('contract_type') == 'parttime' ? 'selected' : '' }}>
                                    {{ __('admin.users.create.form.options.parttime') }}
                                </option>
                            </select>
                            @error('contract_type')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    
                    <!-- Sección: Horario de Trabajo (solo horas) -->
                    @php
                        // Array con las claves de los días.
                        $weekdayKeys = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
                        // Como es creación, probablemente el usuario no tenga schedule aún.
                        $schedule = null;
                    @endphp

                    <div class="mt-8">
                        <h2 class="text-xl font-bold text-gray-800 dark:text-gray-200 mb-4">
                            {{ __('admin.users.create.schedule.title') }}
                        </h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach($weekdayKeys as $dayKey)
                                <div class="mb-4">
                                    <label class="block text-sm font-bold text-gray-700">
                                        {{ __('admin.weekdays.' . $dayKey) }} - {{ __('admin.users.create.schedule.hours') }}
                                    </label>
                                    <input 
                                        type="number" 
                                        name="work_schedule[{{ $dayKey }}_hours]" 
                                        value="{{ old("work_schedule.{$dayKey}_hours") }}"
                                        min="0" max="24"
                                        class="mt-1 block w-full border border-gray-300 rounded-md"
                                        required
                                    />
                                    @error("work_schedule.{$dayKey}_hours")
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Botón para Guardar Cambios -->
                    <div class="mt-6">
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                            {{ __('admin.users.create.form.save_changes') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
