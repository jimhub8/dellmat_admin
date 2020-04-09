<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\models\AutoGenerate;
use App\models\Product;

class AutoGenerateController extends Controller
{
    public function unique_sku($id)
    {
        $product = Product::find($id);
        $unique_sku = new AutoGenerate;
        if (count($product->product_variants) > 0) {
            // return '11111';
            return $unique_sku->unique_sku_2($id);
        } else {
            // return '2222';

            return $unique_sku->unique_sku();
        }
    }
}
