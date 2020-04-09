<?php

namespace App\Http\Controllers;

use App\models\Category_discount;
use App\models\Offer;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OfferController extends Controller
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
        return Offer::paginate(500);
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
        $offer = new Category_discount();
        $start_date = Carbon::parse($request->start_date);
        $end_date = Carbon::parse($request->end_date);
        $coupon_code = $request->coupon_code;
        $discount_type = $request->discount_type;
        $categories = $request->category;
        $brand = $request->brand;
        if ($request->discount_type == 'product_type') {
            foreach ($categories as $category) {
                // dd($category);
                $offer->product_category_id = $category;
                $offer->discount_value = $request->discount_value;
                $offer->discount_unit = $request->discount_unit;
                $offer->valid_from = $start_date;
                $offer->valid_until = $end_date;
                $offer->coupon_code = $coupon_code;
                // $offer->minimum_order_value = $request->minimum_order_value;
                // $offer->maximum_discount_amount = $request->maximum_discount_amount;
                $offer->save();
            }
        }

        // $offer->is_redeem_allowed = $is_redeem_allowed;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\models\Offer  $offer
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Offer::find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\models\Offer  $offer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $offer = Offer::find($id);
        $offer->user_id = $this->logged_user()->id;
        $offer->offer_name = $request->offer_name;
        $offer->to_price = $request->to_price;
        $offer->from_price = $request->from_price;
        $offer->discount_type = $request->discount_type;
        $offer->value = $request->value;
        $offer->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\models\Offer  $offer
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Offer::find($id)->delete();
    }
}
