<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Post;
use Illuminate\Support\Facades\Storage;

echo "<pre>";
echo "<h1>Diagnosa Slider Hero</h1>";

// Ambil Featured Posts (seperti di Slider.php)
$sliders = Post::where('status', 'published')
    ->where('is_featured', true)
    ->latest('published_at')
    ->take(5)
    ->get();

if ($sliders->isEmpty()) {
    echo "TIDAK ADA Postingan Featured (Slider Kosong).\n";
} else {
    foreach ($sliders as $index => $post) {
        echo "\n--- Slider #" . ($index + 1) . ": " . $post->title . " ---\n";
        echo "ID: " . $post->id . "\n";
        echo "Foto Utama (DB): " . $post->foto_utama . "\n";
        
        $url = $post->foto_utama_url;
        echo "URL Generated: <a href='$url' target='_blank'>$url</a>\n";
        
        if ($post->foto_utama) {
            // Cek fisik feature image
            $paths = [
                'Storage Public (Target Asli)' => storage_path('app/public/' . $post->foto_utama),
                'Storage Private (Salah Upload)' => storage_path('app/private/' . $post->foto_utama),
                'Public Folder (Langsung)' => public_path($post->foto_utama),
            ];
            
            $found = false;
            foreach ($paths as $label => $path) {
                if (file_exists($path)) {
                    echo "[ADA] $label: $path\n";
                    echo "Permissions: " . substr(sprintf('%o', fileperms($path)), -4) . "\n";
                    $found = true;
                } else {
                    echo "[HILANG] $label: $path\n";
                }
            }
            
            if (!$found) {
                echo "<span style='color:red'>KESIMPULAN: File fisik gambar master TIDAK DITEMUKAN dimanapun. Perlu upload ulang?</span>\n";
            }
        } else {
            echo "<span style='color:orange'>Post ini tidak punya file Foto Utama.</span>\n";
        }
    }
}
echo "</pre>";
