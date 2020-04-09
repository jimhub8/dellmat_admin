<?php

namespace App\Http\Controllers;

use App\models\Brand;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BrandController extends Controller
{
    public function logged_user()
    {
        $user = new User;
        return  $user->logged_user();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Brand::paginate(500);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $brand = new Brand;
        $brand->brand = $request->brand;
        $brand->user_id = $this->logged_user()->id;
        $brand->save();
        return $brand;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Brand::find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $brand = Brand::find($id);
        $brand->brand = $request->brand;
        $brand->save();
        return $brand;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Brand::find($id)->delete();
    }
}
