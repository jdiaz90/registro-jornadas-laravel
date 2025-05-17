<x-app-layout>
    <!-- Encabezado de la página -->
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
                <form id="work_log_form" action="{{ route('admin.work_logs.update', $workLog->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Grupo 1: Check In y Check Out -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Campo para Entrada (Check In) -->
                        <div class="mb-4">
                            <label for="check_in" class="block text-gray-700 font-bold">
                                {{ __('work_logs.edit.check_in_label') }}:
                            </label>
                            <x-text-input id="check_in" name="check_in" type="datetime-local" required
                                class="block w-full"
                                value="{{ old('check_in', $workLog->check_in ? \Carbon\Carbon::parse($workLog->check_in)->format('Y-m-d\TH:i') : '') }}" />
                            @error('check_in')
                                <x-input-error :messages="[$message]" />
                            @enderror
                        </div>

                        <!-- Campo para Salida (Check Out) -->
                        <div class="mb-4">
                            <label for="check_out" class="block text-gray-700 font-bold">
                                {{ __('work_logs.edit.check_out_label') }}:
                            </label>
                            <x-text-input id="check_out" name="check_out" type="datetime-local" required
                                class="block w-full"
                                value="{{ old('check_out', $workLog->check_out ? \Carbon\Carbon::parse($workLog->check_out)->format('Y-m-d\TH:i') : '') }}" />
                            @error('check_out')
                                <x-input-error :messages="[$message]" />
                            @enderror
                        </div>
                    </div>

                    <!-- Grupo 2: Datos de Pausa -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-6">
                        <!-- Campo para Inicio de Pausa -->
                        <div class="mb-4">
                            <label for="pause_start" class="block text-gray-700 font-bold">
                                {{ __('work_logs.edit.pause_start_label') }}:
                            </label>
                            <x-text-input id="pause_start" name="pause_start" type="datetime-local"
                                class="block w-full"
                                value="{{ old('pause_start', $workLog->pause_start ? \Carbon\Carbon::parse($workLog->pause_start)->format('Y-m-d\TH:i') : '') }}" />
                            @error('pause_start')
                                <x-input-error :messages="[$message]" />
                            @enderror
                        </div>

                        <!-- Campo para Fin de Pausa -->
                        <div class="mb-4">
                            <label for="pause_end" class="block text-gray-700 font-bold">
                                {{ __('work_logs.edit.pause_end_label') }}:
                            </label>
                            <x-text-input id="pause_end" name="pause_end" type="datetime-local"
                                class="block w-full"
                                value="{{ old('pause_end', $workLog->pause_end ? \Carbon\Carbon::parse($workLog->pause_end)->format('Y-m-d\TH:i') : '') }}" />
                            @error('pause_end')
                                <x-input-error :messages="[$message]" />
                            @enderror
                        </div>
                    </div>

                    <!-- Grupo 3: Desglose de Horas (solo lectura) -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-6">
                        <!-- Horas Ordinarias (solo lectura) -->
                        <div class="mb-4">
                            <label for="ordinary_hours" class="block text-gray-700 font-bold">
                                {{ __('work_logs.edit.ordinary_hours_label') }}:
                            </label>
                            <x-text-input id="ordinary_hours" name="ordinary_hours" type="number" step="0.01" readonly
                                class="block w-full"
                                value="{{ old('ordinary_hours', $workLog->ordinary_hours) }}" />
                            @error('ordinary_hours')
                                <x-input-error :messages="[$message]" />
                            @enderror
                        </div>

                        <!-- Horas Complementarias (solo lectura) -->
                        <div class="mb-4">
                            <label for="complementary_hours" class="block text-gray-700 font-bold">
                                {{ __('work_logs.edit.complementary_hours_label') }}:
                            </label>
                            <x-text-input id="complementary_hours" name="complementary_hours" type="number" step="0.01" readonly
                                class="block w-full"
                                value="{{ old('complementary_hours', $workLog->complementary_hours) }}" />
                            @error('complementary_hours')
                                <x-input-error :messages="[$message]" />
                            @enderror
                        </div>

                        <!-- Horas Extraordinarias (solo lectura) -->
                        <div class="mb-4">
                            <label for="overtime_hours" class="block text-gray-700 font-bold">
                                {{ __('work_logs.edit.overtime_hours_label') }}:
                            </label>
                            <x-text-input id="overtime_hours" name="overtime_hours" type="number" step="0.01" readonly
                                class="block w-full"
                                value="{{ old('overtime_hours', $workLog->overtime_hours) }}" />
                            @error('overtime_hours')
                                <x-input-error :messages="[$message]" />
                            @enderror
                        </div>

                        <!-- Minutos de Pausa (solo lectura) -->
                        <div class="mb-4">
                            <label for="pause_minutes" class="block text-gray-700 font-bold">
                                {{ __('work_logs.edit.pause_minutes_label') }}:
                            </label>
                            <x-text-input id="pause_minutes" name="pause_minutes" type="number" readonly
                                class="block w-full"
                                value="{{ old('pause_minutes', $workLog->pause_minutes) }}" />
                            @error('pause_minutes')
                                <x-input-error :messages="[$message]" />
                            @enderror
                        </div>
                    </div>

                    <!-- Campo de Hash (solo lectura) -->
                    <div class="mb-4 mt-6">
                        <label for="hash" class="block text-gray-700 font-bold">
                            {{ __('work_logs.edit.current_hash_label') }}:
                        </label>
                        <x-text-input id="hash" name="hash" type="text" readonly
                            class="block w-full bg-gray-100"
                            value="{{ $workLog->hash }}" />
                    </div>

                    <!-- Grupo 4: Motivo de Modificación con Contador -->
                    <div class="mb-4 mt-6">
                        <label for="modification_reason" class="block text-gray-700 font-bold">
                            {{ __('work_logs.edit.modification_reason_label', ['id' => $workLog->id]) }}:
                        </label>
                        <textarea name="modification_reason" id="modification_reason" required
                            class="mt-1 block w-full border-gray-300 rounded-md" rows="3" maxlength="255">{{ old('modification_reason') }}</textarea>
                        <small id="charCount" class="block text-sm text-gray-500 mt-1">
                            {{ __('work_logs.edit.char_count', ['count' => 0, 'max' => 255]) }}
                        </small>
                        @error('modification_reason')
                            <x-input-error :messages="[$message]" />
                        @enderror
                    </div>

                    <!-- Botón para Enviar -->
                    <div class="mt-6">
                        <x-primary-button class="w-full">
                            {{ __('work_logs.edit.save_changes') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Script para Cálculo Automático de Horas y Contador de Caracteres -->
    <script>
        // Plantilla para el contador utilizando etiquetas de idioma
        const charCountTemplate = "{{ __('work_logs.edit.char_count', ['count' => ':count', 'max' => ':max']) }}";

        function formatCharCount(count, max) {
            return charCountTemplate.replace(':count', count).replace(':max', max);
        }

        // Función para calcular las horas en función de las fechas de entrada, salida y pausa.
        function calculateHours() {
            const checkInStr  = document.getElementById('check_in').value;
            const checkOutStr = document.getElementById('check_out').value;
            if (!checkInStr || !checkOutStr) return;

            const checkIn  = new Date(checkInStr);
            const checkOut = new Date(checkOutStr);
            const workedMinutes = Math.abs((checkOut - checkIn) / 60000);

            const pauseStartStr = document.getElementById('pause_start').value;
            const pauseEndStr   = document.getElementById('pause_end').value;
            let pauseMinutes = 0;
            if (pauseStartStr && pauseEndStr) {
                const pauseStart = new Date(pauseStartStr);
                const pauseEnd   = new Date(pauseEndStr);
                pauseMinutes = Math.abs((pauseEnd - pauseStart) / 60000);
            }
            document.getElementById('pause_minutes').value = Math.round(pauseMinutes);

            const netWorkedMinutes = workedMinutes - pauseMinutes;
            const assignedMinutes  = 7 * 60; // 420 minutos
            let ordinaryHours = 0, complementaryHours = 0, overtimeHours = 0;

            const contractType = "{{ $workLog->user->contract_type }}";
            if (netWorkedMinutes <= assignedMinutes) {
                ordinaryHours = netWorkedMinutes / 60;
            } else {
                ordinaryHours = assignedMinutes / 60;
                const extraMinutes = netWorkedMinutes - assignedMinutes;
                if (contractType === 'fulltime') {
                    overtimeHours = extraMinutes / 60;
                } else {
                    complementaryHours = extraMinutes / 60;
                }
            }

            document.getElementById('ordinary_hours').value = ordinaryHours.toFixed(2);
            document.getElementById('complementary_hours').value = complementaryHours.toFixed(2);
            document.getElementById('overtime_hours').value = overtimeHours.toFixed(2);
        }

        // Se actualizan los cálculos al modificar los campos de fecha y pausa.
        document.getElementById('check_in').addEventListener('input', calculateHours);
        document.getElementById('check_out').addEventListener('input', calculateHours);
        document.getElementById('pause_start').addEventListener('input', calculateHours);
        document.getElementById('pause_end').addEventListener('input', calculateHours);

        // Actualizar el contador de caracteres en tiempo real para el textarea "modification_reason".
        const textarea = document.getElementById('modification_reason');
        const charCount = document.getElementById('charCount');

        function updateCharCount() {
            const count = textarea.value.length;
            charCount.textContent = formatCharCount(count, 255);
            charCount.style.color = count >= 220 ? 'red' : 'gray';
        }
        updateCharCount();
        textarea.addEventListener('input', updateCharCount);
    </script>
</x-app-layout>
