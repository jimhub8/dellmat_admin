<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\models\Storedetails;
use App\Seller;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class SellerController extends Controller
{

    public function logged_user()
    {
        $user = new User();
        return  $user->logged_user();
    }
    public function index()
    {
        return Seller::with('storedetail')->paginate(500);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'email' => 'required|email|unique:sellers,email',
            'company_name' => 'required',
            'company_address' => 'required',
            'company_phone' => 'required',
            'company_email' => 'required',
            'building' => 'required',
            'floor' => 'required',
            'payment_mode' => 'required',
        ]);
        $data = $request->all();
        // return $data['phone'];
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
            'company_name' => (array_key_exists('company_name', $data)) ? $data['company_name']: null,
            'company_address' => (array_key_exists('company_address', $data)) ? $data['company_address']: null,
            'address_2' => (array_key_exists('address_2', $data)) ? $data['address_2']: null,
            'company_phone' => (array_key_exists('company_phone', $data)) ? $data['company_phone']: null,
            'company_email' => (array_key_exists('company_email', $data)) ? $data['company_email']: null,
            'company_website' => (array_key_exists('company_website', $data)) ? $data['company_website']: null,
            'postal_code' => (array_key_exists('postal_code', $data)) ? $data['postal_code']: null,
            'business_no' => (array_key_exists('business_no', $data)) ? $data['business_no']: null,
            'building' => (array_key_exists('building', $data)) ? $data['building']: null,
            'floor' => (array_key_exists('floor', $data)) ? $data['floor']: null,
            'location' => (array_key_exists('location', $data)) ? $data['location']: null,
            'longitude' => (array_key_exists('longitude', $data)) ? $data['longitude']: null,
            'latitude' => (array_key_exists('latitude', $data)) ? $data['latitude']: null,
            'payment_mode' => (array_key_exists('payment_mode', $data)) ? $data['payment_mode']: null,
            'bank_name' => (array_key_exists('bank_name', $data)) ? $data['bank_name']: null,
            'bank_code' => (array_key_exists('bank_code', $data)) ? $data['bank_code']: null,
            'account_no' => (array_key_exists('account_no', $data)) ? $data['account_no']: null,
            'branch' => (array_key_exists('branch', $data)) ? $data['branch']: null,
            'account_name' => (array_key_exists('account_name', $data)) ? $data['account_name']: null,
            'mpesa_reg_name' => (array_key_exists('mpesa_reg_name', $data)) ? $data['mpesa_reg_name']: null,
            'mpesa_phone' => (array_key_exists('mpesa_phone', $data)) ? $data['mpesa_phone']: null,
        ]);
        return $user_details;
    }
    public function update(Request $request, $id)
    {
        // return $request->all();
        $data = $request->all();
        $user = Seller::where('id', $id)->update([
            'name' => $data['name'],
            'phone' => $data['phone'],
            'address' => $data['address'],
            'email' => $data['email'],
            'password' => bcrypt('password'),
            'active' => true,
        ]);
        $data = $request->storedetail;
        $user_details = Storedetails::where('seller_id', $id)->update([
            'company_name' => (array_key_exists('company_name', $data)) ? $data['company_name']: null,
            'company_address' => (array_key_exists('company_address', $data)) ? $data['company_address']: null,
            'address_2' => (array_key_exists('address_2', $data)) ? $data['address_2']: null,
            'company_phone' => (array_key_exists('company_phone', $data)) ? $data['company_phone']: null,
            'company_email' => (array_key_exists('company_email', $data)) ? $data['company_email']: null,
            'company_website' => (array_key_exists('company_website', $data)) ? $data['company_website']: null,
            'postal_code' => (array_key_exists('postal_code', $data)) ? $data['postal_code']: null,
            'business_no' => (array_key_exists('business_no', $data)) ? $data['business_no']: null,
            'building' => (array_key_exists('building', $data)) ? $data['building']: null,
            'floor' => (array_key_exists('floor', $data)) ? $data['floor']: null,
            'location' => (array_key_exists('location', $data)) ? $data['location']: null,
            'longitude' => (array_key_exists('longitude', $data)) ? $data['longitude']: null,
            'latitude' => (array_key_exists('latitude', $data)) ? $data['latitude']: null,
            'payment_mode' => (array_key_exists('payment_mode', $data)) ? $data['payment_mode']: null,
            'bank_name' => (array_key_exists('bank_name', $data)) ? $data['bank_name']: null,
            'bank_code' => (array_key_exists('bank_code', $data)) ? $data['bank_code']: null,
            'account_no' => (array_key_exists('account_no', $data)) ? $data['account_no']: null,
            'branch' => (array_key_exists('branch', $data)) ? $data['branch']: null,
            'account_name' => (array_key_exists('account_name', $data)) ? $data['account_name']: null,
            'mpesa_reg_name' => (array_key_exists('mpesa_reg_name', $data)) ? $data['mpesa_reg_name']: null,
            'mpesa_phone' => (array_key_exists('mpesa_phone', $data)) ? $data['mpesa_phone']: null,
        ]);
        return $user_details;
    }

}
