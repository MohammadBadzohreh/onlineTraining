<?php

namespace Badzohreh\User\Services;


class VerifyService
{
    public static function generate()
    {
        return random_int(100000, 999999);
    }


    public static function store($id, $code)
    {
        cache()->set("verificaionCode" . $id,
            $code,
            now()->addDay());

    }


}