<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('schedule_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained()->cascadeOnDelete();
            $table->date('start_date');
            $table->unsignedSmallInteger('day_start')->default(8 * 60);
            $table->unsignedTinyInteger('blocks_per_day')->default(3);
            $table->unsignedSmallInteger('lesson_minutes')->default(85);
            $table->unsignedSmallInteger('break_minutes')->default(20);
            $table->json('school_days');
            $table->json('subject_weights');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('schedule_settings');
    }
};
