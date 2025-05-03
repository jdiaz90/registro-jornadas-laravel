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
        Schema::create('work_logs_audits', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('work_log_id');
            
            // Almacenamos los valores antiguos y nuevos
            $table->timestamp('old_check_in')->nullable();
            $table->timestamp('new_check_in')->nullable();
            
            $table->timestamp('old_check_out')->nullable();
            $table->timestamp('new_check_out')->nullable();
            
            $table->string('old_hash')->nullable();
            $table->string('new_hash')->nullable();
            
            // Nombre del usuario que realizó la modificación
            $table->string('updated_by')->nullable();
            $table->timestamps();

            // Establecer clave foránea
            $table->foreign('work_log_id')->references('id')->on('work_logs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_logs_audits');
    }
};

