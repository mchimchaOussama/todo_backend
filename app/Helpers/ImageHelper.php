<?php
namespace App\Helpers;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ImageHelper
{
    public static function store(?UploadedFile $image): ?string
    {
        if (!$image) {
            return null;
        }

        $imageName = time() . '_' . $image->getClientOriginalName();
        return $image->storeAs('uploads', $imageName, 'public');
    }
}
