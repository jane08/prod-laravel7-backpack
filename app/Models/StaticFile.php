<?php

namespace App\Models;

use App\Helpers\ImageHelper;
use Illuminate\Database\Eloquent\Model;

class StaticFile extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;

    const TYPE_FILE = "file";
    const TYPE_ALT = "alt";

    protected $table = 'static_files';

    protected $fillable = ['file', 'keyword', 'page','alt'];

    /**
     * Saving images as path
     * uncomment if you need path instead of base64
     * @param $value
     */
    public function setFileAttribute($value)
    {
        $destination_path = "public/uploads/main";
        $attribute_name = 'file';

        $url = parse_url($value);
        if(!empty($url['host']))
        {
            $value = $url['path'];
        }

        $this->attributes[$attribute_name] = ImageHelper::setImageAttribute($value,$attribute_name,$destination_path,$this);

    }

    public static function t($keyword,$text,$page=MenuItem::PAGE_MAIN,$type="file",$alt="")
    {
        $staticTrans = StaticFile::where(['keyword' => $keyword,'page' => $page])->first();
        if(empty($staticTrans)) {
            $staticTrans = new StaticFile();
            $staticTrans->page =$page;
            $staticTrans->file = $text;
            $staticTrans->keyword = $keyword;
            $staticTrans->alt = $alt;
            $staticTrans->save();
        }

        $param = $staticTrans->file;
        if($type==self::TYPE_ALT)
        {
            $param = $staticTrans->alt;
        }

        return $param;

    }

    public static function imgAlt($keyword,$text,$page=MenuItem::PAGE_MAIN,$alt="")
    {
        $staticTrans = StaticFile::where(['keyword' => $keyword,'page' => $page])->first();
        if(empty($staticTrans)) {
            $staticTrans = new StaticFile();
            $staticTrans->page =$page;
            $staticTrans->file = $text;
            $staticTrans->keyword = $keyword;
            $staticTrans->alt = $alt;
            $staticTrans->save();
        }

        return $staticTrans->alt;

    }
}
