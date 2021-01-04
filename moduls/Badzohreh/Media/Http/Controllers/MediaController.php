<?php

namespace Badzohreh\Media\Http\Controllers;

use App\Http\Controllers\Controller;
use Badzohreh\Media\Models\Media;
use Badzohreh\Media\Services\MediaService;
use Illuminate\Http\Request;

class MediaController extends Controller{
    public function download(Media $media , Request $request)
    {
        if (!$request->hasValidSignature()){
            abort(401);
        }
        MediaService::stream($media);
    }
}

