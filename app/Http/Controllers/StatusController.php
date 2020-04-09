<?php

namespace App\Http\Controllers;

use App\models\ProductSale;
use App\models\Sale;
use App\models\Status;
use App\models\Transaction;
use Illuminate\Http\Request;

class StatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Status::paginate(1000);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $status = new Status();
        $status->status = $request->status;
        $status->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\models\Status  $status
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
     * @param  \App\models\Status  $status
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $status = Status::find($id);
        $status->status = $request->status;
        $status->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\models\Status  $status
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Status::find($id)->delete();
    }

    public function status_update(Request $request, $id)
    {
        $sales = Sale::find($id);
        $sales->status = $request->status;
        $products = $sales->products;
        if ($request->status == 'Complete' || $request->status == 'Delivered') {
            foreach ($products as $product) {
                $amount = $sales->total_price;
                Transaction::where('seller_id', $product->vendor_id)->increment('amount', $amount);
            }
        }
        $sales->save();
        ProductSale::where('sale_id', $id)->update(['status', $request->status]);
    }
}
