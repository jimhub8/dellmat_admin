<?php

namespace App\Http\Controllers;

use App\models\BrandProduct;
use App\models\CategoryProduct;
use App\models\Option;
use App\models\OptionValue;
use App\models\Product;
use App\models\Sku;
use Illuminate\Http\Request;
use App\models\ProductOption;
use App\models\ProductVariant;
use App\models\VariantValue;
use App\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class VariantController extends Controller
{
    public function logged_user()
    {
        $user = new User();
        return  $user->logged_user();
    }
    public function options()
    {
        return Option::all();
    }
    public function option_values()
    {
        return OptionValue::all();
    }

    public function variant_sku($id)
    {
        return $skus = Sku::where('product_id', $id)->get();
        // $skus->transform(function($sku) {
        //     $sku->
        // });
    }

    public function product_variant($id)
    {
        $product = Product::find($id);
        // return $product;
        $attribute_arr = [];
        if (count($product->product_variants) < 1) {
            return $attribute_arr;
        }
        $options_val = option::all()->toArray();
        $variant_values = $product->product_variants[0]->variant_values;
        foreach ($variant_values as $index => $element) {
            foreach ($options_val as $index_opt => $element_opt) {
                // dd($element_opt->option_name, $element->option_value->option->option_name, $index_opt);
                if ($element_opt['option_name'] == $element->option_value->option->option_name) {
                    if (count($attribute_arr) < 1) {
                        $attribute_arr[$index_opt] = $element_opt;
                        $attribute_arr[$index_opt]['attribute'] = $element_opt;
                        $attribute_arr[$index_opt]['tags'] = [];
                    }
                } else {
                    foreach ($attribute_arr as $art_index => $element_art) {
                        $attribute_arr[$index_opt] = $element_opt;
                        $attribute_arr[$index_opt]['attribute'] = $element_opt;
                        $attribute_arr[$index_opt]['tags'] = [];
                    }
                }
            }
            foreach ($attribute_arr as $art_index => $element_art) {
                foreach ($variant_values as $index => $element) {
                    // dd($element->option_value->option->option_name == $element_art['option_name'] );
                    if ($element->option_value->option->option_name == $element_art['option_name']) {
                        // dd($attribute_arr[$index]['tags'], $element->option_value);
                        array_push($attribute_arr[$art_index]['tags'], $element->option_value);
                        // return $attribute_arr[$index];

                    }
                }
            }

            foreach ($attribute_arr as $art_index => $element_art) {
                // return $element_art['tags'];
                if (count($element_art['tags']) < 1) {
                    Arr::forget($attribute_arr, $art_index);
                }
            }
            return ($attribute_arr);
        }
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
        // return $request->all();

        $update_product = Product::find($id);

        $variants = $request->variants;
        $product_variants = ProductVariant::updateOrCreate(
            ['product_id' => $id]
        );
        $option_value_id_arr = [];

        $option_arr = [];
        foreach ($variants[0] as $variant) {
            $option_id = Option::where('option_name', $variant['attribute']['option_name'])->first();
            $option_id = $option_id->id;
            $option_arr[] = $option_id;
            $product_option = ProductOption::updateOrCreate(
                ['product_id' => $id, 'option_id' => $option_id]
            );

            foreach ($variant['tags'] as $key => $tag) {
                $option_value_id = OptionValue::where('option_name', $tag['option_name'])->first();
                $option_value_id_arr[] = $option_value_id->id;

                $product_variant_product_id = $id;
                $product_variant_variant_id = $product_variants->id;;
                $product_option_product_id = $id;
                $option_value_option_id = $product_option->option_id;
                $product_option_id = $product_option->id;
                $option_value_id = $option_value_id->id;
                // $price = 100 + $key;
                VariantValue::updateOrCreate(
                    [
                        'product_variant_product_id' =>  $product_variant_product_id,
                        'product_variant_variant_id' =>  $product_variant_variant_id,
                        'product_option_product_id' =>  $product_option_product_id,
                        'option_value_option_id' =>  $option_value_option_id,
                        'product_option_id' =>  $product_option_id,
                        'option_value_id' =>  $option_value_id,
                    ]
                );
            }
        }
        // return $option_value_id_arr;
        $pro_opt_delete = ProductOption::whereNotIn('option_id', $option_arr)->whereIn('product_id', [$id])->get();
        foreach ($pro_opt_delete as $pro_opt_del) {
            $pro_opt_del->delete();
        }
        $arr_only = Arr::only($option_value_id_arr, 'id');
        // return ($arr_only);

        // return ($flattened);
        $var_opt_delete = VariantValue::whereNotIn('option_value_id', $option_value_id_arr)->where('product_variant_product_id', $id)->get();

        foreach ($var_opt_delete as $var_opt_del) {
            $var_opt_del->delete();
        }
        $variants_sku = $variants[1];
        $sku_arr = [];
        foreach ($variants_sku as $sku) {
            $sku_arr[] = $sku['sku_no'];
            Sku::withTrashed()->updateOrCreate(
                [
                    'sku_no' => $sku['sku_no'],
                ],
                [
                    'price' => $sku['price'],
                    'quantity' => $sku['qty_available'],
                    'product_id' => $id,
                    'reorder_point' => $sku['reorder_point'],
                    // 'deleted_at' => null,
                ]
            );
        }

        // DB::enableQueryLog(); // Enable query log

        $sku_av = Sku::withTrashed()->select('id')->whereIn('sku_no', $sku_arr)->where('product_id', $id)->get('id')->toArray();
        // dd(DB::getQueryLog()); // Show results of log
        // $flatten = Arr::flatten($sku_av);
        $sku_restore = Sku::withTrashed()->whereIn('id', $sku_av)->where('product_id', $id)->get();
        // return $sku_arr;
        $sku_delete = Sku::whereNotIn('id', $sku_av)->where('product_id', $id)->get();
        if (count($sku_delete) > 0) {
            foreach ($sku_delete as  $sku_a) {
                $sku_a->delete();
            }
        }

        if (count($sku_restore) > 0) {
            foreach ($sku_restore as  $sku_r) {
                $sku_r->restore();
            }
        }
        $this->category_fun($request->product['categories'], $update_product);
        $this->subcategory_fun($request->product['subcategories'], $update_product);
        $this->brand_fun($request->product['brands'], $update_product);

        // return $sku_restore;
    }

    public function category_fun($categories, $update_product)
    {
        $category_sync_id = [];
        foreach ($categories as  $category) {
            $category_sync_id[] = $category['id'];
        }
        $update_product->categories()->sync($category_sync_id);

    }

    public function brand_fun($brands, $update_product)
    {
        $brand_sync_id = [];
        foreach ($brands as  $brand) {
            $brand_sync_id[] = $brand['id'];
        }
        $update_product->brands()->sync($brand_sync_id);
    }

    public function subcategory_fun($sub_cats, $update_product)
    {
        $subcat_sync_id = [];
        foreach ($sub_cats as  $sub_cat) {
            $subcat_sync_id[] = $sub_cat['id'];
        }
        $update_product->subcategories()->sync($subcat_sync_id);
    }
}
