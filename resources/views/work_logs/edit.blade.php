<x-app-layout>
    <!-- Encabezado de la página -->
    <x-slot name="header">
        <h1 class="text-2xl font-bold">{{ __('work_logs.edit.header', ['id' => $workLog->id]) }}</h1>
    </x-slot>

    <!-- Contenido principal -->
    <div class="py-6" data-contract-type="{{ $workLog->user->contract_type }}">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Formulario de edición -->
            <form id="work_log_form" action="{{ route('admin.work_logs.update', $workLog->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <!-- Agrupación 1: Fechas y pausas -->
                <div class="mb-6 p-4 border border-gray-200 rounded">
                    <h2 class="text-lg font-semibold mb-4">{{ __('work_logs.edit.time_fields_title') }}</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Check In -->
                        <div>
                            <x-input-label for="check_in" value="{{ __('work_logs.edit.check_in_label') }}" />
                            <x-text-input id="check_in" name="check_in" type="datetime-local" required class="block w-full"
                                value="{{ old('check_in', $workLog->check_in ? \Carbon\Carbon::parse($workLog->check_in)->format('Y-m-d\TH:i') : '') }}" />
                            @error('check_in')
                                <x-input-error :messages="[$message]" />
                            @enderror
                        </div>
                        <!-- Check Out -->
                        <div>
                            <x-input-label for="check_out" value="{{ __('work_logs.edit.check_out_label') }}" />
                            <x-text-input id="check_out" name="check_out" type="datetime-local" required class="block w-full"
                                value="{{ old('check_out', $workLog->check_out ? \Carbon\Carbon::parse($workLog->check_out)->format('Y-m-d\TH:i') : '') }}" />
                            @error('check_out')
                                <x-input-error :messages="[$message]" />
                            @enderror
                        </div>
                        <!-- Inicio de Pausa -->
                        <div>
                            <x-input-label for="pause_start" value="{{ __('work_logs.edit.pause_start_label') }}" />
                            <x-text-input id="pause_start" name="pause_start" type="datetime-local" class="block w-full"
                                value="{{ old('pause_start', $workLog->pause_start ? \Carbon\Carbon::parse($workLog->pause_start)->format('Y-m-d\TH:i') : '') }}" />
                            @error('pause_start')
                                <x-input-error :messages="[$message]" />
                            @enderror
                        </div>
                        <!-- Fin de Pausa -->
                        <div>
                            <x-input-label for="pause_end" value="{{ __('work_logs.edit.pause_end_label') }}" />
                            <x-text-input id="pause_end" name="pause_end" type="datetime-local" class="block w-full"
                                value="{{ old('pause_end', $workLog->pause_end ? \Carbon\Carbon::parse($workLog->pause_end)->format('Y-m-d\TH:i') : '') }}" />
                            @error('pause_end')
                                <x-input-error :messages="[$message]" />
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Agrupación 2: Horas Calculadas -->
                <div class="mb-6 p-4 border border-gray-200 rounded">
                    <h2 class="text-lg font-semibold mb-4">{{ __('work_logs.edit.hour_fields_title') }}</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Horas Ordinarias -->
                        <div>
                            <x-input-label for="ordinary_hours" value="{{ __('work_logs.edit.ordinary_hours_label') }}" />
                            <x-text-input id="ordinary_hours" name="ordinary_hours" type="number" step="0.01" readonly class="block w-full"
                                value="{{ old('ordinary_hours', $workLog->ordinary_hours) }}" />
                            @error('ordinary_hours')
                                <x-input-error :messages="[$message]" />
                            @enderror
                        </div>
                        <!-- Horas Complementarias -->
                        <div>
                            <x-input-label for="complementary_hours" value="{{ __('work_logs.edit.complementary_hours_label') }}" />
                            <x-text-input id="complementary_hours" name="complementary_hours" type="number" step="0.01" readonly class="block w-full"
                                value="{{ old('complementary_hours', $workLog->complementary_hours) }}" />
                            @error('complementary_hours')
                                <x-input-error :messages="[$message]" />
                            @enderror
                        </div>
                        <!-- Horas Extraordinarias -->
                        <div>
                            <x-input-label for="overtime_hours" value="{{ __('work_logs.edit.overtime_hours_label') }}" />
                            <x-text-input id="overtime_hours" name="overtime_hours" type="number" step="0.01" readonly class="block w-full"
                                value="{{ old('overtime_hours', $workLog->overtime_hours) }}" />
                            @error('overtime_hours')
                                <x-input-error :messages="[$message]" />
                            @enderror
                        </div>
                        <!-- Minutos de Pausa -->
                        <div>
                            <x-input-label for="pause_minutes" value="{{ __('work_logs.edit.pause_minutes_label') }}" />
                            <x-text-input id="pause_minutes" name="pause_minutes" type="number" readonly class="block w-full"
                                value="{{ old('pause_minutes', $workLog->pause_minutes) }}" />
                            @error('pause_minutes')
                                <x-input-error :messages="[$message]" />
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Otros campos -->
                <!-- Campo de Hash (solo lectura) -->
                <div class="mb-4">
                    <x-input-label for="hash" value="{{ __('work_logs.edit.current_hash_label') }}" />
                    <x-text-input id="hash" name="hash" type="text" readonly class="block w-full bg-gray-100"
                        value="{{ $workLog->hash }}" />
                </div>

                <!-- Motivo de Modificación con contador de caracteres -->
                <div class="mb-4">
                    <x-input-label for="modification_reason" value="{{ __('work_logs.edit.modification_reason_label', ['id' => $workLog->id]) }}" />
                    <textarea name="modification_reason" id="modification_reason" required class="mt-1 block w-full border-gray-300 rounded-md" rows="3" maxlength="255">{{ old('modification_reason') }}</textarea>
                    <small id="charCount" class="block text-sm text-gray-500 mt-1">{{ __('work_logs.edit.char_count', ['count' => 0, 'max' => 255]) }}</small>
                    @error('modification_reason')
                        <x-input-error :messages="[$message]" />
                    @enderror
                </div>

                <!-- Botón de envío -->
                <div class="mt-6">
                    <x-primary-button class="w-full">{{ __('work_logs.edit.save_changes') }}</x-primary-button>
                </div>
            </form>
        </div>
    </div>

    <!-- Incluir el archivo JavaScript mediante Vite -->
    @vite('resources/js/workLogEdit.js')
</x-app-layout>
