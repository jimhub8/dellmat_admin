<?php

namespace App\Http\Controllers;

use App\models\Client;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{
    public function logged_user()
    {
        $user = new User();
        return  $user->logged_user();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return User::paginate(500);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request->all();

        $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'email' => 'required',
        ]);
        $client = new User();
        $client->user_id = $this->logged_user()->id;
        $client->name = $request->name;
        $client->email = $request->email;
        $client->phone = $request->phone;
        $client->group_id = $request->group_id;
        $client->gender = $request->gender;
        $client->payment_type = $request->payment_type;
        $client->save();
        return $client;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return User::find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $client = User::find($id);
        $client->name = $request->name;
        $client->email = $request->email;
        $client->phone = $request->phone;
        $client->payment_type = $request->payment_type;
        $client->save();
        return $client;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::find($id)->delete();
    }

    public function client_search($search)
    {
        return User::where('name', 'LIKE', "%{$search}%")
            // ->orWhere('product_barcode', 'LIKE', "%{$search}%")
            // ->orWhere('description', 'LIKE', "%{$search}%")
            ->paginate(100);
    }
}
