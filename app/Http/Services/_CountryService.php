<?php

namespace App\Http\Services;


use App\Helpers\CommonHelper;
use App\Models\_Country;
use App\Models\AboutSystem;
use App\Models\City;
use App\Models\Country;
use App\Models\Project;
use App\Models\Promo;
use App\Models\StaticTrans;
use App\Models\StrikeEvent;
use Illuminate\Support\Facades\Lang;

class _CountryService
{
    public static function getAll()
    {

        $title = "title_en";
        return _Country::orderBy("$title")->get();
    }

    public static function getOne($id)
    {
        return _Country::where(['country_id'=>$id])->get()->first();
    }


    public static function getOneByCountryName($title_en)
    {
        return _Country::where(['title_en' => $title_en])->first()??null;
    }

    public static function getAllArray()
    {
        return _Country::select('country_id','title_en')->orderBy("title_en")->get()->pluck('title_en', 'country_id')->toArray();
    }

}
