<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class StaticPageImageService
{
    public function storeCover(TemporaryUploadedFile $file): string
    {
        return $this->processAndSave($file, 2000, 'static_pages/covers');
    }

    public function storeGallery(TemporaryUploadedFile $file): string
    {
        return $this->processAndSave($file, 1280, 'static_pages/galleries');
    }

    private function processAndSave(TemporaryUploadedFile $file, int $width, string $path): string
    {
        $manager = new ImageManager(new Driver);
        $image = $manager->read($file->getRealPath());
        $image->scaleDown(width: $width);

        $filename = trim($path, '/').'/'.Str::random(40).'.webp';
        Storage::disk('public')->put($filename, $image->toWebp(80)->toString());

        return $filename;
    }
}
