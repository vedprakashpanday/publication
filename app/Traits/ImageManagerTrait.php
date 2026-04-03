<?php

namespace App\Traits;

use Illuminate\Support\Facades\File;

trait ImageManagerTrait
{
    /**
     * Upload Image, Convert to WebP, and Delete Old Image (if any)
     *
     * @param  \Illuminate\Http\UploadedFile $file
     * @param  string $folderPath
     * @param  string|null $oldImagePath
     * @return string
     */
    public function uploadAndConvertToWebp($file, $folderPath, $oldImagePath = null)
    {
        // 1. Agar old image hai, toh usko delete karein (Server clean rakhna hai)
        if ($oldImagePath && File::exists(public_path($oldImagePath))) {
            File::delete(public_path($oldImagePath));
        }

        // 2. Folder check karein, agar nahi hai toh create karein
        $destinationPath = public_path($folderPath);
        if (!File::exists($destinationPath)) {
            File::makeDirectory($destinationPath, 0755, true);
        }

        // 3. Unique naam generate karein (Sirf .webp extension ke sath)
        $filename = time() . '_' . uniqid() . '.webp';
        
        // 4. File ko memory mein load karein (Works for JPG, PNG, etc.)
        $imageStream = imagecreatefromstring(file_get_contents($file));

        // Background transparent (PNG) ke liye color fix
        imagealphablending($imageStream, false);
        imagesavealpha($imageStream, true);

        // 5. Image ko WebP mein convert karke direct public folder mein save karein (Quality: 80%)
        $fullPath = $destinationPath . '/' . $filename;
        imagewebp($imageStream, $fullPath, 80);

        // Memory free karein
        imagedestroy($imageStream);

        // 6. Database mein save karne ke liye relative path return karein
        return $folderPath . '/' . $filename;
    }

    /**
     * Delete Image Method
     */
    public function deleteImage($imagePath)
    {
        if ($imagePath && File::exists(public_path($imagePath))) {
            File::delete(public_path($imagePath));
        }
    }
}