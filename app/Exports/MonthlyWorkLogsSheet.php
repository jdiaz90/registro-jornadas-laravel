<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\WorkLog;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class MonthlyWorkLogsSheet implements FromArray, WithTitle, WithEvents
{
    protected $year;
    protected $month;
    protected $userId;
    protected $monthName;

    public function __construct($year, $month, $userId)
    {
        $this->year = $year;
        $this->month = $month;
        $this->userId = $userId;
        $this->monthName = Carbon::createFromDate($year, $month, 1)->translatedFormat('F');
    }

    public function array(): array
    {
        $rows = [];
        // Cabecera de columnas
        $rows[] = ['Día', 'Hora Entrada', 'Hora Salida', 'Ordinarias'];
        $numDays = Carbon::createFromDate($this->year, $this->month, 1)->daysInMonth;
        $monthTotal = 0; // acumulador de horas para el mes

        for ($day = 1; $day <= $numDays; $day++) {
            $date = Carbon::createFromDate($this->year, $this->month, $day)->toDateString();
            // Obtener todos los registros del día para el usuario
            $logs = WorkLog::where('user_id', $this->userId)
                    ->whereDate('check_in', $date)
                    ->get();

            $horaEntradas = [];
            $horaSalidas = [];
            $totalSeconds = 0;

            // Si existen registros, recorremos ambos y acumulamos las horas y los tiempos en cadenas.
            if ($logs->count() > 0) {
                foreach ($logs as $log) {
                    if ($log->check_in) {
                        $horaEntradas[] = Carbon::parse($log->check_in)->format('H:i');
                    }
                    if ($log->check_out) {
                        $horaSalidas[] = Carbon::parse($log->check_out)->format('H:i');
                        $totalSeconds += Carbon::parse($log->check_out)
                                            ->diffInSeconds(Carbon::parse($log->check_in));
                    }
                }
                $ordinarias = round($totalSeconds / 3600, 2);
                $monthTotal += $ordinarias;
            } else {
                $ordinarias = 0;
            }
            // Concatenar todas las entradas y salidas en un string separados por coma
            $horaEntradaStr = implode(', ', $horaEntradas);
            $horaSalidaStr  = implode(', ', $horaSalidas);

            $rows[] = [$day, $horaEntradaStr, $horaSalidaStr, $ordinarias];
        }
        // Fila final con el total acumulado
        $rows[] = ["Horas ordinarias totales trabajadas", "", "", $monthTotal];
        return $rows;
    }

    public function title(): string
    {
        // Aseguramos que el nombre del mes inicie en mayúscula
        return ucfirst($this->monthName);
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet;
                // Determinar el número de columnas (4) y la letra de la última columna (D en este caso)
                $numCols = count($this->array()[0]);
                $lastColLetter = chr(64 + $numCols); // A, B, C, D...

                // Insertar el título en la fila 1 (sin dejar fila extra vacía) 
                // Se insertará una nueva fila antes de la fila 1 y se establece el título
                $title = ucfirst($this->monthName) . ' - ' . $this->year;
                $sheet->getDelegate()->insertNewRowBefore(1, 1);
                $sheet->getDelegate()->setCellValue('A1', $title);
                // Fusionar celdas desde A1 hasta D1 y centrar el título
                $sheet->getDelegate()->mergeCells("A1:{$lastColLetter}1");
                $sheet->getDelegate()->getStyle("A1")
                     ->getFont()->setBold(true)->setSize(14);
                $sheet->getDelegate()->getStyle("A1")
                     ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                // La cabecera se traslada a la fila 2
                $headerRow = 2;
                $sheet->getDelegate()->getStyle("A{$headerRow}:{$lastColLetter}{$headerRow}")
                     ->getFont()->setBold(true);

                // Calcular el total de filas (la función array() ya incluye la fila de cabecera y la fila total final)
                $totalRows = count($this->array()) + 1; // +1 por la nueva fila del título
                $cellRange = "A{$headerRow}:{$lastColLetter}{$totalRows}";
                $sheet->getDelegate()->getStyle($cellRange)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => 'FF000000'],
                        ],
                    ],
                ]);

                // En las filas de datos (desde la fila 3 hasta la penúltima, ya que la última es la fila de totales),
                // se pone en negrita la primera columna (el día)
                for ($row = $headerRow + 1; $row < $totalRows; $row++) {
                    $sheet->getDelegate()->getStyle("A{$row}")
                          ->getFont()->setBold(true);
                }

                // Autosize en todas las columnas
                for ($col = 'A'; $col <= $lastColLetter; $col++) {
                    $sheet->getDelegate()->getColumnDimension($col)->setAutoSize(true);
                }

                // En la última fila (fila total), fusionar las tres primeras columnas
                $lastRow = $totalRows;
                $sheet->getDelegate()->mergeCells("A{$lastRow}:C{$lastRow}");
            },
        ];
    }
}
