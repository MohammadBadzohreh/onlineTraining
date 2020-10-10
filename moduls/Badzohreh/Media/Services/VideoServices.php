<?php

namespace Badzohreh\Media\Services;


use Illuminate\Support\Facades\Storage;

class VideoServices
{
    public static function upload($file)
    {
        $filename = uniqid();
        $extention = $file->getClientOriginalExtension();
        $dir = 'private\\';
        Storage::putFileAs($dir, $file, $filename . '.' . $extention);
        return ['video' => $dir . $filename . "." . $extention];
    }
}