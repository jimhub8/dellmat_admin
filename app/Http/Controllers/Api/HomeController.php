<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;


use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Session;
use App\models\Company;
use Illuminate\Support\Arr;

class HomeController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            $auth_user = Auth::user();
            // dd($auth_user);
            return view('welcome', compact('auth_user'));
        }
        return view('welcome');
    }
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    public function ecommerce()
    {
        //  dd($carts = Session::get('coupon')); die;
        if (Auth::check()) {
            $permissions = [];
            foreach (Permission::all() as $permission) {
                if (Auth::user()->can($permission->name)) {
                    $permissions[$permission->name] = true;
                } else {
                    $permissions[$permission->name] = false;
                }
            }
            $user = Auth::user();

            $auth_user = Arr::prepend($user->toArray(), $permissions, 'can');
            $user = Auth::user();
            return view('welcome', compact('auth_user'));
        } else {
            return view('welcome');
        }

        // dd($country);
        // $users->transform(function ($user, $key) {
        //     $country = Country::find($user->country_id);
        //     $user->country_name = $country->name;
        //     return $user;
        // });
        // dd(json_decode(json_encode((Auth::user()), false)));
    }
    public function admin()
    {
        $permissions = [];
        foreach (Permission::all() as $permission) {
            if (Auth::user()->can($permission->name)) {
                $permissions[$permission->name] = true;
            } else {
                $permissions[$permission->name] = false;
            }
        }
        $user = Auth::user();

        $company_id = Auth::user()->company_id;
        $company = Company::find($company_id);
        // $country = Country::find($user->country_id);
        // // dd($country);
        // $user->country_name = $country->country_name;
        // $users->transform(function ($user, $key) {
        //     $country = Country::find($user->country_id);
        //     $user->country_name = $country->name;
        //     return $user;
        // });
        // dd(json_decode(json_encode((Auth::user()), false)));
        $auth_user = array_prepend($user->toArray(), $permissions, 'can');
        return view('admin.admin', compact('auth_user', 'company'));
        // return redirect('/')->where('name', '[A-Za-z]+');
    }
}
