<?php

namespace App\Http\Controllers\Seller\Auth;

use App\Seller;
use App\Http\Controllers\Controller;
use App\Mail\NewVendor;
use App\models\Storedetails;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new admins as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/seller';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('seller.guest:seller');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:sellers',
            'password' => 'required|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     * @return \App\Seller
     */
    protected function store(Request $request)
    {
        $data = $request->all();
        // return $request->all();
        $user = Seller::create([
            'name' => $data['name'],
            'phone' => $data['phone'],
            'address' => $data['address'],
            'email' => $data['email'],
            'password' => bcrypt('password'),
            'active' => true,
        ]);

        $user_details = Storedetails::create([
            'seller_id' => $user->id,
            'company_name' => (array_key_exists('company_name', $data)) ? $data['company_name'] : null,
            'company_address' => (array_key_exists('company_address', $data)) ? $data['company_address'] : null,
            'address_2' => (array_key_exists('address_2', $data)) ? $data['address_2'] : null,
            'company_phone' => (array_key_exists('company_phone', $data)) ? $data['company_phone'] : null,
            'company_email' => (array_key_exists('company_email', $data)) ? $data['company_email'] : null,
            'company_website' => (array_key_exists('company_website', $data)) ? $data['company_website'] : null,
            'postal_code' => (array_key_exists('postal_code', $data)) ? $data['postal_code'] : null,
            'business_no' => (array_key_exists('business_no', $data)) ? $data['business_no'] : null,
            'building' => (array_key_exists('building', $data)) ? $data['building'] : null,
            'floor' => (array_key_exists('floor', $data)) ? $data['floor'] : null,
            'location' => (array_key_exists('location', $data)) ? $data['location'] : null,
            'longitude' => (array_key_exists('longitude', $data)) ? $data['longitude'] : null,
            'latitude' => (array_key_exists('latitude', $data)) ? $data['latitude'] : null,
            'payment_mode' => (array_key_exists('payment_mode', $data)) ? $data['payment_mode'] : null,
            'bank_name' => (array_key_exists('bank_name', $data)) ? $data['bank_name'] : null,
            'bank_code' => (array_key_exists('bank_code', $data)) ? $data['bank_code'] : null,
            'account_no' => (array_key_exists('account_no', $data)) ? $data['account_no'] : null,
            'branch' => (array_key_exists('branch', $data)) ? $data['branch'] : null,
            'account_name' => (array_key_exists('account_name', $data)) ? $data['account_name'] : null,
            'mpesa_reg_name' => (array_key_exists('mpesa_reg_name', $data)) ? $data['mpesa_reg_name'] : null,
            'mpesa_phone' => (array_key_exists('mpesa_phone', $data)) ? $data['mpesa_phone'] : null,
        ]);

        // $vendor = Seller::find(1);
        Mail::to($data['email'])->send(new NewVendor($user));
        return $user_details;
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm()
    {
        return view('seller.auth.register');
    }

    /**
     * Get the guard to be used during registration.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('seller');
    }
}
