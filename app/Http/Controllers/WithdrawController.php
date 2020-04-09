<?php

namespace App\Http\Controllers;

use App\models\AutoGenerate;
use App\models\Transaction;
use App\models\Withdraw;
use Bitfumes\Multiauth\Model\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WithdrawController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Withdraw::where('status', 'Pending')->paginate(500);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $withdraw = new Withdraw;
        $withdraw->amount = $request->amount;
        $withdrawal_no = new AutoGenerate;
        $withdrawal_no = $withdrawal_no->withdrawal_no();
        $withdraw->withdrawal_no = $withdrawal_no;
        $withdraw->admin_id = Admin::first()->id;
        $withdraw->seller_id = Auth::guard('seller')->id();
        $withdraw->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\models\Withdraw  $withdraw
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Withdraw::find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\models\Withdraw  $withdraw
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // return $request->all();
        $withdraw = Withdraw::find($id);
        $withdraw->status = $request->status;
        $withdraw->comment = $request->comment;
        if ($request->status == 'Approved') {
            $seller_id = $withdraw->seller_id;
            $amount = $withdraw->amount;
            $withdraw->admin_id = Auth::guard('admin')->id();
            $transaction = Transaction::where('seller_id', $seller_id)->decrement('amount', $amount);
        }
        $withdraw->save();
    }
    public function filter_withdrawals(Request $request)
    {
        // return $request->all();
        return Withdraw::where('status', $request->tab)->paginate(500);
    }
}
