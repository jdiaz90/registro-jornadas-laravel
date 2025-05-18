<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class TruncateWorkLogs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'truncate:worklogs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Vacía (trunca) las tablas work_logs y work_logs_audits';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Para PostgreSQL se puede usar:
        DB::statement('TRUNCATE TABLE work_logs, work_logs_audits RESTART IDENTITY CASCADE');
        
        // Si usas MySQL quizás quieras desactivar temporalmente las comprobaciones de claves foráneas:
        // DB::statement('SET FOREIGN_KEY_CHECKS=0');
        // DB::table('work_logs')->truncate();
        // DB::table('work_logs_audits')->truncate();
        // DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $this->info('Las tablas work_logs y work_logs_audits han sido vaciadas correctamente.');

        return 0;
    }
}
