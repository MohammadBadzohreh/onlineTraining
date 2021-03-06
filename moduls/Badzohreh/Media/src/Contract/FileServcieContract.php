<?php

namespace Badzohreh\Media\Contract;

use Illuminate\Http\UploadedFile;

interface FileServcieContract
{
    public static function upload(UploadedFile $file, $dir, $filename): array;

    public static function delete($file);

    public static function thumb($file);

    public static function stream($media);
}
