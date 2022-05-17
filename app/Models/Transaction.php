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

    const PAY_TYPE_CURRENCY = "currency";
    const PAY_TYPE_CRYPTO = "crypto";
    const STRIPE = "stripe";

    const CODE_CANT_EXTEND = 2;
    const CODE_CANT_BUY = 3;

    protected $fillable = ["start_date","end_date","status","course_id","user_id","tariff_id","tariff_type","message",'sum'];

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


    public static function saveTransaction($userId,$courseId,$tariffType,$status,$tariffId=null,$type=self::TYPE_COURSE,$payType=Transaction::STRIPE,$message="",$sum=0)
    {
        $transaction=null;
           $tariff = TariffService::getOne($tariffId);

               $transaction = Transaction::where(['user_id' => $userId,"course_id"=>$courseId])->orderEndDateDesc()->activeDates()->paid()->first();
               $course = CourseService::getOne($courseId);
               if (empty($transaction)) {

                   $startDate = Carbon::now()->toDateTimeString();
                   $endDate = Carbon::now()->addHours($course->access_hours)->toDateTimeString();

               } else {
                   $date = new Carbon($transaction->end_date);
                   $startDate = $date->toDateTimeString();

                   $endDate = $date->addHours($course->access_hours)->toDateTimeString();
               }

        $transaction = new Transaction();
               $transaction->user_id = $userId;
               $transaction->course_id = $courseId;
               $transaction->start_date = $startDate;
               $transaction->end_date = $endDate;
               $transaction->user_id = $userId;
               $transaction->tariff_id = $tariffId;
               $transaction->sum = $tariff->price;
               $transaction->status = $status;
               $transaction->type = $type;
               $transaction->pay_type = $payType;
               $transaction->tariff_type = $tariffType;
               $transaction->message = $message;
               $transaction->save();

        return $transaction;
    }

    /**
     * Can not extend if course was not bought. Can only extend if the course was bought
     * @param $userId
     * @param $courseId
     *
     */
    public static function canBuy($userId,$courseId,$tariffType)
    {
        $respond=[];
        $respond["code"] = CommonHelper::ONE;
        $respond["status"] = false;
        $transaction = Transaction::where(['user_id' => $userId,"course_id"=>$courseId])->orderEndDateDesc()->paid()->first();

        if(empty($transaction))
        {
            if($tariffType==Tariff::EXTEND)
            {
                $respond["status"] = false;
                $respond["code"] = self::CODE_CANT_EXTEND;
                return $respond;
            }
            $respond["status"] = true;
            return $respond;
        }
        else {
            if ($transaction->tariff_type == Tariff::EXTEND) {
                $respond["status"] = true;

                return $respond;
            }
            $respond["status"] = false;
            $respond["code"] = self::CODE_CANT_BUY;

            return $respond;
        }

        return $respond;

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
