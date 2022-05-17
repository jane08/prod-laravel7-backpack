<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Model;

class StaticTrans extends Model
{
    use CrudTrait;
    use HasTranslations;

    protected $table = 'static_trans';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = ['content', 'keyword', 'page'];
    protected $translatable = ['content'];



    protected function asJson($value)
    {
        return json_encode($value, JSON_UNESCAPED_UNICODE);
    }


    public static function t($keyword,$text,$page=MenuItem::PAGE_MAIN)
    {
        $staticTrans = StaticTrans::where(['keyword' => $keyword,'page' => $page])->first();
        if(empty($staticTrans)) {
            $staticTrans = new StaticTrans();
            $staticTrans->page =$page;
            $staticTrans->content = $text;
            $staticTrans->keyword = $keyword;
            $staticTrans->save();
        }

        return $staticTrans->content;

    }

}
