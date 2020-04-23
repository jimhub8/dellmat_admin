<?php

namespace App\Http\Controllers;

use App\User;
use Bitfumes\Multiauth\Model\Permission;
use Bitfumes\Multiauth\Model\Role;
use Illuminate\Http\Request;

class RoleController extends Controller {

    public function logged_user()
    {
        $user = new User();
        return  $user->logged_user();
    }
	public function index() {
        $roles = Role::all();
        $roles->transform(function($role) {
            foreach ($role->permissions as  $permission) {
                $permissions[] = $permission['id'];
            }
            // dd($permissions);
            $role->permissions_arr = $permissions;
            return $role;
        });
        return $roles;
	}

	public function permissions()
	{
		return Permission::all();
	}

	public function store(Request $request)
	{

        // dd($request->all());
        $request->validate(['name' => 'required']);
        $role = Role::create($request->all());
        $role->addPermission($request->permissions);
        // return $request->all();
        // $role = Role::create(['name' => $request->name]);
        // $role->addPermission($request->permissions);
		return $role;
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Role  $role
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id) {
		// return $request->all();
		$role = Role::find($id);
		$role->name = $request->form['name'];
		$role->save();
		$role->syncPermissions($request->selected);
		return $role;
	}

	public function destroy(Role $role) {
		// return $role->id;
		Role::find($role->id)->delete();
	}


	public function getRolesPerm(Request $request)
	{
		// return $request->all();
		return Role::findByName($request->name)->permissions->pluck('name');
	}
}
