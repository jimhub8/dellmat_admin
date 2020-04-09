<?php

namespace App\Http\Controllers;

use App\models\Commision;
use Illuminate\Http\Request;

class CommisionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Commission::paginate(1000);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $commission = new Commission;
        $commission->amount = $request->amount;
        $commission->commission = $request->commission;
        $commission->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\models\Commision  $commision
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
     * @param  \App\models\Commision  $commision
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $commission = Commission::find($id);
        $commission->amount = $request->amount;
        $commission->commission = $request->commission;
        $commission->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\models\Commision  $commision
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
    }
}
