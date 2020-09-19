<?php
namespace Badzohreh\Media\Services;

use Badzohreh\Media\Models\Media;

class MediaService
{

    public static function uplaod($file)
    {
        $extention = strtolower($file->getClientOriginalExtension());

        switch ($extention){

            case "png":
            case "jpg":
            case "jpeg":

                $media = new Media();
                $media->user_id = auth()->id();
                $media->files = ImageServices::upload($file);
                $media->type = "image";
                $media->file_name = $file->getClientOriginalName();
                $media->save();
                return $media;
                break;

            case "mp4":
            case "avi":
                VideoServices::upload();
                break;
        }
    }
}