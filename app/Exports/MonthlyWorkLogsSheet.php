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
        // Encabezados (ahora se incluye la nueva columna para las horas extraordinarias)
        $rows[] = ['Día', 'Hora Entrada', 'Hora Salida', 'Ordinarias', 'Extraordinarias/Complementarias'];
        
        // Número de días del mes
        $numDays = Carbon::createFromDate($this->year, $this->month, 1)->daysInMonth;
        // Acumuladores de totales para el mes
        $monthOrdinariasTotal = 0;
        $monthExtraTotal = 0;

        for ($day = 1; $day <= $numDays; $day++) {
            $date = Carbon::createFromDate($this->year, $this->month, $day)->toDateString();
            // Obtener todos los registros (WorkLogs) del día para el usuario
            $logs = WorkLog::where('user_id', $this->userId)
                    ->whereDate('check_in', $date)
                    ->get();

            $horaEntradas = [];
            $horaSalidas = [];
            $totalSeconds = 0;

            if ($logs->count() > 0) {
                foreach ($logs as $log) {
                    if ($log->check_in) {
                        $horaEntradas[] = Carbon::parse($log->check_in)->format('H:i');
                    }
                    if ($log->check_out) {
                        $horaSalidas[] = Carbon::parse($log->check_out)->format('H:i');
                        // Se suma la diferencia en segundos (valor positivo)
                        $diff = Carbon::parse($log->check_out)->diffInSeconds(Carbon::parse($log->check_in));
                        $totalSeconds += $diff;
                    }
                }
                // Convertir el total de segundos a horas (valor positivo)
                $workedHours = round($totalSeconds / 3600, 2);
                $workedHours = abs($workedHours);

                // Si se trabajaron más de 7 horas, se asignan 7 como ordinarias y el resto como extraordinarias
                if ($workedHours > 7) {
                    $ordinarias = 7;
                    $extra = round($workedHours - 7, 2);
                } else {
                    $ordinarias = $workedHours;
                    $extra = 0;
                }
                // Acumular los totales del mes
                $monthOrdinariasTotal += $ordinarias;
                $monthExtraTotal += $extra;
            } else {
                $ordinarias = 0;
                $extra = 0;
            }
            // Concatenar los registros de entrada y salida (sep. por coma)
            $horaEntradaStr = implode(', ', $horaEntradas);
            $horaSalidaStr  = implode(', ', $horaSalidas);

            $rows[] = [$day, $horaEntradaStr, $horaSalidaStr, $ordinarias, $extra];
        }

        // Fila final: se muestra en la primera celda el rótulo y, en las celdas adyacentes, las sumas acumuladas
        $rows[] = ["Horas totales trabajadas", "", "", $monthOrdinariasTotal, $monthExtraTotal];

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

            // Determinar el n\u00FAmero de columnas: asumimos que el array() devuelve 5 columnas.
            $numCols = count($this->array()[0]);
            $lastColLetter = chr(64 + $numCols); // Para 5 columnas, E.

            // Obtener datos para el header y footer
            $workerName = strtoupper(\App\Models\User::find($this->userId)->name);
            $headerText = strtoupper('REGISTRO DE JORNADA - ' . $workerName);
            $footerText = strtoupper($this->monthName . ' ' . $this->year);

            // Configurar encabezado y pie de página (centrados, en may\u00FAscula y negrita)
            $sheet->getDelegate()->getHeaderFooter()->setOddHeader('&C&"Arial,Bold"' . $headerText);
            $sheet->getDelegate()->getHeaderFooter()->setOddFooter('&C&"Arial,Bold"' . $footerText);

            // Suponemos que la primera fila (fila 1) del array() es la cabecera.
            $headerRow = 1;
            // Aplicar negrita a la cabecera.
            $sheet->getDelegate()->getStyle("A{$headerRow}:{$lastColLetter}{$headerRow}")
                  ->getFont()->setBold(true);

            // Insertar salto de l\u00EDnea en la cabecera de la \u00FAltima columna: "Extraordinarias/Complementarias"
            $headerCellCoordinate = $lastColLetter . $headerRow;
            $oldHeaderValue = $sheet->getDelegate()->getCell($headerCellCoordinate)->getValue();
            // Reemplazar '/' por "/\n" para forzar un retorno de carro
            $newHeaderValue = str_replace('/', "/\n", $oldHeaderValue);
            $sheet->getDelegate()->setCellValue($headerCellCoordinate, $newHeaderValue);

            // Determinar el total de filas (ya que nuestro array() devuelve toda la tabla incluyendo la fila final de totales)
            $totalRows = count($this->array());
            $cellRange = "A{$headerRow}:{$lastColLetter}{$totalRows}";

            // Aplicar borde a todo el rango de la tabla.
            $sheet->getDelegate()->getStyle($cellRange)->applyFromArray([
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color'       => ['argb' => 'FF000000'],
                    ],
                ],
            ]);

            // Alineaci\u00F3n: horizontal a la derecha y vertical centrada, adem\u00E1s de wrap text en todas las celdas.
            $sheet->getDelegate()->getStyle($cellRange)->getAlignment()
                  ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT)
                  ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)
                  ->setWrapText(true);

            // Configurar el ancho de las columnas: columna A a 40 y de la B al final a 125.
            $sheet->getDelegate()->getColumnDimension('A')->setWidth(5);
            for ($col = 'B'; $col <= $lastColLetter; $col++) {
                $sheet->getDelegate()->getColumnDimension($col)->setWidth(17);
            }

            for ($row = $headerRow + 1; $row <= $totalRows; $row++) {
                $sheet->getDelegate()->getRowDimension($row)->setRowHeight(20);
            }

            $sheet->getDelegate()->getStyle("A2:A{$totalRows}")->getFont()->setBold(true);
            
            // Configurar \u00E1rea de impresi\u00F3n para que todo quepa en una sola hoja.
            $sheet->getDelegate()->getPageSetup()->setPrintArea("A1:{$lastColLetter}{$totalRows}");
            $sheet->getDelegate()->getPageSetup()->setFitToWidth(1);
            $sheet->getDelegate()->getPageSetup()->setFitToHeight(1);

            // Si existe una fila final de totales, fusionar las columnas A a C de esa fila y poner en negrita.
            $lastRow = $totalRows;
            $sheet->getDelegate()->mergeCells("A{$lastRow}:C{$lastRow}");
            $sheet->getDelegate()->getStyle("A{$lastRow}")->getFont()->setBold(true);
        },
    ];
}


      
}
