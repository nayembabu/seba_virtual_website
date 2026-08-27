<?php

namespace App\Http\Traits;

use Illuminate\Support\Facades\File;

trait Upload
{
    /**
     * Upload an image and return the filename
     *
     * @param $file
     * @param $location
     * @param null $old
     * @return string
     */
    public function uploadImage($file, $location, $old = null)
    {
        // Create directory if it doesn't exist
        $path = public_path($location);
        if (!File::isDirectory($path)) {
            File::makeDirectory($path, 0755, true);
        }

        // Generate filename
        $filename = uniqid() . time() . '.' . $file->getClientOriginalExtension();

        // Upload file
        $file->move($path, $filename);

        // Delete old file if exists
        if ($old) {
            $oldFile = $path . '/' . $old;
            if (File::exists($oldFile)) {
                File::delete($oldFile);
            }
        }

        return $filename;
    }
}