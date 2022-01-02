<?php

namespace App\Traits\ProductTraits;

use Illuminate\Support\Facades\Storage;

trait UploadImage
{
    public function upload($image): string
    {
        $uploadFolder = 'images';
        $image_uploaded_path = $image->store($uploadFolder, 'public');
        return Storage::disk('public')->url($image_uploaded_path);
    }
}
