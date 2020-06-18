<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Mail\NewOrder;
use App\models\AutoGenerate;
use App\models\Drawer;
use App\models\Ordershipping;
use App\models\ProductSale;
use App\models\Sale;
use App\models\Shippingaddress;
use App\models\Sku;
use Illuminate\Http\Request;
use Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // return $request->all();
        $sales = Sale::where('client_id', auth('api')->id())->paginate(500);
        $sales->transform(function ($sale) {
            // $sale->discount = ($sale->discount != null) ? $sale->discount : 0;
            // $total = 0;
            // foreach ($sale->products as $product) {
            //     $total += $product->price;
            // }
            $sale->sub_total = $sale->sub_total;
            $sale->total = $sale->sub_total - $sale->discount;
            // $sale->client_name = $sale->client->name;
            $sale->user = auth('api')->user();
            return $sale;
        });
        return $sales;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function sale($carts, $method, $payment, $data)
    {
        // $client_id = auth('api')->id();
        $client_id = 1;
        // $total_price = $this->cart_total();
        $total_price = 2000;
        $sub_total_price = $total_price;
        $sale = new Sale;
        $sale->total_price = $total_price;
        $sale->sub_total = $sub_total_price;
        // $sale->discount = $discount;
        $sale->user_id = 1;
        // $sale->user_id = auth('api')->id();
        $sale->client_id = $client_id;
        $order_no = new AutoGenerate;
        $sale->order_no = $order_no->order_no();
        $sale->payment_method = 'method';
        if ($method == 'Paypal') {
            $sale->payment_id = $payment->id;
            $sale->paypal = $payment;
        }
        $sale->save();
        foreach ($carts as $cart) {
            // dd($cart->name['vendor_id']);
            $sku_id = Sku::where('sku_no', $cart->name['sku_no'])->first('id');
            $sku_id = $sku_id->id;
            $product_sale = new ProductSale;
            $product_sale->sale_id = $sale->id;
            $product_sale->product_id = $cart->name['id'];
            $product_sale->seller_id = $cart->name['vendor_id'];
            $product_sale->sku_id = $sku_id;
            $product_sale->sku_no =  $cart->name['sku_no'];
            $product_sale->price = $cart->name['price'];
            $product_sale->quantity = $cart->quantity;
            $product_sale->total_price = $cart->name['price'] * $cart->quantity;
            $product_sale->save();
        }

        if (auth('api')->check()) {
            if (auth('api')->user()->shipping) {
                $address = auth('api')->user()->shipping;
            } else {
                $address = $data;
                foreach ($address as  $value) {
                    unset($address['payment']);
                    unset($address['billing']);
                    unset($address['shipping']);
                }
            }
            $shipping_id = $this->shipping($address);

            Ordershipping::firstOrCreate(
                ['sale_id' => $sale->id],
                [
                    'shippingaddress_id' => $shipping_id,
                ]
            );
        }

        $user = auth('api')->user();
        $cart = Cart::getContent();
        Mail::to($user['email'])->send(new NewOrder($sale, $user, $cart));

        return $sale;
    }

    public function shipping($address)
    {
        // dd($address);
        $shippingaddress = Shippingaddress::firstOrCreate(
            ['user_id' => auth('api')->id()],
            [
                'name' => (array_key_exists('name', $address)) ?$address['name'] : null,
                'street_address' => (array_key_exists('street_address', $address)) ?$address['street_address'] : null,
                'town' => (array_key_exists('town', $address)) ? $address['town'] : $address['county'] ,
                'country' => (array_key_exists('country', $address)) ?$address['country'] : null,
                'county' => (array_key_exists('county', $address)) ?$address['county'] : null,
                'postal_code' => (array_key_exists('postal_code', $address)) ?$address['postal_code'] : null,
                'phone' => (array_key_exists('phone', $address)) ?$address['phone'] : null,
                'email' => (array_key_exists('email', $address)) ?$address['email'] : null,
            ]
        );
        return $shippingaddress->id;
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

    public function cart_total()
    {
        return $cart = Cart::getTotal();
        return str_replace(',', '', $cart);
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
