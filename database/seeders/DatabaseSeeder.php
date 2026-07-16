<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Database\Seeders\TermsOfUseSeeder;
use Database\Seeders\PrivacyPolicySeeder;
use Database\Seeders\ContactSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::updateOrCreate(
            ['email' => 'test@example.com'],
            ['name' => 'Test User']
        );

        $this->call([
            TermsOfUseSeeder::class,
            PrivacyPolicySeeder::class,
            ContactSeeder::class,
        ]);
    }
}
