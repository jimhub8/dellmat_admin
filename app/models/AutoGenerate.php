<?php

namespace App\models;

class AutoGenerate
{
    public function unique_sku()
    {
        $sku = Sku::withTrashed()->select('id', 'sku_no')->orderBy('id', 'Desc')->first();
        // dd($sku);
        if ($sku) {
            $inv_arr = explode('SKU_', $sku->sku_no);
            // dd($sku);
            // $id = ''.str_pad($product->id + 1, 8, "0", STR_PAD_LEFT);
            $sku_no = ($inv_arr) ? str_pad($sku->id + 1, 8, "0", STR_PAD_LEFT) : str_pad(1, 8, "0", STR_PAD_LEFT);
            $validator = \Validator::make(['sku_no' => $sku_no], ['sku_no' => 'unique:skus,sku_no']);
            if ($validator->fails()) {
                $in_ar = (int) $inv_arr[1];
                for ($i = 1; $i < 50; $i++) {
                    $sku_no = ($sku) ? str_pad($in_ar + $i, 8, "0", STR_PAD_LEFT) : str_pad(1, 8, "0", STR_PAD_LEFT);
                    $validator = \Validator::make(['sku_no' => $sku_no], ['sku_no' => 'unique:skus,sku_no']);
                    if (!$validator->fails()) {
                        return (int) $sku_no;
                    }
                }
            } else {
                return (int) $sku_no;
            }
        } else {
            return (int)str_pad(1, 8, "0", STR_PAD_LEFT);
        }
    }

    public function product_sku()
    {
        $product_sku = Product::withTrashed()->select('id', 'sku_no')->orderBy('id', 'Desc')->first();
        // dd($product_sku);
        if ($product_sku) {
            $inv_arr = explode('SKU_', $product_sku->sku_no);
            // dd($product_sku);
            // $id = ''.str_pad($product->id + 1, 8, "0", STR_PAD_LEFT);
            $sku_no = ($inv_arr) ? str_pad($product_sku->id + 1, 8, "0", STR_PAD_LEFT) : str_pad(1, 8, "0", STR_PAD_LEFT);
            $validator = \Validator::make(['sku_no' => $sku_no], ['sku_no' => 'unique:skus,sku_no']);
            if ($validator->fails()) {
                $in_ar = (int) $inv_arr[1];
                for ($i = 1; $i < 50; $i++) {
                    $sku_no = ($product_sku) ? str_pad($in_ar + $i, 8, "0", STR_PAD_LEFT) : str_pad(1, 8, "0", STR_PAD_LEFT);
                    $validator = \Validator::make(['sku_no' => $sku_no], ['sku_no' => 'unique:skus,sku_no']);
                    if (!$validator->fails()) {
                        return 'SKU_' .  $sku_no;
                    }
                }
            } else {
                return 'SKU_' .  $sku_no;
            }
        } else {
            return 'SKU_' .  str_pad(1, 8, "0", STR_PAD_LEFT);
        }
    }

    public function unique_sku_2($id)
    {
        $sku = Sku::withTrashed()->where('product_id', $id)->orderBy('id', 'ASC')->first();
        // dd($sku);
        if ($sku) {
            $inv_arr = explode('SKU_', $sku->sku_no);
            // dd($inv_arr);
            // $id = ''.str_pad($product->id + 1, 8, "0", STR_PAD_LEFT);
            $sku_no = ($inv_arr) ?  str_pad($sku->id + 1, 8, "0", STR_PAD_LEFT) :  str_pad(1, 8, "0", STR_PAD_LEFT);
            $validator = \Validator::make(['sku_no' => $sku_no], ['sku_no' => 'unique:skus,sku_no']);
            if ($validator->fails()) {
                $in_ar = (int) $inv_arr[1];
                for ($i = 1; $i < 50; $i++) {
                    $sku_no = ($sku) ?  str_pad($in_ar + $i, 8, "0", STR_PAD_LEFT) :  str_pad(1, 8, "0", STR_PAD_LEFT);
                    $validator = \Validator::make(['sku_no' => $sku_no], ['sku_no' => 'unique:skus,sku_no']);
                    if (!$validator->fails()) {
                        return (int) $sku_no - 1;
                    }
                }
            } else {
                return (int) $sku_no - 1;
            }
        } else {
            return  str_pad(1, 8, "0", STR_PAD_LEFT);
        }
    }


    public function withdrawal_no()
    {
        $withdrawal_number = Withdraw::orderBy('id', 'Desc')->first('id');
        // dd($withdrawal_number);
        if ($withdrawal_number) {
            $inv_arr = explode('W_', $withdrawal_number->withdrawal_no);
            // dd($withdrawal_number);
            // $id = ''.str_pad($product->id + 1, 8, "0", STR_PAD_LEFT);
            $withdrawal_no = ($inv_arr) ? str_pad($withdrawal_number->id + 1, 8, "0", STR_PAD_LEFT) : str_pad(1, 8, "0", STR_PAD_LEFT);
            $validator = \Validator::make(['withdrawal_no' => $withdrawal_no], ['withdrawal_no' => 'unique:sales,withdrawal_no']);
            if ($validator->fails()) {
                $in_ar = (int) $inv_arr[1];
                for ($i = 1; $i < 50; $i++) {
                    $withdrawal_no = ($withdrawal_number) ? str_pad($in_ar + $i, 8, "0", STR_PAD_LEFT) : str_pad(1, 8, "0", STR_PAD_LEFT);
                    $validator = \Validator::make(['withdrawal_no' => $withdrawal_no], ['withdrawal_no' => 'unique:sales,withdrawal_no']);
                    if (!$validator->fails()) {
                        return 'W_' .  $withdrawal_no;
                    }
                }
            } else {
                return 'W_' .  $withdrawal_no;
            }
        } else {
            return 'W_' .  str_pad(1, 8, "0", STR_PAD_LEFT);
        }
    }


    public function order_no()
    {
        $order_number = Sale::withTrashed()->select('id')->orderBy('id', 'Desc')->first();
        // dd($order_number);
        if ($order_number) {
            $inv_arr = explode('ORD_', $order_number->order_no);
            // dd($order_number);
            // $id = ''.str_pad($product->id + 1, 8, "0", STR_PAD_LEFT);
            $order_no = ($inv_arr) ? str_pad($order_number->id + 1, 8, "0", STR_PAD_LEFT) : str_pad(1, 8, "0", STR_PAD_LEFT);
            $validator = \Validator::make(['order_no' => $order_no], ['order_no' => 'unique:sales,order_no']);
            if ($validator->fails()) {
                $in_ar = (int) $inv_arr[1];
                for ($i = 1; $i < 50; $i++) {
                    $order_no = ($order_number) ? str_pad($in_ar + $i, 8, "0", STR_PAD_LEFT) : str_pad(1, 8, "0", STR_PAD_LEFT);
                    $validator = \Validator::make(['order_no' => $order_no], ['order_no' => 'unique:sales,order_no']);
                    if (!$validator->fails()) {
                        return 'ORD_' .  $order_no;
                    }
                }
            } else {
                return 'ORD_' .  $order_no;
            }
        } else {
            return 'ORD_' .  str_pad(1, 8, "0", STR_PAD_LEFT);
        }
    }
}
