<div class="max-w-7xl mx-auto space-y-8 sm:px-6 lg:px-8">
    
    <!-- Apartado 1: Información Actual -->
    <div class="bg-white shadow sm:rounded-lg p-6">
        <h2 class="text-xl font-semibold mb-4">Información Actual</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- Usuario -->
            <div>
                <strong>Usuario:</strong> {{ $workLog->user->name ?? 'N/A' }}
            </div>
            <!-- Hash, con texto pequeño y que se ajuste con break-words -->
            <div>
                <strong>Hash:</strong>
                <div class="text-xs break-words">
                    {{ $workLog->hash ?? '-' }}
                </div>
            </div>
            <!-- Entrada -->
            <div>
                <strong>Entrada:</strong> {{ $workLog->check_in ?? '-' }}
            </div>
            <!-- Salida -->
            <div>
                <strong>Salida:</strong> {{ $workLog->check_out ?? '-' }}
            </div>
            <!-- Creado -->
            <div>
                <strong>Creado:</strong> {{ $workLog->created_at }}
            </div>
            <!-- Actualizado -->
            <div>
                <strong>Actualizado:</strong> {{ $workLog->updated_at }}
            </div>
        </div>
    </div>
    
    <!-- Apartado 2: Historial de Cambios -->
    <div class="bg-white shadow sm:rounded-lg p-6">
        <h2 class="text-xl font-semibold mb-4">Historial de Cambios</h2>
        @if($audits->count())
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Fecha</th>
                            <th class="px-4 py-2 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Campo(s) Modificado</th>
                            <th class="px-4 py-2 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Valor Anterior</th>
                            <th class="px-4 py-2 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Valor Nuevo</th>
                            <th class="px-4 py-2 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Actualizado Por</th>
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
                                        <div>Entrada</div>
                                    @endif
                                    @if($audit->old_check_out !== $audit->new_check_out)
                                        <div>Salida</div>
                                    @endif
                                    @if($audit->old_hash !== $audit->new_hash)
                                        <div>Hash</div>
                                    @endif
                                </td>
                                <td class="px-4 py-2 whitespace-nowrap">
                                    <div>
                                        <strong>Entrada:</strong> {{ $audit->old_check_in ?? '-' }}
                                    </div>
                                    <div>
                                        <strong>Salida:</strong> {{ $audit->old_check_out ?? '-' }}
                                    </div>
                                    <div>
                                        <strong>Hash:</strong> {{ $audit->old_hash ?? '-' }}
                                    </div>
                                </td>
                                <td class="px-4 py-2 whitespace-nowrap">
                                    <div>
                                        <strong>Entrada:</strong> {{ $audit->new_check_in ?? '-' }}
                                    </div>
                                    <div>
                                        <strong>Salida:</strong> {{ $audit->new_check_out ?? '-' }}
                                    </div>
                                    <div>
                                        <strong>Hash:</strong> {{ $audit->new_hash ?? '-' }}
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
            <p class="text-gray-500">No se encontraron cambios para este registro.</p>
        @endif
    </div>

    <!-- Bloque de botones (Editar e Imprimir) -->
    <div class="flex flex-col sm:flex-row gap-4 mt-4">
        @if(Auth::check() && Auth::user()->role === 'admin')
            <a href="{{ route('admin.work_logs.edit', $workLog->id) }}"
               class="w-full sm:w-1/2 bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-center">
                Editar Registro
            </a>
        @endif
        <button type="button" onclick="window.print()"
                class="w-full sm:w-1/2 bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded text-center">
            Imprimir Registro
        </button>
    </div>
</div>
