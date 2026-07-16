<?php

namespace Database\Seeders;

use App\Models\TermsOfUse;
use Illuminate\Database\Seeder;

class TermsOfUseSeeder extends Seeder
{
    public function run(): void
    {
        TermsOfUse::query()->updateOrCreate(
            [],
            [
                'title' => 'Terms of Use',
                'content' => 'Terms of Use belum diisi.',
            ]
        );
    }
}
