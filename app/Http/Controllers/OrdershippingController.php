<?php

namespace App\Http\Controllers;

use App\models\Ordershipping;
use App\models\Shippingaddress;
use Illuminate\Http\Request;

class OrdershippingController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  \App\models\Ordershipping  $ordershipping
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $shippingaddress_id = Ordershipping::find($id);
        $shippingaddress_id = $shippingaddress_id->shippingaddress_id;
        return Shippingaddress::find($shippingaddress_id);
    }
}
