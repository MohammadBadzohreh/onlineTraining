<?php

namespace Badzohreh\User\Http\Controllers;

use App\Http\Controllers\Controller;
use Badzohreh\Common\Responses\AjaxResponses;
use Badzohreh\Media\Models\Media;
use Badzohreh\Media\Services\MediaService;
use Badzohreh\RolePermissions\Http\Requests\AddRoleRequest;
use Badzohreh\RolePermissions\Models\Permission;
use Badzohreh\RolePermissions\Repositories\RoleRepo;
use Badzohreh\User\Http\Requests\UpdateUser;
use Badzohreh\User\Http\Requests\UpdateUserProfile;
use Badzohreh\User\Http\Requests\UpdateUserRequest;
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
        $this->authorize("addRole", User::class);
        $user = $this->userRepo->findById($userId);
        $user->assignRole($request->role);
        showFeedbacks("عملیات موفقیت آمیز", "با موفقیت اضافه شد.");
        return back();
    }

    public function giveRole($user, $role)
    {
        $this->authorize("removeRole", User::class);
        $user = $this->userRepo->findById($user);
        if ($user->removeRole($role)) {
            return AjaxResponses::successResponses();
        }
        return AjaxResponses::failResponses();
    }

    public function edit($userId)
    {

        $this->authorize("update", User::class);

        $user = $this->userRepo->findById($userId);

        return view("User::users.edit", compact("user"));
    }

    public function update($userId, UpdateUserRequest $request)
    {
        $this->authorize("update", User::class);

        $user = $this->userRepo->findById($userId);
        if ($request->file("image")) {
            if ($user->banner) {
                $user->banner->delete();
            }
            $request->image_id = MediaService::publicUplaod($request->file("image"))->id;
        } else {
            $request->image_id = $user->image_id;
        }
        $this->userRepo->update($userId, $request);
        showFeedbacks();
        return redirect()->back();
    }

    public function destroy($userId)
    {
        $this->authorize("delete", User::class);
        $this->userRepo->delete($userId);
    }

    public function manualConfirm($userId)
    {
        $this->authorize("manaualConfirm", User::class);
        $user = $this->userRepo->findById($userId);
        $user->markEmailAsVerified();
        return AjaxResponses::successResponses();
    }


//    profile

    public function userProfileImage(UpdateUserProfile $request)
    {
        $user = auth()->user();
        if ($user->banner) {
            $user->banner->delete();
        }
        $user->image_id = MediaService::publicUplaod($request->file("image"))->id;
        $user->save();
        return redirect()->back();
    }

    public function profile()
    {
        return view("User::users.information");
    }

    public function updateProfile(UpdateUser $request)
    {
        $this->userRepo->updateCurrentProfile($request);
        showFeedbacks();
        return back();
    }

    public function info($user_id)
    {
        $this->authorize("index", User::class);
        $user = $this->userRepo->findWithInfo($user_id);
        return view("User::users.info", compact("user"));
    }


}
