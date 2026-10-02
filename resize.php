<?php
$sourcePath = 'logo lanjo.png';

$img = imagecreatefrompng($sourcePath);
if (!$img) {
    die("Failed to load image");
}

$width = imagesx($img);
$height = imagesy($img);

function resizeAndSave($img, $width, $height, $targetSize, $savePath) {
    $dest = imagecreatetruecolor($targetSize, $targetSize);
    imagealphablending($dest, false);
    imagesavealpha($dest, true);
    $trans = imagecolorallocatealpha($dest, 0, 0, 0, 127);
    imagefilledrectangle($dest, 0, 0, $targetSize, $targetSize, $trans);
    
    // Maintain aspect ratio or just stretch? The user just said "jadikan logo ini untuk PWA"
    // Usually it's better to fit it in the center or just resample.
    // Assuming the logo is roughly square, we'll just resample.
    imagecopyresampled($dest, $img, 0, 0, 0, 0, $targetSize, $targetSize, $width, $height);
    imagepng($dest, $savePath);
    imagedestroy($dest);
}

resizeAndSave($img, $width, $height, 192, 'public/images/icon-192x192.png');
resizeAndSave($img, $width, $height, 512, 'public/images/icon-512x512.png');

echo "Resized successfully.\n";
