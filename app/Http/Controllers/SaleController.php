<?php

namespace App\Http\Controllers;

use App\models\Drawer;
use App\models\ProductSale;
use App\models\Sale;
use App\models\Sku;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class SaleController extends Controller
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

        $sales = ProductSale::get('sale_id');

        $sale_id = [];

        foreach($sales as $sale) {
            $sale_id[] = $sale->sale_id;
        }

        return $sale_data = Sale::whereIn('id', $sale_id)->paginate(500);

        $sale_data->transform(function($sale) {
            $sale->discount = ($sale->discount != null) ? $sale->discount : 0;
            $total = 0;
            foreach ($sale->products as $product) {
                $total += $product->price;
            }
            $sale->sub_total = $sale->sub_total;
            $sale->total = $sale->sub_total - $sale->discount;
            // $sale->client_name = $sale->client;
            // $sale->client_name = $sale->user->name;
            return $sale;
        });
        return $sale_data;
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
        $request->validate([
            'client_id' => 'required',
            'cart' => 'required'
        ]);
        $client_id = $request->client_id;
        $total_price = $request->total_price;
        $sub_total_price = $request->sub_total_price;
        $discount = $request->discount;
        // return $request->all();
        $drawers = Drawer::latest()->where('user_id', Auth::id())->first();
        $products = $request->cart;
        $sale = new Sale;
        $sale->total_price = $total_price;
        $sale->sub_total = $sub_total_price;
        $sale->discount = $discount;
        $sale->user_id = $this->logged_user()->id;
        $sale->client_id = $client_id;
        $sale->drawer_id = $drawers->id;
        // $sale->order_no = $request->price;
        $sale->save();

        foreach ($products as $product) {
            // return($product['sku_no']);
            $sku_id = Sku::where('sku_no', $product['sku_no'])->first('id');
            // return $sku_id;
            $product_sale = new ProductSale;
            $product_sale->sale_id = $sale->id;
            $product_sale->product_id = $product['id'];
            $product_sale->sku_id = $sku_id->id;
            $product_sale->sku_no = $product['sku_no'];
            $product_sale->price = $product['price'];
            $product_sale->quantity = $product['ordered'];
            $product_sale->total_price = $product['price'] * $product['ordered'];
            $product_sale->save();
        }
        $drawer = Drawer::where('user_id', Auth::id())->first();
        $drawer->sale_total += $total_price;
        $drawer->expected_closing_amount += $total_price;
        $drawer->save();
        return $sale;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\models\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return  Sale::find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\models\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $sale = Sale::find($id);
        $sale->active = $request->active;
        $sale->base_price = $request->base_price;
        $sale->base_tax_amount = $request->base_tax_amount;
        $sale->base_total = $request->base_total;
        $sale->f_price = $request->f_price;
        $sale->f_total = $request->f_total;
        $sale->name = $request->name;
        $sale->price = $request->price;
        $sale->qty_ordered = $request->qty_ordered;
        $sale->sku = $request->sku;
        $sale->tax_amount = $request->tax_amount;
        $sale->tax_category_id = $request->tax_category_id;
        $sale->tax_percent = $request->tax_percent;
        $sale->total = $request->total;
        $sale->total_weight = $request->total_weight;
        $sale->type = $request->type;
        $sale->weight = $request->weight;
        $sale->save();
        return $sale;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\models\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Sale::find($id)->delete();
    }
}
