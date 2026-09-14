<?php

namespace Database\Seeders;

use App\Content\ContentImporter;
use App\Enums\UserRole;
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
        $parent = User::factory()->create([
            'name' => 'Sarah Schneider',
            'email' => 'eltern@example.com',
            'role' => UserRole::Parent,
        ]);

        User::factory()->create([
            'name' => 'Alexa Schneider',
            'email' => 'alexa@example.com',
            'parent_id' => $parent->id,
        ]);

        ContentImporter::default()->import();
    }
}
