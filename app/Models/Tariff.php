<?php

namespace App\Models;

use App\Helpers\CommonHelper;
use App\Http\Services\CourseService;
use App\Http\Services\TariffService;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Model;

class Tariff extends Model
{
    use CrudTrait;

    const LIMIT = 100000;

    const LATEST = 'latest';
    const OLDEST = 'oldest';

    const BASIC = 'basic';
    const EXTEND = 'extend';
    const VIP = 'vip';

    protected $table = 'tariffs';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = ['title', 'content','code','price', 'sort','active','pluses'];


    protected function asJson($value)
    {
        return json_encode($value, JSON_UNESCAPED_UNICODE);
    }


    public static function courseHasTariff($courseId,$tariffId,$tariffType)
    {
        $result = false;
        $course = CourseService::getOne($courseId);
        if($tariffType == self::BASIC)
        {
            if(TariffService::getBasicByCourse($courseId,$tariffId))
            {
                $result = true;
            }
        }
        else if($tariffType == self::EXTEND)
        {
            if(TariffService::getExtendByCourse($courseId,$tariffId))
            {
                $result = true;
            }
        }
        else if($tariffType == self::VIP)
        {
            if(TariffService::getVipByCourse($courseId,$tariffId))
            {
                $result = true;
            }
        }
        return $result;
    }

    /*
  |--------------------------------------------------------------------------
  | scopes
  |--------------------------------------------------------------------------
  */
    public function scopeBysort($query,$sort)
    {
        if($sort==self::LATEST) {
            $query->orderBy('sort', 'DESC');
        }
        else{
            $query->orderBy('sort');
        }
    }


    public function scopePublished($query)
    {
        return $query->where('active', CommonHelper::ACTIVE);
    }

    public function getPlusesAttribute($value) {

        $value = json_decode($value , true);

        return $value;
    }

}
