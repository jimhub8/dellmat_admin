<?php

namespace App\Http\Controllers;

use App\models\AutoGenerate;
use App\models\Product;
use App\models\Sku;
use App\User;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
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
        // return Product::all();
        // return $products = Product::paginate(10);
        $products = Product::with('images')->paginate(10);
        return $this->transform_product($products);
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
        $product = new Product();
        // $product->description = $request->description;

        if (Auth::guard('seller')->check()) {
            $seller_id = Auth::guard('seller')->id();
            $this->logged_user()->id;
            $user_id = 0;
        } elseif (Auth::guard('admin')) {
            $seller_id = $request->seller_id;
            $this->logged_user()->id;
            $user_id = 0;
        }

        $product->product_name = $request->product_name;
        $product->user_id = $user_id;
        $product->vendor_id = $seller_id;
        $sku_no = new AutoGenerate;
        $product->sku_no = $sku_no->product_sku();
        $product->save();

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $products = Product::where('id', $id)->get();
        $$products = $this->transform_product($products);
        return $$products[0];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
    //     $request->validate([
    //         'product.description' => 'required'
    //     ],
    //     [
    //         'product.description.required' => 'Product description field is required'
    //     ]
    // );
        // return $request->all();
        $sku_values = $request->sku_values;
        $product = $request->product;
        // return $request->product['subcategories'];
        $sku = Sku::updateOrCreate(
            [
                'sku_no' => $product['sku_no'],
            ],
            [
                'price' => $sku_values['price'],
                'description' => (array_key_exists('description', $product)) ? $product['description'] : '',
                // 'description' => ($sku_values['description']) ? $sku_values['description'] : $product['description'],
                'quantity' => $sku_values['quantity'],
                'product_id' => $id,
                'reorder_point' => $sku_values['reorder_point']
            ]
        );

        $relation = new VariantController;
        $update_product = Product::find($id);
        $relation->category_fun($request->product['categories'], $update_product);
        $relation->subcategory_fun($request->product['subcategories'], $update_product);
        $relation->brand_fun($request->product['brands'], $update_product);
        // return $update_product;
        return $sku;
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Product::find($id)->delete();
    }


    public function product_search($search)
    {
        return Product::where('product_name', 'LIKE', "%{$search}%")
            // ->orWhere('product_barcode', 'LIKE', "%{$search}%")
            // ->orWhere('description', 'LIKE', "%{$search}%")
            ->paginate(100);
    }

    public function transform_product($products)
    {

        $products->transform(function ($product) {
            // dd($product->skus);
            $product->rating = rand(0,5);
            // dd(count($product->product_variants));
            if (count($product->product_variants) == 0) {
                if (count($product->skus) > 0) {
                    // dd(($product->skus[0]->price));
                    $product->sku_no = $product->skus[0]->sku_no;
                    $product->description = $product->skus[0]->description;
                    $product->price = $product->skus[0]->price;
                    $product->quantity = $product->skus[0]->quantity;
                }
            } else {

            }
            foreach ($product->images as  $pro_image) {
                if ($pro_image->display) {
                    $product->image = $pro_image->image;
                }
            }
            return $product;
        });
        return $products;
    }


    public function product_table()
    {
        // return Product::all();
        // return $products = Product::paginate(10);
        $products = Product::paginate(500);
        return $this->transform_display_product($products);
    }


    public function transform_display_product($products)
    {
        $products->transform(function ($product) {
            // dd($product->skus);
            foreach ($product->images as  $pro_image) {
                if ($pro_image->display) {
                    $product->image = $pro_image->image;
                }
            }
            // dd(count($product->product_variants));
            if (count($product->skus) > 0) {
                if (count($product->skus) > 1) {
                    $prices = [];
                    $quantity = 0;
                    foreach ($product->skus as  $pro_price) {
                        // dd($pro_price['price']);
                        $prices[] = $pro_price['price'];
                        $quantity += $pro_price['quantity'];
                    }
                    $product->price = 'from ' . min($prices);
                    $product->quantity = $quantity;
                } else {
                    foreach ($product->skus as  $pro_price) {
                        // dd($pro_price['price']);
                        $prices = $pro_price['price'];
                        $quantity = $pro_price['quantity'];
                    }
                $product->price = $prices;
                $product->quantity = $quantity;
            }
                // dd(($product->skus[0]->price));
                // $product->quantity = $product->skus[0]->quantity;
            } else {
                $product->price = 0;
                $product->quantity = 0;

            }
            $product->variants = count($product->skus);
            $product->discount = 0;


            // if ($product->categories) {
            //     foreach ($product->categories as  $category) {
            //         foreach ($category->discounts as  $discount) {
            //             if ($discount->discount_unit == 'percentage') {

            //             }
            //             // dd($discount->discount_unit);
            //         }
            //     }
            // }



            // $product->sku_no = 'test_123';
            return $product;
        });
        return $products;
    }
}
