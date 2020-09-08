<?php


namespace Badzohreh\User\Repositories;
class UserRepo
{
    public function findgByEmail($email)
    {
        return User::query()->where("email", $email)->first();
    }
}