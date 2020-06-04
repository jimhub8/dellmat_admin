<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;

use App\models\wish;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Wish::paginate(500);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $wish = Wish::firstOrCreate([
            [
                'user_id' => auth('api')->id(),
                'product_id' => $request->id,
            ],

        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\models\wish  $wish
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
     * @param  \App\models\wish  $wish
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $wish = Wish::firstOrCreate([
            [
                'user_id' => auth('api')->id(),
                'product_id' => $id,
            ],
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\models\wish  $wish
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
