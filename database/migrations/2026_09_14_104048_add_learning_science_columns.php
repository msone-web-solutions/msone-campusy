<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('questions', function (Blueprint $table) {
            $table->string('role', 10)->default('test')->after('key');
            $table->unsignedSmallInteger('segment')->nullable()->after('sort');
        });

        Schema::table('topics', function (Blueprint $table) {
            $table->text('reflect_prompt')->nullable()->after('notebook_entry');
        });

        Schema::table('quiz_attempts', function (Blueprint $table) {
            $table->unsignedTinyInteger('confidence')->nullable()->after('passed');
            $table->text('self_explanation')->nullable()->after('confidence');
        });

        Schema::table('topic_progress', function (Blueprint $table) {
            $table->timestamp('mastered_at')->nullable()->after('best_percent');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('parent_id')->nullable()->after('role')->constrained('users')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropConstrainedForeignId('parent_id');
        });
        Schema::table('topic_progress', fn (Blueprint $table) => $table->dropColumn('mastered_at'));
        Schema::table('quiz_attempts', fn (Blueprint $table) => $table->dropColumn(['confidence', 'self_explanation']));
        Schema::table('topics', fn (Blueprint $table) => $table->dropColumn('reflect_prompt'));
        Schema::table('questions', fn (Blueprint $table) => $table->dropColumn(['role', 'segment']));
    }
};
