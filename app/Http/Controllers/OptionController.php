<?php

namespace App\Http\Controllers;

use App\models\Option;
use App\models\OptionValue;
use App\models\ProductOption;
use Illuminate\Http\Request;

class OptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Option::with('option_values')->get();
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
        $option = new Option;
        $option->option_name = $request->option_name;
        $option->save();
        // $option->product_options()->sync($request->option_values_arr);
        foreach ($request->option_values_arr as $option_values) {
            // dd($option_values['option_name']);
            $product_options = new OptionValue();
            $product_options->option_name = $option_values['option_name'];
            $product_options->option_id = $option->id;
            $product_options->save();
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\models\Option  $option
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Option::find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\models\Option  $option
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $option = Option::find($id);
        $option->option_name = $request->option_name;
        $option->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\models\Option  $option
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Option::find($id)->delete();
    }
}
