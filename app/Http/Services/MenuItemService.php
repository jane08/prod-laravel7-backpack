<?php

namespace App\Http\Services;


use App\Helpers\CommonHelper;

use App\Models\MenuItem;
use App\Models\Review;
use App\Models\StaticTrans;


class MenuItemService
{

    public static function getAll($position,$sort = 'latest',$limit = MenuItem::LIMIT)
    {

        return MenuItem::where(["position"=>$position])->bysort($sort)->paginate($limit);

    }


    public static function getOne($id)
    {
        return MenuItem::where(['id'=>$id])->get()->first();
    }

}
