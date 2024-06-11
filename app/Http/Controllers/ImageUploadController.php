<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageUploadController extends Controller
{
    public function upload(Request $request)
    {
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $path = $file->store('uploads', 'public');
            $url = Storage::url($path);

            return response()->json(['url' => $url], 200);
        }

        return response()->json(['error' => 'No file uploaded'], 400);
    }
}
