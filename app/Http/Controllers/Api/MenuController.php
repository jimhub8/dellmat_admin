<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;

use App\models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Menu::with('categories')->paginate(500);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $menu = new Menu;
        $menu->menu = $request->menu;
        $menu->user_id = auth('api')->id();
        $menu->save();
        return $menu;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Menu::find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $menu = Menu::find($id);
        $menu->menu = $request->menu;
        $menu->save();
        return $menu;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
