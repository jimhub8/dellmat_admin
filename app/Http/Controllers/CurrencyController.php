<?php

namespace App\Http\Controllers;

use App\models\Currency;
use Illuminate\Http\Request;

class CurrencyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Currency::paginate(1000);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $currency = new Currency;
        $currency->rate = $request->rate;
        $currency->currency_code = $request->currency_code;
        $currency->currency = $request->currency;
        $currency->save();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\models\Currency  $currency
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $currency = Currency::find($id);
        $currency->rate = $request->rate;
        $currency->currency_code = $request->currency_code;
        $currency->currency = $request->currency;
        $currency->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\models\Currency  $currency
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Currency::find($id)->delete();

    }
}
