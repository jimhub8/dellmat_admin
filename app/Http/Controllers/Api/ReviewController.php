<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;


use App\models\Review;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use App\models\Product;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Review::all();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function show(Review $review, $id)
    {
        // return 'Review::all()';
        // $avg_rating = $this->avrgRating($review->id);
        $reviews = Review::where('product_id', $id)->orderBy('created_at', 'DESC')->paginate(10);
        // return $reviews;
        $reviews->transform(function ($review, $key) {
            // var_dump($review->user_id);
            $user = User::find($review->user_id);
            $review->user_name = $user->name;
            $review->profile = $user->profile;
            return $review;
        });
        return $reviews;
    }

    public function ratings($id)
    {
        return $reviews = Review::where('product_id', $id)->avg('rating');
    }

    public function rate(Request $request)
    {
        // return $request->all();
        $rating = new Review;
        $rating->rating = $request->rating;
        $rating->product_id = $request->id;
        $rating->comments = $request->comments;
        $rating->user_id = Auth::id();
        $rating->save();
        return $rating;
    }

    public function bestRated()
    {
        $ratings = Review::take(3)->orderBy('rating', 'DESC')->get();

        $ratings->transform(function ($review, $key) {
            $user = User::find($review->user_id);
            $product = Product::find($review->product_id);
            $review->product_name = $product->name;
            $review->user_name = $user->name;
            $review->profile = $user->profile;
            return $review;
        });
        return $ratings;
    }
    public function getReviews($id)
    {
        $reviews = Review::where('product_id', $id)->orderBy('created_at', 'DESC')->paginate(10);
        // return $reviews;
        $reviews->transform(function ($review, $key) {
            // var_dump($review->user_id);
            $user = User::find($review->user_id);
            $review->user_name = $user->name;
            $review->profile = $user->profile;
            return $review;
        });
        return $reviews;
    }
}



