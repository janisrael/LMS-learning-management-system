<?php

namespace App\Http\Controllers;

use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class UploadsController extends AuthenticationController
{
 
    public function uploadFile(Request $request)
    {
//        $path = $request->file('file')->store('temp_files');
//        $file = explode('/', $path);
        $putFilesTo = 'public';
        $request_from = $request->path();
        if(strpos($request_from, 'lessons') !== false){
            if(strpos($request_from, 'resources') !== false){
                $putFilesTo = 'public\lessons\resources';
            }
            else {
                $putFilesTo = 'public\lessons';
            }
        }

        if(strpos($request_from, 'courses') !== false){
            $putFilesTo = 'public\temp_files';
        }

        $upload = new File($request->file('file'));
        // Generate unique name with real extension using the same method used by Storage::putFile()
        $fileHash = str_replace('.' . $upload->extension(), '', $upload->hashName());
        $fileName = $fileHash . '.' . $request->file('file')->getClientOriginalExtension();
        $path = Storage::putFileAs($putFilesTo, $upload, $fileName);
        $file = explode('/', $path);
        return response()->json(['path' => $file[1]], 200);
    }
}
