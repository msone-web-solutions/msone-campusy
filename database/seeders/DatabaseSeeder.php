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
        // Ohne Factory, damit der Seeder auch ohne Dev-Abhängigkeiten (Faker) in Produktion läuft.
        $parent = User::query()->firstOrCreate(['email' => 'dad@msone.cloud'], [
            'name' => 'Sarah Schneider',
            'role' => UserRole::Parent,
            'password' => 'password',
            'must_change_password' => true,
            'email_verified_at' => now(),
        ]);

        User::query()->firstOrCreate(['email' => 'alexa@msone.cloud'], [
            'name' => 'Alexa Schneider',
            'role' => UserRole::Student,
            'parent_id' => $parent->id,
            'password' => 'password',
            'must_change_password' => true,
            'email_verified_at' => now(),
        ]);

        ContentImporter::default()->import();
    }
}
