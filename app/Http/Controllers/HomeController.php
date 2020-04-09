<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;

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
                $auth_user = Auth::guard('seller')->user();
                $auth_user->is_admin = false;
                $auth_user->is_user = false;
                $auth_user->is_seller = true;
            }
            if (Auth::guard('admin')->check()) {
                $auth_user = Auth::guard('admin')->user();
                $auth_user->is_admin = true;
                $auth_user->is_user = false;
                $auth_user->is_seller = false;
            }
            return view('welcome', compact('auth_user'));
        } else {
            return redirect('/login');
        }
    }
}
