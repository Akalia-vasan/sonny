<?php

namespace App\Http\Controllers\API\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{

    public function index(Request $request)
    {
        $roles = Role::orderBy('id','DESC')->paginate(5);
        return res_success('Success!',['roles'=> $roles]);
    }

    public function create()
    {
        $permission = Permission::get();
        return res_success('Success!',['permission'=> $permission]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:roles,name',
            'permission' => 'required',
        ]);
        $role = Role::create(['name' => $request->input('name')]);
        $role->syncPermissions($request->input('permission'));
        return res_success('Success!',['data'=> $role]);
    }

    public function show($id)
    {
        $role = Role::find($id);
        $rolePermissions = Permission::join("role_has_permissions","role_has_permissions.permission_id","=","permissions.id")
            ->where("role_has_permissions.role_id",$id)
            ->get();
            return res_success('Success!',['role'=> $role,'rolePermissions'=> $rolePermissions]);
    }

    public function edit($id)
    {
        $role = Role::find($id);
        $permission = Permission::get();
        $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id",$id)
            ->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')
            ->all();
        return res_success('Success!',['role'=> $role, 'permission'=> $permission, 'rolePermissions'=> $rolePermissions]);  
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'permission' => 'required',
        ]);
        $role = Role::find($id);
       
        $role->name = $request->input('name');
        $role->save();
        
        $role->syncPermissions($request->input('permission'));
        return res_success('Success!',['data'=> $role]);
    }

    public function destroy($id)
    {
        DB::table("roles")->where('id',$id)->delete();
        return res_success('Success!',['data'=> '']);
    }

}
