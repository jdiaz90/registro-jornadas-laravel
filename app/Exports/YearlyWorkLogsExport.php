<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class YearlyWorkLogsExport implements WithMultipleSheets
{
    protected $year;
    protected $userId;

    public function __construct($year, $userId = null)
    {
        $this->year = $year;
        $this->userId = $userId ?? auth()->id();
    }

    public function sheets(): array
    {
        $sheets = [];
        for ($month = 1; $month <= 12; $month++) {
            $sheets[] = new MonthlyWorkLogsSheet($this->year, $month, $this->userId);
        }
        return $sheets;
    }

    public function getYear()
    {
        return $this->year;
    }

}
