<?php

namespace Database\Seeders;

use App\Models\Contact;
use Illuminate\Database\Seeder;

class ContactSeeder extends Seeder
{
    public function run(): void
    {
        Contact::query()->updateOrCreate(
            [],
            [
                'email' => null,
                'phone' => null,
                'address' => null,
                'content' => 'Contact belum diisi oleh admin.',
            ]
        );
    }
}
