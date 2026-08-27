<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Log;

use Illuminate\Http\Request;

class SignatureController extends Controller
{
    // Function to clean up the full name
    private function removeAdditionalParts($full_name) {
        return trim($full_name);
    }

    // Function to save the photo in the uploads directory
    private function savePhoto($photoContent, $fileName) {
        $filePath = public_path("uploads/{$fileName}.png");
        if (file_put_contents($filePath, $photoContent)) {
            return asset("uploads/{$fileName}.png");
        }
        return false;
    }

    // Main function to handle signature generation
    public function generateSignature(Request $request) {
        $name_bn = $request->input('name_bn');

        if (!$name_bn) {
            return response()->json(['error' => 'Name not provided.'], 400);
        }

        $cleaned_full_name = $this->removeAdditionalParts($name_bn);
        $name_parts = explode(' ', $cleaned_full_name);
        $first_name = (count($name_parts) > 1) ? $name_parts[1] : $name_parts[0];

        if (!extension_loaded('imagick')) {
            return response()->json(['error' => 'Imagick extension not loaded.'], 500);
        }

        $text = $first_name;
        $font = public_path('fonts/HandWriting.ttf');
        $fontSize = 20;
        $maxWidth = 136;
        $maxHeight = 72;

        $image = new \Imagick();
        $draw = new \ImagickDraw();
        $draw->setFont($font);
        $draw->setFontSize($fontSize);
        $draw->setFillColor('black');
        $draw->setTextAlignment(\Imagick::ALIGN_CENTER);

        $tempImage = new \Imagick();
        $tempImage->newImage(1, 1, new \ImagickPixel('transparent'));
        $metrics = $tempImage->queryFontMetrics($draw, $text);
        $textWidth = (int) $metrics['textWidth'];
        $textHeight = (int) $metrics['textHeight'];

        while (($textWidth > $maxWidth || $textHeight > $maxHeight) && $fontSize > 1) {
            $fontSize--;
            $draw->setFontSize($fontSize);
            $metrics = $tempImage->queryFontMetrics($draw, $text);
            $textWidth = (int) $metrics['textWidth'];
            $textHeight = (int) $metrics['textHeight'];
        }

        $image->newImage($textWidth + 20, $textHeight + 20, new \ImagickPixel('transparent'));
        $image->annotateImage($draw, ($textWidth + 20) / 2, ($textHeight + 20) / 2 - $fontSize / 2, 0, $text);
        $image->setImageFormat('png');

        $photoContent = $image->getImageBlob();
        $image->clear();
        $image->destroy();

        $savedPhotoUrl = $this->savePhoto($photoContent, 'signature');

        if ($savedPhotoUrl) {
            return response()->json(['sign' => $savedPhotoUrl]);
        } else {
            return response()->json(['error' => 'Failed to save the photo.'], 500);
        }
    }
}
