<?php

namespace Badzohreh\Media\Services;


use Badzohreh\Media\Contract\FileServcieContract;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class CompressServcie extends DefaultMediaService implements FileServcieContract
{
    public static function upload(UploadedFile $file,$dir,$filename): array
    {
        Storage::putFileAs($dir, $file, $filename . '.' . $file->getClientOriginalExtension());
        return ['zip' => $filename . "." . $file->getClientOriginalExtension()];
    }
    public static function thumb($file)
    {
        return url("img/zipBanner.png");
    }

    public static function getFileName()
    {
        return (self::$media->is_private ? "private/" : "public/") . self::$media->files["zip"];
    }



}
