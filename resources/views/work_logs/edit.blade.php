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
                        <!-- Mostrar el error para 'check_in' debajo del input -->
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
                        <!-- Mostrar el error para 'check_out' debajo del input -->
                        @error('check_out')
                            <x-input-error :messages="[$message]" />
                        @enderror
                    </div>

                    <!-- Campo de Hash actual (sólo lectura) -->
                    <div class="mb-4">
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
