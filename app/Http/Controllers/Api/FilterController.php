<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;


use Illuminate\Http\Request;
use App\models\Product;
use Illuminate\Support\Facades\Session;
use App\models\Category;
use App\models\CategoryProduct;
use App\models\Menu;
use App\models\Sku;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class FilterController extends Controller
{
    public function filterItem(Request $request)
    {
        // return $request->all();
        return Product::whereIn('subcategory_id', $request->all())->paginate(9);
    }
    public function filterProduct(Request $request, $id)
    {
        // return $request->all();
        return Product::where('subcategory_id', $id)->paginate(9);
    }

    public function filterItems(Request $request)
    {
        // return $request->all();
        if ($request->brand != null) {
            return Product::where('brand_id', $request->brand)->paginate(9);
        } elseif ($request->sub_cat) {
            return Product::where('subcategory_id', $request->sub_cat)->paginate(9);
        } elseif ($request->price) {
            return Product::whereBetween('price', $request->price)->paginate(9);
        } else {
            return 'noop';
        }
    }


    public function FilterShop(Request $request)
    {
        // return $request->all();
        // return $request->price['state'];
        $products = new Product;
        $product_arr_sku = [];
        $product_arr = [];

        if ($request->price[1] > 0) {

            $sku_id = Sku::whereBetween('price', $request->price)->get('product_id');
            // return $sku_id;
            foreach ($sku_id as $key => $value) {
                $product_arr_sku[] = $value->product_id;
            }
            $products = $products->whereIn('id', $product_arr_sku);
        }
        if ($request->category_id) {
            // $products = Category::find($request->category_id)->products();
            $product_id = CategoryProduct::where('category_id', $request->category_id)->get('product_id');

            foreach ($product_id as $key => $value) {
                $product_arr[] = $value->product_id;
            }
            $products = $products->whereIn('id', $product_arr);
        }


        // dd([$product_arr, $product_arr_sku]);
        // $product_id = Arr::collapse([$product_arr, $product_arr_sku]);
        // $product_id = array_unique($product_id);

        $products = $products->paginate(12);
        $pro_transform = new ProductController;
        return $pro_transform->transform_product($products, '');
    }
}
