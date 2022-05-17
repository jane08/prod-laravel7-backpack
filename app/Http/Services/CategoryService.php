<?php

namespace App\Http\Services;


use App\Helpers\CommonHelper;
use App\Models\AboutSystem;
use App\Models\Category;
use App\Models\StaticTrans;

class CategoryService
{
    public static function getAll()
    {
        return Category::all();
    }

    public static function getOne($id)
    {
        return Category::where(['id'=>$id])->get()->first();
    }

}
