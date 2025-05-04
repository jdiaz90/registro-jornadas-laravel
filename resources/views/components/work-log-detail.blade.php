<div class="max-w-7xl mx-auto space-y-8 sm:px-6 lg:px-8">
    
    <!-- Apartado 1: Información Actual -->
    <div class="bg-white shadow sm:rounded-lg p-6">
        <h2 class="text-xl font-semibold mb-4">
            {{ __('components.work_log_detail.current_info_title') }}
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- Usuario -->
            <div>
                <strong>{{ __('components.work_log_detail.label.user') }}</strong> {{ $workLog->user->name ?? 'N/A' }}
            </div>
            <!-- Hash, con texto pequeño y que se ajuste con break-words -->
            <div>
                <strong>{{ __('components.work_log_detail.label.hash') }}:</strong>
                <div class="text-xs break-words">
                    {{ $workLog->hash ?? '-' }}
                </div>
            </div>
            <!-- Entrada -->
            <div>
                <strong>{{ __('components.work_log_detail.label.check_in') }}:</strong> {{ $workLog->check_in ?? '-' }}
            </div>
            <!-- Salida -->
            <div>
                <strong>{{ __('components.work_log_detail.label.check_out') }}:</strong> {{ $workLog->check_out ?? '-' }}
            </div>
            <!-- Creado -->
            <div>
                <strong>{{ __('components.work_log_detail.label.created_at') }}</strong> {{ $workLog->created_at }}
            </div>
            <!-- Actualizado -->
            <div>
                <strong>{{ __('components.work_log_detail.label.updated_at') }}</strong> {{ $workLog->updated_at }}
            </div>
        </div>
    </div>
    
    <!-- Apartado 2: Historial de Cambios -->
    <div class="bg-white shadow sm:rounded-lg p-6">
        <h2 class="text-xl font-semibold mb-4">
            {{ __('components.work_log_detail.audit_history_title') }}
        </h2>
        @if($audits->count())
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                {{ __('components.work_log_detail.table.date') }}
                            </th>
                            <th class="px-4 py-2 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                {{ __('components.work_log_detail.table.modified_fields') }}
                            </th>
                            <th class="px-4 py-2 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                {{ __('components.work_log_detail.table.old_value') }}
                            </th>
                            <th class="px-4 py-2 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                {{ __('components.work_log_detail.table.new_value') }}
                            </th>
                            <th class="px-4 py-2 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                {{ __('components.work_log_detail.table.updated_by') }}
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($audits as $audit)
                            <tr>
                                <td class="px-4 py-2 whitespace-nowrap">
                                    {{ $audit->created_at->format('d/m/Y H:i') }}
                                </td>
                                <td class="px-4 py-2 whitespace-nowrap">
                                    @if($audit->old_check_in !== $audit->new_check_in)
                                        <div>{{ __('components.work_log_detail.label.check_in') }}</div>
                                    @endif
                                    @if($audit->old_check_out !== $audit->new_check_out)
                                        <div>{{ __('components.work_log_detail.label.check_out') }}</div>
                                    @endif
                                    @if($audit->old_hash !== $audit->new_hash)
                                        <div>{{ __('components.work_log_detail.label.hash') }}</div>
                                    @endif
                                </td>
                                <td class="px-4 py-2 whitespace-nowrap">
                                    <div>
                                        <strong>{{ __('components.work_log_detail.label.check_in') }}:</strong> {{ $audit->old_check_in ?? '-' }}
                                    </div>
                                    <div>
                                        <strong>{{ __('components.work_log_detail.label.check_out') }}:</strong> {{ $audit->old_check_out ?? '-' }}
                                    </div>
                                    <div>
                                        <strong>{{ __('components.work_log_detail.label.hash') }}:</strong> {{ $audit->old_hash ?? '-' }}
                                    </div>
                                </td>
                                <td class="px-4 py-2 whitespace-nowrap">
                                    <div>
                                        <strong>{{ __('components.work_log_detail.label.check_in') }}:</strong> {{ $audit->new_check_in ?? '-' }}
                                    </div>
                                    <div>
                                        <strong>{{ __('components.work_log_detail.label.check_out') }}:</strong> {{ $audit->new_check_out ?? '-' }}
                                    </div>
                                    <div>
                                        <strong>{{ __('components.work_log_detail.label.hash') }}:</strong> {{ $audit->new_hash ?? '-' }}
                                    </div>
                                </td>
                                <td class="px-4 py-2 whitespace-nowrap">
                                    {{ $audit->updated_by }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-gray-500">
                {{ __('components.work_log_detail.audit_empty') }}
            </p>
        @endif
    </div>

    <!-- Bloque de botones (Editar e Imprimir) -->
    <div class="flex flex-col sm:flex-row gap-4 mt-4">
        @if(Auth::check() && Auth::user()->role === 'admin')
            <a href="{{ route('admin.work_logs.edit', $workLog->id) }}"
               class="w-full sm:w-1/2 bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-center">
                {{ __('components.work_log_detail.edit_button') }}
            </a>
        @endif
        <button type="button" onclick="window.print()"
                class="w-full sm:w-1/2 bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded text-center">
            {{ __('components.work_log_detail.print_button') }}
        </button>
    </div>
</div>
