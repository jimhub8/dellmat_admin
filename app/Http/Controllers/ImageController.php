<?php

namespace App\Http\Controllers;

use App\models\Image;
use App\models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $image_file = $request->all();
        // dd($image_file);
        $image = new Image();
        $image->product_id = $request->id;


        if ($request->hasFile('image')) {
            $img = $request->image;
            if (File::exists($image->image)) {
                $image_path = $image->image;
                File::delete($image_path);
            }


            $imagename = Storage::disk(env('STORAGE_DISK'))->put('slider', $img);
            $imgArr = explode('/', $imagename);
            $image_name = $imgArr[1];
            $image->image = env('STORAGE_PATH') . '/products/' . $image_name;

            // $imagename = Storage::disk('public')->put('products', $img);
            // $imgArr = explode('/', $imagename);
            // $image_name = $imgArr[1];
            // $image->image = '/storage/products/' . $image_name;


            $image->save();
            return $image;
        }
        return 'error';
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\models\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Image $image)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\models\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function destroy(Image $image)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function images(Request $request, $id)
    {
        $image_file = $request->all();
        // dd($image_file);
        $image = Image::where('product_id', $id)->where('display', 1)->first();
        if (!$image) {
            $image = new Image();
        }
        if ($image) {
            $image_display = Image::where('product_id', $id)->where('display', 1)->get();
            foreach ($image_display as  $image_update) {
                $image_update->display = false;
                $image_update->save();
            }
        }
        $image->product_id = $id;
        if ($request->hasFile('image')) {
            $img = $request->image;
            if (File::exists($image->image)) {
                // dd($image->image);
                $image_path = $image->image;
                File::delete($image_path);
            }
            // $imagename = Storage::disk('dellmat')->put('products', $img);
            // $imgArr = explode('/', $imagename);
            // $image_name = $imgArr[1];
            // $image->image = '/delstorage/products/' . $image_name;


            $imagename = Storage::disk(env('STORAGE_DISK'))->put('products', $img);
            $imgArr = explode('/', $imagename);
            $image_name = $imgArr[1];
            $uploaded_img = env('STORAGE_PATH') . '/products/' . $image_name;
            $image->image = $uploaded_img;
            $image->display = true;

            // return $uploaded_img;

            // $image->image = '/storage/products/' . $image_name;
            // $image->image = env('APP_URL') . '/storage/products/' . $image_name;
            $image->save();
            return $image;
        }
        return 'error';
    }

    public function product_image(Request $request, $id)
    {
        // dd($request->image);
        $upload = new Image();
        // $upload = Product::find($id);
        $upload->product_id = $id;
        if ($request->hasFile('image')) {
            $img = $request->image;
            // dd($upload->image);
            if (File::exists($upload->image)) {
                // return ('test');
                $image_path = $upload->image;
                File::delete($image_path);
            }
            $imagename = Storage::disk('dellmat')->put('pro_images', $img);
            // $imagename = Storage::disk('public')->put('pro_images', $img);
            // return ('noop');
            $imgArr = explode('/', $imagename);
            $image_name = $imgArr[1];
            $upload->image = '/delstorage/pro_images/' . $image_name;
            // $upload->image = '/storage/pro_images/' . $image_name;
            $upload->display = false;
            // $upload->image = env('APP_URL') . '/storage/products/' . $image_name;
            $upload->save();
            return $upload;
        }
    }
}
