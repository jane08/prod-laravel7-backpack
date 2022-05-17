<?php

namespace App\Http\Services;


use App\Helpers\CommonHelper;
use App\Models\AboutSystem;
use App\Models\Course;
use App\Models\Promo;
use App\Models\StaticTrans;
use App\Models\StrikeEvent;
use App\Models\Tariff;

class TariffService
{
    public static function getAll()
    {
        return Tariff::published()->get();
    }

    public static function getOne($id)
    {
        return Tariff::where(['id'=>$id])->get()->first();
    }

    public static function getBasicByCourse($courseId,$tariffId)
    {
        return Course::where(['tariff_basic_id'=>$tariffId,"id"=>$courseId])->get()->first();
    }
    public static function getExtendByCourse($courseId,$tariffId)
    {
        return Course::where(['tariff_extend_id'=>$tariffId,"id"=>$courseId])->get()->first();
    }
    public static function getVipByCourse($courseId,$tariffId)
    {
        return Course::where(['tariff_vip_id'=>$tariffId,"id"=>$courseId])->get()->first();
    }

}
