<?php

namespace Database\Factories;

use App\Models\WorkLogAudit;
use App\Models\WorkLog;
use Illuminate\Database\Eloquent\Factories\Factory;

class WorkLogAuditFactory extends Factory
{
    protected $model = WorkLogAudit::class;

    public function definition()
    {
        return [
            // Se relaciona con un WorkLog; esto se puede sobreescribir en el seeder si ya existe un registro.
            'work_log_id'             => WorkLog::factory(),
            'old_check_in'            => $this->faker->dateTimeBetween('-1 month', 'now'),
            'new_check_in'            => $this->faker->dateTimeBetween('-1 month', 'now'),
            'old_check_out'           => $this->faker->dateTimeBetween('-1 month', 'now'),
            'new_check_out'           => $this->faker->dateTimeBetween('-1 month', 'now'),
            'old_hash'                => $this->faker->sha256,
            'new_hash'                => $this->faker->sha256,
            'updated_by'              => $this->faker->name,
            'old_ordinary_hours'      => $this->faker->randomFloat(2, 6, 7),
            'new_ordinary_hours'      => $this->faker->randomFloat(2, 6, 7),
            'old_complementary_hours' => $this->faker->randomFloat(2, 0, 2),
            'new_complementary_hours' => $this->faker->randomFloat(2, 0, 2),
            'old_overtime_hours'      => $this->faker->randomFloat(2, 0, 2),
            'new_overtime_hours'      => $this->faker->randomFloat(2, 0, 2),
            'old_pause_minutes'       => $this->faker->numberBetween(0, 60),
            'new_pause_minutes'       => $this->faker->numberBetween(0, 60),
            'old_pause_start'         => $this->faker->dateTimeBetween('-1 month', 'now'),
            'new_pause_start'         => $this->faker->dateTimeBetween('-1 month', 'now'),
            'old_pause_end'           => $this->faker->dateTimeBetween('-1 month', 'now'),
            'new_pause_end'           => $this->faker->dateTimeBetween('-1 month', 'now'),
            'modification_reason'     => $this->faker->sentence,
        ];
    }
}
