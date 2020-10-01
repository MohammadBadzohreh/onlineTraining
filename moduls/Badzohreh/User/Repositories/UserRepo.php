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
            "name" =>$values->name ,
            "email" =>$values->email ,
            "image_id"=>$values->image_id,
            "username" =>$values->username,
            "mobile" =>$values->mobile ,
            "headline" =>$values->headline ,
            "website" =>$values->website ,
            "facebook" =>$values->facebook ,
            "linkedin" =>$values->likedin ,
            "twitter" =>$values->twitter ,
            "youtube" =>$values->youtube ,
            "instagram" =>$values->instagram ,
            "telegram" =>$values->telegram ,
            "status" =>$values->status ,
            "bio" =>$values->bio ,
        ];
        if (!is_null($values->password)){
            $data['password'] = bcrypt($values->password);
        }
        $user->update($data);
    }

    public function delete($userId)
    {
        $user = $this->findById($userId);
        if ($user->banner){
            $user->banner->delete();
        }
        $user->delete();
    }
}


