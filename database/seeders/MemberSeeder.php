<?php

namespace Database\Seeders;

use App\Models\Member;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class MemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Member::updateOrCreate(
            ['email' => 'member@merahputihpers.com'],
            [
                'name' => 'Member MerahPutihPers',
                'password' => Hash::make('password123'),
            ]
        );

        $this->command->info('Akun member berhasil dibuat:');
        $this->command->info('  Email    : member@merahputihpers.com');
        $this->command->info('  Password : password123');
    }
}
