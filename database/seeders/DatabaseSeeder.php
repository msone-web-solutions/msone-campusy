<?php

namespace Database\Seeders;

use App\Content\ContentImporter;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Alexa Schneider',
            'email' => 'alexa@example.com',
        ]);

        ContentImporter::default()->import();
    }
}
