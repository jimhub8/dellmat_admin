<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;

use App\models\CouponSession;
use App\models\Product;
use App\models\ProductAttribute;
use App\models\Sku;
use Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CartController_1 extends Controller
{
    public function cartAdd(Request $request, $id)
    {
        // return $request->all();
        // Cart::clear();
        $product = $request->all();
        // return $product['sku_no'];
        // return ['id' => $id, 'product' => $product, 'name' => $product['product_name'], 'quantity' => $request->order_qty, 'price' => $request->price];
        $product['skus'] = null;
        $product['product_variants'] = null;
        $product['categories'] = null;
        $product['images'] = null;
        // return $product;
        // $product = Product::setEagerLoads([])->find($id);
        if (!$request->price) {
            $request->price = 0;
        }
        // $product_name = ($request->product_name) ? $product->product_name;
        // Cart::add(['id' => $id, 'product' => $product, 'name' => $product['product_name'], 'quantity' => $request->order_qty, 'price' => $request->price]);
        $sku_id = Sku::where('sku_no', $request->sku_no)->first('id');
        $sku_id = $sku_id->id;
        // return $sku_id;

        if (auth('api')->check()) {
            Cart::session(auth('api')->id())->add([
                'id' => $sku_id,
                'name' => $product,
                'quantity' => $request->order_qty,
                'price' => $request->price,
                'product_i' => ['test'],
                'attributes' => array( // attributes field is optional
                    $request->choices
                )
            ]);
        } else {
            Cart::add([
                'id' => $sku_id,
                'name' => $product,
                'quantity' => $request->order_qty,
                'price' => $request->price,
                'product_i' => ['test'],
                'attributes' => array( // attributes field is optional
                    $request->choices
                )
            ]);
        }
    }
    public function update_cart(Request $request, $id)
    {
        // return $request->all();

        $sku_id = Sku::where('sku_no', $request->name['sku_no'])->first('id');
        $sku_id = $sku_id->id;

        // return $sku_id;

        $quantity = $request->order_qty;
        if (auth('api')->check()) {
            $cart_available = Cart::session(auth('api')->id())->get($id);
        } else {
            $cart_available = Cart::get($id);

        }
        if ($cart_available->quantity < 2 && $quantity == -1) {
            $this->flashCart($id);
            return;
        }
        // dd($quantity);

        if (auth('api')->check()) {
            Cart::session(auth('api')->id())->update($id, ['quantity' => $quantity]);
        } else {
            Cart::update($id, ['quantity' => $quantity]);
        }
        return;
    }

    public function flashCart($id)
    {
        if (auth('api')->check()) {
            Cart::session(auth('api')->id())->remove($id);
        } else {
            Cart::remove($id);
        }
    }
    public function getCart()
    {
        if (auth('api')->check()) {
            return $cart_d =  Cart::session(auth('api')->id())->getContent();
        } else {
            $cart_d =  Cart::getContent();
        }
        foreach ($cart_d as $cart) {
            $sku = Sku::where('id', (int) $cart->id)->first('product_id');
            // return $sku;
            $products = Product::setEagerLoads([])->where('id', $sku->product_id)->get();

            $prod_tras = new ProductController;
            $prod_tras = $prod_tras->transform_product($products);

            $cart['product'] = $prod_tras[0];
            // return ($cart);
        }
        // $cart_d->transform(function ($cart) {
        // dd($cart->id);
        // $product = Product::setEagerLoads([])->find((int) $cart->id);
        // // dd($product);
        // $cart->product = $product;
        // return $cart;
        // });
        return $cart_d;
    }

    public function getCartProduct()
    {
        $cart = $this->getCart();
        foreach ($cart as $product) {
            $cart_id = $product['item']['id'];
            $cart_qty = $product['qty'];
            $product_s = Product::find($cart_id);
            $new_qty = $product_s->quantity - $cart_qty;
            // dd($product_s->quantity .' - '. $cart_qty . ' = '. $new_qty);
            $product = Product::where('id', $cart_id)->update(['quantity' => $new_qty]);
        }
        return $product;
    }


    public function couponSes()
    {
        $oldCounpon = Session::has('coupon') ? Session::get('coupon') : null;
        $coupon = new CouponSession($oldCounpon);
        return $coupon->getCoupon();
    }

    public function cartAdd_1(Request $request, $id)
    {
        // Cart::destroy();
        // return;
        return $request->all();
        $product = Product::setEagerLoads([])->find($id);
        if ($request->attribute) {
            $attr_ = ProductAttribute::select('quantity', 'value', 'price')->find($request->attribute);
            $attr_qty = $attr_->quantity;
            $product->quantity = $request->attribute;
            $price = (float) $attr_['price'];
            // dd($price);
            $value = $attr_['value'];
            if ($request->quantity > $attr_qty) {
                return response()->json(['errors' => "Only " . $attr_qty . " items are available, you already have " . $av_quantity . " in your cart", 'status' => '200'], '200');
            }
            Cart::add(['id' => $id, 'product' => $product, 'name' => $product->product_name, 'qty' => $request->quantity, 'price' => $price, 'options' => ['size' => $value]]);
        } else {
            // dd($product->price);
            if ($request->quantity > $product->quantity) {
                return response()->json(['errors' => "Only " . $product->quantity . " items are available, you already have " . $product->quantity . " in your cart", 'status' => '200'], '200');
                Cart::add(['id' => $id, 'product' => $product, 'name' => $product->product_name, 'qty' => $request->quantity, 'price' => $product->price]);
            }
            Cart::add(['id' => $id, 'product' => $product, 'name' => $product->product_name, 'qty' => $request->quantity, 'price' => (int) $product->price]);
        }
    }


    public function cart_total()
    {
        if (auth('api')->check()) {
            return $cart = Cart::session(auth('api')->id())->getSubTotal();
        } else {
            return $cart = Cart::getSubTotal();
        }
    }

    public function cart_count()
    {
        if (auth('api')->check()) {
            $cart_d =  Cart::session(auth('api')->id())->getContent();
        } else {
            $cart_d =  Cart::getContent();
        }
        return $cart_d->count();
    }
}
