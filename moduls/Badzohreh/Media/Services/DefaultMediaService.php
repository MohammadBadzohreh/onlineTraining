<?php

namespace Badzohreh\Media\Services;

use Illuminate\Support\Facades\Storage;

abstract class DefaultMediaService
{
    static $media;

    public static function delete($media)
    {
        foreach ($media->files as $file) {
            if ($media->is_private) {
                Storage::delete("private\\" . $file);
            } else {
                Storage::delete("public\\" . $file);
            }
        }

    }
    abstract public static function getFileName();

    public static function stream($media)
    {
        static::$media = $media;
        $stream = Storage::readStream(static::getFilename());
        return response()->stream(function () use ($stream) {
            while (ob_get_level() > 0) ob_get_flush();
            fpassthru($stream);
        }, 200, [
            'Content-Type' => Storage::mimeType(static::getFileName()),
            'Content-Disposition' => 'attachment; filename=' . static::$media->file_name . ';'
        ]);
    }
}
