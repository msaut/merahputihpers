<?php

namespace Database\Seeders;

use App\Models\SubscriptionPlan;
use Illuminate\Database\Seeder;

class SubscriptionPlanSeeder extends Seeder
{
    // Seed paket langganan default
    public function run(): void
    {
        SubscriptionPlan::updateOrCreate(
            ['name' => 'Paket 7 Hari'],
            [
                'days'        => 7,
                'price'       => 25000,
                'description' => 'Akses koran digital selama 7 hari.',
                'is_active'   => true,
            ]
        );

        SubscriptionPlan::updateOrCreate(
            ['name' => 'Paket 30 Hari'],
            [
                'days'        => 30,
                'price'       => 75000,
                'description' => 'Akses koran digital selama 30 hari.',
                'is_active'   => true,
            ]
        );

        $this->command->info('Paket langganan berhasil dibuat.');
    }
}
