<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;


use App\models\Product;
use App\models\Sku;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class SkuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\models\Sku  $sku
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $sku = Sku::where('product_id', $id)->first();
        if ($sku) {
            return response()->json([
                'status' => true,
                'sku' => $sku
            ]);
        } else {
            return response()->json([
                'status' => false,
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\models\Sku  $sku
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\models\Sku  $sku
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function variants_values(Request $request, $id)
    {
        // return $request->all();
        $product = Product::select('product_name')->where('id', $id)->first();
        $product_name = substr($product->product_name, 0, 2);
        $var_choices = [];
        $choices = [];
        foreach ($request->all() as $choise) {
            // dd($choise);
            $leters = substr($choise['choise'], 0, 2);
            // dd($leters);
            $choices[] = $leters;
            $var_choices[] = $choise['choise'];
        }
        // $array = ($choices);
        $array = Arr::prepend($choices, $product_name);

        // $array = explode('_', 'Er_La_Bl');
        function depth_picker($arr, $temp_string, &$collect)
        {
            if ($temp_string != "")
                $collect[] = $temp_string;

            for ($i = 0, $iMax = sizeof($arr); $i < $iMax; $i++) {
                $arrcopy = $arr;
                // dd(sizeof($arrcopy));
                $elem = array_splice($arrcopy, $i, 1); // removes and returns the i'th element
                if (sizeof($arrcopy) > 0) {
                    depth_picker($arrcopy, $temp_string . "_" . $elem[0], $collect);
                } else {
                    $collect[] = $temp_string . "_" . $elem[0];
                }
            }
        }

        $collect = array();
        depth_picker($array, "", $collect);
        $str = [];
        foreach ($collect as $value) {
            $str[] = substr($value, 1);
        }


        $arra_size = sizeof($array);
        // DB::enableQueryLog(); // Enable query log
        $new_arr = [];
        foreach ($str as $key => $sku_n) {
            // if ($key > 0) {
            $sku_n_a = explode('_', $sku_n);
            // dd(sizeof($sku_n_a), sizeof($array));
            if (sizeof($sku_n_a) == $arra_size) {
                $new_arr[] = $sku_n;
                $skus = Sku::with(['product'])->where('sku_no', 'LIKE', "%{$sku_n}%")->first();
                // return $sku_n;
                if ($skus) {
                    $data = array('skus' => $skus, 'choices' => $var_choices);
                    return $data;
                    // return $this->transform_product($skus, $choices);
                }
            }
            // }
        }
        // dd($new_arr);
        // dd(DB::getQueryLog()); // Show results of log

    }

    public function transform_product($sku, $choices)
    {
        $products = $sku->product;
        $products->transform(function ($product) use ($sku, $choices) {
            $product->quantity = $sku->quantity;
            $product->price = $sku->price;
            $product->choices = $choices;
            return $product;
        });
        return $products;
    }
}
