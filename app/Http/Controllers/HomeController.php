<?php

namespace App\Http\Controllers;

use App\User;
use Bitfumes\Multiauth\Model\Permission;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function logged_user()
    {
        $user = new User;
        return  $user->logged_user();
    }
    public function index()
    {


        if (Auth::check() || Auth::guard('seller')->check()  || Auth::guard('admin')->check()) {
            if (Auth::check()) {
                $auth_user = $this->logged_user();
                $auth_user->is_admin = false;
                $auth_user->is_user = true;
                $auth_user->is_seller = false;
            }
            if (Auth::guard('seller')->check()) {
                // foreach (Permission::all() as $permission) {
                //     if (Auth::guard('seller')->user()->can($permission->name)) {
                //         $permissions[$permission->name] = true;
                //     } else {
                //         $permissions[$permission->name] = false;
                //     }
                // }
                $auth_user = Auth::guard('seller')->user();
                $auth_user->is_admin = false;
                $auth_user->is_user = false;
                $auth_user->is_seller = true;
            }
            if (Auth::guard('admin')->check()) {
                foreach (Permission::all() as $permission) {
                    if (Auth::guard('admin')->user()->can($permission->name)) {
                        $permissions[$permission->name] = true;
                    } else {
                        $permissions[$permission->name] = false;
                    }
                }
                $auth_user = Auth::guard('admin')->user();
                $auth_user->is_admin = true;
                $auth_user->is_user = false;
                $auth_user->is_seller = false;
                $auth_user = Arr::prepend($auth_user->toArray(), $permissions, 'can');
            }
            return view('welcome', compact('auth_user'));
        } else {
            return redirect('/login');
        }
    }
}
