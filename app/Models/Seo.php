<?php

namespace App\Models;

use App\Helpers\ImageHelper;
use App\Interfaces\SeoInterface;
use Illuminate\Database\Eloquent\Model;

class Seo extends Model implements SeoInterface
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    protected $table = 'seos';

    protected $fillable = ['meta_title', 'meta_description', 'og_image','meta_keywords','page','canonical'];

    public static function t($page=MenuItem::PAGE_MAIN)
    {

        return Seo::where(['page' => MenuItem::PAGE_MAIN])->first();

    }

    public static function getMetaTitle($page=MenuItem::PAGE_MAIN)
    {
        $seo = Seo::where(['page' => $page])->first();
        return $seo->meta_title??'';

    }

    public static function getMetaDescription($page=MenuItem::PAGE_MAIN)
    {
        $seo = Seo::where(['page' => $page])->first();
        return $seo->meta_description??'';

    }

    public static function getMetaKeywords($page=MenuItem::PAGE_MAIN)
    {
        $seo = Seo::where(['page' => $page])->first();
        return $seo->meta_keywords??'';

    }

    public static function getCanonical($page=MenuItem::PAGE_MAIN)
    {
        $seo = Seo::where(['page' => $page])->first();
        return $seo->canonical??'';

    }

    public static function getOgImage($page=MenuItem::PAGE_MAIN)
    {
        $seo = Seo::where(['page' => $page])->first();
        return $seo->og_image??'';

    }

    public function setOgImageAttribute($value)
    {
        $destination_path = "public/uploads/seo";
        $attribute_name = 'og_image';

        $url = parse_url($value);
        if(!empty($url['host']))
        {
            $value = $url['path'];
        }

        $this->attributes[$attribute_name] = ImageHelper::setImageAttribute($value,$attribute_name,$destination_path,$this);

    }

}
