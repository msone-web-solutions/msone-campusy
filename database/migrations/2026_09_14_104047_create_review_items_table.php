<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('review_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('question_id')->constrained()->cascadeOnDelete();
            $table->unsignedTinyInteger('box')->default(1);
            $table->timestamp('due_at');
            $table->timestamp('last_reviewed_at')->nullable();
            $table->unsignedSmallInteger('correct_streak')->default(0);
            $table->unsignedSmallInteger('lapses')->default(0);
            $table->timestamps();

            $table->unique(['user_id', 'question_id']);
            $table->index(['user_id', 'due_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('review_items');
    }
};
