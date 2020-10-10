<?php

namespace Badzohreh\Media\Services;


use Badzohreh\Media\Contract\FileServcieContract;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class CompressServcie implements FileServcieContract
{
    public static function upload(UploadedFile $file): array
    {
        $filename = uniqid();
        $extention = $file->getClientOriginalExtension();
        $dir = 'private\\';
        Storage::putFileAs($dir, $file, $filename . '.' . $extention);
        return ['video' => $dir . $filename . "." . $extention];
    }
    public static function delete()
    {
    }

}