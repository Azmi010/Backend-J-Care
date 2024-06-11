<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class ImageUploadController extends Controller
{
    public function upload(Request $request)
    {
        Log::info('Upload request received', ['request' => $request->all()]);
        
        if ($request->hasFile('file')) {
            try {
                $file = $request->file('file');
                $path = $file->store('uploads', 'public'); // Store in the 'uploads' directory within the 'public' disk
                $url = Storage::url($path); // Get URL to the stored file

                Log::info('File uploaded successfully', ['url' => $url]);
                return response()->json(['url' => $url], 200);
            } catch (\Exception $e) {
                Log::error('Failed to upload image', ['error' => $e->getMessage()]);
                return response()->json(['error' => 'Failed to upload image', 'message' => $e->getMessage()], 500);
            }
        }

        Log::warning('No file uploaded');
        return response()->json(['error' => 'No file uploaded'], 400);
    }
}
