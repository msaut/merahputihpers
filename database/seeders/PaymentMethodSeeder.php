<?php

namespace Database\Seeders;

use App\Models\PaymentMethod;
use Illuminate\Database\Seeder;

class PaymentMethodSeeder extends Seeder
{
    // Seed master metode pembayaran default
    public function run(): void
    {
PaymentMethod::updateOrCreate(
            ['code' => 'qris'],
            [
                'name' => 'QRIS',
                'is_active' => true,
                'description' => 'Scan QR di bawah untuk membayar menggunakan aplikasi apa pun yang mendukung QRIS (GoPay, OVO, Dana, ShopeePay, m-banking, dll).',
            ]
        );

        PaymentMethod::updateOrCreate(
            ['code' => 'shopeepay'],
            [
                'name' => 'ShopeePay',
                'is_active' => true,
                'description' => 'Transfer ke nomor ShopeePay di bawah, lalu lengkapi nominal sesuai paket yang dipilih.',
            ]
        );

        $this->command->info('Metode pembayaran berhasil dibuat.');
    }
}
