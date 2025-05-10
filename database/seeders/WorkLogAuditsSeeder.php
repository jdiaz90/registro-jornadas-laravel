<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\WorkLog;
use App\Models\WorkLogAudit;

class WorkLogAuditsSeeder extends Seeder
{
    public function run()
    {
        $workLogs = WorkLog::all();
        $totalWorkLogs = $workLogs->count();

        $bar = $this->command->getOutput()->createProgressBar($totalWorkLogs);
        $bar->start();

        foreach ($workLogs as $workLog) {
            // Creación de 2 auditorías para cada work log
            WorkLogAudit::factory(2)->create(['work_log_id' => $workLog->id]);
            $bar->advance();
        }

        $bar->finish();
        $this->command->info("\nWork Log Audits have been seeded for {$totalWorkLogs} work logs.");
    }
}
