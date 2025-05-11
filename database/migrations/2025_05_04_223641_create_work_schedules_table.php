<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('work_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->integer('monday_hours')->default(7);
            $table->integer('tuesday_hours')->default(7);
            $table->integer('wednesday_hours')->default(7);
            $table->integer('thursday_hours')->default(7);
            $table->integer('friday_hours')->default(7);
            // Opcional: si se trabajan fines de semana
            $table->integer('saturday_hours')->default(0);
            $table->integer('sunday_hours')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_schedules');
    }
}
