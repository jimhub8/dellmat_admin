<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ProductController;
use App\models\CouponSession;
use App\models\Product;
use App\models\ProductAttribute;
use App\models\Sku;
use Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
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
        Cart::session($id)->add([
            'id' => $sku_id,
            'name' => $product,
            'quantity' => $request->order_qty,
            'price' => $request->price,
            'product_i' => ['test'],
            'attributes' => array( // attributes field is optional
                $request->choices
            )
        ]);
        return $this->getCart($id);
    }
    public function update_cart(Request $request, $id)
    {
        // return $request->all();
        $cart_item = $request->cart;
        // return $cart_item['name']['sku_no'];
        $sku_id = Sku::where('sku_no', $cart_item['name']['sku_no'])->first('id');
        $sku_id = $sku_id->id;

        // return $sku_id;

        $quantity = $request->order_qty;
        $cart_available = Cart::session($id)->get($cart_item['id']);
        if ($cart_available->quantity < 2 && $quantity == -1) {
            $this->flash_cart($id, $cart_item['id']);
            return;
        }
        // dd($quantity);
        Cart::update($cart_item['id'], ['quantity' => $quantity]);
        return;
    }

    public function flashCart(Request $request, $id)
    {
        // return $request->all();
        Cart::session($id)->remove($request->id);
    }

    public function flash_cart($id, $cart_id)
    {
        Cart::session($id)->remove($cart_id);
    }
    public function getCart($id)
    {

        return Cart::session($id)->getContent();
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

    public function cart_total($id)
    {
        $total = 0;
        $items = $this->getCart($id);
        // dd($items);
        // return  $item->getPriceSum();

        foreach ($items as $item) {

            $item->id; // the Id of the item
            $item->name; // the name
            $item->price; // the single price without conditions applied
            $total += $item->getPriceSum(); // the subtotal without conditions applied
            $item->getPriceWithConditions(); // the single price with conditions applied
            $item->getPriceSumWithConditions(); // the subtotal with conditions applied
            $item->quantity; // the quantity
            $item->attributes; // the attributes
            // if ($item->attributes->has('size')) {
            //     // item has attribute size
            // } else {
            //     // item has no attribute size
            // }
        }
        return $total;

        // return $cart = Cart::getSubTotal();
        // return str_replace(',', '', $cart);
    }

    public function cart_count($id)
    {
        $cart_d =  Cart::session($id)->getContent();
        return $cart_d->count();
    }

    public function couponSes()
    {
        $oldCounpon = Session::has('coupon') ? Session::get('coupon') : null;
        $coupon = new CouponSession($oldCounpon);
        return $coupon->getCoupon();
    }

}
