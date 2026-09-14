<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('subjects', function (Blueprint $table) {
            // Wahlfächer (Russisch, Französisch, Religion, Ethik) sind standardmäßig abgewählt.
            $table->boolean('optional')->default(false)->after('sort');
        });
    }

    public function down(): void
    {
        Schema::table('subjects', function (Blueprint $table) {
            $table->dropColumn('optional');
        });
    }
};
