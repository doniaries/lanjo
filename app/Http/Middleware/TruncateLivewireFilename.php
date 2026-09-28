<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

/**
 * Middleware to truncate long filenames for Livewire file uploads
 *
 * Livewire's TemporaryUploadedFile::generateHashNameWithOriginalNameEmbedded()
 * base64-encodes the original filename, which can exceed Windows' 255 char path limit.
 * This middleware renames uploaded files with long names before Livewire processes them.
 */
class TruncateLivewireFilename
{
    /**
     * Maximum filename length (excluding extension) to avoid path length issues.
     */
    private const MAX_FILENAME_LENGTH = 50;

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $path = $request->path();

        // Only process Livewire file upload requests
        if (! str_contains($path, 'livewire/upload-file')) {
            return $next($request);
        }

        $files = $request->allFiles();
        foreach ($files as $key => $file) {
            $this->processFiles($key, $file);
        }

        return $next($request);
    }

    /**
     * Process files recursively (handles nested arrays from Livewire).
     */
    private function processFiles(string $key, mixed $file): void
    {
        if (is_array($file)) {
            foreach ($file as $subKey => $subFile) {
                $this->processFiles($key . '.' . $subKey, $subFile);
            }
            return;
        }

        if ($file instanceof UploadedFile) {
            $this->truncateFilenameIfNeeded($file);
        }
    }

    /**
     * Truncate the filename if it exceeds the max length.
     */
    private function truncateFilenameIfNeeded(UploadedFile $file): void
    {
        $originalName = $file->getClientOriginalName();
        $extension = pathinfo($originalName, PATHINFO_EXTENSION);
        $basename = pathinfo($originalName, PATHINFO_FILENAME);

        // Only truncate if the basename exceeds max length
        if (mb_strlen($basename) <= self::MAX_FILENAME_LENGTH) {
            return;
        }

        // Truncate basename and preserve extension
        $truncatedBasename = mb_substr($basename, 0, self::MAX_FILENAME_LENGTH);
        $newFilename = $extension ? "{$truncatedBasename}.{$extension}" : $truncatedBasename;

        // Use reflection to update the private originalName property on Symfony's UploadedFile
        // The property is on incoming Symfony UploadedFile instance
        try {
            $symfonyClass = \Symfony\Component\HttpFoundation\File\UploadedFile::class;
            $reflection = new \ReflectionClass($symfonyClass);

            if ($reflection->hasProperty('originalName')) {
                $property = $reflection->getProperty('originalName');
                $property->setAccessible(true);
                $property->setValue($file, $newFilename);
            }
        } catch (\Exception $e) {
            Log::warning('[TruncateLivewireFilename] Could not find originalName property or failed to set it: ' . $e->getMessage());
        }
    }
}
