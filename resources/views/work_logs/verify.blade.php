<x-app-layout>
    <!-- Encabezado -->
    <x-slot name="header">
        <h1 class="text-2xl font-bold">
            {{ __('work_logs.verify.header') }}
        </h1>
    </x-slot>

    <!-- Contenido principal -->
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Área de resultado de verificación: se muestra si existe la variable $isValid --}}
            @isset($isValid)
                @if($isValid)
                    <div class="mb-4 p-4 bg-green-200 border border-green-500 rounded">
                        <h2 class="font-bold text-green-800">
                            {{ __('work_logs.verify.success.title') }}
                        </h2>
                        <p><strong>{{ __('work_logs.verify.success.check_in') }}:</strong> {{ $workLog->check_in }}</p>
                        <p><strong>{{ __('work_logs.verify.success.check_out') }}:</strong> {{ $workLog->check_out }}</p>
                        <p><strong>{{ __('work_logs.verify.success.user') }}:</strong> {{ optional($workLog->user)->name ?? 'N/A' }}</p>
                        <!-- Puedes agregar más información del registro aquí -->
                    </div>
                @else
                    <div class="mb-4 p-4 bg-red-100 border border-red-500 rounded">
                        <h2 class="font-bold text-red-800">
                            {{ __('work_logs.verify.failure.title') }}
                        </h2>
                        <p>{{ __('work_logs.verify.failure.message') }}</p>
                    </div>
                @endif
            @endisset

            {{-- Formulario para ingresar el código hash --}}
            <div class="bg-white shadow sm:rounded-lg p-6">
                <form action="{{ route('work_logs.verify.process') }}" method="POST">
                    @csrf
            
                    <div class="mb-4">
                        <label for="work_log_id" class="block text-gray-700 font-bold">
                            {{ __('work_logs.verify.form.id_label') }}
                        </label>
                        <input type="number" name="work_log_id" id="work_log_id" value="{{ old('work_log_id') }}" class="w-full border rounded p-2" placeholder="{{ __('work_logs.verify.form.id_placeholder') }}">
                    </div>

                    <div class="mb-4">
                        <label for="hash_code" class="block text-gray-700 font-bold">
                            {{ __('work_logs.verify.form.hash_label') }}
                        </label>
                        <input type="text" name="hash_code" id="hash_code" value="{{ old('hash_code') }}" class="w-full border rounded p-2" placeholder="{{ __('work_logs.verify.form.hash_placeholder') }}">
                    </div>

                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                        {{ __('work_logs.verify.form.button') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
