<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('topic_progress', function (Blueprint $table) {
            $table->timestamp('passed_at')->nullable()->after('best_percent');
        });

        DB::table('topic_progress')->whereIn('status', ['passed', 'mastered'])->update(['passed_at' => DB::raw('updated_at')]);
    }

    public function down(): void
    {
        Schema::table('topic_progress', function (Blueprint $table) {
            $table->dropColumn('passed_at');
        });
    }
};
