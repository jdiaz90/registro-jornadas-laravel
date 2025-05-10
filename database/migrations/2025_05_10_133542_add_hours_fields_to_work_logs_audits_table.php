<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('work_logs_audits', function (Blueprint $table) {
            // Añadimos los campos para las horas ordinarias
            $table->decimal('old_ordinary_hours', 5, 2)->nullable()->after('new_hash');
            $table->decimal('new_ordinary_hours', 5, 2)->nullable()->after('old_ordinary_hours');

            // Añadimos los campos para las horas complementarias
            $table->decimal('old_complementary_hours', 5, 2)->nullable()->after('new_ordinary_hours');
            $table->decimal('new_complementary_hours', 5, 2)->nullable()->after('old_complementary_hours');

            // Añadimos los campos para las horas extraordinarias (o extra)
            $table->decimal('old_overtime_hours', 5, 2)->nullable()->after('new_complementary_hours');
            $table->decimal('new_overtime_hours', 5, 2)->nullable()->after('old_overtime_hours');

            // Añadimos los campos para los inicios y finales de pausa
            $table->timestamp('old_pause_start')->nullable()->after('new_overtime_hours');
            $table->timestamp('new_pause_start')->nullable()->after('old_pause_start');
            $table->timestamp('old_pause_end')->nullable()->after('new_pause_start');
            $table->timestamp('new_pause_end')->nullable()->after('old_pause_end');

            // Añadimos los campos para los minutos de pausa
            $table->integer('old_pause_minutes')->nullable()->after('new_pause_end');
            $table->integer('new_pause_minutes')->nullable()->after('old_pause_minutes');

            // Añadimos el campo para los comentarios de modificación
            $table->text('modification_reason')->nullable()->after('new_pause_minutes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('work_logs_audits', function (Blueprint $table) {
            $table->dropColumn([
                'old_ordinary_hours',
                'new_ordinary_hours',
                'old_complementary_hours',
                'new_complementary_hours',
                'old_overtime_hours',
                'new_overtime_hours',
                'old_pause_start',
                'new_pause_start',
                'old_pause_end',
                'new_pause_end',
                'old_pause_minutes',
                'new_pause_minutes',
                'modification_reason'
            ]);
        });
    }
};
