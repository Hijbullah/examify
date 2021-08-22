<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Image;
use Illuminate\Support\Facades\Storage;

class ImageUploaderController extends Controller
{
    public function uploadImage(Request $request)
    {
        $request->validate([
            'file' => ['required', 'image', 'mimes:jpg,jpeg,png,svg', 'max:2048']
        ]);


        $path = $request->file('file')->store('uploads', 'public');
        return ['location' => Storage::url($path)];

        // $file = $request->file('file');
        // $path = $file->hashName('temporary-images');
        // // avatars/bf5db5c75904dac712aea27d45320403.jpeg

        // $image = Image::make($file);

        // $image->fit(250, 250, function ($constraint) {
        //     $constraint->aspectRatio();
        // });

        // Storage::put($path, (string) $image->encode());

        // return response()->json([
        //     'status' => 'Success',
        //     'url' => Storage::url($path)
        // ]); 
    }
}
