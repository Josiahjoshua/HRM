<?php

namespace App\Http\Controllers;

use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        
        $roles = Role::all();
        return view('user-management.roles.index', compact('roles'));
    }

    public function edit(Role $role)
    {
        
        $permissions = Permission::all();
        $role->load('permissions');

        return view('user-management.roles.edit', compact('role', 'permissions'));
    }
    public function store(Request $request)
    {
        
        $request->validate([
            'name' => ['required']
        ]);

        Role::create(['name' => $request->name]);
        toast('Successfully added!','success');
        return back();
    }

    public function update(Request $request, Role $role)
    {
        
        $request->validate([
            'permissions' => ['array']
        ]);

        $role->syncPermissions($request->permissions);
        Alert::success('Success!', 'Successfully Role updated');
        return back();
    }
    public function destroy($id)
    {
      
        $role = Role::findOrFail($id);
        $role->delete();
        Alert::success('Success!', 'Successfully deleted');
        return back();
    }
}
