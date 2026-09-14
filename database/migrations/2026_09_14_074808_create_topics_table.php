<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('topics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('topic_area_id')->constrained()->cascadeOnDelete();
            $table->string('slug');
            $table->string('title');
            $table->text('intro')->nullable();
            $table->longText('explanation');
            $table->longText('notebook_entry');
            $table->text('curriculum_ref')->nullable();
            $table->unsignedSmallInteger('estimated_minutes')->default(20);
            $table->unsignedTinyInteger('pass_percent')->default(70);
            $table->unsignedSmallInteger('sort')->default(0);
            $table->timestamps();

            $table->unique(['topic_area_id', 'slug']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('topics');
    }
};
