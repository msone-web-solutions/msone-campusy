<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('subjects', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('icon')->default('academic-cap');
            $table->string('color')->default('zinc');
            $table->unsignedTinyInteger('grade')->default(7);
            $table->string('school_type')->default('sekundarschule');
            $table->string('state', 2)->default('ST');
            $table->string('curriculum_version')->default('lsa-sks-2019');
            $table->unsignedSmallInteger('sort')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subjects');
    }
};
