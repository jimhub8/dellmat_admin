<?php

namespace App\Http\Controllers;

use App\models\Option;
use App\models\OptionValue;
use App\models\Product;
use App\models\ProductOption;
use App\models\ProductVariant;
use App\models\VariantValue;
use App\User;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductController_copy extends Controller
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
        return Product::paginate(10);
        // return VariantValue::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $product = new Product();
        $product->description = $request->description;
        $product->product_name = $request->product_name;
        // $product->pos_status = $request->pos_status;
        // $product->price = $request->price;
        // $product->product_barcode = $request->product_barcode;
        // $product->quantity = $request->quantity;
        // $product->sku = $request->sku;
        // $product->tax_category_id = $request->tax_category_id;
        // $product->tax_percent = $request->tax_percent;
        // $product->type = $request->type;
        // $product->weight = $request->weight;
        $product->save();
        return $product;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $product = Product::find($id);
        $attribute_arr = [];
        // $attribute_arr = [
        // return count($attribute_arr);
        // ];
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
                        // return $attribute_arr[$index];
                        // return $attribute_arr;
                        // var_dump($attribute_arr);
                        // element_art.tags.push(element.option_value)
                        // } else {
                        //     foreach ($attribute_arr as $index_opt => $element_art) {
                        //         return '2' . $element_art;
                        //         if ($element_opt['option_name'] == $element_art['attribute']['option_name']) {
                        //             $attribute_arr[$index] = $element_opt;
                        //         }
                        // }
                    }
                } else {
                    // dd($element_opt->option_name, $element->option_value->option->option_name, $index);

                    // $element_opt['attribute'] = $element->option_value->option;
                    // $attribute_arr.push(element_opt)
                    foreach ($attribute_arr as $art_index => $element_art) {
                        $attribute_arr[$index_opt] = $element_opt;
                        $attribute_arr[$index_opt]['attribute'] = $element_opt;
                        $attribute_arr[$index_opt]['tags'] = [];

                        // return ($element_opt);
                        // // $attribute_arr.forEach((element_art, art_index) => {
                        // // console.log(element_art.tags);
                        // // $u_id = element_art.tags
                        // // if (condition) {

                        // // }
                        // return $element_art->option_name;
                        // dd($element_opt['option_name'], $element_art->option_name);
                        // if ($element_opt['option_name'] == $element_art->attribute['option_name']) {
                        //     // if ($element_art->tags) {
                        //         return ($element_art);

                        //         // console.log(element_art.option_name);
                        //         // $element_art.tags.push(element.option_value)
                        //         // console.log(element_art);
                        //     // }
                        // }
                        // return $element;
                        // dd($element->option_value->option->option_name, $element_art->option_name);
                        // dd($attribute_arr[$index]['tags']);
                        // dd($element->option_value->option->option_name == $element_art->option_name);
                        // if ($element->option_value->option->option_name == $element_art->option_name) {
                        //     $attribute_arr[$index]['tags'] = 'test';
                        //     // return $attribute_arr[$index];

                        // }
                    }
                }
            }
            // if ($variant_values->option_value->option->option_name == $element_art->attribute['option_name']) {
            //     // if ($element_art->tags) {
            //         return ($element_art);

            //         // console.log(element_art.option_name);
            //         // $element_art.tags.push(element.option_value)
            //         // console.log(element_art);
            //     // }
            // }

        }

        // unset($attribute_arr[count($attribute_arr) - 1]);
        // $attribute_arr = $attribute_arr->toArray();
        // return ($attribute_arr);
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
        // unset($attribute_arr[count($attribute_arr) - 1]);

        return ($attribute_arr);


        // variant_values.forEach((element, index) => {
        //     $options_val.forEach((element_opt, index_opt) => {
        //         if (element_opt.option_name == element.option_value.option.option_name) {
        //             // element_opt['attribute'] = element.option_value.option
        //             // this.attribute_arr.push(element_opt)
        //             this.attribute_arr.forEach(element_art => {
        //                 // console.log(element_art.tags);
        //                 if (element_opt.option_name == element_art.attribute.option_name) {
        //                     // console.log(element_art.option_name);
        //                     // element_art.tags.push(element.option_value)
        //                 }
        //             });
        //         } else {
        //             element_opt['attribute'] = element.option_value.option
        //             this.attribute_arr.push(element_opt)

        //             this.attribute_arr.forEach((element_art, art_index) => {
        //                 // console.log(element_art.tags);
        //                 this.u_id = element_art.tags
        //                 if (condition) {

        //                 }
        //                 if (element_opt.option_name == element_art.attribute.option_name) {
        //                     if (element_art.tags) {
        //                         console.log(element_art.option_name);
        //                         element_art.tags.push(element.option_value)
        //                         // console.log(element_art);
        //                     }
        //                 }
        //             });
        //             // this.attribute_arr.push(element_opt)
        //         }
        //         // element['tags'] =
        //     });
        // });



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
        return $request->all();

        $variants = $request->variants;

        // $product_variants = new ProductVariant();
        // $product_variants->product_id = $id;
        // $product_variants->save();
        $product_variants = ProductVariant::updateOrCreate(
            ['product_id' => $id],
        );

        $option_arr = [];
        foreach ($variants[0] as $variant) {
            // dd($variant['attribute']['option_name']);
            // $option = $variant['attribute'];
            $option_id = Option::where('option_name', $variant['attribute']['option_name'])->first();
            $option_id = $option_id->id;
            $option_arr[] = $option_id;

            // $product_option = new ProductOption();
            // $product_option->product_id = $id;
            // $product_option->option_id = $option_id;
            // $product_option->save();

            $product_option = ProductOption::updateOrCreate(
                ['product_id' => $id, 'option_id' => $option_id],
            );

            foreach ($variant['tags'] as $key => $tag) {
                // dd($tag);
                $option_value_id = OptionValue::where('option_name', $tag['option_name'])->first();

                $product_variant_product_id = $id;
                $product_variant_variant_id = $product_variants->id;;
                $product_option_product_id = $id;
                $option_value_option_id = $product_option->option_id;
                $product_option_id = $product_option->id;
                $option_value_id = $option_value_id->id;

                $price = 100 + $key;

                // $variant_values = new VariantValue();

                // $variant_values->product_variant_product_id =  (int)$product_variant_product_id;
                // $variant_values->product_variant_variant_id =  (int)$product_variant_variant_id;
                // $variant_values->product_option_product_id =  (int)$product_option_product_id;
                // $variant_values->option_value_option_id =  (int)$option_value_option_id;
                // $variant_values->product_option_id =  (int)$product_option_id;
                // $variant_values->option_value_id =  (int)$option_value_id;
                // $variant_values->save();
                // dd($product_variant_product_id,
                // $product_variant_variant_id,
                // $product_option_product_id,
                // $option_value_option_id,
                // $product_option_id,
                // $option_value_id,);

                $variant_values = VariantValue::updateOrCreate(
                    [
                        'product_variant_product_id' =>  $product_variant_product_id,
                        'product_variant_variant_id' =>  $product_variant_variant_id,
                        'product_option_product_id' =>  $product_option_product_id,
                        'option_value_option_id' =>  $option_value_option_id,
                        'product_option_id' =>  $product_option_id,
                        'option_value_id' =>  $option_value_id,
                        // 'price' =>  $price,
                    ],
                );
            }
        }
        // dd($option_arr);
        // DB::enableQueryLog(); // Enable query log
        $pro_opt_delete = ProductOption::whereNotIn('option_id', $option_arr)->whereIn('product_id', [$id])->get();
        // dd(DB::getQueryLog()); // Show results of log
        foreach ($pro_opt_delete as $pro_opt_del) {
            $pro_opt_del->delete();
        }
        // $pro_opt_delete->delete();
        return 'success';



        /*
        $product = Product::find($id);
        $product->description = $request->description;
        $product->name = $request->name;
        $product->pos_status = $request->pos_status;
        $product->price = $request->price;
        $product->product_barcode = $request->product_barcode;
        $product->quantity = $request->quantity;
        $product->sku = $request->sku;
        $product->tax_category_id = $request->tax_category_id;
        $product->tax_percent = $request->tax_percent;
        $product->type = $request->type;
        $product->weight = $request->weight;
        $product->save();
        return $product;
        */
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

    public function product_image(Request $request, $id)
    {
        // dd($request->image);
        $upload = Product::find($request->id);
        if ($request->hasFile('image')) {
            $img = $request->image;
            // dd($upload->image);
            if (File::exists($upload->image)) {
                // return ('test');
                $image_path = $upload->image;
                File::delete($image_path);
            }
            $imagename = Storage::disk('public')->put('products', $img);
            // return ('noop');
            $imgArr = explode('/', $imagename);
            $image_name = $imgArr[1];
            $upload->image = '/storage/products/' . $image_name;
            $upload->save();
            return $upload;
        }
    }

    public function product_search($search)
    {
        return Product::where('name', 'LIKE', "%{$search}%")
            ->orWhere('product_barcode', 'LIKE', "%{$search}%")
            ->orWhere('description', 'LIKE', "%{$search}%")
            ->paginate(10);
    }
}
