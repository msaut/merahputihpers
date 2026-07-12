<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Berita;
use Illuminate\Support\Str;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class BeritaSeeder extends Seeder
{
    private function downloadImage($kategori)
{
    $keyword = strtolower($kategori);

    // ambil random image
    $url = "https://source.unsplash.com/600x600/?$keyword&sig=" . rand(1, 9999);

    $response = Http::get($url);

    if ($response->successful()) {
        $filename = 'berita/' . uniqid() . '.jpg';
        Storage::disk('public')->put($filename, $response->body());

        return $filename; // simpan ke DB
    }

    return 'berita/default.jpg'; // fallback
}
    public function run(): void
    {
        $faker = Faker::create('id_ID');

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
            for ($i = 1; $i <= 3; $i++) {

                // 🎯 Judul sesuai kategori
                $judul = $this->generateJudul($nama, $faker);

                Berita::create([
                    'judul' => $judul,
                    'slug' => Str::slug($judul . '-' . uniqid()),
                    'isi' => $this->generateIsi($nama, $faker),
                    'kategori_id' => $id,
                    'gambar' => $this->downloadImage($nama),
                    'views' => rand(50, 5000),
                    'created_at' => now()->subDays(rand(0, 30)),
                ]);
            }
        }
    }

    private function generateJudul($kategori, $faker)
    {
        $judulList = [
            'Nasional' => [
                'Pemerintah Umumkan Kebijakan Baru Terkait Energi',
                'Ekonomi Nasional Diprediksi Tumbuh Stabil Tahun Ini',
                'Presiden Resmikan Proyek Infrastruktur Strategis',
            ],
            'Internasional' => [
                'Ketegangan Global Meningkat di Kawasan Timur Tengah',
                'Negara G20 Sepakati Kerjasama Ekonomi Baru',
                'Isu Perubahan Iklim Jadi Sorotan Dunia',
            ],
            'Kilas Daerah' => [
                'Warga Lokal Gelar Festival Budaya Tahunan',
                'Pembangunan Jalan Desa Dipercepat',
                'UMKM Daerah Alami Peningkatan Penjualan',
            ],
            'Kilas Pemerintah' => [
                'Kementerian Luncurkan Program Digitalisasi',
                'Pemerintah Tingkatkan Layanan Publik Online',
                'Anggaran Negara Difokuskan ke Pendidikan',
            ],
            'Politik' => [
                'Partai Politik Mulai Siapkan Strategi Pemilu',
                'Debat Publik Bahas Isu Ekonomi Nasional',
                'Koalisi Baru Mulai Terbentuk',
            ],
            'Sosial' => [
                'Gerakan Sosial Bantu Korban Bencana',
                'Kesadaran Masyarakat Terhadap Lingkungan Meningkat',
                'Komunitas Lokal Gelar Aksi Bersih Kota',
            ],
            'Properti' => [
                'Harga Rumah di Perkotaan Terus Naik',
                'Investasi Properti Masih Menjanjikan',
                'Tren Hunian Minimalis Semakin Diminati',
            ],
            'Sport' => [
                'Tim Nasional Menang Dramatis di Laga Terakhir',
                'Atlet Indonesia Raih Medali Emas',
                'Liga Lokal Semakin Kompetitif',
            ],
            'Otomotif' => [
                'Mobil Listrik Semakin Diminati Masyarakat',
                'Produsen Rilis Model Terbaru Tahun Ini',
                'Teknologi Hybrid Jadi Tren Baru',
            ],
            'Lifestyle' => [
                'Tren Gaya Hidup Sehat Meningkat',
                'Kuliner Lokal Kembali Populer',
                'Traveling Jadi Pilihan Liburan Favorit',
            ],
            'Edukasi' => [
                'Sistem Pendidikan Digital Terus Berkembang',
                'Sekolah Mulai Terapkan Kurikulum Baru',
                'Beasiswa Luar Negeri Meningkat Tahun Ini',
            ],
        ];

        return $judulList[$kategori][array_rand($judulList[$kategori])] . ' #' . rand(1, 999);
    }

    private function generateIsi($kategori, $faker)
    {
        return match ($kategori) {
            'Nasional' => "Berita nasional terbaru menunjukkan perkembangan signifikan di berbagai sektor. " . $faker->paragraph(5),

            'Internasional' => "Dunia internasional saat ini sedang menghadapi berbagai tantangan global. " . $faker->paragraph(5),

            'Kilas Daerah' => "Perkembangan daerah terus menunjukkan kemajuan positif. " . $faker->paragraph(5),

            'Kilas Pemerintah' => "Pemerintah terus berupaya meningkatkan pelayanan kepada masyarakat. " . $faker->paragraph(5),

            'Politik' => "Situasi politik nasional semakin dinamis menjelang momentum penting. " . $faker->paragraph(5),

            'Sosial' => "Kehidupan sosial masyarakat mengalami perubahan yang cukup signifikan. " . $faker->paragraph(5),

            'Properti' => "Sektor properti menunjukkan tren yang terus berkembang. " . $faker->paragraph(5),

            'Sport' => "Dunia olahraga kembali diramaikan dengan berbagai pertandingan seru. " . $faker->paragraph(5),

            'Otomotif' => "Industri otomotif terus berinovasi menghadirkan teknologi terbaru. " . $faker->paragraph(5),

            'Lifestyle' => "Gaya hidup masyarakat modern semakin beragam dan dinamis. " . $faker->paragraph(5),

            'Edukasi' => "Dunia pendidikan terus beradaptasi dengan perkembangan teknologi. " . $faker->paragraph(5),

            default => $faker->paragraph(5),
        };
    }
    
}