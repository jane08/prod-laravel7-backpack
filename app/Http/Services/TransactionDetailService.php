<?php

namespace App\Http\Services;


use App\Helpers\CommonHelper;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Carbon\Carbon;

class TransactionDetailService
{
    public static function getAll()
    {
        return TransactionDetail::all();
    }

    public static function getAllByTransaction($transactionId)
    {
        return TransactionDetail::where(['transaction_id'=>$transactionId])->get();
    }

    public static function getOne($id)
    {
        return TransactionDetail::where(['id'=>$id])->get()->first();
    }



}
