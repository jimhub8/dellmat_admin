<?php

namespace App\Http\Controllers;

use App\models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Slider::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
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

        // return $request->all();
        $image_file = $request->all();
        // dd($image_file);
        $image = new Slider;
        if ($request->hasFile('image')) {
            $img = $request->image;

            $imagename = Storage::disk('public')->put('slider', $img);
            $imgArr = explode('/', $imagename);
            $image_name = $imgArr[1];
            $image->image = '/storage/slider/' . $image_name;
            // $image->content = $request->content;
            $image->active = true;
            $image->save();
            return $image;
        }
        return 'error';
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\models\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function show(Slider $slider)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\models\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Slider $slider)
    {

        // return $request->all();
        $image_file = $request->all();
        // dd($image_file);
        $image = Slider::where('product_id', $id)->where('display', 1)->first();
        if (!$image) {
            $image = new Slider();
        }
        if ($image) {
            $image_display = Slider::where('product_id', $id)->where('display', 1)->get();
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
            $imagename = Storage::disk('public')->put('slider', $img);
            $imgArr = explode('/', $imagename);
            $image_name = $imgArr[1];
            $image->image = env('APP_URL') . '/storage/slider/' . $image_name;
            $image->content = $request->content;
            $image->active = true;
            $image->save();
            return $image;
        }
        return 'error';
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\models\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function destroy(Slider $slider)
    {
        //
    }
}
