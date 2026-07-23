<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\SignatureProcessor;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class SignatureController extends Controller
{
    protected $signatureProcessor;

    public function __construct()
    {
        // Initialize SignatureProcessor directly to avoid dependency injection issues
        $this->signatureProcessor = new SignatureProcessor();
    }

    /**
     * Process signature image via AJAX
     */
    public function processSignature(Request $request)
    {
        try {
            // Validate request
            $request->validate([
                'signature' => 'required|file|mimes:jpg,jpeg,png|max:5120', // 5MB max
            ]);

            $file = $request->file('signature');
            
            // Store original file temporarily
            $originalPath = $file->store('temp/signatures', 'public');
            $fullOriginalPath = storage_path('app/public/' . $originalPath);

            // Check if SignatureProcessor exists
            if (!class_exists('App\Services\SignatureProcessor')) {
                return response()->json([
                    'success' => false,
                    'message' => 'SignatureProcessor service not found'
                ], 500);
            }

            // Process the signature
            $result = $this->signatureProcessor->processSignature($fullOriginalPath);

            if ($result['success']) {
                // Create signature hash
                $hash = $this->signatureProcessor->createSignatureHash(storage_path('app/public/' . $result['processed_path']));
                
                // Generate preview URL
                $previewUrl = asset('storage/' . $result['processed_path']);
                
                return response()->json([
                    'success' => true,
                    'processed_path' => $result['processed_path'],
                    'original_path' => $originalPath,
                    'preview_url' => $previewUrl,
                    'signature_hash' => $hash,
                    'has_valid_signature' => $result['has_content'],
                    'original_size' => $result['original_size'],
                    'processed_size' => $result['processed_size'],
                    'message' => 'Signature processed successfully'
                ]);
            } else {
                // Clean up temp file on error
                Storage::disk('public')->delete($originalPath);
                
                return response()->json([
                    'success' => false,
                    'message' => $result['error'] ?? 'Failed to process signature'
                ], 422);
            }

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid file format or size. Please upload JPG, PNG files under 5MB.',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Signature processing error: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            
            return response()->json([
                'success' => false,
                'message' => 'Server error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get processed signature preview
     */
    public function getPreview($path)
    {
        try {
            $decodedPath = base64_decode($path);
            
            if (!Storage::disk('public')->exists($decodedPath)) {
                abort(404);
            }

            return response()->file(storage_path('app/public/' . $decodedPath));
        } catch (\Exception $e) {
            abort(404);
        }
    }

    /**
     * Compare signatures (for staff use)
     */
    public function compareSignatures(Request $request)
    {
        try {
            $request->validate([
                'hash1' => 'required|string',
                'hash2' => 'required|string',
            ]);

            $similarity = $this->signatureProcessor->compareSignatures(
                $request->hash1,
                $request->hash2
            );

            return response()->json([
                'success' => true,
                'similarity' => $similarity,
                'is_similar' => $similarity >= 70 // 70% threshold
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error comparing signatures'
            ], 500);
        }
    }
}