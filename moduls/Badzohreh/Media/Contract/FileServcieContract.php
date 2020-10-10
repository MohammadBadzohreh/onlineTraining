<?php

namespace Badzohreh\Media\Contract;
use Illuminate\Http\UploadedFile;

interface FileServcieContract{
    public static function upload(UploadedFile $file) :array;
    public static function delete();
}