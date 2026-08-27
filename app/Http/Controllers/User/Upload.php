<?php

namespace App\Http\Controllers\User;

trait Upload
{
    public function uploadFile($file, $destinationPath)
    {
        // Logic to handle file upload
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->move($destinationPath, $filename);
        return $filename;
    }
}
