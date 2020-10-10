<?php
namespace Badzohreh\Media\Services;

use Badzohreh\Media\Models\Media;
use Faker\Provider\Image;

class MediaService
{

    public static function uplaod($file)
    {
        $extention = strtolower($file->getClientOriginalExtension());
        foreach (config("MediaFile.mediaTypeService") as $key=>$service){
            if (in_array($extention,$service["extentions"])){
                $media = new Media();
                $media->user_id = auth()->id();
                $media->files = $service["handler"]::upload($file);
                $media->type = $key;
                $media->file_name = $file->getClientOriginalName();
                $media->save();
                return $media;
                break;
            }
        }
    }
    public static function delete($media){
        switch ($media->type){
            case "image":
                ImageServices::delete($media->files);
        }

    }
}