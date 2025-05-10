<x-app-layout>
    <!-- Slot para el encabezado -->
    <x-slot name="header">
        <h1 class="text-2xl font-bold">
            {{ __('work_logs.edit.header', ['id' => $workLog->id]) }}
        </h1>
    </x-slot>

    <!-- Contenido principal -->
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Contenedor del formulario de edición -->
            <div class="bg-white shadow sm:rounded-lg p-6">
                <form action="{{ route('admin.work_logs.update', $workLog->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Grupo 1: Check In y Check Out -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Campo para Entrada (Check In) -->
                        <div class="mb-4">
                            <label for="check_in" class="block text-gray-700 font-bold">
                                {{ __('work_logs.edit.check_in_label') }}:
                            </label>
                            <input 
                                type="datetime-local" 
                                name="check_in" 
                                id="check_in"
                                required
                                value="{{ old('check_in', $workLog->check_in ? \Carbon\Carbon::parse($workLog->check_in)->format('Y-m-d\TH:i') : '') }}"
                                class="mt-1 block w-full border-gray-300 rounded-md" 
                            />
                            @error('check_in')
                                <x-input-error :messages="[$message]" />
                            @enderror
                        </div>

                        <!-- Campo para Salida (Check Out) -->
                        <div class="mb-4">
                            <label for="check_out" class="block text-gray-700 font-bold">
                                {{ __('work_logs.edit.check_out_label') }}:
                            </label>
                            <input 
                                type="datetime-local" 
                                name="check_out" 
                                id="check_out"
                                required
                                value="{{ old('check_out', $workLog->check_out ? \Carbon\Carbon::parse($workLog->check_out)->format('Y-m-d\TH:i') : '') }}"
                                class="mt-1 block w-full border-gray-300 rounded-md" 
                            />
                            @error('check_out')
                                <x-input-error :messages="[$message]" />
                            @enderror
                        </div>
                    </div>

                    <!-- Grupo 2: Datos de Pausa -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-6">
                        <!-- Campo para Hora de Inicio de la Pausa -->
                        <div class="mb-4">
                            <label for="pause_start" class="block text-gray-700 font-bold">
                                {{ __('work_logs.edit.pause_start_label') }}:
                            </label>
                            <input 
                                type="datetime-local" 
                                name="pause_start" 
                                id="pause_start"
                                value="{{ old('pause_start', $workLog->pause_start ? \Carbon\Carbon::parse($workLog->pause_start)->format('Y-m-d\TH:i') : '') }}"
                                class="mt-1 block w-full border-gray-300 rounded-md" 
                            />
                            @error('pause_start')
                                <x-input-error :messages="[$message]" />
                            @enderror
                        </div>

                        <!-- Campo para Hora de Finalización de la Pausa -->
                        <div class="mb-4">
                            <label for="pause_end" class="block text-gray-700 font-bold">
                                {{ __('work_logs.edit.pause_end_label') }}:
                            </label>
                            <input 
                                type="datetime-local" 
                                name="pause_end" 
                                id="pause_end"
                                value="{{ old('pause_end', $workLog->pause_end ? \Carbon\Carbon::parse($workLog->pause_end)->format('Y-m-d\TH:i') : '') }}"
                                class="mt-1 block w-full border-gray-300 rounded-md" 
                            />
                            @error('pause_end')
                                <x-input-error :messages="[$message]" />
                            @enderror
                        </div>
                    </div>

                    <!-- Grupo 3: Desglose de Horas y Pausa en minutos -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-6">
                        <!-- Campo para Horas Ordinarias -->
                        <div class="mb-4">
                            <label for="ordinary_hours" class="block text-gray-700 font-bold">
                                {{ __('work_logs.edit.ordinary_hours_label') }}:
                            </label>
                            <input 
                                type="number" 
                                name="ordinary_hours" 
                                id="ordinary_hours"
                                step="0.01"
                                value="{{ old('ordinary_hours', $workLog->ordinary_hours) }}"
                                class="mt-1 block w-full border-gray-300 rounded-md" 
                            />
                            @error('ordinary_hours')
                                <x-input-error :messages="[$message]" />
                            @enderror
                        </div>

                        <!-- Campo para Horas Complementarias -->
                        <div class="mb-4">
                            <label for="complementary_hours" class="block text-gray-700 font-bold">
                                {{ __('work_logs.edit.complementary_hours_label') }}:
                            </label>
                            <input 
                                type="number" 
                                name="complementary_hours" 
                                id="complementary_hours"
                                step="0.01"
                                value="{{ old('complementary_hours', $workLog->complementary_hours) }}"
                                class="mt-1 block w-full border-gray-300 rounded-md" 
                            />
                            @error('complementary_hours')
                                <x-input-error :messages="[$message]" />
                            @enderror
                        </div>

                        <!-- Campo para Horas Extraordinarias -->
                        <div class="mb-4">
                            <label for="overtime_hours" class="block text-gray-700 font-bold">
                                {{ __('work_logs.edit.overtime_hours_label') }}:
                            </label>
                            <input 
                                type="number" 
                                name="overtime_hours" 
                                id="overtime_hours"
                                step="0.01"
                                value="{{ old('overtime_hours', $workLog->overtime_hours) }}"
                                class="mt-1 block w-full border-gray-300 rounded-md" 
                            />
                            @error('overtime_hours')
                                <x-input-error :messages="[$message]" />
                            @enderror
                        </div>

                        <!-- Campo para Minutos de Pausa -->
                        <div class="mb-4">
                            <label for="pause_minutes" class="block text-gray-700 font-bold">
                                {{ __('work_logs.edit.pause_minutes_label') }}:
                            </label>
                            <input 
                                type="number" 
                                name="pause_minutes" 
                                id="pause_minutes"
                                value="{{ old('pause_minutes', $workLog->pause_minutes) }}"
                                class="mt-1 block w-full border-gray-300 rounded-md" 
                            />
                            @error('pause_minutes')
                                <x-input-error :messages="[$message]" />
                            @enderror
                        </div>
                    </div>

                    <!-- Campo de Hash actual (sólo lectura) -->
                    <div class="mb-4 mt-6">
                        <label for="hash" class="block text-gray-700 font-bold">
                            {{ __('work_logs.edit.current_hash_label') }}:
                        </label>
                        <input 
                            type="text" 
                            name="hash" 
                            id="hash" 
                            value="{{ $workLog->hash }}" 
                            readonly
                            class="mt-1 block w-full border-gray-300 rounded-md bg-gray-100" 
                        />
                    </div>

                    <!-- Botón para enviar el formulario -->
                    <button 
                        type="submit"
                        class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700"
                    >
                        {{ __('work_logs.edit.save_changes') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
