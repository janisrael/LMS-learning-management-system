<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use Illuminate\Support\Facades\Storage;

class FileDownloadController extends Controller
{
    public function getCourseAttachment($filename)
    {
        $filePath = Course::PERMANENT_DIRECTORY.'/'.$filename;

        return $this->getFile($filePath);
    }

    function getFile($filePath)
    {
        ob_end_clean();
        if (!Storage::exists($filePath))
        {
            return $this->toJson(['message'=>'File not found'],404);
        }
        return Storage::download($filePath);
    }
}
