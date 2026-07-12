<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kategori;
use Illuminate\Support\Str;

class KategoriSeeder extends Seeder
{
    public function run(): void
    {
        $kategoris = [
            1 => 'Nasional',
            2 => 'Internasional',
            3 => 'Kilas Daerah',
            4 => 'Kilas Pemerintah',
            5 => 'Politik',
            6 => 'Sosial',
            7 => 'Properti',
            8 => 'Sport',
            9 => 'Otomotif',
            10 => 'Lifestyle',
            11 => 'Edukasi',
        ];

        foreach ($kategoris as $id => $nama) {
            Kategori::updateOrCreate(
                ['id' => $id], // biar sesuai ID yang kamu tentukan
                [
                    'nama' => $nama,
                    // 'slug' => Str::slug($nama),
                ]
            );
        }
    }
}