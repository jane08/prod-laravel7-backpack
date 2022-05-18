<?php

namespace App\Models;

use App\Helpers\CommonHelper;
use App\Helpers\ImageHelper;
use App\Traits\HasTranslations;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use Sluggable, SluggableScopeHelpers;
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use HasTranslations;

    const LIMIT = 100000;

    const LATEST = 'latest';
    const OLDEST = 'oldest';

    protected $table = 'products';

    protected $fillable = ['title', 'description', 'image','active','sort','alt','price','category_id','qty','meta_title', 'meta_description','meta_keywords','canonical','slug'];
    protected $translatable = ['title', 'description','meta_title', 'meta_description','meta_keywords'];

    protected function asJson($value)
    {
        return json_encode($value, JSON_UNESCAPED_UNICODE);
    }

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'slug_or_title',
            ],
        ];
    }

    // The slug is created automatically from the "title" field if no slug exists.
    public function getSlugOrTitleAttribute()
    {
        if ($this->slug != '') {
            return $this->slug;
        }

        return $this->title;
    }

    public function scopeSort($query,$sort)
    {
        if($sort==self::LATEST) {
            $query->orderBy('id', 'DESC');
        }
        else{
            $query->orderBy('id');
        }
    }

    public function scopeBysort($query,$sort)
    {
        if($sort==self::LATEST) {
            $query->orderBy('sort', 'DESC');
        }
        else{
            $query->orderBy('sort');
        }
    }


    public function scopePublished($query)
    {
        return $query->where('active', CommonHelper::ACTIVE);
    }


    /**
     * Saving images as path
     * uncomment if you need path instead of base64
     * @param $value
     */
    public function setImageAttribute($value)
    {
        $destination_path = "public/uploads/products";
        $attribute_name = 'image';

        $url = parse_url($value);
        if(!empty($url['host']))
        {
            $value = $url['path'];
        }

        $this->attributes[$attribute_name] = ImageHelper::setImageAttribute($value,$attribute_name,$destination_path,$this);

    }

}
