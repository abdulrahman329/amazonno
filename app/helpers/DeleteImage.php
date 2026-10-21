<?php

use Illuminate\Support\Facades\Storage;

if (!function_exists('deleteImage')) {
    function deleteImage(?string $path, string $disk = 'public'): void
    {
        if ($path) {
            Storage::disk($disk)->delete($path);
        }
    }
}