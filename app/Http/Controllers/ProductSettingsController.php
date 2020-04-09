<?php

namespace App\Http\Controllers;

use App\models\ProductSettings;
use App\User;
use Illuminate\Http\Request;

class ProductSettingsController extends Controller
{
    public function logged_user()
    {
        $user = new User();
        return  $user->logged_user();
    }
    public function index()
    {
        $setting = ProductSettings::first();
        return $setting;

    }
    public function featured(Request $request)
    {
        // return $request->all();
        $count = ProductSettings::count();
        if ($count < 1) {
            $featured = new ProductSettings();
            $featured->featured = $request->categories;
        } else {
            $featured = ProductSettings::first();
            $featured->featured = $request->categories;
        }
        $featured->save();

    }
    public function newproduct(Request $request)
    {
        // return $request->all();
        $count = ProductSettings::count();
        if ($count < 1) {
            $newproduct = new ProductSettings();
            $newproduct->newproduct = $request->categories;
        } else {
            $newproduct = ProductSettings::first();
            $newproduct->newproduct = $request->categories;
        }
        $newproduct->save();
    }
    public function bestsellers(Request $request)
    {
        // return $request->all();
        $count = ProductSettings::count();
        if ($count < 1) {
            $bestsellers = new ProductSettings();
            $bestsellers->bestsellers = $request->categories;
        } else {
            $bestsellers = ProductSettings::first();
            $bestsellers->bestsellers = $request->categories;
        }
        $bestsellers->save();
    }
}
