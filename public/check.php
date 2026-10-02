<?php
// TEMPORARY DIAGNOSTIC - HAPUS SETELAH SELESAI!
// Akses via: https://lanjo.sijunjung.cloud/check.php

error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<pre style='background:#111;color:#0f0;padding:20px;font-size:13px'>";
echo "=== LARAVEL DIAGNOSTIC ===\n\n";

// 1. Cek .env
$envPath = dirname(__DIR__) . '/.env';
echo "1. .env exists: " . (file_exists($envPath) ? "✅ YES" : "❌ NO") . "\n";

// 2. Cek vendor/autoload.php
$vendorPath = dirname(__DIR__) . '/vendor/autoload.php';
echo "2. vendor/autoload.php: " . (file_exists($vendorPath) ? "✅ YES" : "❌ NO - vendor hilang!") . "\n";

// 3. Cek bootstrap/cache
$cachePath = dirname(__DIR__) . '/bootstrap/cache';
echo "3. bootstrap/cache writable: " . (is_writable($cachePath) ? "✅ YES" : "❌ NO - permission error!") . "\n";

// 4. Cek storage writable
$storagePath = dirname(__DIR__) . '/storage';
echo "4. storage writable: " . (is_writable($storagePath) ? "✅ YES" : "❌ NO - permission error!") . "\n";

// 5. Cek cached files
$cachedConfig = $cachePath . '/config.php';
$cachedRoutes = $cachePath . '/routes-v7.php';
echo "5. Cached config: " . (file_exists($cachedConfig) ? "⚠️ ADA (mungkin stale)" : "✅ Tidak ada") . "\n";
echo "6. Cached routes: " . (file_exists($cachedRoutes) ? "⚠️ ADA (mungkin stale)" : "✅ Tidak ada") . "\n";

// 6. Hapus cache files jika ada
echo "\n--- Membersihkan cache... ---\n";
$files = glob($cachePath . '/*.php');
foreach ($files as $file) {
    if (basename($file) !== 'packages.php') {
        unlink($file);
        echo "✅ Deleted: " . basename($file) . "\n";
    }
}

// 7. Cek error_log terakhir
echo "\n--- 20 baris terakhir error_log ---\n";
$errorLog = dirname(__DIR__) . '/error_log';
if (file_exists($errorLog)) {
    $lines = file($errorLog);
    $last = array_slice($lines, -20);
    echo implode("", $last);
} else {
    $errorLog2 = dirname(__DIR__) . '/storage/logs/laravel.log';
    if (file_exists($errorLog2)) {
        $lines = file($errorLog2);
        $last = array_slice($lines, -30);
        echo implode("", $last);
    } else {
        echo "Tidak ada error log ditemukan\n";
    }
}

echo "\n=== DONE ===";
echo "</pre>";
