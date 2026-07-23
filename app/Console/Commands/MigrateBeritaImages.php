<?php

namespace App\Console\Commands;

use App\Models\Berita;
use App\Support\Base64Image;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class MigrateBeritaImages extends Command
{
    // /**
    //  * The name and signature of the console command.
    //  *
    //  * @var string
    //  */
    protected $signature = 'berita:migrate-images';

    // /**
    //  * The console command description.
    //  *
    //  * @var string
    //  */
    protected $description = 'Migrate existing base64 berita images to stored files in storage/app/public/berita/';

    // /**
    //  * Execute the console command.
    //  */
    public function handle()
    {
        $this->info('Migrating existing berita base64 images to stored files...');

        $beritas = Berita::whereNotNull('gambar_base64')->get();
        $count = 0;
        $skipped = 0;

        foreach ($beritas as $berita) {
            // Skip if already has a stored file
            if ($berita->gambar && Storage::disk('public')->exists('berita/' . $berita->gambar)) {
                $skipped++;
                continue;
            }

            // Convert base64 to file
            $result = Base64Image::base64ToFile($berita->gambar_base64, 'berita');

            if ($result['filename']) {
                $berita->update(['gambar' => $result['filename']]);
                $count++;
                $this->line("  ✅ Berita #{$berita->id}: {$berita->judul} → {$result['filename']}");
            } else {
                $this->warn("  ⚠️  Berita #{$berita->id}: Failed to decode base64 image");
            }
        }

        $this->newLine();
        $this->info("Complete! {$count} images converted, {$skipped} already had files.");
    }
}
