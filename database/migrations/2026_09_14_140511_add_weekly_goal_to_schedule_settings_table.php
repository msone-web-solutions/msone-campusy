<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('schedule_settings', function (Blueprint $table) {
            $table->unsignedTinyInteger('weekly_goal_blocks')->default(12)->after('break_minutes');
            $table->unsignedTinyInteger('backlog_alert_blocks')->default(3)->after('weekly_goal_blocks');
            $table->timestamp('backlog_alerted_at')->nullable()->after('subject_weights');
        });
    }

    public function down(): void
    {
        Schema::table('schedule_settings', function (Blueprint $table) {
            $table->dropColumn(['weekly_goal_blocks', 'backlog_alert_blocks', 'backlog_alerted_at']);
        });
    }
};
