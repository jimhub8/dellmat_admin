<?php

namespace App\Http\Controllers\api;

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
        if (auth('api')->check()) {
            $auth_user = auth('api')->user();
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
        if (auth('api')->check()) {
            $permissions = [];
            foreach (Permission::all() as $permission) {
                if (auth('api')->user()->can($permission->name)) {
                    $permissions[$permission->name] = true;
                } else {
                    $permissions[$permission->name] = false;
                }
            }
            $user = auth('api')->user();

            $auth_user = Arr::prepend($user->toArray(), $permissions, 'can');
            $user = auth('api')->user();
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
        // dd(json_decode(json_encode((auth('api')->user()), false)));
    }
    public function admin()
    {
        $permissions = [];
        foreach (Permission::all() as $permission) {
            if (auth('api')->user()->can($permission->name)) {
                $permissions[$permission->name] = true;
            } else {
                $permissions[$permission->name] = false;
            }
        }
        $user = auth('api')->user();

        $company_id = auth('api')->user()->company_id;
        $company = Company::find($company_id);
        // $country = Country::find($user->country_id);
        // // dd($country);
        // $user->country_name = $country->country_name;
        // $users->transform(function ($user, $key) {
        //     $country = Country::find($user->country_id);
        //     $user->country_name = $country->name;
        //     return $user;
        // });
        // dd(json_decode(json_encode((auth('api')->user()), false)));
        $auth_user = array_prepend($user->toArray(), $permissions, 'can');
        return view('admin.admin', compact('auth_user', 'company'));
        // return redirect('/')->where('name', '[A-Za-z]+');
    }
}
