<?php

namespace App\Http\Controllers;

use App\models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Group::paginate(1000);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $group = new Group();
        $group->user_id = $this->logged_user()->id;
        $group->group_name = $request->group_name;
        $group->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\models\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Group::find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\models\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $group = Group::find($id);
        $group->user_id = $this->logged_user()->id;
        $group->group_name = $request->group_name;
        $group->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\models\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Group::find($id)->delete();
    }
}
