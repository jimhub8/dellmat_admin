<?php

namespace App\Http\Controllers;

use App\models\Drawer;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DrawerController extends Controller
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
        $drawers = Drawer::with('sales')->latest()->where('open', true)->where('user_id', Auth::id())->take(1)->get();
        $drawers->transform(function($drawer) {
            $sale_total = 0;
            $sale_discount = 0;
            foreach ($drawer->sales as  $sale) {
                $sale_total += $sale->total_price;
                $sale_discount += $sale->discount;
            }
            $drawer->total = $sale_total;
            $drawer->discount = $sale_discount;
            $drawer->user_name = $drawer->user->name;
            return $drawer;
        });
        $total = 0;
        // foreach ($drawers->sales as $drawer) {
        //     $total += $drawer->sub_total;
        // }
        $drawers->total = $total;
        return $drawers[0];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $drawer = new Drawer;
        $drawer->opening_amount = $request->opening_amount;
        $drawer->expected_closing_amount = $request->opening_amount;
        $drawer->opening_remark = $request->opening_remark;
        $drawer->sale_total = 0;
        $drawer->user_id = $this->logged_user()->id;
        $drawer->save();
        $user = $this->logged_user();
        $user->drawer_open = true;
        $user->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\models\Drawer  $drawer
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Drawer::find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\models\Drawer  $drawer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // return $request->all();
        $drawer = Drawer::find($id);
        $drawer->closing_amount = $request->drawer_amount;
        $drawer->closing_remark = $drawer->remark;
        $drawer->remaining_amount = $drawer->expected_closing_amount - $request->drawer_amount;
        $drawer->open = false;
        $drawer->sale_total = $request->sale_total;
        $drawer->save();
        // return $drawer;
        $user = $this->logged_user()

        // $user = User::find(Auth::id());
        // dd($user);
        $user->drawer_open = false;
        $user->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\models\Drawer  $drawer
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return Drawer::delete();
    }
}
