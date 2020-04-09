<?php

namespace App\Http\Controllers;

use App\models\Supplier;
use App\User;
use Illuminate\Http\Request;

class SupplierController extends Controller
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
        return Supplier::paginate(500);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $supplier = new Supplier();
        $supplier->user_id = $this->logged_user()->id;
        $supplier->name = $request->name;
        $supplier->email = $request->email;
        $supplier->phone = $request->phone;
        $supplier->payment_type = $request->payment_type;
        $supplier->save();
        return $supplier;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Supplier::find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $supplier = Supplier::find($id);
        $supplier->name = $request->name;
        $supplier->email = $request->email;
        $supplier->phone = $request->phone;
        $supplier->payment_type = $request->payment_type;
        $supplier->save();
        return $supplier;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Supplier::find($id)->delete();
    }
}
