<?php

namespace Badzohreh\RolePermissions\Http\Controllers;

use App\Http\Controllers\Controller;
use Badzohreh\Category\Responses\AjaxResponses;
use Badzohreh\RolePermissions\Http\Requests\RolePermissionStoreRequest;
use Badzohreh\RolePermissions\http\Requests\UpdateRolerequest;
use Badzohreh\RolePermissions\Models\Role;
use Badzohreh\RolePermissions\Repositories\PermissionsRepo;
use Badzohreh\RolePermissions\Repositories\RoleRepo;

class RolePermissionsController extends Controller
{

    private $RoleRepo;
    private $PermissionRepo;

    public function __construct(RoleRepo $RoleRepo,PermissionsRepo $permissionRepo) {
        $this->RoleRepo = $RoleRepo;
        $this->PermissionRepo= $permissionRepo;
    }

    public function index(PermissionsRepo $permissionRepo)
    {
        $this->authorize('manage',Role::class);
        $roles = $this->RoleRepo->all();
        $permissions=$this->PermissionRepo->all();
        return view("RolePermissions::index", compact("roles","permissions"));
    }

    public function store(RolePermissionStoreRequest $request)
    {

        $this->authorize("store",Role::class);
         $this->RoleRepo->store($request);
         return  redirect(route("permissions.index"));
    }

    public function edit($id)
    {
        $this->authorize("edit",Role::class);
        $role = $this->RoleRepo->findById($id);
        $permissions = $this->PermissionRepo->all();
       return view("RolePermissions::edit",compact("role","permissions"));
    }

    public function update(UpdateRolerequest $request,$roleId)
    {
        $this->authorize("edit",Role::class);
        $this->RoleRepo->update($roleId,$request);
        return redirect(route("permissions.index"));
    }

    public function destroy($roleId)
    {
        $this->authorize("delete",Role::class);
        $this->RoleRepo->delete($roleId);
        return AjaxResponses::successResponses();
    }

}