<?php

namespace Badzohreh\User\Services;


class VerifyService
{
    private static $min = 100000;
    private static $max = 999999;

    public static function generate()
    {
        return random_int(self::$min, self::$max);
    }


    public static function store($id, $code)
    {
        cache()->set("verificaionCode" . $id,
            $code,
            now()->addDay());

    }


    public static function get($id)
    {
        return cache()->get("verificaionCode" . $id);
    }

    public static function delete($id)
    {
        cache()->delete("verificaionCode" . $id);

    }


    public static function getRule()
    {
        return "required|numeric|between:" . self::$min . ',' . self::$max;
    }


    public static function check($id, $code)
    {
        if (self::get($id) != $code)
            return false;

        self::delete($id);
        return true;
    }

}