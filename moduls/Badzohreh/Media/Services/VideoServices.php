<?php

namespace Badzohreh\Media\Services;


use Badzohreh\Media\Contract\FileServcieContract;
use Illuminate\Support\Facades\Storage;

class VideoServices extends DefaultMediaService implements FileServcieContract
{
    public static function upload($file, $dir, $filename): array
    {
        Storage::putFileAs($dir, $file, $filename . '.' . $file->getClientOriginalExtension());
        return ['video' => $filename . "." . $file->getClientOriginalExtension()];
    }

}