<x-app-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
          {{ __('calendar.header', ['year' => $year]) }}
      </h2>
  </x-slot>
  
  <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
          <!-- Formulario para cambiar de año -->
          <div class="bg-white dark:bg-gray-700 shadow rounded-lg p-4">
              <form action="{{ route('calendar.index') }}" method="GET" class="flex items-center gap-4">
                  <label class="text-gray-700 dark:text-gray-300">{{ __('calendar.form.year_label') }}</label>
                  <input type="number" name="year" value="{{ $year }}" min="2000" max="2100" class="border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                  <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded">
                      {{ __('calendar.form.submit') }}
                  </button>
              </form>
          </div>

          <!-- Contenedor para los meses en dos columnas -->
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              @for ($m = 1; $m <= 12; $m++)
                  @php
                      // Generamos el objeto para el primer día del mes
                      $monthDate = \Carbon\Carbon::createFromDate($year, $m, 1);
                      // Obtenemos el nombre del mes en español (la función translatedFormat requiere que previamente se haya configurado Carbon en español)
                      $monthName = ucfirst($monthDate->translatedFormat('F'));
                      $daysInMonth = $monthDate->daysInMonth;
                      // dayOfWeekIso devuelve 1 para lunes y 7 para domingo; usamos para calcular cuántas celdas vacías (offset) se deben mostrar
                      $offset = $monthDate->dayOfWeekIso - 1;
                  @endphp

                  <div class="bg-white dark:bg-gray-700 shadow rounded-lg p-4">
                      <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-2">{{ $monthName }}</h3>
                      <table class="w-full text-center border-collapse text-xs">
                          <thead>
                              <tr>
                                  <th class="py-1 text-gray-600 dark:text-gray-300">{{ __('calendar.days.mon') }}</th>
                                  <th class="py-1 text-gray-600 dark:text-gray-300">{{ __('calendar.days.tue') }}</th>
                                  <th class="py-1 text-gray-600 dark:text-gray-300">{{ __('calendar.days.wed') }}</th>
                                  <th class="py-1 text-gray-600 dark:text-gray-300">{{ __('calendar.days.thu') }}</th>
                                  <th class="py-1 text-gray-600 dark:text-gray-300">{{ __('calendar.days.fri') }}</th>
                                  <th class="py-1 text-gray-600 dark:text-gray-300">{{ __('calendar.days.sat') }}</th>
                                  <th class="py-1 text-gray-600 dark:text-gray-300">{{ __('calendar.days.sun') }}</th>
                              </tr>
                          </thead>
                          <tbody>
                              @php
                                  // Calcula cuántas celdas se necesitan para completar la presentación en semanas
                                  $totalCells = ceil(($offset + $daysInMonth) / 7) * 7;
                              @endphp
                              @for ($i = 0; $i < $totalCells; $i++)
                                  @php
                                      $day = $i - $offset + 1;
                                  @endphp
                                  @if ($i % 7 == 0)
                                      <tr>
                                  @endif

                                  @if ($day < 1 || $day > $daysInMonth)
                                      <td class="border border-gray-200 dark:border-gray-600 px-2 py-1">&nbsp;</td>
                                  @else
                                      @php
                                          // Se genera la fecha en formato "Y-m-d" para buscar en el agrupamiento
                                          $currentDate = \Carbon\Carbon::createFromDate($year, $m, $day)->format('Y-m-d');
                                          // Aquí recuperamos todos los registros asignados a ese día (si existen) o una colección vacía
                                          $dayLogs = $logs->get($currentDate) ?? collect();
                                      @endphp
                                      <td class="border border-gray-200 dark:border-gray-600 px-2 py-1 relative calendar-group">
                                          <span class="text-gray-900 dark:text-gray-100">{{ $day }}</span>
                                          @if($dayLogs->isNotEmpty())
                                              <div class="calendar-tooltip absolute left-0 bottom-full mb-1 w-32 bg-gray-800 text-white text-xs rounded py-1 px-2 z-10">
                                                  @foreach($dayLogs as $logEntry)
                                                      <div>{{ __('calendar.log.check_in') }} {{ \Carbon\Carbon::parse($logEntry->check_in)->format('H:i') }}</div>
                                                      <div>
                                                          {{ __('calendar.log.check_out') }} 
                                                          {{ $logEntry->check_out ? \Carbon\Carbon::parse($logEntry->check_out)->format('H:i') : __('calendar.log.in_progress') }}
                                                      </div>
                                                      @if(!$loop->last)
                                                          <hr class="my-1 border-gray-500">
                                                      @endif
                                                  @endforeach
                                              </div>
                                          @endif
                                      </td>
                                  @endif

                                  @if ($i % 7 == 6)
                                      </tr>
                                  @endif
                              @endfor
                          </tbody>
                      </table>
                  </div>
              @endfor
          </div>
      </div>
  </div>
</x-app-layout>
