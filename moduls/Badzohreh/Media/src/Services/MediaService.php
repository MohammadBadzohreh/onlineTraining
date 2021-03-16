<?php

namespace Badzohreh\Media\Services;

use Badzohreh\Media\Contract\FileServcieContract;
use Badzohreh\Media\Models\Media;

class MediaService
{

    private static $direction;
    private static $file;
    private static $is_private;

    public static function publicUplaod($file)
    {
        self::$direction = 'public';
        self::$file = $file;
        self::$is_private = false;
        return self::uplaod($file);
    }

    public static function privateUpload($file)
    {
        self::$direction = 'private';
        self::$file = $file;
        self::$is_private = true;
        return self::uplaod($file);
    }


    public static function uplaod($file)
    {
        foreach (config("MediaFile.mediaTypeService") as $key => $service) {
            if (in_array(self::getFileExtension(self::$file), $service["extentions"])) {
                return self::handleUploadMedia(new $service['handler'], $key);
            }
        }
    }

    public static function delete($media)
    {
        foreach (config("MediaFile.mediaTypeService") as $key => $service) {
            if ($key == $media->type){
                $service["handler"]::delete($media);
            }
        }

    }
    public static function thumb(Media $media){
        foreach (config("MediaFile.mediaTypeService") as $type=>$service) {
            if ($type == $media->type){
                return $service["handler"]::thumb($media);
            }
        }
    }

    private static function generateFileName()
    {
        return uniqid();
    }

    private static function getFileExtension($file)
    {
        return strtolower($file->getClientOriginalExtension());
    }

    private static function handleUploadMedia(FileServcieContract $service, $key)
    {
        $media = new Media();
        $media->user_id = auth()->id();
        $media->files = $service::upload(self::$file, self::$direction, self::generateFileName());
        $media->type = $key;
        $media->file_name = self::$file->getClientOriginalName();
        $media->is_private = self::$is_private;
        $media->save();
        return $media;
    }

    public static function stream(Media $media)
    {
        foreach (config("MediaFile.mediaTypeService") as $type=>$service) {
            if ($type == $media->type){
                return $service["handler"]::stream($media);
            }
        }

    }
}
