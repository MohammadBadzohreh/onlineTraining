<?php

namespace Badzohreh\User\Http\Controllers;

use App\Http\Controllers\Controller;
use Badzohreh\Common\Responses\AjaxResponses;
use Badzohreh\RolePermissions\Http\Requests\AddRoleRequest;
use Badzohreh\RolePermissions\Repositories\RoleRepo;
use Badzohreh\User\Models\User;
use Badzohreh\User\Repositories\UserRepo;

class UserController extends Controller
{

    private $userRepo;

    public function __construct(UserRepo $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    public function index(RoleRepo $roleRepo)
    {
        $this->authorize("index", User::class);
        $users = $this->userRepo->paginate();
        $roles = $roleRepo->all();
        return view("User::users.index", compact("users", "roles"));
    }
    public function addRole($userId, AddRoleRequest $request)
    {
        $user = $this->userRepo->findById($userId);
        $user->assignRole($request->role);
        showFeedbacks("عملیات موفقیت آمیز","با موفقیت اضافه شد.");
        return back();
    }

    public function giveRole($user, $role)
    {
        $user = $this->userRepo->findById($user);
        if ($user->removeRole($role)) {
            return AjaxResponses::successResponses();
        }
        return AjaxResponses::failResponses();
    }

    public function edit($userId)
    {

        $user = $this->userRepo->findById($userId);

        return view("User::users.edit",compact("user"));
    }

    public function update($userId)
    {

    }


}
