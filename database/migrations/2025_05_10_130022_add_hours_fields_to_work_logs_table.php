<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('work_logs', function (Blueprint $table) {
            $table->timestamp('pause_start')->nullable();
            $table->timestamp('pause_end')->nullable();
            $table->decimal('ordinary_hours', 5, 2)->default(0);
            $table->decimal('complementary_hours', 5, 2)->default(0);
            $table->decimal('overtime_hours', 5, 2)->default(0);
            $table->integer('pause_minutes')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('work_logs', function (Blueprint $table) {
            $table->dropColumn([
                'ordinary_hours', 
                'complementary_hours', 
                'overtime_hours', 
                'pause_minutes',
                'pause_start',
                'pause_end'
            ]);
        });
    }
};
