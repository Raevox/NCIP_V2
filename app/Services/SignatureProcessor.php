<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver; // pwede rin Imagick kung enabled

class SignatureProcessor
{
    protected $manager;

    public function __construct()
    {
       $this->manager = new ImageManager(['driver' => 'gd']);
    }

    /**
     * Process signature image: remove background, enhance contrast, standardize size
     */
    public function processSignature($imagePath, $outputPath = null)
    {
        try {
            // Load the image
            $image = $this->manager->read($imagePath);

            // Get original dimensions
            $originalWidth = $image->width();
            $originalHeight = $image->height();

            // Step 1: Convert to grayscale for processing
            $processedImage = clone $image;
            $processedImage->greyscale();

            // Step 2: Increase contrast to make signature darker
            $processedImage->contrast(50);

            // Step 3: Adjust brightness to remove gray background
            $processedImage->brightness(-10);

            // Step 4: Apply threshold
            $this->applyThreshold($processedImage);

            // Step 5: Remove white background (make transparent)
            $this->removeWhiteBackground($processedImage);

            // Step 6: Crop to signature bounds
            $processedImage = $this->cropToSignature($processedImage);

            // Step 7: Standardize size while maintaining aspect ratio
            $processedImage = $this->standardizeSize($processedImage, 400, 150);

            // Step 8: Save processed image
            if (!$outputPath) {
                $outputPath = 'signatures/processed_' . uniqid() . '.png';
            }

            $processedImage->toPng()->save(storage_path('app/public/' . $outputPath));

            return [
                'success' => true,
                'processed_path' => $outputPath,
                'original_size' => ['width' => $originalWidth, 'height' => $originalHeight],
                'processed_size' => ['width' => $processedImage->width(), 'height' => $processedImage->height()],
                'has_content' => $this->validateSignatureContent($processedImage)
            ];

        } catch (\Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    private function applyThreshold($image, $threshold = 200)
    {
        $image->greyscale();
        $image->contrast(50);
        $image->brightness(-10);

        // Reduce colors to 2 → black & white only
        $image->limitColors(2, '#ffffff');
    }

    private function removeWhiteBackground($image)
    {
        // Convert to PNG with transparency
        $image->toPng();
        $image->trim('top-left', null, 40);
    }

    private function cropToSignature($image)
    {
        $image->trim('top-left', null, 30);
        return $image;
    }

    private function standardizeSize($image, $maxWidth = 400, $maxHeight = 150)
    {
        $image->resize($maxWidth, $maxHeight, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });

        return $image;
    }

    private function validateSignatureContent($image)
    {
        $clone = clone $image;
        $clone->resize(50, 20)->greyscale();

        $darkPixels = 0;
        $totalPixels = $clone->width() * $clone->height();

        $data = $clone->toPng();
        $resource = imagecreatefromstring($data);

        for ($x = 0; $x < imagesx($resource); $x++) {
            for ($y = 0; $y < imagesy($resource); $y++) {
                $rgb = imagecolorat($resource, $x, $y);
                $r = ($rgb >> 16) & 0xFF;
                $g = ($rgb >> 8) & 0xFF;
                $b = $rgb & 0xFF;
                $brightness = ($r + $g + $b) / 3;

                if ($brightness < 200) {
                    $darkPixels++;
                }
            }
        }

        imagedestroy($resource);

        $coverage = ($darkPixels / $totalPixels) * 100;
        return $darkPixels >= 100 && $coverage >= 1 && $coverage <= 80;
    }

    public function createSignatureHash($imagePath)
    {
        try {
            $image = $this->manager->read($imagePath);

            $image->resize(50, 20);
            $image->greyscale();

            $hash = '';
            $data = $image->toPng();
            $resource = imagecreatefromstring($data);

            for ($y = 0; $y < imagesy($resource); $y++) {
                for ($x = 0; $x < imagesx($resource); $x++) {
                    $rgb = imagecolorat($resource, $x, $y);
                    $r = ($rgb >> 16) & 0xFF;
                    $g = ($rgb >> 8) & 0xFF;
                    $b = $rgb & 0xFF;
                    $brightness = ($r + $g + $b) / 3;

                    $hash .= ($brightness < 128) ? '1' : '0';
                }
            }

            imagedestroy($resource);
            return $hash;

        } catch (\Exception $e) {
            return null;
        }
    }

    public function compareSignatures($hash1, $hash2)
    {
        if (!$hash1 || !$hash2 || strlen($hash1) !== strlen($hash2)) {
            return 0;
        }

        $matches = 0;
        $total = strlen($hash1);

        for ($i = 0; $i < $total; $i++) {
            if ($hash1[$i] === $hash2[$i]) {
                $matches++;
            }
        }

        return ($matches / $total) * 100;
    }
}
