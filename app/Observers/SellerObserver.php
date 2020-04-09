<?php

namespace App\Observers;

use App\models\Transaction;
use App\Seller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class SellerObserver
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }
    /**
     * Handle the product "created" event.
     *
     * @param  \App\models\Seller  $seller
     * @return void
     */
    public function created(Seller $seller)
    {
        $transaction = new Transaction();
        $transaction->amount = 0;
        $transaction->seller_id = $seller->id;
        $transaction->save();
    }

    /**
     * Handle the product "updated" event.
     *
     * @param  \App\models\Seller  $seller
     * @return void
     */
    public function updated(Seller $seller)
    {

    }

    /**
     * Handle the product "deleted" event.
     *
     * @param  \App\models\Seller  $seller
     * @return void
     */
    public function deleted(Seller $seller)
    {

    }

    /**
     * Handle the product "restored" event.
     *
     * @param  \App\models\Seller  $seller
     * @return void
     */
    public function restored(Seller $seller)
    {

    }

    /**
     * Handle the product "force deleted" event.
     *
     * @param  \App\models\Seller  $seller
     * @return void
     */
    public function forceDeleted(Seller $seller)
    {

    }
}
