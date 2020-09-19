<?php


namespace Badzohreh\Media\Services;


use Intervention\Image\Facades\Image;

class ImageServices
{
    protected static $sizes = ['300','450', '600'];

    public static function upload($file)
    {
        $filename = uniqid();
        $extention = $file->getClientOriginalExtension();
        $dir = "app\public\\";

        $file->move(storage_path($dir), $filename . "." . $extention);

        $path = $dir . "\\" . $filename . "." . $extention;

        return self::resize(storage_path($path), storage_path($dir), $filename, $extention);


    }

    public static function resize($img, $dir, $filename, $extention)
    {

        $img = Image::make($img);

        $imgs["original"] = $dir . $filename . "." . $extention;
        foreach (self::$sizes as $size) {
            $imgs[$size] = $dir . $filename . "_" . $size . "." . $extention;
            $img->resize($size, null, function ($aspect) {
                $aspect->aspectRatio();
            })->save($dir . $filename . "_" . $size . "." . $extention);
        }
        return $imgs;
    }

}