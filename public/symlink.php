<?php
// Script untuk membuat symlink storage di server hosting
$target = __DIR__ . '/../storage/app/public';
$shortcut = __DIR__ . '/storage';

if (file_exists($shortcut)) {
    echo "Symlink sudah ada!";
} else {
    try {
        symlink($target, $shortcut);
        echo "Symlink berhasil dibuat!";
    } catch (\Throwable $e) {
        echo "Gagal membuat symlink: " . $e->getMessage();
        echo "<br>Coba jalankan via Cron Job atau minta hosting mengaktifkan fsockopen/symlink/exec.";
    }
}
