<?php

namespace App\Http\Controllers;

use App\models\Menu;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MenuController extends Controller
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
        return Menu::paginate(500);
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
        $menu->user_id = $this->logged_user()->id;
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
