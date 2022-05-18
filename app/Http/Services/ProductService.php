<?php

namespace App\Http\Services;


use App\Helpers\CommonHelper;
use App\Models\AboutSystem;
use App\Models\Product;
use App\Models\Profile;
use App\Models\Promo;
use App\Models\StaticTrans;
use App\Models\StrikeEvent;

class ProductService
{

    public static function getAll($sort = 'oldest',$limit = Product::LIMIT)
    {
        return Product::published()->bysort($sort)->paginate($limit);
    }

    public static function getOne($id)
    {
        return Product::where(['id'=>$id])->get()->first();
    }

    public static function getOneBySlug($slug)
    {
        return Product::where(['slug'=>$slug])->get()->first();
    }

}
