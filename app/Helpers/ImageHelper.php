<?php

namespace App\Helpers;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class ImageHelper
{
    /**
     * Konversi file ke format WebP secara manual dengan penanganan error.
     */
    public static function convertToWebp(TemporaryUploadedFile $file, string $directory, int $width = 1024): string
    {
        try {
            $manager = new ImageManager(new Driver());
            $image = $manager->read($file->getRealPath());

            // Resize jika lebar melebihi batas
            if ($image->width() > $width) {
                $image->scale(width: $width);
            }

            $name = Str::uuid() . '.webp';
            $path = rtrim($directory, '/') . '/' . $name;

            $encoded = $image->toWebp(80);

            Storage::disk('public')->put($path, (string) $encoded);

            return $path;
        } catch (\Exception $e) {
            // Fallback: simpan file asli jika konversi gagal
            return $file->store($directory, 'public');
        }
    }
}
