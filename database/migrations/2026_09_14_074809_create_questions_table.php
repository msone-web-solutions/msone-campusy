<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('topic_id')->constrained()->cascadeOnDelete();
            $table->string('key');
            $table->string('type', 30);
            $table->text('prompt');
            $table->json('options')->nullable();
            $table->json('answer');
            $table->text('explanation')->nullable();
            $table->unsignedTinyInteger('points')->default(1);
            $table->unsignedTinyInteger('difficulty')->default(1);
            $table->unsignedSmallInteger('sort')->default(0);
            $table->timestamps();

            $table->unique(['topic_id', 'key']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
