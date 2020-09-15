<?php

namespace Badzohreh\RolePermissions\Http\Controllers;

use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionsController extends Controller
{

    public function index()
    {


        $permissions = Permission::all();
        $roles = Role::all();
        return view("RolePermissions::index", compact("roles","permissions"));
    }

}