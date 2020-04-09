<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{

    protected $redirectTo = '/seller/login';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('seller.auth:seller');
    }

    /**
     * Show the Seller dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        // return view('seller.home');
        // return Auth::guard('seller')->check();
        if (Auth::guard('seller')->check()) {
            $auth_user = Auth::guard('seller')->user();
            return view('welcome', compact('auth_user'));
        }
        return view('welcome');
    }

}
