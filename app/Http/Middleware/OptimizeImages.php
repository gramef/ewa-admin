<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class OptimizeImages
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // Only process image uploads
        if ($request->hasFile('image') || $request->hasFile('images')) {
            $this->optimizeUploadedImages($request);
        }

        return $response;
    }

    /**
     * Optimize uploaded images
     */
    private function optimizeUploadedImages(Request $request)
    {
        // Handle single image upload
        if ($request->hasFile('image')) {
            $this->processImage($request->file('image'));
        }

        // Handle multiple images upload
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $this->processImage($image);
            }
        }

        // Handle media uploads (for media library)
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            if ($this->isImage($file)) {
                $this->processImage($file);
            }
        }
    }

    /**
     * Process and optimize individual image
     */
    private function processImage($file)
    {
        if (!$this->isImage($file)) {
            return;
        }

        try {
            // Get original path
            $originalPath = $file->getPathname();
            
            // Create optimized image
            $image = Image::make($originalPath);
            
            // Resize if too large (max width: 1920px, max height: 1080px)
            if ($image->width() > 1920 || $image->height() > 1080) {
                $image->resize(1920, 1080, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
            }

            // Optimize quality based on file size
            $quality = $this->getOptimalQuality($image->filesize());
            
            // Save optimized image back to original path
            $image->save($originalPath, $quality);

            // Generate thumbnail if needed
            $this->generateThumbnail($image, $originalPath);

        } catch (\Exception $e) {
            \Log::error('Image optimization failed: ' . $e->getMessage());
        }
    }

    /**
     * Check if file is an image
     */
    private function isImage($file): bool
    {
        $allowedMimes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        return in_array($file->getMimeType(), $allowedMimes);
    }

    /**
     * Get optimal quality based on file size
     */
    private function getOptimalQuality(int $fileSize): int
    {
        // File size in MB
        $sizeMB = $fileSize / (1024 * 1024);

        if ($sizeMB > 5) {
            return 60; // Heavy compression for large files
        } elseif ($sizeMB > 2) {
            return 75; // Medium compression
        } elseif ($sizeMB > 1) {
            return 85; // Light compression
        }

        return 90; // Minimal compression for small files
    }

    /**
     * Generate thumbnail for images
     */
    private function generateThumbnail($image, string $originalPath)
    {
        try {
            $thumbnailPath = $this->getThumbnailPath($originalPath);
            
            // Create thumbnail (300x300 max)
            $thumbnail = clone $image;
            $thumbnail->resize(300, 300, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });

            $thumbnail->save($thumbnailPath, 80);
        } catch (\Exception $e) {
            \Log::error('Thumbnail generation failed: ' . $e->getMessage());
        }
    }

    /**
     * Get thumbnail path
     */
    private function getThumbnailPath(string $originalPath): string
    {
        $pathInfo = pathinfo($originalPath);
        return $pathInfo['dirname'] . '/' . $pathInfo['filename'] . '_thumb.' . $pathInfo['extension'];
    }
}
