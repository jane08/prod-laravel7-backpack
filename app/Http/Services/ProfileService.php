<?php

namespace App\Http\Services;


use App\Helpers\CommonHelper;
use App\Models\AboutSystem;
use App\Models\Profile;
use App\Models\Promo;
use App\Models\StaticTrans;
use App\Models\StrikeEvent;

class ProfileService
{

    public static function getOne($id)
    {
        return Profile::where(['id'=>$id])->get()->first();
    }
    public static function getOneByUserId($user_id)
    {
        return Profile::where(['user_id'=>$user_id])->get()->first();
    }

}
