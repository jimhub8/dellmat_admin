<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;


use App\models\Shippingaddress;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShippingaddressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $shippingaddress = Shippingaddress::firstOrCreate(
            ['user_id' => Auth::id()],
            [
                'name' => $request->name,
                'street_address' => $request->street_address,
                'town' => $request->town,
                'country' => $request->country,
                'county' => $request->county,
                'postal_code' => $request->postal_code,
                'phone' => $request->phone,
                'email' => $request->email,
            ]
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\models\Shippingaddress  $shippingaddress
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Auth::user()->shipping;

    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\models\Shippingaddress  $shippingaddress
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $shippingaddress = User::find($id)->shipping;
        // return $shippingaddress;
        if ($shippingaddress) {
            $shippingaddress = Shippingaddress::where('user_id', $id)->first();
        } else {
            $shippingaddress =new  Shippingaddress;

        }
        $shippingaddress->user_id = $id;
        $shippingaddress->name = $request->name;
        $shippingaddress->street_address = $request->street_address;
        $shippingaddress->town = $request->town;
        $shippingaddress->country = $request->country;
        $shippingaddress->county = $request->county;
        $shippingaddress->postal_code = $request->postal_code;
        $shippingaddress->phone = $request->phone;
        $shippingaddress->email = $request->email;
        $shippingaddress->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\models\Shippingaddress  $shippingaddress
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Shippingaddress::find($id)->delete();
    }
}
