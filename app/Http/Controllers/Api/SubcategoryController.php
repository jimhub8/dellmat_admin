<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;


use App\models\Product;
use App\models\Subcategory;
use App\models\SubcategoryProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubcategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Subcategory::paginate(500);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\models\Subcategory  $subcategory
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        // DB::enableQueryLog(); // Enable query log

        $product_id = SubcategoryProduct::where('subcategory_id', $id)->get('product_id');
        $products = [];
        foreach ($product_id as $key => $value) {
            $products[] = $value->product_id;
        }

        $products_a = Product::whereIn('id', $products)->paginate();
        // dd(DB::getQueryLog()); // Show results of log
        $prod_trans = new ProductController;
        return $prod_trans->transform_product($products_a);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\models\Subcategory  $subcategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $subcategory = Subcategory::find($id);
        $subcategory->subcategory = $request->subcategory;
        $subcategory->category_id = $request->category_id;
        $subcategory->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\models\Subcategory  $subcategory
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
