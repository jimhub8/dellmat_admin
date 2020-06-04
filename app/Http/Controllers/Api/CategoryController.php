<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ProductController;
use App\models\Category;
use App\models\CategoryProduct;
use App\models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::with(['products' => function($query) {
            $query->setEagerLoads([])->take(2);
        }])->paginate(10);
        return $this->transform_cat($categories);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // DB::enableQueryLog(); // Enable query log

        $product_id = CategoryProduct::where('category_id', $id)->get('product_id');
        $products = [];
        foreach ($product_id as $key => $value) {
            $products[] = $value->product_id;
        }



        $products_a = Product::whereIn('id', $products)->paginate();
        // dd(DB::getQueryLog()); // Show results of log
        $prod_trans = new ProductController;
        return $prod_trans->transform_product($products_a, '');
    }

    public function transform_cat($categories)
    {
        $categories->transform(function ($category) {
            $category->products->transform(function ($product) {
                // dd($product->skus);
                // dd(count($product->product_variants));
                if (count($product->product_variants) == 0) {
                    if (count($product->skus) > 0) {
                        // dd(($product->skus[0]->price));
                        $product->sku_no = $product->skus[0]->sku_no;
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
            return $category;
        });
        return $categories;

    }

}
