<?php

namespace App\Http\Controllers;

use App\models\Subcategory;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubcategoryController extends Controller
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
        return Subcategory::paginate(500);
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
        $subcategory = new Subcategory;
        $subcategory->user_id = $this->logged_user()->id;
        $subcategory->subcategory = $request->subcategory;
        $subcategory->category_id = $request->categories['id'];
        $subcategory->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\models\Subcategory  $subcategory
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\models\Subcategory  $subcategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $subcategory = Subcategory::find($id);
        $subcategory->subcategory = $request->subcategory;
        $subcategory->category_id = $request->category_id;
        $subcategory->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\models\Subcategory  $subcategory
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
