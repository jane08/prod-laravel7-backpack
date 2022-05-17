<?php

namespace App\Http\Services;


use App\Helpers\CommonHelper;
use App\Models\AboutSystem;
use App\Models\Promo;
use App\Models\StaticTrans;
use App\Models\StrikeEvent;
use App\Models\Transaction;
use Carbon\Carbon;

class TransactionService
{
    public static function getAll()
    {
        return Transaction::all();
    }

    public static function getOne($id)
    {
        return Transaction::where(['id'=>$id])->get()->first();
    }

    public static function getPaidTariffData($user_id)
    {
        $data = [];
        $transactions = 0;
        $trans = Transaction::where(['user_id'=>$user_id,'type'=>Transaction::TYPE_TARIFF])->orderEndDate()->activeDates()->paid();
        if(!empty($trans))
        {
            $transactions = $trans->count();
        }
        if($transactions>CommonHelper::ONE)
        {
            $transactionLast = Transaction::where(['user_id'=>$user_id,'type'=>Transaction::TYPE_TARIFF])->orderEndDateDesc()->activeDates()->paid()->first();
            $transaction = Transaction::where(['user_id'=>$user_id,'type'=>Transaction::TYPE_TARIFF])->orderEndDate()->activeDates()->paid()->get()->first();

            $endDate = $transactionLast->end_date??'';
            $startDate = $transaction->start_date??'';

        }
        else {
            $transaction = Transaction::where(['user_id' => $user_id,'type'=>Transaction::TYPE_TARIFF])->orderEndDateDesc()->activeDates()->paid()->first();
            $endDate = $transaction->end_date??'';
            $startDate = $transaction->start_date??'';
           // $title = $transaction->title??'';
        }
        if(!empty($transaction)) {

            $data['tariff_id'] = $transaction->tariff_id;
            $data['user_id'] = $transaction->user_id;
            $data['title'] = $transaction->tariff->title ?? '';
            $data['code'] = $transaction->tariff->code ?? '';
            $data['sum'] = $transaction->sum;
            $data['start_date'] = $startDate;
            $data['end_date'] = $endDate;
        }
        return $data;
    }

    public static function getActivePaidTariffData($user_id)
    {
        $transactionLast = Transaction::where(['user_id'=>$user_id,'type'=>Transaction::TYPE_TARIFF])->orderEndDateDesc()->activeDates()->paid()->first();
       // if(!empty($transactionLast) && !empty($transactionLast->end_date))
        //{
            $transactions = Transaction::where(['user_id'=>$user_id,'type'=>Transaction::TYPE_TARIFF])->orderEndDate()->activeDates()->paid()->get()->first();
      //  }
    }

    public static function getStartDate($userId,$courseId)
    {
        $transaction = Transaction::where(['user_id'=>$userId,'course_id'=>$courseId])->orderEndDate()->paid()->first();
        return $transaction->start_date??'';
    }
    public static function getTimeLeft($userId,$courseId)
    {
        $transaction = Transaction::where(['user_id'=>$userId,'course_id'=>$courseId])->orderEndDateDesc()->paid()->first();

        //$end = Carbon::parse($transaction->end_date);
        //$start = Carbon::now();

        $date1 = strtotime(Carbon::now()->toDateTimeString());
        $date2 = strtotime($transaction->end_date);

        $diff = ($date2 - $date1);
        if($diff<=0){
            return 0;
        }

        $diff = abs($date2 - $date1);
        // To get the year divide the resultant date into
        // total seconds in a year (365*60*60*24)
        $years = floor($diff / (365*60*60*24));

        // To get the month, subtract it with years and
        // divide the resultant date into
        // total seconds in a month (30*60*60*24)
        $months = floor(($diff - $years * 365*60*60*24)
            / (30*60*60*24));

        // To get the day, subtract it with years and
        // months and divide the resultant date into
        // total seconds in a days (60*60*24)
        $days = floor(($diff - $years * 365*60*60*24 -
                $months*30*60*60*24)/ (60*60*24));

        // To get the hour, subtract it with years,
        // months & seconds and divide the resultant
        // date into total seconds in a hours (60*60)
        $hours = floor(($diff - $years * 365*60*60*24
                - $months*30*60*60*24 - $days*60*60*24)
            / (60*60));

       return $days." days ".$hours." hours";
    }

}
