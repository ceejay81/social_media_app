<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class FileHandlingService
{
    public function handleMediaUpload(UploadedFile $file)
    {
        $fileExtension = $file->getClientOriginalExtension();
        
        if (in_array($fileExtension, ['jpeg', 'png', 'jpg', 'gif'])) {
            $path = $file->store('post-images', 'public');
            return ['type' => 'image', 'path' => $path];
        } elseif (in_array($fileExtension, ['mp4', 'mov', 'avi'])) {
            $path = $file->store('post-videos', 'public');
            Log::info("Video uploaded successfully: " . $path);
            return ['type' => 'video', 'path' => $path];
        }

        return null;
    }

    public function deleteOldMedia($post)
    {
        if ($post->image) {
            Storage::disk('public')->delete($post->image);
        }
        if ($post->video) {
            Storage::disk('public')->delete($post->video);
        }
    }
}