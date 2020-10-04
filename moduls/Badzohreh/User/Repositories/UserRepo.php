<?php


namespace Badzohreh\User\Repositories;


use Badzohreh\RolePermissions\Models\Permission;
use Badzohreh\User\Models\User;

class UserRepo
{

    public function paginate()
    {
        return User::paginate();
    }

    public function getTeacher()
    {
        return User::permission(Permission::PERMISSION_TEACH);
    }

    public function findgByEmail($email)
    {
        return User::query()->where("email", $email)->first();
    }

    public function findById($id)
    {
        return User::find($id);
    }

    public function update($userId, $values)
    {
        $user = $this->findById($userId);
        $data = [
            "name" => $values->name,
            "email" => $values->email,
            "image_id" => $values->image_id,
            "username" => $values->username,
            "mobile" => $values->mobile,
            "headline" => $values->headline,
            "website" => $values->website,
            "telegram" => $values->telegram,
            "status" => $values->status,
            "bio" => $values->bio,
        ];
        if (!is_null($values->password)) {
            $data['password'] = bcrypt($values->password);
        }
        $user->update($data);
    }

    public function delete($userId)
    {
        $user = $this->findById($userId);
        if ($user->banner) {
            $user->banner->delete();
        }
        $user->delete();
    }


    public function updateCurrentProfile($values)
    {
        $user = auth()->user();
        $user->name = $values->name;
        if ($user->email != $values->email) {
            $user->email = $values->email;
            $user->email_verified_at = null;
        }
        $user->mobile = $values->mobile;
        $user->headline = $values->headline;
        $user->username = $values->username;
        if ($values->password) {
            $user->password = bcrypt($values->password);
        }
        if ($user->hasPermissionTo(Permission::PERMISSION_TEACH)) {
            $user->shaba = $values->shaba;
            $user->card_number = $values->card_number;
            $user->bio = $values->bio;
        }
        $user->save();
    }


}


