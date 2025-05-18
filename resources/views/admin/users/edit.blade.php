<x-app-layout>
    <!-- Encabezado -->
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-200">
                {{ __('admin.users.edit.header', ['name' => $user->name]) }}
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
            
            <!-- Formulario de edición del usuario -->
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Grupo: Datos del Usuario -->
                    <div class="mb-6">
                        <h2 class="text-xl font-bold text-gray-800 dark:text-gray-200">
                           {{ __('admin.users.edit.info_title') }}
                        </h2>
                    </div>

                    <!-- Campo: Nombre -->
                    <div class="mb-4">
                        <x-input-label for="name" value="{{ __('admin.users.edit.form.name') }}" />
                        <x-text-input 
                            id="name" 
                            name="name" 
                            type="text"
                            :value="old('name', $user->name)" 
                            class="mt-1 block w-full border border-gray-300 rounded-md"
                            required
                        />
                        @error('name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Campo: Correo Electr\u00F3nico -->
                    <div class="mb-4">
                        <x-input-label for="email" value="{{ __('admin.users.edit.form.email') }}" />
                        <x-text-input 
                            id="email" 
                            name="email" 
                            type="email"
                            :value="old('email', $user->email)" 
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
                            <x-input-label for="role" value="{{ __('admin.users.edit.form.role') }}" />
                            <select id="role" name="role" class="mt-1 block w-full border border-gray-300 rounded-md" required>
                                <option value="user" {{ old('role', $user->role) == 'user' ? 'selected' : '' }}>
                                    {{ __('admin.users.edit.form.options.user') }}
                                </option>
                                <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>
                                    {{ __('admin.users.edit.form.options.admin') }}
                                </option>
                            </select>
                            @error('role')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Campo: Tipo de Contrato -->
                        <div class="mb-4">
                            <x-input-label for="contract_type" value="{{ __('admin.users.edit.form.contract_type') }}" />
                            <select id="contract_type" name="contract_type" class="mt-1 block w-full border border-gray-300 rounded-md" required>
                                <option value="fulltime" {{ old('contract_type', $user->contract_type) == 'fulltime' ? 'selected' : '' }}>
                                    {{ __('admin.users.edit.form.options.fulltime') }}
                                </option>
                                <option value="parttime" {{ old('contract_type', $user->contract_type) == 'parttime' ? 'selected' : '' }}>
                                    {{ __('admin.users.edit.form.options.parttime') }}
                                </option>
                            </select>
                            @error('contract_type')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    
                    <!-- Sección: Horario de Trabajo (solo horas) -->
                    @php
                        // Array con las claves de los d\u00EDas
                        $weekdayKeys = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
                        // Si el usuario tiene un workSchedule, se usar\u00E1; en caso contrario, se mostrar\u00E1 vac\u00EDo.
                        $schedule = $user->workSchedule;
                    @endphp

                    <div class="mt-8">
                        <h2 class="text-xl font-bold text-gray-800 dark:text-gray-200 mb-4">
                            {{ __('admin.users.edit.schedule.title') }}
                        </h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach($weekdayKeys as $dayKey)
                                <div class="mb-4">
                                    <x-input-label value="{{ __('admin.weekdays.' . $dayKey) }} - {{ __('admin.users.edit.schedule.hours') }}" />
                                    <x-text-input 
                                        type="number" 
                                        name="work_schedule[{{ $dayKey }}_hours]" 
                                        :value="old('work_schedule.' . $dayKey . '_hours', isset($schedule) ? $schedule->{$dayKey . '_hours'} : '')" 
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
                        <x-primary-button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                            {{ __('admin.users.edit.form.save_changes') }}
                        </x-primary-button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</x-app-layout>
