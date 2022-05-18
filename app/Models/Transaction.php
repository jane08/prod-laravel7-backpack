<?php

namespace App\Models;

use App\Helpers\CommonHelper;
use App\Http\Services\CourseService;
use App\Http\Services\TariffService;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Transaction extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    const PENDING = 'pending';
    const SUCCESS = 'success'; // оплачено
    const FAILED = 'failed';

    const TYPE_TARIFF="tariff";
    const TYPE_SCORE="score";
    const TYPE_COURSE="course";
    const TYPE_PRODUCT="product";

    const PAY_TYPE_CURRENCY = "currency";
    const PAY_TYPE_CRYPTO = "crypto";
    const STRIPE = "stripe";

    const CODE_CANT_EXTEND = 2;
    const CODE_CANT_BUY = 3;

    protected $fillable = ["start_date","end_date","status","user_id","tariff_id","tariff_type","message",'sum','qty'];

    public static $statuses =[
        self::PENDING => 'PENDING',
        self::SUCCESS => 'Success',
        self::FAILED => 'Failed',
    ];

    public static $statusesArr =[
        self::PENDING => self::PENDING,
        self::SUCCESS => self::SUCCESS,
        self::FAILED =>  self::FAILED,
    ];

    public static function getStatus($key)
    {
        return self::$statuses[$key];
    }
    public static function getStatuses()
    {
        return self::$statuses;
    }


    public static function saveTransaction($userId,$status,$request,$product=null,$payType=Transaction::STRIPE,$type=self::TYPE_PRODUCT,$cart=null,$sum=0,$qty=0,$tariffId=null)
    {
        $transaction=null;

        $transaction = new Transaction();
               $transaction->user_id = $userId;
               $transaction->qty = $qty;
               $transaction->start_date = null;
               $transaction->end_date = null;
               $transaction->user_id = $userId;
               $transaction->tariff_id = $tariffId;
               $transaction->sum =  $product->price??$sum;
               $transaction->status = $status;
               $transaction->type = $type;
               $transaction->pay_type = $payType;
               $transaction->tariff_type = null;
               $transaction->message = $request->message??'';
               $transaction->save();

               if(!empty($transaction))
               {
                    $transactionDetail = new TransactionDetail();
                    $transactionDetail->transaction_id = $transaction->id;
                    $transactionDetail->product_id = $product->id;
                    $transactionDetail->price = $product->price;
                    $transactionDetail->sum = $product->price;
                    $transactionDetail->qty = CommonHelper::ONE;
                   $transactionDetail->save();
               }

        return $transaction;
    }

    /*
   |--------------------------------------------------------------------------
   | relations
   |--------------------------------------------------------------------------
   */
    public function tariff()
    {
        return $this->belongsTo('App\Models\Tariff', 'tariff_id');
    }

    /*
    |--------------------------------------------------------------------------
    | scopes
    |--------------------------------------------------------------------------
    */
    public function scopeOrderEndDate($query)
    {
        $query->orderBy('end_date', 'ASC');
    }
    public function scopeOrderEndDateDesc($query)
    {
        $query->orderBy('end_date', 'DESC');
    }
    public function scopePaid($query)
    {
        $query->where('status', self::SUCCESS);
    }
    public function scopeBeforeEndDate($query)
    {
        return $query->whereDate('end_date', '<=', Carbon::now());
    }
    public function scopeActiveDates($query)
    {
        return $query->whereDate('end_date', '>=', Carbon::now());
       // return $query->whereBetween('end_date', [ Carbon::now(), $end_date]);
    }

    public function getStartDateAttribute($value) {

        $value = Carbon::parse($value);

        return  $value->format('F d, Y H:i');
    }

    public function course()
    {
        return $this->belongsTo('App\Models\Course', 'course_id');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function setEndDateAttribute($value) {
        $this->attributes['end_date'] = \Carbon\Carbon::parse($value);
    }
    public function setStartDateAttribute($value) {
        $this->attributes['start_date'] = \Carbon\Carbon::parse($value);
    }




}
