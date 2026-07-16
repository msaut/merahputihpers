<?php

namespace Database\Seeders;

use App\Models\PrivacyPolicy;
use Illuminate\Database\Seeder;

class PrivacyPolicySeeder extends Seeder
{
    public function run(): void
    {
        PrivacyPolicy::query()->updateOrCreate(
            [],
            [
                'title' => 'Privacy Policy',
                'content' => 'Privacy Policy belum diisi.',
            ]
        );
    }
}
