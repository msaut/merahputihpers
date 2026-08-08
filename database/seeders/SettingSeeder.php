<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    // Seed default setting email (diambil dari env/config saat ini)
    public function run(): void
    {
        if (!Setting::where('key', 'mail_host')->exists()) {
            Setting::set('mail_host', config('mail.mailers.smtp.host', 'smtp.gmail.com'));
        }
        if (!Setting::where('key', 'mail_port')->exists()) {
            Setting::set('mail_port', config('mail.mailers.smtp.port', 587));
        }
        if (!Setting::where('key', 'mail_username')->exists()) {
            Setting::set('mail_username', config('mail.mailers.smtp.username', ''));
        }
        if (!Setting::where('key', 'mail_password')->exists()) {
            Setting::set('mail_password', config('mail.mailers.smtp.password', ''));
        }
        if (!Setting::where('key', 'mail_encryption')->exists()) {
            Setting::set('mail_encryption', config('mail.mailers.smtp.encryption', 'tls'));
        }
        if (!Setting::where('key', 'mail_from_address')->exists()) {
            Setting::set('mail_from_address', config('mail.from.address', 'admin@merahputihpers.com'));
        }
if (!Setting::where('key', 'mail_from_name')->exists()) {
            Setting::set('mail_from_name', config('mail.from.name', 'MerahPutihPers'));
        }
        if (!Setting::where('key', 'qr_enabled')->exists()) {
            Setting::set('qr_enabled', '1');
        }

        $this->command->info('Setting email berhasil dibuat.');
    }
}
