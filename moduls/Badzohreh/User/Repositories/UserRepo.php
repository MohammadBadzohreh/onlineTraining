<?php



namespace Badzohreh\User\Repositories;


use Badzohreh\User\Models\User;

class UserRepo
{
    public function findgByEmail($email)
    {
        return User::query()->where("email", $email)->first();
    }

    public function findById($id)
    {
        return User::find($id);
    }
}


