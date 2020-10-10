<?php
namespace Badzohreh\Media\Services;

class DefaultMediaService
{
    public static function delete($files)
    {
        foreach ($files as $file) {
            if ($file->is_private) {
                Storage::delete("private\\" . $file);
            } else {
                Storage::delete("public\\" . $file);
            }
        }

    }
}