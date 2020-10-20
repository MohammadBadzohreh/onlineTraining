<?php


namespace Badzohreh\Media\Services;


use Badzohreh\Media\Contract\FileServcieContract;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class ImageServices extends DefaultMediaService implements FileServcieContract
{
    protected static $sizes = ['300', '450', '600'];

    public static function upload($file, $dir, $filename): array
    {
        Storage::putFileAs($dir, $file, $filename . "." . $file->getClientOriginalExtension());
        $path = $dir . "\\" . $filename . "." . $file->getClientOriginalExtension();
        return self::resize(Storage::path($path), $dir, $filename, $file->getClientOriginalExtension());
    }

    public static function resize($img, $dir, $filename, $extention)
    {
        $img = Image::make($img);
        $imgs["original"] = $filename . "." . $extention;
        foreach (self::$sizes as $size) {
            $imgs[$size] = $filename . "_" . $size . "." . $extention;
            $img->resize($size, null, function ($aspect) {
                $aspect->aspectRatio();
            })->save(Storage::path($dir) . '/' . $filename . '_' . $size . '.' . $extention);
        }
        return $imgs;
    }

    public static function thumb($media)
    {
        return '/storage/' . $media->files["300"];
    }

}