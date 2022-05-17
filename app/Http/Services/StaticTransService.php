<?php

namespace App\Http\Services;


use App\Models\StaticTrans;

class StaticTransService
{
    public static function getAll()
    {
        return StaticTrans::all();
    }

    public static function getListByPage($page)
    {
        return StaticTrans::where(['page'=>$page])->get();
    }

    /**
     * получение перевода
     * @param $page
     * @param $key
     * @return mixed
     */
    public static function getListByPageKey($page,$key)
    {
        return StaticTrans::where(['page'=>$page,'keyword'=>$key])->first();
    }

}
