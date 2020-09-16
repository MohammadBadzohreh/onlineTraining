<?php

namespace Badzohreh\RolePermissions\Http\Controllers;

use App\Http\Controllers\Controller;
use Badzohreh\RolePermissions\Http\Requests\RolePermissionStoreRequest;
use Badzohreh\RolePermissions\http\Requests\UpdateRolerequest;
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
        $roles = $this->RoleRepo->all();
        $permissions=$this->PermissionRepo->all();
        return view("RolePermissions::index", compact("roles","permissions"));
    }

    public function store(RolePermissionStoreRequest $request)
    {
         $this->RoleRepo->store($request);
         return  redirect(route("permissions.index"));
    }

    public function edit($id)
    {
        $role = $this->RoleRepo->findById($id);
        $permissions = $this->PermissionRepo->all();
       return view("RolePermissions::edit",compact("role","permissions"));
    }

    public function update(UpdateRolerequest $request,$roleId)
    {
        $this->RoleRepo->update($roleId,$request);
        return redirect(route("permissions.index"));
    }




}